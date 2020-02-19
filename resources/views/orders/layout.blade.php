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
  <a class="navbar-brand" href="#">Navbar</a>
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
  </div>
</nav>
<div class="container">
    @yield('content')
</div>
</body>
</html>