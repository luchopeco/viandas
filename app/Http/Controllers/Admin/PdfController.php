<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Http\Request;

use viandas\Cliente;
use viandas\DiaSemana;
use viandas\Empresa;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;

class PdfController extends Controller
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
        return view('admin.pdf.planillasemanal');
    }

    public function planillasemanal()
    {

        $listDiaSemana = DiaSemana::all();
        $listEmpresas = Empresa::all();
        $listClientesSinEmpresa= Cliente::whereRaw(' id in (select distinct cliente_id from cliente_dia ) and idempresa is null')->get();

//        $view =  \View::make('admin.pdf.planillasemanal',compact('listDiaSemana','listEmpresas','listClientesSinEmpresa'))->render();
//        $pdf =  \App::make('dompdf.wrapper');
//        $pdf->setPaper("A4", "portrait");
//        $pdf->loadHTML($view);
//        return $pdf->stream('planilaa');
        return view('admin.pdf.planillasemanal',compact('listDiaSemana','listEmpresas','listClientesSinEmpresa'));
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
