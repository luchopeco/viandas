<?php

namespace viandas\Http\Controllers\Admin;

use Carbon\Carbon;
use Faker\Provider\zh_TW\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use viandas\Gasto;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\TipoGasto;

class GastosController extends Controller
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
        $listTipoGastos = TipoGasto::all()->lists('descripcion', 'id');
        return view ('admin.gastos',compact('listTipoGastos'));
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
            $a= new Gasto($request->all());
            $fd = Carbon::parse($request->fecha)->format('Y-d-m');
            $a->fecha=$fd;
            $a->save();

            Session::flash('mensajeOk', 'Gasto  Agregado Con Exito');
            return back();
        }
        catch(\Exception $ex){

            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }

    }
    public function  buscarxfechas(Request $request)
    {
        $fd = Carbon::parse($request->fecha_desde)->format('Y-d-m');
        $fh = Carbon::parse($request->fecha_hasta)->format('Y-d-m');
        $listGastos = Gasto::whereRaw("fecha >= '". $fd. "' AND  fecha <='". $fh."'")->get();
        return view ('admin.include.gastos',compact('listGastos'));
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
