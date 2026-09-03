@extends('layouts.app')

@section('titulo', 'Meu perfil')

@section('conteudo')

<div class="mx-auto max-w-4xl px-6 py-12">



<div class="mb-8">
    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Meu perfil</h1>
    <p class="mt-2 text-sm text-slate-600">Visualize e gerencie as informações da sua conta.</p>
</div>

<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">


    <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
        <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-blue-700 text-white">
                <x-heroicon-o-user class="h-7 w-7" />
            </div>
            <div>
                <h2 class="text-lg font-semibold text-slate-900">{{ $usuario->name }}</h2>
                <p class="text-sm text-slate-500">{{ $usuario->email }}</p>
            </div>
        </div>
    </div>


    <div class="divide-y divide-slate-200">


        <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <x-heroicon-o-user class="h-5 w-5 text-blue-700" />
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Nome</p>
                    <p class="mt-1 text-sm font-medium text-slate-900">{{ $usuario->name }}</p>
                </div>
            </div>
        </div>


        <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <x-heroicon-o-envelope class="h-5 w-5 text-blue-700" />
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">E-mail</p>
                    <p class="mt-1 text-sm font-medium text-slate-900">{{ $usuario->email }}</p>
                </div>
            </div>
        </div>


        <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <x-heroicon-o-calendar-days class="h-5 w-5 text-blue-700" />
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Membro desde</p>
                    <p class="mt-1 text-sm font-medium text-slate-900">{{ $usuario->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

    </div>


    <div class="flex flex-col gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:justify-end">

        <a href="{{ route('usuario.livros') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
            <x-heroicon-o-book-open class="h-5 w-5" />
            Meus livros
        </a>

        <a href="{{ route('usuario.form_editar') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-800">
            <x-heroicon-o-pencil-square class="h-5 w-5" />
            Editar perfil
        </a>

        <form action="{{ route('usuario.deletar') }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Essa ação não poderá ser desfeita.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-900 sm:w-auto">
                <x-heroicon-o-trash class="h-5 w-5" />
                Excluir conta
            </button>
        </form>

    </div>

</div>


</div>

@endsection