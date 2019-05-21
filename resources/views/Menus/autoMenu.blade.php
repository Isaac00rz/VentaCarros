@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/menusGenerales.css') }}">
<title>Vendedores</title>
<div class="contenido">
    <fieldset>
        <legend>Administrar Autos</legend>
        <p>Alta de Autos</p>
        <a href="{{ url('/Autos/Alta')}}">Alta</a>
        <br>
        <hr>
        <p>Modificar/Baja Autos</p>
        <a href="{{url('/Autos/BajaMod')}}">ModBaja</a>
        <br>
        <hr>
        <p>Busqueda Autos</p>
         <a href="{{url('/Autos/Buscar')}}">Busqueda</a>
        <br>
        <hr>
    </fieldset>
</div>
</body>
@include('Menus.footer')
</html>
