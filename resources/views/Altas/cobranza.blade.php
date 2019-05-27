@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/menusGenerales.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/FormularioBusqueda.css') }}">
<title>Clientes</title>
<style>
    #formpay{
        text-align: center;
    }
     #reporte{
        margin-left: 70%;
        padding: 1%;
        background: #1883BA;
        text-decoration: none;
        color:white;
        font-family: arial;
        font-weight: bold;
        font-size: 20px;
        margin-top: 50px;
        border:2px solid #0016B0;
        border-radius: 10px;
    }
    #reporte:hover{
        transition: all 0.3s;
        opacity:0.5;
    }
    #pay{
        border:none;
        padding: 7%;
        background: #A02929;
        color:white;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 7%;
    }
    
</style>
<br /><br /><br />
<a id="reporte" href="{{url('Pagos/Generar/PDF',$idVenta)}}">Crear PDF</a>
<section class="contenido">
    <fieldset>
        <legend>Pagos de {{$nombreCliente}}</legend>
        <table id="tabla" cellpadding = "0" cellspacing="0" style="text-align:center;">
            <thead>
            <tr>
				<th>No</th>
                <th>Fecha</th>
                <th>Abono</th>
                <th>Dias de retraso</th>
                <th>Interes</th>	
                <th>Estado</th>
				<th>Mensualidad</th>
                <th>Fecha pagado</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            @for($cont=0;$cont<count($fechas);$cont++)
                <tr>
					<td>{{$cont+1}}</td>
                    <td>{{$fechas[$cont]}}</td>
                    <td>${{bcdiv($mensualidades[$cont],'1',2)}}</td>
                    <td>{{$diasRetraso[$cont]}}</td>
                    <td>${{bcdiv($intereses[$cont],'1',2)}}</td>
                    <td>{{$estados[$cont]}}</td>
					<td>${{bcdiv($mensualidades[$cont]+$intereses[$cont],'1',2)}}</td>
                    <td>{{$fechaPagos[$cont]}}</td>
                    <?php 
                    if($cont==$putButtonPosition){ ?>
                    <td>
                        <form role="form" method="post" action="{{ url('/Cobranza/Pagar') }}" id="formpay">
                            @csrf
                            <input type="submit" value="Pagar" id="pay"/>
                            <input type="hidden" name="idVenta" value="{{$idVenta}}" />
                            <input type="hidden" name="interes" value="{{$intereses[$cont]}}" />
                            <input type="hidden" name="fechaMensualidad" value="{{$fechas[$cont]}}" />
                            <input type="hidden" name="mensualidad" value="{{$mensualidades[$cont]}}" />
                            
                        </form>
                    </td>
                    <?php    
                    }else{ ?>
                        <td></td>
                    <?php }
                    ?>
                </tr>
            @endfor
        </table>
        <h4>Saldo por pagar: {{bcdiv($aPagar,'1',2)}}</h4>
    </fieldset>
<br>
</section> 
</body>
@include('Menus.footer')
</html>