@extends('layouts.app')

@section('titulo', 'Adicionar livro')

@section('conteudo')

<div class="mx-auto max-w-2xl px-6 py-12">

<div class="mb-8">
    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Adicionar livro</h1>
    <p class="mt-2 text-sm text-slate-600">Registre uma nova leitura na sua estante.</p>
</div>

<form action="{{ route('livro.cadastro') }}" method="POST" enctype="multipart/form-data" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    @csrf

    <div>
        <label for="titulo" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
            <x-heroicon-o-book-open class="h-4 w-4 text-blue-700" />
            Título
        </label>

        <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" placeholder="Título do livro" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

        @error('titulo')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="autor" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
            <x-heroicon-o-user class="h-4 w-4 text-blue-700" />
            Autor
        </label>

        <input type="text" id="autor" name="autor" value="{{ old('autor') }}" placeholder="Nome do autor" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

        @error('autor')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="genero" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                <x-heroicon-o-tag class="h-4 w-4 text-blue-700" />
                Gênero
            </label>

            <input type="text" id="genero" name="genero" value="{{ old('genero') }}" placeholder="Ex.: Romance" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

            @error('genero')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="ano_publicacao" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                <x-heroicon-o-calendar class="h-4 w-4 text-blue-700" />
                Ano de publicação
            </label>

            <input type="number" id="ano_publicacao" name="ano_publicacao" value="{{ old('ano_publicacao') }}" placeholder="Ex.: 2024" min="0" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

            @error('ano_publicacao')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="nota" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                <x-heroicon-o-star class="h-4 w-4 text-blue-700" />
                Nota
            </label>

            <input type="number" id="nota" name="nota" value="{{ old('nota') }}" placeholder="Ex.: 8.5" min="0" max="10" step="0.1" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

            @error('nota')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="data_conclusao" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                <x-heroicon-o-calendar-days class="h-4 w-4 text-blue-700" />
                Data de conclusão
            </label>

            <input type="date" id="data_conclusao" name="data_conclusao" value="{{ old('data_conclusao') }}" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

            @error('data_conclusao')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="arquivo" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
            <x-heroicon-o-photo class="h-4 w-4 text-blue-700" />
            Capa do livro
        </label>

        <input type="file" id="arquivo" name="arquivo" accept="image/*" class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-3 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100">

        <p class="mt-1.5 text-xs text-slate-500">Opcional. Caso nenhuma imagem seja enviada, a capa padrão será utilizada.</p>

        @error('arquivo')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex flex-col gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:justify-end">
        <a href="{{ route('usuario.livros') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
            <x-heroicon-o-arrow-left class="h-5 w-5" />
            Cancelar
        </a>

        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <x-heroicon-o-plus class="h-5 w-5" />
            Adicionar livro
        </button>
    </div>
</form>


</div>

@endsection
