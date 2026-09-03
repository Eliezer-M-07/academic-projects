<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioLoginRequest;
use App\Http\Requests\UsuarioRegistroRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function form_cadastrar()
    {
        return view('auth.form-cadastro');
    }

    public function create(UsuarioRegistroRequest $request)
    {
        $usuario = new User($request->validated());

        $usuario->save();

        Auth::login($usuario);

        $request->session()->regenerate();

        return redirect()->route('home')->with('sucesso', 'Conta criada com sucesso.');
    }

    public function form_login()
    {
        return view('auth.form-login');
    }

    public function login(UsuarioLoginRequest $request)
    {
        if(!Auth::attempt($request->validated()))
        {
            return redirect()->route('login')->withErrors(['email' => 'Credenciais inválidas.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('sucesso', 'Login realizado com sucesso.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('sucesso', 'Logout realizado com sucesso.');
    }
}
