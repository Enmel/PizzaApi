<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{asset('css/app.css') }}">
        <script src="{{asset('js/app.js') }}" crossorigin="anonymous"></script>
        <title>Panel de Control</title>
    </head>
    <body>
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="#">
                <img src="" width="30" height="30" class="d-inline-block align-top" alt="">
                <i class="fab fa-cpanel"></i>
            </a>
        </nav>

        <div>
            <a href="{{ route('tables.index') }}"><i class="fas fa-table"></i></a>
            <a href="{{ route('foodcategories.index') }}">Categorias</a>
            <a href="{{ route('foods.index') }}">Comidas</a>
            <a href="{{ route('reservations.index') }}">Reservaciones</a>
            <a href="{{ route('orders.index') }}">Ordenes</a>
        </div>
        
    </body>
</html>
