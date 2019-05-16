@include('Menus.MenuAdmin')
    <link rel="stylesheet" href="{{ asset('css/cotizacion.css') }}">
    <div class="col-md-5" align="left">
            <h1>Plan de Pago:</h1>
        </div>
    <form id = "pdf" action="{{url('Ventas/Generar/PDF')}}" method="post">
            @csrf
            @for ($i = 0; $i < $plazos; $i++)
                <input name="datos[]" id = "datos[]" type="hidden" value="{{$datos[$i]}}">
            @endfor
            <input name="vendedor" id = "vendedor" type="hidden" value="{{$datosRaw[0]}}">
            <input name="auto" id = "auto" type="hidden" value="{{$datosRaw[1]}}">
            <input name="cliente" id = "cliente" type="hidden" value="{{$datosRaw[2]}}">

            <div class="boton" aling="right">
            <input type="submit" value="Crear PDF">
            </div>
            
    </form>
        
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Abono</th>
                <th>Interes</th>
                <th>Mensualidad</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody id="datosTabla">
            @for($i = 0; $i<$plazos;$i=$i+6)
                <tr>
                    <td>{{$datos[$i]}}</td>
                    <td>{{$datos[$i+1]}}</td>
                    <td>Mensualidad</td>
                    <td>${{$datos[$i+2]}}</td>
                    <td>${{$datos[$i+3]}}</td>
                    <td>${{$datos[$i+4]}}</td>
                    <td>${{$datos[$i+5]}}</td>
                </tr>    
            @endfor
        </tbody>
    </table>
</body>
@include('Menus.footer')
</html>