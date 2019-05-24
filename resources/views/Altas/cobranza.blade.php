@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/menusGenerales.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/FormularioBusqueda.css') }}">
<title>Clientes</title>
<section class="contenido">
    <fieldset>
        <legend>Pagos <?php echo($nombre[0]->nombre) ?></legend>
        <table id="tabla" cellpadding = "0" cellspacing="0">
            <thead>
            <tr>
                <th>No.Pago</th>
                <th>Fecha</th>
                <th>Importe</th>
                <th>Estado</th>	
                <th>Saldo restante</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($pagos as $pago)
                <tr>
                    
                    <td>{{$pago->fecha}}</td>
                    <td>{{$pago->importe}}</td>
                    <td>Estado</td>
                    <td>{{$compra->enganche}}</td>
                    <td>
                        <?php 
                            if((($compra->importe) - ($compra->pagoTotal))<=0)
                                echo('Liquidado');
                            else echo('Pendiente');
                        ?>
                    </td>
                    <td>
                        <a href="#">Ver</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </fieldset>
<br>
{{ $compras->links('paginacion.paginacion') }}
</section> 
</body>
@include('Menus.footer')
</html>