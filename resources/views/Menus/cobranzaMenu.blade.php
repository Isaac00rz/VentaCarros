@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/menusGenerales.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/FormularioBusqueda.css') }}">
<title>Clientes</title>
<section class="contenido">
    <div id="Busqueda" class= "Busqueda">

        <form id = "Busqueda" role="form" method="post" action="{{ url('/Cobranza/BusquedaCliente') }}">
            @csrf
            <legend>Búsqueda</legend>
            <p>
                <label for ="rfc">Nombre del Cliente:</label> 
                <input type="text" name = "rfc" id = "nombre" size = "30" maxlength = "20" placeholder="RFC" autofocus required><br/>
            </p>
        </form>
    </div>

    <fieldset>
        <legend>Busqueda Cliente</legend>
        <table id="tabla" cellpadding = "0" cellspacing="0">
            <thead>
            <tr>
                <th>RFC</th>
                <th>Nombre</th>
                <th>Dirección</th>	
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{$cliente->RFC}}</td>
                    <td>{{$cliente->nombre}}</td>
                    <td>{{$cliente->direccion}}</td>
                    <td>
                        <a href="{{url('/Cobranza/BusquedaCompra',$cliente->RFC)}}">Ver</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </fieldset>
<br>
{{ $clientes->links('paginacion.paginacion') }}
</section> 
</body>
@include('Menus.footer')
</html>