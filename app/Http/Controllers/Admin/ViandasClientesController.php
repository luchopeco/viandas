<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\ViandaCliente;

class ViandasClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
            $a= new ViandaCliente($request->all());
            $a->save();

            Session::flash('mensajeOk', 'Vianda  Agregada Con Exito');
            return back();
        }
        catch(\Exception $ex){

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
    public function destroy(Request $request)
    {
        try{
            $aux = explode('-',$request->id);
            $cliente_id = $aux[0];
            $dia_semana_id=$aux[1];
            $tipo_vianda_id=$aux[2];
            DB::table('cliente_dia')->where('cliente_id', '=', $cliente_id)->where('dia_semana_id','=',$dia_semana_id)->where('tipo_vianda_id','=',$tipo_vianda_id)->delete();
            //ViandaCliente::destroy($cliente_id,$dia_semana_id,$tipo_vianda_id);
            Session::flash('mensajeOk','Vianda Eliminada con exito');
            return back();
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }
}
