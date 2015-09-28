<?php

namespace viandas\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        if (Auth::attempt(['name' => $request->name, 'password' => $request->password]))
        {
            return redirect()->intended('/admin/home');
        }
        else
        {
            Session::flash('mensajeError','Usuario y/o clave Incorreta');
            return $this->getLogin();
        }
    }
    public function getLogout()
    {
        Auth::logout();
        return $this->getLogin();
    }
}
