<?php

namespace viandas\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
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
                                                                            (SELECT
                                                                              c.id
                                                                            FROM cliente c
                                                                              LEFT JOIN empresa e
                                                                                ON c.idempresa = e.id
                                                                            WHERE c.deleted_at IS NOT NULL
                                                                                OR e.deleted_at IS NOT NULL)
                                                                            ")
            ->join('cliente', 'cliente_dia.cliente_id','=','cliente.id')
            ->orderBy("cliente.apellido")->get();

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

        //var_dump($listPedidosClientes->count());


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


        //var_dump($request->pedido);
        //var_dump( Input::all());
        $rq = array();
        $rq =  json_decode($request->pedido, true);
        //$rq = $request->all();
        //var_dump($rq['pedCli']);

        $listPem = collect();
        if(isset($rq['pedEmp']) )
        {
            foreach ($rq['pedEmp'] as $pe) {
                $pem = new PedidoEmpresa();
                $pem->fecha_pedido = Carbon::createFromFormat('d/m/Y', $pe['fecha_pedido']);
                $pem->empresa_id = $pe['empresa_id'];
                $pem->precio_envio = 0;
                if (isset($pe['envio'])) {
                    $pem->envio = 1;
                    $pem->precio_envio = $pe['precio_envio'];
                    $pem->cadete_id = $pe['cadete_id'];
                }
                $pem->cobrado = 0;
                $pem->total = $pem->precio_envio;
                foreach ($pe['ped'] as $pc) {
                    $pedido = new Pedido();
                    $pedido->fecha_pedido = Carbon::createFromFormat('d/m/Y', $pc['fecha_pedido']);
                    $pedido->cliente_id = $pc['cliente_id'];
                    $pedido->cobrado = 0;
                    $pedido->total = 0;
                    $almenosUnaLineaPedido = 0;
                    foreach ($pc['linea'] as $lp) {
                        if (isset($lp['confirmado'])) {
                            $almenosUnaLineaPedido = 1;
                            $lpp = new LineaPedido();
                            $lpp->cantidad = $lp['cantidad'];
                            $lpp->tipo_vianda_id = $lp['tipo_vianda_id'];
                            $lpp->precio_vianda = $lp['precio_vianda'] / $lp['cantidad'];
                            $pedido->ListLineasPedido->add($lpp);
                            $pedido->total = $pedido->total + ($lpp->precio_vianda * $lpp->cantidad);
                        }
                    }
                    if ($almenosUnaLineaPedido == 1) {
                        $pem->ListPedidos->add($pedido);
                        $pem->total = $pem->total + $pedido->total;
                    }
                }
                if ($pem->ListPedidos->count() > 0) {
                    $listPem->push($pem);
                }
            }
        }
        $listPedCli = collect();
        if(isset($rq['pedCli']) ) {
            foreach ($rq['pedCli'] as $pcl) {
                $pedido = new Pedido();
                $pedido->fecha_pedido = Carbon::createFromFormat('d/m/Y', $pcl['fecha_pedido']);
                $pedido->cliente_id = $pcl['cliente_id'];
                $pedido->cobrado = 0;
                $pedido->total = 0;
                $pedido->precio_envio = 0;
                if (isset($pcl['envio'])) {
                    $pedido->envio = 1;
                    $pedido->precio_envio = $pcl['precio_envio'];
                    $pedido->cadete_id = $pcl['cadete_id'];
                }
                $pedido->total = $pedido->precio_envio;
                $almenosUnaLineaPedidoc = 0;
                if(isset($pcl['linea'])){
                    foreach ($pcl['linea'] as $lpc) {
                        if (isset($lpc['confirmado'])) {
                            $almenosUnaLineaPedidoc = 1;
                            $lppp = new LineaPedido();
                            $lppp->cantidad = $lpc['cantidad'];
                            $lppp->tipo_vianda_id = $lpc['tipo_vianda_id'];
                            $lppp->precio_vianda = $lpc['precio_vianda'] / $lpc['cantidad'];
                            $pedido->ListLineasPedido->add($lppp);
                            $pedido->total = $pedido->total + ($lppp->precio_vianda * $lppp->cantidad);
                        }
                    }
                }
                if ($almenosUnaLineaPedidoc == 1) {
                    $listPedCli->push($pedido);
                }
            }
        }

        foreach ($listPem as $pedidoEmpresa)
        {
            $pedidoEmpresa->save();
            foreach ($pedidoEmpresa->ListPedidos as $pedidoCliente)
            {
                $pedidoEmpresa->ListPedidos()->save($pedidoCliente);
                foreach($pedidoCliente->ListLineasPedido as $linPed )
                {
                    $pedidoCliente->ListLineasPedido()->save($linPed);
                }
            }

        }


        foreach ($listPedCli as $pedidoCli)
        {
            $pedidoCli->save();
            foreach($pedidoCli->ListLineasPedido as $linPedi )
            {
                $pedidoCli->ListLineasPedido()->save($linPedi);
            }
        }


        //var_dump($pedidoCli);
        Session::flash('mensajeOk', 'Pedidos Confirmados Con Exito');
        //return back();


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
        $pedido = Pedido::findOrFail($id);
        if($pedido->cobrado ==1)
        {
            Session::flash('mensajeError', 'No se Puede Modificar Un pedido Cobrado');
            return back();
        }
        $listCadetes =   DB::table('cadete')->select(DB::raw('id, CONCAT( COALESCE(apellido, ""),", ", COALESCE(nombre, "")) as apenom'))
            ->where('deleted_at',null)
            ->orderBy('apenom')
            ->lists('apenom','id');
        $listTipoViandas = TipoVianda::all();
        return view ('admin.pedidoeditar', compact('pedido','listCadetes','listTipoViandas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{

            $p = Pedido::findOrFail($request->id);
            $p->observaciones = $request->observaciones;
            if(isset($request->envio)){
                if($p->precio_envio!= $request->precio_envio)
                {
                    $p->total=$p->total-$p->precio_envio;
                    $p->total = $p->total+$request->precio_envio;
                    $p->precio_envio = $request->precio_envio;

                }
                $p->envio=1;
                $p->cadete_id=$request->cadete_id;
            }
            else{
                $p->envio=0;
                $p->total = $p->total - $p->precio_envio;
                $p->precio_envio=0;
                $p->cadete_id=null;
            }
            $p->save();

            Session::flash('mensajeOk','Cabecera del Pedido Modificada con exito');
            return back();
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            Pedido::destroy($request->id);
            Session::flash('mensajeOk','Pedido Eliminado con exito');
            return back();
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
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

        $listPedidos = Pedido::whereRaw($empresaSQL." (deleted_at is null AND fecha_pedido BETWEEN '".$fechadesde->format('Y-m-d')."' AND '".$fechahasta->format('Y-m-d')."')")->get();

        $arreglo = Array();

        foreach ($listPedidos as $pedido) {

          $clienteX = Cliente::withTrashed()
                ->where('id',  $pedido->cliente_id)
                ->get();

          //  var_dump($clienteX[0]);die();
            if(!$clienteX[0]->trashed()){
                
                $clientedelpedido = $clienteX[0]; //Cliente::findOrFail($pedido->cliente_id);
             //   var_dump($pedido->cliente_id);die();

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


// recibos
    public function listarPedidosRecibos(){

        $listaDePedidos =  Pedido::all();
        $empresas = Empresa::all();


        return view ('admin.recibos',compact('listaDePedidos','empresas'));
    }
    public function emitirRecibos(){

        $fechadesde = Carbon::createFromFormat('d/m/Y', str_replace('%2F', '/', $_GET['fechaDesde']));
        $fechahasta = Carbon::createFromFormat('d/m/Y', str_replace('%2F', '/', $_GET['fechaHasta']));

        $clientes= Cliente::whereRaw("envio='1' AND idempresa IS NULL")->get();

        $total = 0;
        $contadorClientes=0;

        foreach ($clientes as $c) {
            $pedidosC = Pedido::whereRaw("cliente_id='".$c->id."' AND (fecha_pedido BETWEEN '".$fechadesde->format('Y-m-d')."' AND '".$fechahasta->format('Y-m-d')."')")->get();
        
            $tienepedido=false;
            $totalcliente = 0;
            foreach ($pedidosC as $p) {

                // aca preguntar si tiene envio !
                
                $totalcliente= $totalcliente + $p->total;
                $tienepedido = true;                
            }  
            if ($tienepedido) {

                $contadorClientes++;

                // DIBUJAR EL RECIBO

                ECHO '- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br><br>';
                ECHO 'Nutrilife Viandas - Liquidaci&oacute;n desde: '.$fechadesde->format("d-m-Y").' -> hasta '.$fechahasta->format('d-m-Y').'<br>';
                
                echo $c->nombre.' '.$c->apellido.' - TOTAL: $ '.$totalcliente;

                ECHO '<br><br>';
            }

            
        }

        die();

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


            $ped->total = $request->total;

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
        $listEmpresas = Empresa::all();
        return view ('admin.gestionpedidos', compact('listEmpresas'));
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
            ->where('pedido_empresa_id', NULL)
            ->get();
        return view('admin.include.pedidos-gestion', compact('listPedidos'));
    }
    public function buscarpedidosempresas(Request $request)
    {
        $empresa_id = $request->empresa_id;
        $fechaDesde = Carbon::createFromFormat('d/m/Y', $request->fecha_pedido_desde);
        $fechaHasta = Carbon::createFromFormat('d/m/Y', $request->fecha_pedido_hasta);

        if($empresa_id==0)
        {
            $listPedidos = PedidoEmpresa::where('fecha_pedido', '>=', $fechaDesde->format('Y-m-d'))
                ->where('fecha_pedido', '<=', $fechaHasta->format('Y-m-d'))
                ->get();
        }
        else
        {
            $listPedidos = PedidoEmpresa::where('empresa_id', '=', $empresa_id)
                ->where('fecha_pedido', '>=', $fechaDesde->format('Y-m-d'))
                ->where('fecha_pedido', '<=', $fechaHasta->format('Y-m-d'))
                ->get();
        }


        return view('admin.include.pedidos-empresa-gestion', compact('listPedidos'));
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
        $fechaHo = new Carbon('now');
        //$fechaManana = new Carbon('tomorrow');
        $fechaManana=$fechaHo->addDays(10);
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
                                                                           (SELECT
                                                                              c.id
                                                                            FROM cliente c
                                                                              LEFT JOIN empresa e
                                                                                ON c.idempresa = e.id
                                                                            WHERE c.deleted_at IS NOT NULL
                                                                                OR e.deleted_at IS NOT NULL)
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
                    $pedidoEmpresa->precio_envio =$pedidoCliente->Cliente->Empresa->Localidad->costo_envio;
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
        $listCadetes =   DB::table('cadete')->select(DB::raw('id, CONCAT( COALESCE(apellido, ""),", ", COALESCE(nombre, "")) as apenom'))
            ->where('deleted_at',null)
            ->orderBy('apenom')
            ->lists('apenom','id');
        $cantidadTotal=0;
        foreach($listPedidosEmpresa as $lpe )
        {
            $cantidadTotal= $cantidadTotal+ $lpe->ListPedidos->count();
        }
        $cantidadTotal = $cantidadTotal+ $listPedidosClientes->count();



        return view ('admin.include.pedidosV1', compact('cantidadTotal','listPedidosEmpresa','listPedidosClientes','fecha_pedido','listCadetes'));

    }

    public function buscarpedidoempresa(Request $request)
    {
        $pedido=PedidoEmpresa::findOrFail($request->id);
        return view ('admin.include.pedido-empresa-detalle', compact('pedido'));
    }

    public function eliminarlinea(Request $request)
    {
        try{
            $lp = LineaPedido::findOrFail($request->id);
            $p = Pedido::findOrFail($lp->pedido_id);
            if($p->ListLineasPedido->count() == 1 )
            {
                Session::flash('mensajeError', 'No se puede dejar el pedido sin lineas. Agregue una nueva untes de Eliminar esta linea');
                return back();
            }
            $p->total = $p->total - ($lp->cantidad * $lp->precio_vianda);
            $p->save();
            LineaPedido::destroy($request->id);
            Session::flash('mensajeOk','Linea Pedido Eliminada con exito');
            return back();
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }

    }

    public function agregarlinea(Request $request)
    {
        try{
            $p = Pedido::findOrFail($request->pedido_id);
            $a= new LineaPedido($request->all());
            $precioVianda =  $a->precio_vianda / $a->cantidad;

            $a->precio_vianda = $precioVianda;

            $p->total = $p->total + ($request->cantidad * $a->precio_vianda);
            $a->save();
            $p->save();

            Session::flash('mensajeOk', 'Linea Pedido Agregada Con Exito');
            return back();
        }
        catch(\Exception $ex){

            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }

}
