@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<title>Baja/Mod Vendedors</title>
<section class="contenido">
    <fieldset>
        <legend>Modificar/Baja Vendedor</legend>
<table id="tabla" cellpadding = "0" cellspacing="0">
	<thead>
	<tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Telfono</th>	
        <th>Email</th>	
        <th>Acción</th>
	</tr>
	</thead>
	<tbody>
	@foreach ($vendedores as $vendedor)
		<tr>
		<td>{{$vendedor->id}}</td>
		<td>{{$vendedor->nombre}}</td>
        <td>{{$vendedor->telefono}}</td>
        <td>{{$vendedor->email}}</td>
		<td>
			<a href="{{ URL('/Vendedores/Editar',$vendedor->id) }}">Editar</a>
			<a href="{{ URL('/Vendedores/Eliminar',$vendedor->id) }}">Eliminar</a>
		</td>
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