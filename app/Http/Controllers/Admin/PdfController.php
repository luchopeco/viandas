<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
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
       $listPedidos= DB::select(DB::raw("SELECT
                        c.apellido,
                        c.nombre,
                        cd.cantidad,
                        CONCAT(tv.nombre, ' - $', tv.precio ) AS pedido,
                        cd.cantidad * tv.precio AS total,
                        GROUP_CONCAT(DISTINCT a.nombre ORDER BY a.nombre SEPARATOR  ', ' ) no_me_gusta,
                        e.nombre AS empresa,
                        cd.dia_semana_id AS dia
                    FROM
                        cliente_dia cd
                        INNER JOIN tipo_vianda tv
                            ON   tv.id = cd.tipo_vianda_id
                            INNER JOIN cliente c ON c.id = cd.cliente_id
                            LEFT JOIN no_me_gusta nmg ON nmg.cliente_id = c.id
                            LEFT JOIN alimento a ON a.id = nmg.alimento_id
                            LEFT JOIN empresa e ON e.id = c.idempresa
                    GROUP BY 	c.apellido,
                        c.nombre,
                        cd.cantidad,
                         pedido,
                        total
                    ORDER BY dia ASC,  c.apellido ASC , c.nombre Asc
                    "));

        $listDiaSemana = DiaSemana::all();
        $listEmpresas = Empresa::all();
        //$listClientesSinEmpresa= Cliente::whereRaw(' id in (select distinct cliente_id from cliente_dia ) and idempresa is null')->get();

        //$view =  \View::make('admin.pdf.planillasemanal',compact('listDiaSemana','listEmpresas','listClientesSinEmpresa'))->render();
        $view =  \View::make('admin.pdf.planilla',compact('listDiaSemana','listEmpresas','listPedidos'))->render();
        $pdf =  \App::make('dompdf.wrapper');
        $pdf->setPaper("A4", "portrait");
        $pdf->loadHTML($view);
        return $pdf->stream('planilaa');
//        return view('admin.pdf.planillasemanal',compact('listDiaSemana','listEmpresas','listClientesSinEmpresa'));
        //return view('admin.pdf.planilla',compact('listDiaSemana','listEmpresas','listPedidos'));
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
