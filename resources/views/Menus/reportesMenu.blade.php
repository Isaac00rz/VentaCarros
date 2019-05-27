@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/menusGenerales.css') }}">
<title>Reportes</title>
<div class="contenido">
    <fieldset>
        <legend>Generar Reportes</legend>
        <p>Reportes Clientes</p>

        <a href="{{ url('/Reportes/Pagos')}}">Pagos</a>
        <a href="{{ url('/')}}">Compras</a>


        <br>
        <hr>
        <p>Reportes Vendedores</p>
        <a href="{{url('/Reportes/Comisiones')}}">Comisiones</a>
        <br>
        <hr>
        <p>Reportes Varios</p>
        <a href="{{url('/')}}">Otro</a>
        <br>
        <hr>
    </fieldset>
</div>
</body>
@include('Menus.footer')
</html>
