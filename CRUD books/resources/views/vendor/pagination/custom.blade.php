@if ($paginator->hasPages())

    <div class="flex items-center gap-2">

        {{-- Anterior --}}
        @if ($paginator->onFirstPage())

            <span class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-300 shadow-sm">
                <x-heroicon-o-chevron-left class="h-5 w-5" />
            </span>

        @else

            <a
                href="{{ $paginator->previousPageUrl() }}"
                class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 hover:shadow-md"
            >
                <x-heroicon-o-chevron-left class="h-5 w-5" />
            </a>

        @endif


        {{-- Números --}}
        @foreach ($elements as $element)

            @if (is_string($element))

                <span class="flex h-10 w-10 items-center justify-center rounded-lg text-slate-400">
                    {{ $element }}
                </span>

            @endif

            @if (is_array($element))

                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())

                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-700 text-base font-semibold text-white shadow-md">
                            {{ $page }}
                        </span>

                    @else

                        <a
                            href="{{ $url }}"
                            class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-base font-medium text-slate-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 hover:shadow-md"
                        >
                            {{ $page }}
                        </a>

                    @endif

                @endforeach

            @endif

        @endforeach


        {{-- Próxima --}}
        @if ($paginator->hasMorePages())

            <a
                href="{{ $paginator->nextPageUrl() }}"
                class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-blue-50 hover:text-blue-700 hover:shadow-md"
            >
                <x-heroicon-o-chevron-right class="h-5 w-5" />
            </a>

        @else

            <span class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-300 shadow-sm">
                <x-heroicon-o-chevron-right class="h-5 w-5" />
            </span>

        @endif

    </div>

@endif