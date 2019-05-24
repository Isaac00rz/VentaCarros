@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/FormularioBusqueda.css') }}">
<title>Busqueda Clientes</title>
<section class="contenido">
    <div id="Busqueda" class= "Busqueda">

        <form id = "Busqueda" role="form" method="post" action="{{ url('/Clientes/buscarNombre') }}">
            @csrf
            <legend>Búsqueda</legend>
            <p>
                <label for ="nombre">Nombre Cliente:</label> 
                <input type="text" name = "nombre" id = "nombre" size = "30" maxlength = "20" placeholder="Nombre" autofocus required><br/>
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
                <th>Calle</th>	
                <th>No Exterior</th>
                <th>No Interior</th>
                <th>Colonia</th>
                <th>Ciudad</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($vendedores as $vendedor)
                <tr>
                <td>{{$cliente->rfc}}</td>
                <td>{{$cliente->nombre}}</td>
                <td>{{$cliente->calle}}</td>
                <td>{{$cliente->noExterior}}</td>
                <td>{{$cliente->noInterior}}</td>
                <td>{{$cliente->colonia}}</td>
                <td>{{$cliente->ciudad}}</td>
                <td>{{$cliente->estado}}</td>
                </tr>
            @endforeach
        </table>
    </fieldset>
<br>
{{ $vendedores->links('paginacion.paginacion') }}
</section> 
</body>
@include('Menus.footer')
</html>