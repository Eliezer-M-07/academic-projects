<nav class="border-b border-blue-100 bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold tracking-tight text-blue-950">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl shadow-sm">
                    <x-heroicon-o-book-open class="h-6 w-6" />
                </span>
                <span>Library</span>
            </a>

            <div class="hidden items-center gap-2 md:flex">
                <a href="{{ route('home') }}" class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-blue-50 hover:text-blue-700">
                    <x-heroicon-o-home class="h-5 w-5" />
                    Início
                </a>

                @auth
                    <a href="{{ route('usuario.perfil') }}" class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-blue-50 hover:text-blue-700">
                        <x-heroicon-o-user class="h-5 w-5" />
                        Meu perfil
                    </a>

                    <a href="{{ route('usuario.livros') }}" class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-blue-50 hover:text-blue-700">
                        <x-heroicon-o-book-open class="h-5 w-5" />
                        Meus livros
                    </a>

                    <form action="{{ route('usuario.logout') }}" method="POST" class="ml-1">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-500 transition hover:bg-red-50 hover:text-red-600">
                            <x-heroicon-o-arrow-right-start-on-rectangle class="h-5 w-5" />
                            Sair
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-blue-50 hover:text-blue-700">
                        <x-heroicon-o-arrow-right-end-on-rectangle class="h-5 w-5" />
                        Entrar
                    </a>

                    <a href="{{ route('usuario.form_cadastro') }}" class="flex items-center gap-2 rounded-lg bg-blue-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800">
                        <x-heroicon-o-user-plus class="h-5 w-5" />
                        Criar conta
                    </a>
                @endauth
            </div>

            <button type="button" id="menu-button" class="rounded-lg p-2 text-slate-600 transition hover:bg-blue-50 hover:text-blue-700 md:hidden" aria-label="Abrir menu">
                <x-heroicon-o-bars-3 class="h-7 w-7" />
            </button>
        </div>

        <div id="mobile-menu" class="hidden border-t border-blue-100 py-3 md:hidden">
            <div class="flex flex-col gap-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                    <x-heroicon-o-home class="h-5 w-5 text-blue-700" />
                    Início
                </a>

                @auth
                    <a href="{{ route('usuario.perfil') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                        <x-heroicon-o-user class="h-5 w-5 text-blue-700" />
                        Meu perfil
                    </a>

                    <a href="{{ route('usuario.livros') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                        <x-heroicon-o-book-open class="h-5 w-5 text-blue-700" />
                        Meus livros
                    </a>

                    <form action="{{ route('usuario.logout') }}" method="POST" class="mt-1">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-700 hover:bg-red-50">
                            <x-heroicon-o-arrow-right-start-on-rectangle class="h-5 w-5 text-blue-700" />
                            Sair
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                        <x-heroicon-o-arrow-right-end-on-rectangle class="h-5 w-5 text-blue-700" />
                        Entrar
                    </a>

                    <a href="{{ route('usuario.form_cadastro') }}" class="mt-1 flex items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                        <x-heroicon-o-user-plus class="h-5 w-5" />
                        Criar conta
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    const menuButton = document.getElementById('menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    menuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>