@extends('layouts.app')

@section('titulo', 'Início')

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

<section class="mx-auto max-w-6xl px-6 py-16">

<div class="max-w-3xl">
    <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-blue-700">LIBRARY</p>

    <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
        Organize os livros que você já leu.
    </h1>

    <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">
        Registre suas leituras, dê uma nota para cada livro e mantenha sua própria estante organizada em um só lugar.
    </p>

    <div class="mt-8 flex flex-wrap gap-3">
        @auth
            <a href="{{ route('usuario.livros') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">
                <x-heroicon-o-book-open class="h-5 w-5" />
                Ver meus livros
            </a>

            <a href="{{ route('livro.form_cadastro') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                <x-heroicon-o-plus class="h-5 w-5" />
                Adicionar livro
            </a>
        @else
            <a href="{{ route('usuario.form_cadastro') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">
                <x-heroicon-o-user-plus class="h-5 w-5" />
                Criar uma conta
            </a>

            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Entrar
            </a>
        @endauth
    </div>
</div>


<div class="mt-20 grid gap-6 border-t border-slate-200 pt-10 sm:grid-cols-3">

    <div>
        <x-heroicon-o-book-open class="h-7 w-7 text-blue-700" />
        <h2 class="mt-4 font-semibold text-slate-900">Sua estante</h2>
        <p class="mt-2 text-sm leading-6 text-slate-600">
            Tenha seus livros registrados e organizados no seu perfil.
        </p>
    </div>

    <div>
        <x-heroicon-o-star class="h-7 w-7 text-blue-700" />
        <h2 class="mt-4 font-semibold text-slate-900">Suas avaliações</h2>
        <p class="mt-2 text-sm leading-6 text-slate-600">
            Dê uma nota para cada leitura e veja quais foram suas favoritas.
        </p>
    </div>

    <div>
        <x-heroicon-o-calendar-days class="h-7 w-7 text-blue-700" />
        <h2 class="mt-4 font-semibold text-slate-900">Histórico de leituras</h2>
        <p class="mt-2 text-sm leading-6 text-slate-600">
            Registre quando terminou cada livro e acompanhe seu histórico.
        </p>
    </div>

</div>


</section>

@endsection
