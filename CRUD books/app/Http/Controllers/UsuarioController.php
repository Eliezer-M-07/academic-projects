<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioEditarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UsuarioController extends Controller
{
    public function perfil()
    {
        $usuario = auth()->user();

        return view('usuario.perfil', compact('usuario'));
    }

    public function form_editar()
    {
        $usuario = auth()->user();

        return view('usuario.form-editar', compact('usuario'));
    }

    public function editar(UsuarioEditarRequest $request)
    {
        $dados = $request->validated();

        if (empty($dados['password'])) {
            unset($dados['password']);
        }

        $usuario = auth()->user();

        $usuario->fill($dados);
        $usuario->save();

        return redirect()->route('usuario.perfil')->with('sucesso', 'Dados atualizados com sucesso.');
    }

    public function deletar(Request $request)
    {
        auth()->user()->delete();
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('sucesso', 'Conta excluida com sucesso.');
    }
}
