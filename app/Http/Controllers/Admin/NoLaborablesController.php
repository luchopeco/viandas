<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use viandas\Alimento;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\NoLaborables;

class NoLaborablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $listNoLaborables = NoLaborables::all();
        
            return view('admin.nolaborables', compact('listNoLaborables'));
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
        try{
            $a= new NoLaborables($request->all());
            $a->save();

            Session::flash('mensajeOk', 'No Laborable  Agregado Con Exito');
            return back();
        }
        catch(\Exception $ex){

            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }

    }

    public function  buscar(Request $request)
    {
        $a=NoLaborables::findOrFail($request->id);
        $response = array(
            "result" => true,
            "mensaje" => "No se pudo realizar la operacion",
            "datos" => $a
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
            $a = NoLaborables::findOrFail($request->id);
            $a->fecha=$request->fecha;
            $a->motivo=$request->motivo;
            $a->estado=$request->estado;
           
            $a->save();

            Session::flash('mensajeOk','NoLaborables Modificado con exito');
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
            NoLaborables::destroy($request->id);
            Session::flash('mensajeOk','NoLaborables Eliminado con exito');
            return back();
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }
}
