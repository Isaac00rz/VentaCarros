@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/FormularioBusqueda.css') }}">
<title>Busqueda Autos</title>
<section class="contenido">
    <div id="Busqueda" class= "Busqueda">

        <form id = "Busqueda" role="form" method="post" action="{{ url('/Autos/buscarNombre') }}">
            @csrf
            <legend>Búsqueda</legend>
            <p>
                <label for ="nombre">Nombre Auto:</label> 
                <input type="text" name = "nombre" id = "nombre" size = "30" maxlength = "20" placeholder="Nombre" autofocus required><br/>
            </p>
        </form>
    </div>

    <fieldset>
        <legend>Busqueda Auto</legend>
        <table id="tabla" cellpadding = "0" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Precio</th>	
            </tr>
            </thead>
            <tbody>
            @foreach ($autos as $auto)
                <tr>
                <td>{{$auto->id}}</td>
                <td>{{$auto->nombre}}</td>
                <td>{{$auto->modelo}}</td>
                <td>{{$auto->marca}}</td>
                <td>{{$auto->precio}}</td>
                </tr>
            @endforeach
        </table>
    </fieldset>
<br>
{{ $autos->links('paginacion.paginacion') }}
</section> 
</body>
@include('Menus.footer')
</html>