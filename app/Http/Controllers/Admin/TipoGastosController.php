<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\TipoGasto;

class TipoGastosController extends Controller
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
        $listTiposGastos = TipoGasto::all();
        return view ('admin.tiposgastos',compact('listTiposGastos'));
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
        $ta = new TipoGasto($request->all());
        $ta->save();

        Session::flash('mensajeOk', 'Tipo Gasto Agregado Con Exito');
        return back();
    }
    public function  buscar(Request $request)
    {
        $ta = TipoGasto::findOrFail($request->id);
        $response = array(
            "result" => true,
            "mensaje" => "No se pudo realizar la operacion",
            "datos" => $ta
        );
        return json_encode($response, JSON_HEX_QUOT | JSON_HEX_TAG);
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
    public function update(Request $request)
    {
        try {
            $tp = TipoGasto::findOrFail($request->id);
            $tp->descripcion=$request->descripcion;
            $tp->save();


            Session::flash('mensajeOk','Tipo Gasto Modificado con exito');
            return back();

        }
        catch( \Exception $ex)
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
            TipoGasto::destroy($request->id);
            Session::flash('mensajeOk','Tipo Gasto Eliminado con exito');
            return back();
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }
}
