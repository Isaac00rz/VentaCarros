<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/reportePagos.css') }}">
    </head>
    <body>
        <div id="encabezado">
            <h2>Información de pagos</h2>
            <h4>Fecha: 
                <?php 
                $hora = new DateTime("now", new DateTimeZone('America/Mexico_City')); 
                echo($hora->format('Y-m-d'));
                ?> </h4>
        </div>
        <div id="clienteInfo">
            <h5>Cliente: {{$datos[0]->nombre}}</h5>
            <h5>Auto: {{$datos[0]->auto}}</h5>
            <h5>Costo del auto: ${{$datos[0]->importe}}</h5>
            <h5>Enganche: $
            <?php
                $enganche=bcdiv((($datos[0]->enganche)/100)*($datos[0]->importe),'1',2);
                echo($enganche);
            ?>
            </h5>
            <h5>Pago restante: 
                <?php 
                echo (bcdiv((($datos[0]->importe)-$enganche)-(((count($pagos))*(($datos[0]->importe-$enganche)/$datos[0]->plazos))),'1',2));
            ?>
            </h5>
        </div>
        
        <table>
            <tr>
                <th>
                    Fecha
                </th>
                <th>
                    Abono
                </th>
                <th>
                    Interes
                </th>
                <th>
                    Mensualidad
                </th>
                <th>
                    Dias de retraso
                </th>
            </tr>
            @foreach($pagos as $pago)
            <tr>
                <td>{{$pago->fecha}}</td>
                <td>{{bcdiv($pago->mensualidad,'1',2)}}</td>
                <td>{{bcdiv($pago->interesImporte,'1',2)}}</td>
                <td>{{bcdiv(($pago->interesImporte)+$pago->mensualidad,'1',2)}}</td>
                <td>
                    <?php
                    if($pago->diasRetraso<0){
                        echo(0);
                    }else{
                        echo($pago->diasRetraso);
                    }
                    ?>
                </td>
            </tr>
            @endforeach
        </table>
    </body>
</html>