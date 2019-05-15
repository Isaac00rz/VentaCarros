@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/FormularioBusqueda.css') }}">
<title>Baja/Mod Vendedors</title>
<section class="contenido">
    <div id="Busqueda" class= "Busqueda">

        <form id = "Busqueda" role="form" method="post" action="{{ url('/Vendedores/buscarNombre') }}">
            @csrf
            <legend>Búsqueda</legend>
            <p>
                <label for ="nombre">Nombre Vendedor:</label> 
                <input type="text" name = "nombre" id = "nombre" size = "30" maxlength = "20" placeholder="Nombre" autofocus required><br/>
            </p>
        </form>
    </div>

    <fieldset>
        <legend>Modificar/Baja Vendedor</legend>
        <table id="tabla" cellpadding = "0" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>	
                <th>Email</th>	
            </tr>
            </thead>
            <tbody>
            @foreach ($vendedores as $vendedor)
                <tr>
                <td>{{$vendedor->id}}</td>
                <td>{{$vendedor->nombre}}</td>
                <td>{{$vendedor->telefono}}</td>
                <td>{{$vendedor->email}}</td>
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