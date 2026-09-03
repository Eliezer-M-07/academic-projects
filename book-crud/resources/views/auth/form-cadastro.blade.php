@extends('layouts.app')

@section('titulo', 'Criar conta')

@section('conteudo')

<div class="mx-auto flex min-h-[calc(100vh-5rem)] max-w-md items-center px-6 py-11">
    <div class="w-full">

        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Criar sua conta</h1>
            <p class="mt-2 text-sm text-slate-600">Crie sua conta para começar a organizar suas leituras.</p>
        </div>

        <form action="{{ route('usuario.cadastro') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                    <x-heroicon-o-user class="h-4 w-4 text-blue-700" />
                    Nome
                </label>

                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Seu nome"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                @error('name')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                    <x-heroicon-o-envelope class="h-4 w-4 text-blue-700" />
                    E-mail
                </label>

                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="seu@email.com"
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

                <input type="password" id="password" name="password" placeholder="Mínimo de 8 caracteres"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                @error('password')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                    <x-heroicon-o-lock-closed class="h-4 w-4 text-blue-700" />
                    Confirmar senha
                </label>

                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Digite a senha novamente"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                @error('password_confirmation')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <x-heroicon-o-user-plus class="h-5 w-5" />
                Criar conta
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">
            Já possui uma conta?
            <a href="{{ route('login') }}" class="font-semibold text-blue-700 hover:text-blue-800 hover:underline">Entrar</a>
        </p>

    </div>
</div>

@endsection