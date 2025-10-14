<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recette App</title>

    {{-- CSS en dur --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <div class="container">
        @yield('content')
    </div>

    {{-- JS classique --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
