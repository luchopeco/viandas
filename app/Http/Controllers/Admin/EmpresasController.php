<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use viandas\Cliente;
use viandas\Empresa;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\Localidad;
use viandas\TipoVianda;

class EmpresasController extends Controller
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
            $listEmpresas = Empresa::orderBy('nombre')->get();
            $listEmpresasBajas = Empresa::onlyTrashed()->get();
            $listLocalidad = Localidad::all()->lists('nombre', 'id');
            return view('admin.empresas', compact('listEmpresas', 'listLocalidad','listEmpresasBajas'));
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
            $a= new Empresa($request->all());
            if ($request->envio<> null) {
                $a->envio= 1;
            } else {
                $a->envio= 0;
            }
            $a->save();

            Session::flash('mensajeOk', 'Empresa  Agregada Con Exito');
            return back();
        }
        catch(\Exception $ex){

            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }

    public function  buscar(Request $request)
    {
        $a=Empresa::findOrFail($request->id);
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
        $listTiposViandas = TipoVianda::all()->lists('nombre', 'id');;
        $empresa = Empresa::findOrFail($id);
        return view('admin.empresa', compact('empresa','listTiposViandas'));
    }

    public function preciovianda(Request $request)
    {
        try {

            $emp = Empresa::findOrFail($request->empresa_id);

            $emp->ListPreciosViandas()->attach($request->tipo_vianda_id,['precio'=>$request->precio]);
            Session::flash('mensajeOk', 'Precio Vianda Agregado con Exito');
            return Redirect::route('admin.empresas.show',$request->empresa_id);

        }
        catch(\Exception  $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return Redirect::route('admin.empresas.show',$request->empresa_id);

        }

    }

    public function precioviandaeliminar(Request $request)
    {
        try {
            $emp = Empresa::findOrFail($request->empresa_id);
            $tipo = TipoVianda::findOrFail($request->tipo_vianda_id);
            $emp->ListPreciosViandas()->detach($tipo);
            Session::flash('mensajeOk', 'Precio Vianda Eliminado con Exito');
            return Redirect::route('admin.empresas.show',$request->empresa_id);

        }
        catch(\Exception  $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return Redirect::route('admin.empresas.show',$request->empresa_id);

        }

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
            $a = Empresa::findOrFail($request->id);
            $a->nombre=$request->nombre;
            $a->idlocalidad=$request->idlocalidad;
            if ($request->envio<> null) {
                $a->envio= 1;
            } else {
                $a->envio= 0;
            }
            $a->save();

            Session::flash('mensajeOk','Empresa Modificada con exito');
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
            $listC = Cliente::where('idempresa',$request->id)->get();
            foreach($listC as $c)
            {
                Cliente::destroy($c->id);
            }
            Empresa::destroy($request->id);
            Session::flash('mensajeOk','Empresa Eliminada con exito');
            return back();
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }
    }

    public function alta(Request $request)
    {

        try {
            $tor = Empresa::withTrashed()->where('id', $request->id)->first();
            $tor->restore();
            $listC = Cliente::withTrashed()->where('idempresa',$request->id)->get();
            foreach($listC as $c)
            {
                $c->restore();
            }
            Session::flash('mensajeOk', 'Empresa dada de alta con exito');

            return back();
        } catch (QueryException  $ex) {
            Session::flash('mensajeError', $ex->getMessage());
            $listJugador = Jugador::onlyTrashed()->get();
            return view('admin.listanegra', compact('listJugador'));
        }

    }
}
