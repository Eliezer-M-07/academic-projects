@extends('layouts.app')

@section('titulo', 'Entrar')

@section('conteudo')

<div class="mx-auto flex min-h-[calc(100vh-5rem)] max-w-md items-center px-6 py-12">
    <div class="w-full">

        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Bem-vindo de volta</h1>
            <p class="mt-2 text-sm text-slate-600">Entre na sua conta para acessar sua estante.</p>
        </div>

        <form action="{{ route('usuario.login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                    <x-heroicon-o-envelope class="h-4 w-4 text-blue-700" />
                    E-mail
                </label>

                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="seu@email.com"
                    autocomplete="email"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                @error('email')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                    <x-heroicon-o-lock-closed class="h-4 w-4 text-blue-700" />
                    Senha
                </label>

                <input type="password" id="password" name="password" placeholder="Sua senha"
                    autocomplete="current-password"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                @error('password')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <x-heroicon-o-arrow-right-end-on-rectangle class="h-5 w-5" />
                Entrar
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">
            Ainda não possui uma conta?
            <a href="{{ route('usuario.form_cadastro') }}" class="font-semibold text-blue-700 hover:text-blue-800 hover:underline">
                Criar conta
            </a>
        </p>

    </div>
</div>

@endsection