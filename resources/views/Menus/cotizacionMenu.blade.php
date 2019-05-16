@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/menusGenerales.css') }}">
<title>Cotizacion</title>
<div class="contenido">
    <fieldset>
        <legend>Administrar Cotizaciones</legend>
        <p>Generar Cotizacion</p>
        <a href="{{ url('/Cotizacion/Alta')}}">Generar</a>
        <br>
        <hr>
        <p>Mod/Baja Cotizaciones</p>
        <a href="{{url('/Cotizacion/ModBaja')}}">Ver</a>
        <br>
        <hr>
        <p>Busqueda Cotizaciones</p>
        <a href="{{url('/Cotizacion/Busqueda')}}">Busqueda</a>
        <br>
        <hr>
    </fieldset>
</div>
</body>
@include('Menus.footer')
</html>
