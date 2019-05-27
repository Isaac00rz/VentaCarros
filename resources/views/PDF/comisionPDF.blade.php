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
            <h1>Comisiones</h1>
            <h2>Vendedor: {{$datos2[0]}}</h2>
        </div>
    <table>
        <thead>
            <tr>
                <th>ID.</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Comision</th></th>
            </tr>
        </thead>
        <tbody id="datosTabla">
            @for ($i = 0; $i < $datos2[2]; $i=$i+4)
            <tr>
                <td>{{$datos[$i]}}</td>
                <td>{{$datos[$i+1]}}</td>
                <td>{{$datos[$i+2]}}</td>
                <td>${{$datos[$i+3]}}</td>
            </tr>
            @endfor
            <tr>
                <td>Total</td>
                <td></td>
                <td></td>
                <td>${{$datos2[1]}}</td>
            </tr>
        </tbody>
    </table>
    </body>
</html>
