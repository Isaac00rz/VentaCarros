@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<title>Home</title>
<div class="contenedor">
    <fieldset>
        <p>Bienvenido</p>
        <h1>{{ Auth::user()->name}}</h1>
    </fieldset>
</div>
</body>
@include('Menus.footer')
</html>
