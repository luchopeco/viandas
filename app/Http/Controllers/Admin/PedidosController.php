<?php

namespace viandas\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use viandas\Cadete;
use viandas\Cliente;
use viandas\Empresa;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\Pedido;
use viandas\TipoVianda;
use viandas\ViandaCliente;

class PedidosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('admin.pedidos');
    }

    ///Busca por dia
    public function buscar(Request $request)
    {
        $fechaHoy = new Carbon('now');
        $fechaManana = new Carbon('tomorrow');
        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);
        $fechaAnterior = $fechaHoy->subDays(7);

        if($fecha>=$fechaManana)
        {
            $mensajeError ="No puede registar pedidos para dias futuros";
            return view ('admin.include.pedidos-error',compact('mensajeError'));
        }
        if  ($fecha<$fechaAnterior)
        {
            $mensajeError ="Solo puede registrar pedidos de los ultimos 7 dias";
            return view ('admin.include.pedidos-error',compact('mensajeError'));
        }

        $listPedidos = Pedido::whereRaw("fecha_pedido = '". ($fecha->format('Y-m-d'))."'")->get();

        $dia= $fecha->dayOfWeek+1;

        //$listViandas = ViandaCliente::whereRaw("dia_semana_id = ".$dia)->orderBy("cliente_id")->get();
        $listViandas = ViandaCliente::whereRaw("NOT EXISTS (SELECT * FROM pedido p WHERE p.cliente_id = cliente_dia.cliente_id AND p.tipo_vianda_id = cliente_dia.tipo_vianda_id AND p.fecha_pedido ='".($fecha->format('Y-m-d'))."') AND dia_semana_id = ".$dia." AND cliente_id NOT IN (SELECT id FROM cliente where deleted_at is not null)")->orderBy("cliente_id")->get();
        //$listViandas = ViandaCliente::all();
        //$listViandas= ViandaCliente::with(['cliente' => function($query)
        //{
         //   $query->orderBy('apellido');

//        }])->whereRaw("NOT EXISTS (SELECT * FROM pedido p WHERE p.cliente_id = cliente_dia.cliente_id AND p.tipo_vianda_id = cliente_dia.tipo_vianda_id AND p.fecha_pedido ='".($fecha->format('Y-m-d'))."') AND dia_semana_id = ".$dia." AND cliente_id NOT IN (SELECT id FROM cliente where deleted_at is not null)")->get();


        /// recorro los pedidos, y limpio las viandas segun se realizaron los pedidos

        $fecha_pedido=$request->fecha;

        $listEmpresas = Empresa::all();

        $listCadetes = Cadete::all()->lists('nombre', 'id');


        return view ('admin.include.pedidos', compact('listPedidos','listViandas','listEmpresas','listCadetes','fecha_pedido'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$listClientes=Cliente::orderBy('apellido','desc')->get();
        $listTipoViandas = TipoVianda::orderBy('nombre','desc')->get();
        $listCadetes=Cadete::orderBy('nombre')->lists('nombre', 'id');
        return view ('admin.pedido',compact('listClientes','listTipoViandas','listCadetes'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            foreach ($request->pedidos as $p) {
                if (isset($p['confirmado'])) {
                    $ped = new Pedido();
                    $f = Carbon::createFromFormat('d/m/Y', $p['fecha_pedido']);
                    $ped->fecha_pedido = $f->format('Y-m-d');
                    $ped->cantidad = $p['cantidad'];
                    if (isset($p['envio'])) {
                        $ped->envio = 1;
                        $ped->cadete_id = $p['cadete_id'];
                        $ped->precio_envio = $p['precio_envio'];
                    }
                    if (!empty($p['empresa_id'])) {
                        $ped->empresa_id = $p['empresa_id'];
                    }
                    $ped->observaciones=$p['observaciones'];
                    $ped->cliente_id = $p['cliente_id'];
                    $ped->tipo_vianda_id = $p['tipo_vianda_id'];
                    $ped->precio_vianda = $p['precio_vianda'];
                    $ped->save();

                }
            }
            Session::flash('mensajeOk', 'Pedidos Confirmados Con Exito');
            return back();
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listarPedidos(){

        $listaDePedidos =  Pedido::all();
        $empresas = Empresa::all();


        return view ('admin.cobros',compact('listaDePedidos','empresas'));
    }

    ///Busca por dia
    public function buscarCobros(Request $request)
    {
        $fechaHoy = new Carbon('now');
        $fechadesde = Carbon::createFromFormat('d/m/Y', $request->fechaDesde);
        $fechahasta = Carbon::createFromFormat('d/m/Y', $request->fechaHasta);
        $empresaActual ="";
        //var_dump($fechadesde);die();

        $eID=$request->empresa;
        $empresaSQL='';
        if($eID=='9999'){
            //no tiene empresa
            $empresaSQL='';
        }
        else{
            $empresaActual = Empresa::find($request->empresa);    

            $empresaSQL = '(empresa_id = '.$eID.' ) AND ';

        }

       
        $listPedidos = Pedido::whereRaw($empresaSQL." (fecha_pedido BETWEEN '".$fechadesde->format('Y-m-d')."' AND '".$fechahasta->format('Y-m-d')."')")->get();


//. ($fechadesde->format('Y-m-d'))."'"
      //  $dia= $fecha->dayOfWeek+1;

      //  $listViandas = ViandaCliente::whereRaw("dia_semana_id = ".$dia)->orderBy("cliente_id")->get();

        //$listViandas = ViandaCliente::all();


        /// recorro los pedidos, y limpio las viandas segun se realizaron los pedidos
  /*      foreach ($listPedidos as $pedido)
        {
            $listViandas = $listViandas->where('cliente_id',' != ', $pedido->cliente_id)->where('tipo_vianda_id','!= ', $pedido->tipo_vianda_id);
        }
*/
       // $fecha_pedido=$request->fecha;

        $listEmpresas = Empresa::all();

        $listCadetes = Cadete::all()->lists('nombre', 'id');


        return view ('admin.include.cobros',compact('empresaActual','listPedidos','listEmpresas','listCadetes'));

    }

    public function agregarPedidoManual(Request $request)
    {
        try {


                    $ped = new Pedido();
                    $f = Carbon::createFromFormat('d/m/Y', $request->fecha_pedido);
                    $ped->fecha_pedido = $f->format('Y-m-d');
                    $ped->cantidad = $request->cantidad;
                    if (isset($request->envio)) {
                        $ped->envio = 1;
                        $ped->cadete_id = $request->cadete_id;
                        $ped->precio_envio = $request->precio_envio;
                    }
                    $ped->observaciones=$request->observaciones;
                    $ped->cliente_id = $request->cliente_id;
                    $ped->tipo_vianda_id = $request->tipo_vianda_id;
                    $ped->precio_vianda = $request->precio_vianda;
                    $ped->cobrado=1;
                    $ped->save();



            Session::flash('mensajeOk', 'Pedido Agregado Con Exito');
            return back();
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }
}
