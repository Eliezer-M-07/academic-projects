@extends('layouts.app')

@section('titulo', 'Editar perfil')

@section('conteudo')

    <div class="mx-auto flex min-h-[calc(100vh-5rem)] max-w-md items-center px-6 py-11">
        <div class="w-full">
            <div class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Editar perfil</h1>
                <p class="mt-2 text-sm text-slate-600">Atualize as informações da sua conta.</p>
            </div>

            <form action="{{ route('usuario.editar') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

               
                <div>
                    <label for="name" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                        <x-heroicon-o-user class="h-4 w-4 text-blue-700" />
                        Nome
                    </label>

                    <input type="text" id="name" name="name" value="{{ old('name', $usuario->name) }}" placeholder="Seu nome" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                    @error('name')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

             
                <div>
                    <label for="email" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                        <x-heroicon-o-envelope class="h-4 w-4 text-blue-700" />
                        E-mail
                    </label>

                    <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}" placeholder="seu@email.com" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                    @error('email')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                
                <div>
                    <label for="password" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                        <x-heroicon-o-lock-closed class="h-4 w-4 text-blue-700" />
                        Nova senha
                    </label>

                    <input type="password" id="password" name="password" placeholder="Deixe vazio para manter a senha atual" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                    @error('password')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

             
                <div>
                    <label for="password_confirmation" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700">
                        <x-heroicon-o-lock-closed class="h-4 w-4 text-blue-700" />
                        Confirmar nova senha
                    </label>

                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Digite a nova senha novamente" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">

                    @error('password_confirmation')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

          
                <div class="flex flex-col gap-3 pt-2 sm:flex-row">
                    <a href="{{ route('usuario.perfil') }}" class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        <x-heroicon-o-arrow-left class="h-5 w-5" />
                        Cancelar
                    </a>

                    <button type="submit" class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <x-heroicon-o-check class="h-5 w-5" />
                        Salvar alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

