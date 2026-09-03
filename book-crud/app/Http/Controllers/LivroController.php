<?php

namespace App\Http\Controllers;

use App\Http\Requests\LivroEditarRequest;
use App\Http\Requests\LivroRegistroRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Livro;

class LivroController extends Controller
{
    public function index()
    {
        $livros = auth()->user()->livros()->paginate(8);

        return view('usuario.livros', compact('livros'));
    }

    public function show(Livro $livro)
    {
        if($livro->user_id !== auth()->id()) abort(403);
        
        return view('livro.show', compact('livro'));
    }

    public function form_cadastrar()
    {
        return view('livro.form-cadastro');
    }

    public function create(LivroRegistroRequest $request)
    {
        $livro = new Livro($request->validated());

        $livro->user_id = auth()->id();

        if($request->hasFile('arquivo')){
            $livro->arquivo = $request->file('arquivo')->store('imagens', 'public');
        }else {
            $livro->arquivo = 'imagens/capa-padrao.webp';
        }
        
        $livro->save();

        return redirect()->route('usuario.livros')->with('sucesso', 'Livro criado com sucesso.');
    }

    public function form_editar(Livro $livro)
    {
        if ($livro->user_id !== auth()->id()) abort(403);
        
        return view('livro.form-editar', compact('livro'));
    }

    public function editar(LivroEditarRequest $request, Livro $livro)
    {
        if ($livro->user_id !== auth()->id()) abort(403);

        $livro->fill($request->validated());

        if ($request->hasFile('arquivo')) {
            if($livro->arquivo && $livro->arquivo != 'imagens/capa-padrao.webp'){
                Storage::disk('public')->delete($livro->arquivo);
            }
            $livro->arquivo = $request->file('arquivo')->store('imagens', 'public');
        }

        $livro->save();

        return redirect()->route('livro.show', $livro)->with('sucesso', 'Livro editado com sucesso.');
    }

    public function deletar(Livro $livro)
    {
        if ($livro->user_id !== auth()->id()) abort(403);

        if($livro->arquivo && $livro->arquivo != 'imagens/capa-padrao.webp'){
            Storage::disk('public')->delete($livro->arquivo);
        }

        $livro->delete();

        return redirect()->route('usuario.livros');
    }


}
