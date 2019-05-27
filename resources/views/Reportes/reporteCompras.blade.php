@include('Menus.MenuAdmin')
    <link rel="stylesheet" href="{{ asset('css/cotizacion.css') }}">
    <title>Reporte Compras</title>
    <div class="col-md-5" align="left" style="margin-left: 4%;">
            <h1>Compras</h1>
            <h2>Cliente: {{$cliente}}</h2>
        </div>
    <form id = "pdf" action="{{url('Reportes/Compras/GenerarPDF')}}" method="post">
            @csrf
            <input name="rfc" id = "rfc" type="hidden" value="{{$rfc}}">
            <div class="boton" aling="right">
            <input type="submit" value="Crear PDF">
            </div>
            
    </form>
    <table>
        <thead>
            <tr>
                <th>Auto</th>
                <th>Vendedor</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody id="datosTabla">
        <?php
            $control = 0;
        ?>
            @foreach ($compras as $i => $compra)
            <tr>
                <td>{{$compra->auto}}</td>
                <td>{{$compra->vendedor}}</td>
                <td>{{$compra->fecha}}</td>
                @for($a = 0;$a<$tamanio;$a++)
                    @if($compra->id == $pagado[$a]->id)
                    <?php
                        $control = 1;
                    ?>
                        @if($pagado[$a]->Pagado==1)
                        <td>Pagado</td>
                        @else
                        <td>En deuda</td>
                        @endif
                    @endif

                @endfor
                @if($control==0)
                <th>En deuda</th>
                @endif
                <?php
                    $control = 0;
                ?>
            </tr> 
            @endforeach
        </tbody>
    </table>
</body>
@include('Menus.footer')
</html>