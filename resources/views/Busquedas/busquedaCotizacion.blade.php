@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/FormularioBusqueda.css') }}">
<title>Busqueda Cotizacion</title>
<section class="contenido">
    <div id="Busqueda" class= "Busqueda">

        <form id = "Busqueda" role="form" method="post" action="{{ url('/Cotizacion/buscarCliente') }}">
            @csrf
            <legend>Búsqueda</legend>
            <p>
                <label for ="nombre">Nombre del Cliente:</label> 
                <input type="text" name = "nombre" id = "nombre" size = "30" maxlength = "20" placeholder="Nombre" autofocus required><br/>
            </p>
        </form>
    </div>

    <fieldset>
        <legend>Busqueda Cotizacion</legend>
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
            @foreach ($cotizaciones as $cotizacion)
                <tr>
                    <td>{{$cotizacion->id}}</td>
                    <td>{{$cotizacion->cliente}}</td>
                    <td>{{$cotizacion->auto}}</td>
                    <td>{{$cotizacion->fecha}}</td>
                    <td>${{$cotizacion->importe}}</td>
                    <td>
                        <a href="{{url('/Cotizacion/Editar',$cotizacion->id)}}">Editar</a>
                        <a href="{{url('/Cotizacion/Eliminar',$cotizacion->id)}}">Eliminar</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </fieldset>
<br>
{{ $cotizaciones->links('paginacion.paginacion') }}
</section> 
</body>
@include('Menus.footer')
</html>