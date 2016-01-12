<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use viandas\Alimento;
use viandas\Cliente;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\TipoAlimento;
use viandas\DiaSemana;
use viandas\TipoVianda;
use viandas\Empresa;
use viandas\Localidad;


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

    public function gestionarcliente($id)
    {
        try {                
                $cliente = "";
            //var_dump($id);die();
            if($id=='0'){
                $cliente = new CLiente;
            }else{
                $cliente = Cliente::findOrFail($id);
            }       
               
           
            $diasdelas = Diasdelasemana::all();
            return view('admin.clientesgestionar', compact('cliente','diaslasem'));
            //return view('admin.clientesgestionar', $cliente);       
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

    public function nomegustalista()
    {
        try
        {
            $listTiposAlimentos = TipoAlimento::all();
            return view('admin.loquenogusta', compact('listTiposAlimentos'));
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeError', $ex->getMessage());
            return view('admin.loquenogusta');
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
        $diasdelas = DiaSemana::all();
        $tipos = TipoVianda::all();
        $cliente = new Cliente(); 
        $localidades = Localidad::all();
        $empresas = Empresa::all();

        return view('admin.clientesgestionar', compact('cliente','diasdelas','tipos','empresas','localidades'));
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

        try{
            $a= new Cliente($request->all());
            
            if($request->envio<>null){
                $a->envio = 1;
            }
            else{
                $a->envio = 0;
            }

            $a->save();


            Session::flash('mensajeOk', 'Cliente  Agregado Con Exito');
            return redirect()->route('admin.clientes.index');
        }
        catch(\Exception $ex){

            Session::flash('mensajeError', $ex->getMessage());
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        $listtiposViandas = TipoVianda::all()->lists('nombre','id');
        $listdiasSemana = DiaSemana::all()->lists('nombre','id');

        return view('admin.clientesviandas', compact('cliente','listdiasSemana','listtiposViandas'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

            $cliente = Cliente::findOrFail($id); 
            $diasdelas = DiaSemana::all();
            $tipos = TipoVianda::all();


        $localidades = Localidad::all();
        $empresas = Empresa::all();


            return view('admin.clientesgestionar', compact('tipos','cliente','diasdelas','localidades','empresas'));
            //return view('admin.clientesgestionar', $cliente);       
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
         try {
            $a = Cliente::findOrFail($request->id);
            
            $a->nombre = $request->nombre;
            $a->apellido = $request->apellido;
            $a->email = $request->email;
            $a->dni = $request->dni;
            $a->telefono = $request->telefono;
            $a->idlocalidad = $request->idlocalidad;
            
            if($request->idempresa==0){
                $a->idempresa = null;

            }else{
                $a->idempresa = $request->idempresa;

            }
            
            

            $a->domicilio = $request->domicilio;




            if($request->envio<>null){
                $a->envio = 1;
            }
            else{
                $a->envio = 0;
            }

           

            $a->save();

            Session::flash('mensajeOk','Cliente Modificado con éxito');
             return redirect()->route('admin.clientes.index');


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
