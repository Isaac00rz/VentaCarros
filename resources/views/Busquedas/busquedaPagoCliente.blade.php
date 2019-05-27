@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<title>Reporte Comision</title>
<section class="contenido">
    <fieldset>
        <legend>Clientes pagos</legend>
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
			<a href="{{ URL('/Reportes/Pagos',$cliente->RFC) }}">Ver</a>
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