<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/reporteTablaPDF.css') }}">
        <div class="col-md-5" align="right">
                <?php
                $hora = new DateTime("now", new DateTimeZone('America/Mexico_City'));
                echo "Fecha: ";
                echo $hora->format('Y-m-d');
                ?>
                <br />
                <?php
                echo "Hora: ";
                $hora2 = new DateTime("now", new DateTimeZone('America/Mexico_City'));
                echo $hora2->format('H:i:s');
                 ?>
        </div>
        <div class="col-md-5" align="left">
            <h1>Plan de Pago:</h1>
            <h4>Vendedor: {{$datos[$plazos-3]}}</h4>
            <h4>Auto: {{$datos[$plazos-2]}}</h4>
            <h4>Cliente: {{$datos[$plazos-1]}}</h4>
        </div>
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
            @for($i = 0; $i<$plazos-3;$i=$i+6)
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
</html>
