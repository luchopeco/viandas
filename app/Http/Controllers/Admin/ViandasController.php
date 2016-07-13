<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use viandas\Cliente;
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
        $listPedidos= DB::select("SELECT
                        c.apellido,
                        c.nombre,
                        case c.envio when 1 then 'SI'  when 0 then 'NO' end as envio,
                        cd.cantidad,
                        tv.nombre tipo_vianda,
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
                        c.envio,
                         tipo_vianda,
                        total
                    ORDER BY dia ASC,  c.apellido ASC , c.nombre Asc
                    ");
        $listDiaSemana = DiaSemana::all();
        return view ('admin.include.viandas',compact('listPedidos','listDiaSemana'));
    }
    ///Busca por dia de la semana
    public function buscar(Request $request)
    {
        $listPedidos= DB::select("SELECT
                        c.apellido,
                        c.nombre,
                        case c.envio when 1 then 'SI'  when 0 then 'NO' end as envio,
                        cd.cantidad,
                        tv.nombre tipo_vianda,
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
                    WHERE cd.dia_semana_id = ".$request->id."
                    GROUP BY 	c.apellido,
                        c.nombre,
                        cd.cantidad,
                        c.envio,
                         tipo_vianda,
                        total
                    ORDER BY dia ASC,  c.apellido ASC , c.nombre Asc
                    ");

       // $listClientes = Cliente::orderBy('nombre')->get();
        //$arrDiaSemana = array();
        $diaSemana = DiaSemana::findOrFail($request->id);
        $arrDiaSemana[] = $diaSemana;
        $listDiaSemana = Collection::make($arrDiaSemana);
        return view ('admin.include.viandas',compact('listPedidos','listDiaSemana'));
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
