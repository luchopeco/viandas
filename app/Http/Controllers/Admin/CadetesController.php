<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\Cadete;


class CadetesController extends Controller
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
            $listCadetes = Cadete::all();
            return view('admin.cadetes', compact('listCadetes'));
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
            $a= new Cadete($request->all());
            $a->save();

            Session::flash('mensajeOk', 'Cadete  Agregado Con éxito');
            return back();
        }
        catch(\Exception $ex){

            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }
    public function  buscar(Request $request)
    {
        $a=Cadete::findOrFail($request->id);
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
            $a = Cadete::findOrFail($request->id);
            $a->nombre=$request->nombre;
            $a->apellido=$request->apellido;
            $a->email=$request->email;
            $a->telefono=$request->telefono;
            
            $a->save();

            Session::flash('mensajeOk','Cadete Modificado con éxito');
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
            Cadete::destroy($request->id);
            Session::flash('mensajeOk','Cadete dado de baja con éxito');
            return back();
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }

    public function listaDeBaja()
    {
        try {
           //var_dump('algo');die();
           $listDeleted = Cadete::onlyTrashed()->get();
            
            return view('admin.cadetesbaja', compact('listDeleted'));
        }
        catch(\Exception $ex){

            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }



    
}
