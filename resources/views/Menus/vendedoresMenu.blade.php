@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/menusGenerales.css') }}">
<title>Vendedores</title>
<div class="contenido">
    <fieldset>
        <legend>Administrar Vendedores</legend>
        <p>Alta de Vendedores</p>
        <a href="{{ url('/Vendedores/Alta')}}">Alta</a>
        <br>
        <hr>
        <p>Modificar/Baja Vendedores</p>
        <a href="{{url('/Vendedores/BajaMod')}}">ModBaja</a>
        <br>
        <hr>
        <p>Busqueda Vendedores</p>
        <a href="{{url('/Vendedores/Buscar')}}">Busqueda</a>
        <br>
        <hr>
    </fieldset>
</div>
</body>
@include('Menus.footer')
</html>
