<!DOCTYPE html>
<html>
<head>
    <title>TuPedido</title>
    <link rel="stylesheet" href="{{asset('css/app.css') }}">
    <script src="{{asset('js/app.js') }}" crossorigin="anonymous"></script>
    <style>
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand">TuPedido</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <li class="{{ Request::is('tables') ? 'nav-item active' : 'nav-item' }}">
            <a class="nav-link" href="{{ route('tables.index') }}"> Mesas </a>
        </li>
        <li class="{{ Request::is('orders') ? 'nav-item active' : 'nav-item' }}">
            <a class="nav-link" href="{{ route('orders.index') }}"> Ordenes </a>
        </li>
        <li class="{{ Request::is('categories') ? 'nav-item active' : 'nav-item' }}">
            <a class="nav-link" href="{{ route('foodcategories.index') }}"> Categorias </a>
        </li>
        <li class="{{ Request::is('foods') ? 'nav-item active' : 'nav-item' }}">
            <a class="nav-link" href="{{ route('foods.index') }}"> Comidas </a>
        </li>
        <li class="{{ Request::is('reservations') ? 'nav-item active' : 'nav-item' }}">
            <a class="nav-link" href="{{ route('reservations.index') }}"> Reservaciones </a>
        </li>
    </ul>
    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
  </div>
</nav>
<div class="container">
    @yield('content')
</div>
</body>
</html>