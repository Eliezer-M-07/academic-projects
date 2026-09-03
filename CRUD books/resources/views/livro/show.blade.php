@extends('layouts.app')

@section('titulo', $livro->titulo)

@section('conteudo')

@if (session('sucesso')) 
<div id="mensagem-sucesso" class="fixed top-6 right-6 z-50 w-full max-w-sm transition-all duration-500"> 
    <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-white p-4 shadow-lg"> 
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-green-100"> 
    <x-heroicon-o-check class="h-5 w-5 text-green-600" /> </div>
        <div class="min-w-0 flex-1">
            <p class="text-sm font-semibold text-slate-900">Sucesso!</p>
            <p class="mt-1 text-sm text-slate-600">{{ session('sucesso') }}</p>
        </div>
    </div>
</div>

<script>
    setTimeout(() => {
        const mensagem = document.getElementById('mensagem-sucesso');

        if (mensagem) {
            mensagem.classList.add('translate-y-4', 'opacity-0');

            setTimeout(() => {
                mensagem.remove();
            }, 500);
        }
    }, 2500);
</script>


@endif

<div class="mx-auto max-w-4xl px-6 py-8">


<div class="mb-5">
    <a href="{{ route('usuario.livros') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-blue-700">
        <x-heroicon-o-arrow-left class="h-4 w-4" />
        Voltar para meus livros
    </a>
</div>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex flex-col md:flex-row">

        <div class="relative w-full bg-slate-100 md:w-2/5">
            <img src="{{ asset('storage/' . $livro->arquivo) }}" alt="Capa do livro {{ $livro->titulo }}" class="h-full min-h-[420px] w-full object-cover md:min-h-full">
        </div>

        <div class="w-full p-7 sm:p-8 md:w-3/5">

            <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                {{ $livro->genero }}
            </span>

            <div class="mt-4">
                <h1 class="text-3xl font-bold leading-tight tracking-tight text-slate-900">
                    {{ $livro->titulo }}
                </h1>

                <p class="mt-2 text-lg text-slate-600">
                    {{ $livro->autor }}
                </p>
            </div>

            <div class="mt-6">
                <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Minha avaliação
                </p>

                <div class="inline-flex items-center gap-2 rounded-lg border border-yellow-100 bg-yellow-50 px-4 py-2">
                    <x-heroicon-s-star class="h-5 w-5 text-yellow-500" />

                    <span class="text-lg font-bold text-slate-900">
                        {{ number_format($livro->nota, 1, ',', '.') }}
                    </span>

                    <span class="text-sm text-slate-500">/ 10</span>
                </div>
            </div>

            <div class="mt-7 border-t border-slate-100 pt-6">

                <h2 class="text-sm font-semibold text-slate-900">
                    Informações do livro
                </h2>

                <div class="mt-5 grid gap-5 sm:grid-cols-2">

                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-700">
                            <x-heroicon-o-book-open class="h-5 w-5" />
                        </div>

                        <div>
                            <p class="text-xs font-medium text-slate-500">Ano de publicação</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $livro->ano_publicacao }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-700">
                            <x-heroicon-o-check-circle class="h-5 w-5" />
                        </div>

                        <div>
                            <p class="text-xs font-medium text-slate-500">Data de conclusão</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ \Carbon\Carbon::parse($livro->data_conclusao)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-7 flex flex-col gap-3 border-t border-slate-100 pt-6 sm:flex-row">

                <a href="{{ route('livro.form_editar', $livro) }}" class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 hover:shadow-md">
                    <x-heroicon-o-pencil-square class="h-5 w-5" />
                    Editar livro
                </a>

                <form action="{{ route('livro.deletar', $livro) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')

                    <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este livro?')" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                        <x-heroicon-o-trash class="h-5 w-5" />
                        Excluir
                    </button>
                </form>

            </div>

        </div>

    </div>

</div>


</div>

@endsection
