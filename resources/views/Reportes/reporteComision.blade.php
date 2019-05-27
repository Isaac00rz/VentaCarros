@include('Menus.MenuAdmin')
    <link rel="stylesheet" href="{{ asset('css/cotizacion.css') }}">
    <title>Reporte Comision</title>
    <div class="col-md-5" align="left" style="margin-left: 4%;">
            <h1>Comisiones</h1>
            <h2>Vendedor: {{$vendedor}}</h2>
        </div>
    <form id = "pdf" action="{{url('Reportes/Comisiones/Generar/PDF')}}" method="post">
            @csrf
            <input name="id" id = "id" type="hidden" value="{{$id}}">
            <div class="boton" aling="right">
            <input type="submit" value="Crear PDF">
            </div>
            
    </form>
    <table>
        <thead>
            <tr>
                <th>ID.</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Comision</th>
            </tr>
        </thead>
        <tbody id="datosTabla">
            @foreach ($ventas as $i => $venta)
            <tr>
                <td>{{$venta->id}}</td>
                <td>{{$venta->nombre}}</td>
                <td>{{$venta->fecha}}</td>
                <td>${{$comisiones[$i]}}</td>
            </tr> 
            @endforeach
            <tr>
                <td>Total</td>
                <td></td>
                <td></td>
                <td>${{$total}}</td>
            </tr>
        </tbody>
    </table>
</body>
@include('Menus.footer')
</html>