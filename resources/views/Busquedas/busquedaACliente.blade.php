@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tablaDatos.css') }}">
<link rel = "stylesheet" href = "{{ asset('css/FormularioBusqueda.css') }}">
<title>Busqueda Clientes</title>
<meta name="_token" content="{{ csrf_token() }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<section class="contenido">
        
    <div id="Busqueda" class= "Busqueda">

        <form id = "Busqueda" role="form" method="get" action="{{ url('/Clientes/buscarNombre') }}">
            @csrf
            <legend>Búsqueda</legend>
            <p>
                <label for ="nombre">Nombre Cliente:</label> 
                <input type="text" name="search" id="search" class="form-control" placeholder="Nombre" />
            </p>
        </form>
    </div>

    <fieldset>
        <legend>Busqueda Cliente</legend>
        <table id="tabla" cellpadding = "0" cellspacing="0">
            <thead>
            <tr>
                <th>RFC</th>
                <th>Nombre</th>
                <th>Calle</th>	
                <th>No Exterior</th>
                <th>No Interior</th>
                <th>Colonia</th>
                <th>Ciudad</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>

            </tbody>    
            
        </table>
    </fieldset>
<br>
</section> 
</body>
<script type="text/javascript">
    $('#search').on('keyup',function(){
    $value=$(this).val();
    $.ajax({
    type : 'get',
    url : '{{URL::to('Clientes/buscarNombre')}}',
    data:{'search':$value},
    success:function(data){
    $('tbody').html(data);
    }
    });
    })
    </script>
    <script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    </script>
@include('Menus.footer')
</html>