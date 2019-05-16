@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/menusGenerales.css') }}">
<title>Ventas</title>
<div class="contenido">
    <fieldset>
        <legend>Administrar Ventas</legend>
        <p>Generar Venta</p>
        <a href="{{ url('/Ventas/Alta')}}">Generar</a>
        <br>
        <hr>
        <p>Mod/Baja Venta</p>
        <a href="{{url('/Ventas/ModBaja')}}">Ver</a>
        <br>
        <hr>
        <p>Busqueda Venta</p>
        <a href="{{url('/Ventas/Busqueda')}}">Busqueda</a>
        <br>
        <hr>
    </fieldset>
</div>
</body>
@include('Menus.footer')
</html>