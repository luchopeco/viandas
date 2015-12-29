<?php

namespace viandas\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use viandas\Empresa;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\Pedido;
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
        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);

        $listPedidos = Pedido::where('fecha_pedido', $fecha);

        $listViandas = ViandaCliente::where('dia_semana_id', $fecha->dayOfWeek());


        /// recorro los pedidos, y limpio las viandas segun se realizaron los pedidos
        foreach ($listPedidos as $pedido)
        {
            $listViandas = $listViandas->where('cliente_id','!=',$pedido->cliente_id)->where('tipo_vianda_id','!=', $pedido->tipo_vianda_id);
        }

        $listEmpresas = Empresa::all();

        return view ('admin.include.pedidos',compact('listPedidos','listViandas','listEmpresas'));

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
