<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\TipoVianda;

class TiposViandasController extends Controller
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
        $listTiposViandas =TipoVianda::all();
        return view ('admin.tiposviandas',compact('listTiposViandas'));
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
        $tv = new TipoVianda($request->all());
        $tv->save();

        Session::flash('mensajeOk', 'Tipo Vianda Agregada Con Exito');
        return redirect()->route('admin.tiposviandas.index');
    }
    public function  buscar(Request $request)
    {
        $tv = TipoVianda::findOrFail($request->id);
        $response = array(
            "result" => true,
            "mensaje" => "No se pudo realizar la operacion",
            "datos" => $tv
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
            $tv = TipoVianda::findOrFail($request->id);
            $tv->descripcion=$request->descripcion;
            $tv->nombre=$request->nombre;
            $tv->precio=$request->precio;
            $tv->save();

            Session::flash('mensajeOk','Tipo Vianda Modificada con exito');
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
            TipoVianda::destroy($request->id);
            Session::flash('mensajeOk','Tipo Vianda Eliminada con exito');
            return back();
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }
}
