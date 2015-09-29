<?php

namespace viandas\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use viandas\Http\Requests;
use viandas\Http\Controllers\Controller;
use viandas\User;

class HomeController extends Controller
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
        return view('admin.home');
    }

    public function modificarclave()
    {
        try
        {
            if(Input::get('clave-nueva')==''||Input::get('clave-nueva-2')=='')
            {
                Session::flash('mensajeErrorSession', 'Ingrese una clave nueva');
                return redirect()->action('Admin\HomeController@index');

            }
            else if(Input::get('clave-nueva')!=Input::get('clave-nueva-2'))
            {
                Session::flash('mensajeErrorSession', 'Las claves nuevas no coinciden');
                return redirect()->action('Admin\HomeController@index');
            }
            else{

                $eq = User::findOrFail( Auth::user()->id);
                if (Hash::check(Input::get('clave-actual'),$eq->password))
                {
                    $eq->password=Hash::make(Input::get('clave-nueva'));
                    $eq->save();
                    Session::flash('mensajeOkSession', 'Clave modificada Correctamente');
                    return redirect()->action('Admin\HomeController@index');
                }
                else
                {
                    Session::flash('mensajeErrorSession', 'La clave actual es incorrecta');
                    return redirect()->action('Admin\HomeController@index');
                }

            }
        }
        catch(\Exception $ex)
        {
            Session::flash('mensajeErrorSession', $ex->getMessage());
            return redirect()->action('Admin\HomeController@index');
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
    public function destroy($id)
    {
        //
    }
}
