@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/menusGenerales.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/paginacion.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/FormularioBusqueda.css') }}">
<title>Clientes</title>
<section class="contenido">
    <fieldset>
        <legend>Compras <?php echo($nombre[0]->nombre) ?></legend>
        <table id="tabla" cellpadding = "0" cellspacing="0">
            <thead>
            <tr>
                <th>No Compra</th>
                <th>Auto</th>
                <th>Importe</th>
                <th>Enganche</th>	
                <th>Estado</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($compras as $compra)
                <tr>
                    <td>{{$compra->id}}</td>
                    <td>{{$compra->marca}}{{$compra->modelo}}{{$compra->nombre}}</td>
                    <td>{{$compra->importe}}</td>
                    <td>{{$compra->enganche}}</td>
                    <td>
                        <?php 
                            if((($compra->importe) - ($compra->pagoTotal))<=0)
                                echo('Liquidado');
                            else echo('Pendiente');
                        ?>
                    </td>
                    <td>
                        <a href="{{url('/Cobranza/Pagos',$compra->id)}}">Ver</a>
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