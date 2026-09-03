<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LivroRegistroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'genero' => 'required|string|max:100',
            'ano_publicacao' => 'required|integer|min:1000|max:' . date('Y'),
            'nota' => 'required|numeric|min:0|max:10',
            'data_conclusao' => 'required|date|before_or_equal:today',
            'arquivo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título pode ter no máximo 255 caracteres.',

            'autor.required' => 'O autor é obrigatório.',
            'autor.max' => 'O autor pode ter no máximo 255 caracteres.',

            'genero.required' => 'O gênero é obrigatório.',
            'genero.max' => 'O gênero pode ter no máximo 100 caracteres.',

            'ano_publicacao.required' => 'O ano de publicação é obrigatório.',
            'ano_publicacao.integer' => 'O ano de publicação deve ser um número inteiro.',
            'ano_publicacao.min' => 'O ano de publicação deve ser válido.',
            'ano_publicacao.max' => 'O ano de publicação não pode ser maior que o ano atual.',

            'nota.required' => 'A nota é obrigatória.',
            'nota.numeric' => 'A nota deve ser um número.',
            'nota.min' => 'A nota deve ser no mínimo 0.',
            'nota.max' => 'A nota deve ser no máximo 10.',

            'data_conclusao.required' => 'A data de conclusão é obrigatória.',
            'data_conclusao.date' => 'A data de conclusão deve ser uma data válida.',
            'data_conclusao.before_or_equal' => 'A data de conclusão não pode ser futura.',

            'arquivo.image' => 'O arquivo deve ser uma imagem.',
            'arquivo.mimes' => 'A imagem deve estar no formato JPG, JPEG, PNG ou WEBP.',
            'arquivo.max' => 'A imagem pode ter no máximo 2 MB.',
        ];
    }
}

