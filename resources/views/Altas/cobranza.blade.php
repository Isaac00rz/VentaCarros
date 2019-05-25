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
<section class="contenido">
    <!--
            return view('/Menus/prueba')
            ->with('fechas',$fecha)
            ->with('mensualidades',$mensualidades)
            ->with('intereses',$intereses)
            ->with('diasRetraso',$diasRetraso)
            ->with('estados',$estado)
            ->with('fechaPagos');
            -->
    <fieldset>
        <legend>Pagos de {{$nombreCliente}}</legend>
        <table id="tabla" cellpadding = "0" cellspacing="0" style="text-align:center;">
            <thead>
            <tr>
                <th>Mensualidad</th>
                <th>Monto</th>
                <th>Dias de retraso</th>
                <th>Interes</th>	
                <th>Estado</th>
                <th>Fecha pagado</th>
                <th>Total a pagar</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            @for($cont=0;$cont<count($fechas);$cont++)
                <tr>
                    <td>{{$fechas[$cont]}}</td>
                    <td>${{$mensualidades[$cont]}}</td>
                    <td>{{$diasRetraso[$cont]}}</td>
                    <td>${{$intereses[$cont]}}</td>
                    <td>{{$estados[$cont]}}</td>
                    <td>{{$fechaPagos[$cont]}}</td>
                    <td>${{$mensualidades[$cont]+$intereses[$cont]}}</td>
                    <?php 
                    if($estados[$cont]!="Pagado"){ ?>
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
        <h4>Saldo por pagar: {{$aPagar}}</h4>
    </fieldset>
<br>
</section> 
</body>
@include('Menus.footer')
</html>