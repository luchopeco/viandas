<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use viandas\Alimento;
use viandas\Cliente;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\TipoAlimento;
use viandas\Diasdelasemana;

class ClientesController extends Controller
{

    public $idActual;

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

            $listClientes = Cliente::all();
            return view('admin.clientes', compact('listClientes'));
        }
        catch(\Exception $ex){

            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }

    public function gestionarcliente()
    {
        try {
            
            var_dump($_GET);die();
            if ($id == null) {
               // es nuevo cliente
                $cliente ='nuevo';
            }
            else{
                $cliente = Cliente::findOrFail($id);

            }

            //var_dump($cliente);die();
           
            return view('admin.clientesgestionar', compact('cliente'));
        }
        catch(\Exception $ex){

            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }

    public function  nomegusta($id)
    {
        try {

            $cliente = Cliente::findOrFail($id);
            $listTiposAlimentos = TipoAlimento::all();
            return view('admin.nomegusta', compact('cliente','listTiposAlimentos'));
        }
        catch(\Exception $ex){

            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }


    public function nomegustaagregar(Request $request)
    {
        try{

            $cliente = Cliente::findOrFail($request->id);
            $cliente->ListAlimentosNoMeGusta()->detach();

            $listAlimentos = Alimento::all();

            foreach($listAlimentos as $alimento)
            {
                $desc ='nmg-'.$alimento->id;
                if ($request->has($desc)) {
                    $idali = $request->input($desc);
                    $cliente->ListAlimentosNoMeGusta()->attach($idali);
                }
            }

            Session::flash('mensajeOk','Alimentos que no le gustan agregados con exito ');
            return back();
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
    public function destroy(Request $request)
    {
        try
        {
            $tor = Cliente::withTrashed()->where('id', $request->id)->first();
            $tor->forceDelete();
            Session::flash('mensajeOk', 'Cliente Eliminado con Exito');
            return back();
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }

    public function baja(Request $request)
    {

        try
        {
            Cliente::destroy($request->id);
            Session::flash('mensajeOk', 'Cliente Dado de baja con Exito');
            return back();
        }
        catch(QueryException  $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }

    }
}
