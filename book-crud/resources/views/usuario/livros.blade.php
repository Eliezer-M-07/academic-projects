@extends('layouts.app')

@section('titulo', 'Meus livros')

@section('conteudo')

    <div class="mx-auto max-w-6xl px-6 py-12">
    
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Meus livros</h1>
                <p class="mt-2 text-sm text-slate-600">Confira os livros que você registrou na sua estante.</p>
            </div>

            <a href="{{ route('livro.form_cadastro') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-800">
                <x-heroicon-o-plus class="h-5 w-5" />
                Adicionar livro
            </a>
        </div>

      
        @if ($livros->count())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($livros as $livro)
                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                      
                        <a href="{{ route('livro.show', $livro) }}" class="block">
                            <div class="aspect-[3/4] overflow-hidden bg-slate-100">
                                <img src="{{ asset('storage/' . $livro->arquivo) }}" alt="Capa do livro {{ $livro->titulo }}" class="h-full w-full object-cover transition duration-300 hover:scale-105">
                            </div>
                        </a>

                
                        <div class="p-4">
                            <a href="{{ route('livro.show', $livro) }}">
                                <h2 class="truncate text-base font-semibold text-slate-900 hover:text-blue-700">{{ $livro->titulo }}</h2>
                            </a>

                            <p class="mt-1 truncate text-sm text-slate-600">{{ $livro->autor }}</p>

                            <div class="mt-3 flex items-center justify-between gap-2">
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">{{ $livro->genero }}</span>

                                <span class="flex items-center gap-1 text-sm font-semibold text-slate-700">
                                    <x-heroicon-s-star class="h-4 w-4 text-yellow-500" />
                                    {{ number_format($livro->nota, 1, ',', '.') }}
                                </span>
                            </div>

 
                            <div class="mt-4 flex gap-2 border-t border-slate-100 pt-3">
                                <a href="{{ route('livro.show', $livro) }}" class="flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">
                                    <x-heroicon-o-eye class="h-4 w-4" />
                                    Ver
                                </a>

                                <a href="{{ route('livro.form_editar', $livro) }}" class="flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-blue-700 px-3 py-2 text-xs font-semibold text-white transition hover:bg-blue-800">
                                    <x-heroicon-o-pencil-square class="h-4 w-4" />
                                    Editar
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $livros->onEachSide(1)->links('vendor.pagination.custom') }}
            </div>
        @else
  
            <div class="rounded-xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-50">
                    <x-heroicon-o-book-open class="h-7 w-7 text-blue-700" />
                </div>

                <h2 class="mt-5 text-lg font-semibold text-slate-900">Sua estante está vazia</h2>

                <p class="mx-auto mt-2 max-w-md text-sm text-slate-600">
                    Você ainda não cadastrou nenhum livro. Comece adicionando sua primeira leitura.
                </p>

                <a href="{{ route('livro.form_cadastro') }}" class="mt-6 inline-flex items-center gap-2 rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">
                    <x-heroicon-o-plus class="h-5 w-5" />
                    Adicionar primeiro livro
                </a>
            </div>
        @endif
    </div>

@endsection