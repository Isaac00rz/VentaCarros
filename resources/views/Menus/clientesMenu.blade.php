@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/menusGenerales.css') }}">
<title>Clientes</title>
<div class="contenido">
    <fieldset>
        <legend>Administrar Clientes</legend>
        <p>Alta de Clientes</p>
        <a href="{{ url('/Clientes/Alta')}}">Alta</a>
        <br>
        <hr>
        <p>Modificar/Baja Clientes</p>
        <a href="{{url('/Clientes/BajaMod')}}">ModBaja</a>
        <br>
        <hr>
        <p>Busqueda Clientes</p>
        <a href="{{url('/Clientes/Buscar')}}">Busqueda</a>
        <br>
        <hr>
    </fieldset>
</div>
</body>
@include('Menus.footer')
</html>
