<?php

namespace Database\Seeders;

use App\Models\Livro;
use App\Models\User;
use Illuminate\Database\Seeder;

class LivroSeeder extends Seeder
{
    public function run(): void
    {
        $usuario = User::first();

        Livro::create([
            'user_id' => $usuario->id,
            'titulo' => 'O Hobbit',
            'autor' => 'J. R. R. Tolkien',
            'genero' => 'Fantasia',
            'ano_publicacao' => 1937,
            'nota' => 9.0,
            'data_conclusao' => '2026-01-15',
            'arquivo' => 'imagens/capa-padrao.webp',
        ]);

        Livro::create([
            'user_id' => $usuario->id,
            'titulo' => '1984',
            'autor' => 'George Orwell',
            'genero' => 'Distopia',
            'ano_publicacao' => 1949,
            'nota' => 9.5,
            'data_conclusao' => '2026-02-20',
            'arquivo' => 'imagens/capa-padrao.webp',
        ]);

        Livro::create([
            'user_id' => $usuario->id,
            'titulo' => 'O Nome do Vento',
            'autor' => 'Patrick Rothfuss',
            'genero' => 'Fantasia',
            'ano_publicacao' => 2007,
            'nota' => 10.0,
            'data_conclusao' => '2026-03-10',
            'arquivo' => 'imagens/capa-padrao.webp',
        ]);
    }
}

