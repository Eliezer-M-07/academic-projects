<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Livro extends Model
{
    protected $fillable = [
        'titulo',
        'autor',
        'genero',
        'ano_publicacao',
        'nota',
        'data_conclusao'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

}
