<?php

namespace viandas\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Scalar\LNumber;
use viandas\Cadete;
use viandas\Cliente;
use viandas\Empresa;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\LineaPedido;
use viandas\Pedido;
use viandas\PedidoEmpresa;
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
        $listViandas = ViandaCliente::whereRaw("NOT EXISTS
                                                (SELECT * FROM pedido p
                                                inner join linea_pedido lp on p.id = lp.pedido_id
                                                 WHERE p.cliente_id = cliente_dia.cliente_id
                                                                        AND lp.tipo_vianda_id = cliente_dia.tipo_vianda_id
                                                                        AND p.fecha_pedido ='".($fecha->format('Y-m-d'))."')
                                                                        AND dia_semana_id = ".$dia."
                                                                        AND cliente_id NOT IN
                                                                            (SELECT id FROM cliente where deleted_at is not null)
                                                                            ")
            ->join('cliente', 'cliente_dia.cliente_id','=','cliente.id')
            ->orderBy("cliente.apellido")->get();
        //$listViandas = ViandaCliente::all();
        //$listViandas= ViandaCliente::with(['cliente' => function($query)
        //{
         //   $query->orderBy('apellido');

//        }])->whereRaw("NOT EXISTS (SELECT * FROM pedido p WHERE p.cliente_id = cliente_dia.cliente_id AND p.tipo_vianda_id = cliente_dia.tipo_vianda_id AND p.fecha_pedido ='".($fecha->format('Y-m-d'))."') AND dia_semana_id = ".$dia." AND cliente_id NOT IN (SELECT id FROM cliente where deleted_at is not null)")->get();


        /// recorro los pedidos, y limpio las viandas segun se realizaron los pedidos

        $fecha_pedido=$request->fecha;

        $listEmpresas = Empresa::all();

        $listCadetes = Cadete::all()->lists('nombre', 'id');



        $listPedidosClientes = collect();
        $listPedidosEmpresa = collect();

        ///agrupo por Empresa
        $listAgrupacionViandasClientesXEmpresas = $listViandas->groupBy('Cliente.idempresa');
        //$listAgrupacionClientes->toArray();

        ////recorro los pedidos agrupados por empresa, es decir recorro las empresas
        foreach ( $listAgrupacionViandasClientesXEmpresas as $empresaConViandas)
        {
            $pedidoEmpresa = new PedidoEmpresa();
            $listAgrupacionViandasClientesXCliente = $empresaConViandas->groupBy('cliente_id');
            $lisPedidosTemporal = collect();
            foreach($listAgrupacionViandasClientesXCliente as $listViandasClientesEmpresa)
            {
                $pedidoCliente = new Pedido();
                $idempresa=null;
                foreach($listViandasClientesEmpresa as $viandaClienteEmpresa)
                {
                    $pedidoCliente->cliente_id = $viandaClienteEmpresa->cliente_id;
                    $lp = new LineaPedido();
                    $lp->cantidad = $viandaClienteEmpresa->cantidad;
                    $lp->tipo_vianda_id = $viandaClienteEmpresa->tipo_vianda_id;
                    $lp->precio_vianda = $viandaClienteEmpresa->TipoVianda->precio;
                    $pedidoCliente->ListLineasPedido->push($lp);

                    $idempresa = $pedidoCliente->Cliente->idempresa;
                }
                if ($idempresa !=null)
                {
                    $pedidoEmpresa->ListPedidos->push($pedidoCliente);
                }
                else
                {
                    $listPedidosClientes->push($pedidoCliente);
                }

            }
            if($pedidoEmpresa->ListPedidos->count() >0){
                $listPedidosEmpresa->push($pedidoEmpresa);
            }
        }

        var_dump($listPedidosClientes->count());


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

                    $lp = new LineaPedido();
                    $lp->cantidad =$p['cantidad'];
                    $lp->tipo_vianda_id = $p['tipo_vianda_id'];
                    $lp->precio_vianda = $p['precio_vianda'];

                    $ped->fecha_pedido = $f->format('Y-m-d');
                    if (isset($p['envio'])) {
                        $ped->envio = 1;
                        $ped->cadete_id = $p['cadete_id'];
                        $ped->precio_envio = $p['precio_envio'];
                    }
                    if (!empty($p['empresa_id'])) {
                        $ped->empresa_id = $p['empresa_id'];
                    }
                    //$ped->observaciones=$p['observaciones'];
                    $ped->cliente_id = $p['cliente_id'];

                    $ped->save();
                    $ped->ListLineasPedido() ->save($lp);
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
        $p = Pedido::findOrFail($id);
        ///para cargar el cliente y q me lo envie en el ajax
        $per = $p->Cliente;
        $response = array(
            "datos" => $p
        );
        return json_encode($response, JSON_HEX_QUOT | JSON_HEX_TAG);
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

    public function buscarCobrosAjax()
    {

        $fechaHoy = new Carbon('now');
        $fechadesde = Carbon::createFromFormat('d/m/Y', str_replace('%2F', '/', $_GET['fechadesde']));
        $fechahasta = Carbon::createFromFormat('d/m/Y', str_replace('%2F', '/', $_GET['fechahasta']));
        $empresaActual ="";
        //var_dump($fechadesde);die();

        $eID=$_GET['idempresa'];
        $empresaSQL='';
        if($eID=='9999'){
            //no tiene empresa
            $empresaSQL='';
        }
        else{
            $empresaActual = Empresa::find($eID);    

            $empresaSQL = '(empresa_id = '.$eID.' ) AND ';

        }
        /* ejemplo andando
                $arreglo = Array();
                $cont = Array();
                $cont[] = '1'; 
                $cont[] = '2011-04-25';
                $cont[] = 'System Architect';
                $cont[] = 'Edinburgh';
                $cont[] = '5421';
                $cont[] = '2011-04-25';
                $cont[] = '<input type="checkbox"/>';
                $arreglo[] = $cont;    

        return json_encode($arreglo);
        die();
        */

        $listPedidos = Pedido::whereRaw($empresaSQL." (fecha_pedido BETWEEN '".$fechadesde->format('Y-m-d')."' AND '".$fechahasta->format('Y-m-d')."')")->get();

        $arreglo = Array();

        foreach ($listPedidos as $pedido) {
          
                $cont = Array();
                $cont[] = $pedido->cliente->nombre.' - '.$pedido->cliente->apellido; 
                $cont[] = $pedido->fecha_pedido;
                $lineaP = '';
                foreach ($pedido->ListLineasPedido as $lp) {
                    $lineaP .= $lp->TipoVianda->nombre.' Cant: '.$lp->cantidad.'; '; 
                }

                $cont[] = $lineaP;
                 
                $cont[] = $pedido->precio_envio;
                $cont[] = $pedido->total;        
                $cobrado='';
                if($pedido->cobrado == 1){
                  $cobrado='<input type="checkbox" name="'.$pedido->id.'" id="'.$pedido->id.'" value="'.$pedido->id.'" checked="checked">';
                }else{
                  $cobrado='<input type="checkbox" name="'.$pedido->id.'" id="'.$pedido->id.'" value="'.$pedido->id.'">';
                }
                $cont[] = $cobrado;
                $arreglo[] = $cont;
        }

        return json_encode($arreglo);
        die();

        // ----------------------------------


        $listEmpresas = Empresa::all();
        $listCadetes = Cadete::all()->lists('nombre', 'id');
        return view ('admin.include.cobros',compact('empresaActual','listPedidos','listEmpresas','listCadetes'));
    }

    public function actualizarCobros(){

        $fechadesde = Carbon::createFromFormat('d/m/Y', str_replace('%2F', '/', $_GET['fechaDesdeInput']));
        $fechahasta = Carbon::createFromFormat('d/m/Y', str_replace('%2F', '/', $_GET['fechaHastaInput']));

        $empresaActual ="";

        $eID=$_GET['empresaInput'];
        $empresaSQL='';
        if($eID=='9999'){
            //no tiene empresa
            $empresaSQL='';
        }
        else{
            $empresaActual = Empresa::find($eID);
            $empresaSQL = '(empresa_id = '.$eID.' ) AND ';
        }       

        $listPedidos = Pedido::whereRaw($empresaSQL." (fecha_pedido BETWEEN '".$fechadesde->format('Y-m-d')."' AND '".$fechahasta->format('Y-m-d')."')")->get();
        $arreglo = Array();

        foreach ($listPedidos as $pedido) {
          if(isset($_GET[$pedido->id])){   // está cobrado el pedido
            $pedido->cobrado = 1;            
          }
          else{
            $pedido->cobrado=0;
          }
          $pedido->save();
        }
        
        Session::flash('mensajeOk', 'COBROS ACTUALIZADOS !');
        return redirect('admin/cobros');


        $empresas = Empresa::all();
        $listCadetes = Cadete::all()->lists('nombre', 'id');
        return view ('admin.cobros',compact('empresaActual','listPedidos','empresas','listCadetes'));


    }

    public function agregarPedidoManual(Request $request)
    {
        try {

                $ped = new Pedido();
                $f = Carbon::createFromFormat('d/m/Y', $request->fecha_pedido);
                $lp = new LineaPedido();
                $lp->cantidad = $request->cantidad;
                $lp->tipo_vianda_id = $request->tipo_vianda_id;
                $lp->precio_vianda = $request->precio_vianda;

                $ped->fecha_pedido = $f->format('Y-m-d');
                  //$ped->cantidad =
                $precioEnvio = 0;
                if (isset($request->envio)) {
                $ped->envio = 1;
                $ped->cadete_id = $request->cadete_id;
                $ped->precio_envio = $request->precio_envio;
                    $precioEnvio =$ped->precio_envio;
                }
                $ped->observaciones=$request->observaciones;
                $ped->cliente_id = $request->cliente_id;


                $ped->total = ($lp->precio_vianda * $lp->cantidad) + $precioEnvio;

                $ped->cobrado=0;
                $ped->save();
                $ped->ListLineasPedido() ->save($lp);


                //$lp->pedido_id = $ped->id;
                //$lp->save();

            Session::flash('mensajeOk', 'Pedido Agregado Con Exito');
            return back();
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }

    public function gestion()
    {
        return view ('admin.gestionpedidos');
    }
    //Busca Pedidos Por Cliente y Por Fecha
    public function buscarpedidos(Request $request)
    {
        $cliente_id = $request->cliente_id;
        $fechaDesde = Carbon::createFromFormat('d/m/Y', $request->fecha_pedido_desde);
        $fechaHasta = Carbon::createFromFormat('d/m/Y', $request->fecha_pedido_hasta);

        $listPedidos = Pedido::where('cliente_id', '=', $cliente_id)
            ->where('fecha_pedido', '>=', $fechaDesde->format('Y-m-d'))
            ->where('fecha_pedido', '<=', $fechaHasta->format('Y-m-d'))
            ->get();
        return view('admin.include.pedidos-gestion', compact('listPedidos'));
    }

    public function liquidarCadetes(){

        $cadetes = Cadete::all();


          return view ('admin.liquidarcadete', compact('cadetes'));


    }

    public function liquidarCadeteUnico(){
        
        $cadete = Cadete::findOrFail($_GET['idcadete']);
        

        $fechaHoy = new Carbon('now');
        $fechadesde = Carbon::createFromFormat('d/m/Y', str_replace('%2F', '/', $_GET['fechadesde']));
        $fechahasta = Carbon::createFromFormat('d/m/Y', str_replace('%2F', '/', $_GET['fechahasta']));
        
//        $pedidoscadete = Pedido::where('cadete_id','=',$cadete->id);

        $listPedidos = Pedido::whereRaw("cadete_id='".$cadete->id."' AND (fecha_pedido BETWEEN '".$fechadesde->format('Y-m-d')."' AND '".$fechahasta->format('Y-m-d')."')")->get();

        $arreglo = Array();
        $liquidacion=0;
        foreach ($listPedidos as $pedido) {
          
                $cont = Array();
                $cont[] = $pedido->cliente->nombre.' - '.$pedido->cliente->apellido; 
                $cont[] = $pedido->fecha_pedido;                
                $cont[] = $pedido->precio_envio;                       
              
                $arreglo[] = $cont;

                $liquidacion += $pedido->precio_envio; 
        }
        $arreglo[] = $liquidacion;

        return json_encode($arreglo);
        die();

          


    }


    ///Busca por dia
    public function buscarpedidosxdia(Request $request)
    {
        $fechaHoy = new Carbon('now');
        $fechaManana = new Carbon('tomorrow');
        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);
        $fechaAnterior = $fechaHoy->subDays(7);
        $fecha_pedido=$request->fecha;
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

        $dia= $fecha->dayOfWeek+1;

        //$listViandas = ViandaCliente::whereRaw("dia_semana_id = ".$dia)->orderBy("cliente_id")->get();
        $listViandas = ViandaCliente::whereRaw("NOT EXISTS
                                                (SELECT * FROM pedido p
                                                inner join linea_pedido lp on p.id = lp.pedido_id
                                                 WHERE p.cliente_id = cliente_dia.cliente_id
                                                                        AND lp.tipo_vianda_id = cliente_dia.tipo_vianda_id
                                                                        AND p.fecha_pedido ='".($fecha->format('Y-m-d'))."')
                                                                        AND dia_semana_id = ".$dia."
                                                                        AND cliente_id NOT IN
                                                                            (SELECT id FROM cliente where deleted_at is not null)
                                                                            ")
            ->join('cliente', 'cliente_dia.cliente_id','=','cliente.id')
            ->orderBy("cliente.apellido")->get();

        $listPedidosClientes = collect();
        $listPedidosEmpresa = collect();

        ///agrupo por Empresa
        $listAgrupacionViandasClientesXEmpresas = $listViandas->groupBy('Cliente.idempresa');
        //$listAgrupacionClientes->toArray();

        ////recorro los pedidos agrupados por empresa, es decir recorro las empresas
        foreach ( $listAgrupacionViandasClientesXEmpresas as $empresaConViandas)
        {
            $pedidoEmpresa = new PedidoEmpresa();
            $listAgrupacionViandasClientesXCliente = $empresaConViandas->groupBy('cliente_id');
            $lisPedidosTemporal = collect();
            foreach($listAgrupacionViandasClientesXCliente as $listViandasClientesEmpresa)
            {
                $pedidoCliente = new Pedido();
                $idempresa=null;
                foreach($listViandasClientesEmpresa as $viandaClienteEmpresa)
                {
                    $pedidoCliente->cliente_id = $viandaClienteEmpresa->cliente_id;
                    $lp = new LineaPedido();
                    $lp->cantidad = $viandaClienteEmpresa->cantidad;
                    $lp->tipo_vianda_id = $viandaClienteEmpresa->tipo_vianda_id;
                    $lp->precio_vianda = $viandaClienteEmpresa->TipoVianda->precio;
                    $pedidoCliente->ListLineasPedido->push($lp);

                    $idempresa = $pedidoCliente->Cliente->idempresa;
                }
                if ($idempresa !=null)
                {
                    $pedidoEmpresa->envio = $pedidoCliente->Cliente->Empresa->envio;
                    $pedidoEmpresa->empresa_id = $idempresa;
                    $pedidoEmpresa->ListPedidos->push($pedidoCliente);
                }
                else
                {
                    $listPedidosClientes->push($pedidoCliente);
                }

            }
            if($pedidoEmpresa->ListPedidos->count() >0){
                $listPedidosEmpresa->push($pedidoEmpresa);
            }
        }
        //$l = $listp->groupBy('Cliente.idempresa');
        //foreach($l as $ll){
        //  foreach ($ll as $lll)
          //  {
            //    $llll = $lll->Cliente;
           // }

//        }
  //      var_dump($llll->Empresa->nombre);






        return view ('admin.include.pedidosV1', compact('listPedidosEmpresa','listPedidosClientes','fecha_pedido'));

    }

}
