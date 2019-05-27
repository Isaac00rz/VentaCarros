@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<title>Reporte Compras</title>
<section class="contenido">
    <fieldset>
        <legend>Reporte Compras</legend>
<table id="tabla" cellpadding = "0" cellspacing="0">
	<thead>
	<tr>
        <th>RFC</th>
        <th>Nombre</th>
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
        <td>{{$cliente->ciudad}}</td>
        <td>{{$cliente->estado}}</td>
		<td>
			<a href="{{ URL('/Reportes/Compras',$cliente->rfc) }}">Ver</a>
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