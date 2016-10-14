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
        return view('admin.pdf.planilla');
    }

    public function planillasemanal()
    {
        //set_time_limit(0);
        //ini_set("memory_limit",-1);
        //ini_set('max_execution_time', 0);

        $listPedidos= DB::select("SELECT
                        c.apellido,
                        c.nombre,
                        CASE c.envio WHEN 1 THEN 'SI'  WHEN 0 THEN 'NO' END AS envio,
                        GROUP_CONCAT(DISTINCT CONCAT(cd.cantidad,' ',tv.nombre, ' $', tv.precio,'<br>' ) SEPARATOR ' ') AS pedido,
			SUM(cd.cantidad * tv.precio) / CASE COUNT(a.nombre) WHEN 0 THEN 1 ELSE COUNT(a.nombre)  END AS total,
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
                     WHERE c.deleted_at IS NULL
                    GROUP BY 	c.apellido,
                        c.nombre,
                        c.envio,
                        dia
                    ORDER BY dia ASC,  c.apellido ASC , c.nombre Asc
                    ");

        $cantidades = DB::select("SELECT
                            tv.nombre,
                            SUM(CASE WHEN cd.dia_semana_id = 2 THEN cd.cantidad ELSE 0 END)  lunes,
                            sum(CASE WHEN cd.dia_semana_id = 3 THEN cd.cantidad ELSE 0 END)  martes,
                            sum(CASE WHEN cd.dia_semana_id = 4 THEN cd.cantidad ELSE 0 END)  miercoles,
                            sum(CASE WHEN cd.dia_semana_id = 5 THEN cd.cantidad ELSE 0 END)  jueves,
                            sum(CASE WHEN cd.dia_semana_id = 6 THEN cd.cantidad ELSE 0 END)  viernes,
                            sum(cd.cantidad) total

                        FROM
                            tipo_vianda tv
                            LEFT JOIN cliente_dia cd
                                ON   tv.id = cd.tipo_vianda_id
                            INNER JOIN cliente c
                                ON   c.id = cd.cliente_id
                        WHERE
                            c.deleted_at IS NULL
                        GROUP BY
                            tv.nombre

                            UNION
                            SELECT 'Todas' nombre,
                                SUM(CASE WHEN cd.dia_semana_id = 2 THEN cd.cantidad ELSE 0 END)  lunes,
                                sum(CASE WHEN cd.dia_semana_id = 3 THEN cd.cantidad ELSE 0 END)  martes,
                                sum(CASE WHEN cd.dia_semana_id = 4 THEN cd.cantidad ELSE 0 END)  miercoles,
                                sum(CASE WHEN cd.dia_semana_id = 5 THEN cd.cantidad ELSE 0 END)  jueves,
                                sum(CASE WHEN cd.dia_semana_id = 6 THEN cd.cantidad ELSE 0 END)  viernes,
                                sum(cd.cantidad) total
                             FROM tipo_vianda tv
                            LEFT JOIN cliente_dia cd
                                ON   tv.id = cd.tipo_vianda_id
                            INNER JOIN cliente c
                                ON   c.id = cd.cliente_id
                        WHERE
                            c.deleted_at IS NULL

                            ORDER BY total DESC
                        ");
        $listDiaSemana = DiaSemana::all();
        $listEmpresas = Empresa::all();
        //$listClientesSinEmpresa= Cliente::whereRaw(' id in (select distinct cliente_id from cliente_dia ) and idempresa is null')->get();

        //$view =  \View::make('admin.pdf.planillasemanal',compact('listDiaSemana','listEmpresas','listClientesSinEmpresa'))->render();
        //$view =  \View::make('admin.pdf.planilla',compact('listDiaSemana','listEmpresas','listPedidos','cantidades'))->render();
        //$pdf =  \App::make('dompdf.wrapper');
        //$pdf->setPaper("A4", "portrait");
        //$pdf->loadHTML($view);
        //return $pdf->stream('planilaa');
//        return view('admin.pdf.planillasemanal',compact('listDiaSemana','listEmpresas','listClientesSinEmpresa'));
        return view('admin.pdf.planilla',compact('listDiaSemana','listEmpresas','listPedidos','cantidades'));
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
