<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Library | @yield('titulo')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @include('partials.navbar')
    <main>
        @yield('conteudo')
    </main>

</body>
</html>

