<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use viandas\DiaSemana;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;

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
        $listDiaSemana = DiaSemana::all();
        return view ('admin.include.viandas',compact('listDiaSemana'));
    }
    ///Busca por dia de la semana
    public function buscar(Request $request)
    {
        $arrDiaSemana = array();
        $diaSemana = DiaSemana::findOrFail($request->id);
        $arrDiaSemana[] = $diaSemana;
        $listDiaSemana = Collection::make($arrDiaSemana);
        return view ('admin.include.viandas',compact('listDiaSemana'));
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
