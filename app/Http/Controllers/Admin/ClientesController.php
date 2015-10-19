<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use viandas\Cliente;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\TipoAlimento;

class ClientesController extends Controller
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
        try {

            $listClientes = Cliente::all();
            return view('admin.clientes', compact('listClientes'));
        }
        catch(\Exception $ex){

            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }

    public function  nomegusta($id)
    {
        try {

            $cliente = Cliente::findOrFail($id);
            $listTiposAlimentos = TipoAlimento::all();
            return view('admin.nomegusta', compact('cliente','listTiposAlimentos'));
        }
        catch(\Exception $ex){

            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
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
