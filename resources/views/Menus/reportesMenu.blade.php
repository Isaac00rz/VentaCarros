@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/menusGenerales.css') }}">
<title>Reportes</title>
<div class="contenido">
    <fieldset>
        <legend>Generar Reportes</legend>
        <p>Reportes Clientes</p>
<<<<<<< HEAD
        <a href="{{ url('/Reportes/Pagos')}}">Pagos</a>
        <a href="{{ url('/')}}">Compras</a>
=======
        <a href="{{ url('/Cobranza')}}">Pagos</a>
        <a href="{{ url('Reportes/Compras')}}">Compras</a>
>>>>>>> a9a9d200499091eb472923d063b4b4ee70436691
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
