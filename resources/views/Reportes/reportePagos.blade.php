@include('Menus.MenuAdmin')
    <link rel="stylesheet" href="{{ asset('css/cotizacion.css') }}">
    <title>Reporte Comision</title>
    <div class="col-md-5" align="left" style="margin-left: 4%;">
            <h1>Información de pagos</h1>
            <h2>Cliente: {{$info[0]->nombre}}</h2>
			<h2>Auto adquirido: {{$info[0]->auto}}</h2>
        </div>
    <form id = "pdf" action="{{url('Pagos/Generar/PDF',$info[0]->id)}}" method="GET">
            @csrf
            <div class="boton" aling="right">
            <input type="submit" value="Crear PDF">
            </div>
            
    </form>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Abono</th>
                <th>Interes</th>
				<th>Dias de retraso</th>
            </tr>
        </thead>
        <tbody id="datosTabla">
            @foreach ($pagos as $i => $pago)
            <tr>
                <td>{{$pago->fecha}}</td>
                <td>$ <?php echo(bcdiv($pago->mensualidad,'1',2)); ?></td>
                <td>{{$pago->interesImporte}}</td>
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
            <tr>
                <td>Pago restante</td>
                <td></td>
                <td></td>
                <td>
					<?php 
					$enganche=bcdiv((($info[0]->enganche)/100)*($info[0]->importe),'1',2);
                echo (bcdiv((($info[0]->importe)-$enganche)-(((count($pagos))*(($info[0]->importe-$enganche)/$info[0]->plazos))),'1',2));
            ?>
				</td>
            </tr>
        </tbody>
    </table>
</body>
@include('Menus.footer')
</html>