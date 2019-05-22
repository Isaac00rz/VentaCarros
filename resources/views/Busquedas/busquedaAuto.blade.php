@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<title>Baja/Mod Autos</title>
<section class="contenido">
    <fieldset>
        <legend>Modificar/Baja Auto</legend>
<table id="tabla" cellpadding = "0" cellspacing="0">
	<thead>
	<tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Marca</th>	
        <th>Modelo</th>
        <th>Precio</th>
        <th>Acción</th>
	</tr>
	</thead>
	<tbody>
	@foreach ($autos as $auto)
		<tr>
		<td>{{$auto->id}}</td>
		<td>{{$auto->nombre}}</td>
        <td>{{$auto->modelo}}</td>
        <td>{{$auto->precio}}</td>
        <td>{{$auto->marca}}</td>
		<td>
			<a href="{{ URL('/Autos/Editar',$auto->id) }}">Editar</a>
			<a href="{{ URL('/Autos/Eliminar',$auto->id) }}">Eliminar</a>
		</td>
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