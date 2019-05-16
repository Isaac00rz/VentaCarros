@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/FormularioBusqueda.css') }}">
<title>Busqueda Ventas</title>
<section class="contenido">
    <div id="Busqueda" class= "Busqueda">

        <form id = "Busqueda" role="form" method="post" action="{{ url('/Ventas/Busqueda/buscarCliente') }}">
            @csrf
            <legend>Búsqueda</legend>
            <p>
                <label for ="nombre">Nombre del Cliente:</label> 
                <input type="text" name = "nombre" id = "nombre" size = "30" maxlength = "20" placeholder="Nombre" autofocus required><br/>
            </p>
        </form>
    </div>

    <fieldset>
        <legend>Busqueda Ventas</legend>
        <table id="tabla" cellpadding = "0" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Auto</th>	
                <th>Fecha</th>	
                <th>Importe</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($ventas as $venta)
                <tr>
                    <td>{{$venta->id}}</td>
                    <td>{{$venta->cliente}}</td>
                    <td>{{$venta->auto}}</td>
                    <td>{{$venta->fecha}}</td>
                    <td>${{$venta->importe}}</td>
                    <td>
                        <a href="{{url('/Ventas/Editar',$venta->id)}}">Editar</a>
                        <a href="{{url('/Ventas/Eliminar',$venta->id)}}">Eliminar</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </fieldset>
<br>
{{ $ventas->links('paginacion.paginacion') }}
</section> 
</body>
@include('Menus.footer')
</html>