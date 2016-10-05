<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use viandas\Cliente;
use viandas\DiaSemana;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\LineaPedido;
use viandas\Pedido;
use viandas\PedidoEmpresa;
use viandas\ViandaCliente;

class ViandasController extends Controller
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

        $listDiaSemanaSelect = DiaSemana::all()->lists('nombre', 'id');
        return view ('admin.listadoviandas',compact('listDiaSemana','listDiaSemanaSelect'));
    }
    public function buscarTodas()
    {
        //$listViandas = ViandaCliente::whereRaw("dia_semana_id = ".$dia)->orderBy("cliente_id")->get();
        $listViandas =  ViandaCliente::whereRaw("cliente_id NOT IN
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
            $pedidoEmpresa = new  PedidoEmpresa();
            $listAgrupacionViandasClientesXCliente = $empresaConViandas->groupBy('cliente_id');
            $lisPedidosTemporal = collect();
            foreach($listAgrupacionViandasClientesXCliente as $listViandasClientesEmpresa)
            {
                $pedidoCliente = new  Pedido();
                $idempresa=null;
                foreach($listViandasClientesEmpresa as $viandaClienteEmpresa)
                {

                    $pedidoCliente->cliente_id = $viandaClienteEmpresa->cliente_id;
                    $pedidoCliente->dia_id =$viandaClienteEmpresa->dia_semana_id;
                    $pedidoEmpresa->dia_id = $viandaClienteEmpresa->dia_semana_id;
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
        $listDiaSemana = DiaSemana::all();

        $cantidades = DB::select("SELECT tv.nombre , sum(cd.cantidad) AS cantidad, cd.dia_semana_id AS dia
                        FROM
                            cliente_dia cd
                            INNER JOIN tipo_vianda tv
                                ON   tv.id = cd.tipo_vianda_id
                                INNER JOIN cliente c ON c.id = cd.cliente_id
                        WHERE c.deleted_at IS NULL
                        GROUP BY tv.nombre, dia
                        ORDER BY cantidad, dia");
                       return view ('admin.include.viandas',compact('listPedidosClientes','listPedidosEmpresa','listDiaSemana','cantidades'));
    }
    ///Busca por dia de la semana
    public function buscar(Request $request)
    {
        //$listViandas = ViandaCliente::whereRaw("dia_semana_id = ".$dia)->orderBy("cliente_id")->get();
        $listViandas =  ViandaCliente::whereRaw("dia_semana_id = ".$request->id."
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
            $pedidoEmpresa = new  PedidoEmpresa();
            $listAgrupacionViandasClientesXCliente = $empresaConViandas->groupBy('cliente_id');
            $lisPedidosTemporal = collect();
            foreach($listAgrupacionViandasClientesXCliente as $listViandasClientesEmpresa)
            {
                $pedidoCliente = new  Pedido();
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
                    $pedidoEmpresa->dia_id = $request->id;
                    $pedidoEmpresa->envio = $pedidoCliente->Cliente->Empresa->envio;
                    $pedidoEmpresa->precio_envio =$pedidoCliente->Cliente->Empresa->Localidad->costo_envio;
                    $pedidoEmpresa->empresa_id = $idempresa;
                    $pedidoEmpresa->ListPedidos->push($pedidoCliente);
                }
                else
                {
                    $pedidoCliente->dia_id = $request->id;
                    $listPedidosClientes->push($pedidoCliente);
                }

            }
            if($pedidoEmpresa->ListPedidos->count() >0){
                $listPedidosEmpresa->push($pedidoEmpresa);
            }
        }

        $cantidades = DB::select("SELECT tv.nombre , sum(cd.cantidad) AS cantidad, cd.dia_semana_id AS dia
                        FROM
                            cliente_dia cd
                            INNER JOIN tipo_vianda tv
                                ON   tv.id = cd.tipo_vianda_id
                                INNER JOIN cliente c ON c.id = cd.cliente_id
                        WHERE c.deleted_at IS NULL
                        and cd.dia_semana_id = ".$request->id."
                        GROUP BY tv.nombre, dia
                        ORDER BY cantidad, dia");
       // $listClientes = Cliente::orderBy('nombre')->get();
        //$arrDiaSemana = array();
        $diaSemana = DiaSemana::findOrFail($request->id);
        $arrDiaSemana[] = $diaSemana;
        $listDiaSemana = Collection::make($arrDiaSemana);

        return view ('admin.include.viandas',compact('listPedidosClientes','listPedidosEmpresa','listDiaSemana','cantidades'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
