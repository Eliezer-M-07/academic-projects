@extends('layouts.app')

@section('titulo', 'Editar livro')

@section('conteudo')

<div class="mx-auto max-w-5xl px-6 py-10">

<div class="mb-8">
    <a href="{{ route('livro.show', $livro) }}" class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-blue-700">
        <x-heroicon-o-arrow-left class="h-4 w-4" />
        Voltar para o livro
    </a>

    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Editar livro</h1>
    <p class="mt-2 text-sm text-slate-600">Atualize as informações do seu livro.</p>
</div>

<form action="{{ route('livro.editar', $livro) }}" method="POST" enctype="multipart/form-data" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    @csrf
    @method('PUT')

    <div class="grid md:grid-cols-5">

        <div class="flex flex-col items-center justify-start bg-slate-50 p-8 md:col-span-2 md:p-10">

            <p class="mb-4 w-full text-sm font-semibold text-slate-900">Capa do livro</p>

            <div class="w-full max-w-[260px] overflow-hidden rounded-xl bg-slate-200 shadow-md">
                <img id="preview-capa" src="{{ asset('storage/' . $livro->arquivo) }}" alt="Capa do livro {{ $livro->titulo }}" class="aspect-[3/4] w-full object-cover">
            </div>

            <label for="arquivo" class="mt-5 inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                <x-heroicon-o-photo class="h-5 w-5" />
                Alterar capa
            </label>

            <input type="file" id="arquivo" name="arquivo" accept="image/*" class="hidden">

            @error('arquivo')
                <p class="mt-2 text-center text-sm text-red-600">{{ $message }}</p>
            @enderror

            <p class="mt-2 text-center text-xs text-slate-500">JPG, JPEG, PNG ou WEBP.</p>

        </div>

        <div class="p-7 sm:p-9 md:col-span-3">

            <div class="space-y-5">

                <div>
                    <label for="titulo" class="mb-1.5 flex items-center gap-2 text-sm font-medium text-slate-700">
                        <x-heroicon-o-book-open class="h-4 w-4 text-blue-700" />
                        Título
                    </label>

                    <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $livro->titulo) }}" placeholder="Título do livro" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                    @error('titulo')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="autor" class="mb-1.5 flex items-center gap-2 text-sm font-medium text-slate-700">
                        <x-heroicon-o-user class="h-4 w-4 text-blue-700" />
                        Autor
                    </label>

                    <input type="text" id="autor" name="autor" value="{{ old('autor', $livro->autor) }}" placeholder="Nome do autor" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                    @error('autor')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="genero" class="mb-1.5 flex items-center gap-2 text-sm font-medium text-slate-700">
                        <x-heroicon-o-tag class="h-4 w-4 text-blue-700" />
                        Gênero
                    </label>

                    <input type="text" id="genero" name="genero" value="{{ old('genero', $livro->genero) }}" placeholder="Ex.: Romance, Ficção, Fantasia..." class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                    @error('genero')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-5 sm:grid-cols-2">

                    <div>
                        <label for="ano_publicacao" class="mb-1.5 flex items-center gap-2 text-sm font-medium text-slate-700">
                            <x-heroicon-o-calendar-days class="h-4 w-4 text-blue-700" />
                            Ano de publicação
                        </label>

                        <input type="number" id="ano_publicacao" name="ano_publicacao" value="{{ old('ano_publicacao', $livro->ano_publicacao) }}" placeholder="Ex.: 2020" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                        @error('ano_publicacao')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nota" class="mb-1.5 flex items-center gap-2 text-sm font-medium text-slate-700">
                            <x-heroicon-o-star class="h-4 w-4 text-blue-700" />
                            Nota
                        </label>

                        <input type="number" id="nota" name="nota" value="{{ old('nota', $livro->nota) }}" min="0" max="10" step="0.1" placeholder="0 a 10" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                        @error('nota')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div>
                    <label for="data_conclusao" class="mb-1.5 flex items-center gap-2 text-sm font-medium text-slate-700">
                        <x-heroicon-o-check-circle class="h-4 w-4 text-blue-700" />
                        Data de conclusão
                    </label>

                    <input type="date" id="data_conclusao" name="data_conclusao" value="{{ old('data_conclusao', $livro->data_conclusao) }}" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                    @error('data_conclusao')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-8 flex flex-col gap-3 border-t border-slate-100 pt-7 sm:flex-row sm:justify-end">

                <a href="{{ route('livro.show', $livro) }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Cancelar
                </a>

                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 hover:shadow-md">
                    <x-heroicon-o-check class="h-5 w-5" />
                    Salvar alterações
                </button>

            </div>

        </div>

    </div>

</form>


</div>

<script>
    const arquivo = document.getElementById('arquivo');
    const preview = document.getElementById('preview-capa');

    arquivo.addEventListener('change', function () {
        const imagem = this.files[0];

        if (imagem) {
            preview.src = URL.createObjectURL(imagem);
        }
    });
</script>

@endsection
