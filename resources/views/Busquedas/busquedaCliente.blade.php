@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<title>Baja/Mod Clientes</title>
<section class="contenido">
    <fieldset>
        <legend>Modificar/Baja Cliente</legend>
<table id="tabla" cellpadding = "0" cellspacing="0">
	<thead>
	<tr>
        <th>RFC</th>
        <th>Nombre</th>
        <th>calle</th>	
        <th>No Exterior</th>	
        <th>No Interior</th>
        <th>Colonia</th>
        <th>Ciudad</th>
        <th>Estado</th>
        <th>Accion</th>
	</tr>
	</thead>
	<tbody>
	@foreach ($clientes as $cliente)
		<tr>
		<td>{{$cliente->rfc}}</td>
		<td>{{$cliente->nombre}}</td>
        <td>{{$cliente->calle}}</td>
        <td>{{$cliente->noExterior}}</td>
        <td>{{$cliente->noInterior}}</td>
        <td>{{$cliente->colonia}}</td>
        <td>{{$cliente->ciudad}}</td>
        <td>{{$cliente->estado}}</td>
		<td>
			<a href="{{ URL('/Clientes/Editar',$cliente->rfc) }}">Editar</a>
			<a href="{{ URL('/Clientes/Eliminar',$cliente->rfc) }}">Eliminar</a>
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