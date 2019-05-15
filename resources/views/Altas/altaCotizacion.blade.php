@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/cotizacion.css') }}">
<title>Alta Cotizacion</title>
<div class="contenido">
    <form id = "alta" name = "alta" action="{{url('/Cotizacion/Alta/altaCotizacion')}}" method="post">
        @csrf
        <fieldset>
            <legend>Cotizacion</legend>
            <label for="fecha">Fecha: </label><br><input type="date" id="fecha" name="fecha" required><br>
            
            <label for="nombre">Cliente: </label><br>
            <select id="nombre" name="nombre" required>
                @foreach ($clientes as $cliente)
                    <option value="{{$cliente->rfc}}"> {{$cliente->nombre}}</option>
                @endforeach    
            </select><br>
            <label for="auto">Auto: </label><br>
            <select id="auto" name="auto" required>
                @foreach ($autos as $auto)
                    <option value="{{$auto->id}}"> {{$auto->nombre}}</option>
                @endforeach   
            </select><br>
            <label for="importe">Importe: </label><br><input type="number" min="0" id="importe" name="importe" placeholder="Importe" onchange="importe();" required><br>
            <label for="descuento">Descuento: </label><br><input type="number" min="0" id="descuento" name="descuento" placeholder="Descuento" onchange="descuento();" required><br>
            <label for="enganche">Enganche: </label><br><input type="number" min="0" id="enganche" name="enganche" placeholder="Enganche" required onchange="importeDelEnganche();"><br>
            <label for="importeDel">Importe del enganche: </label><br><input type="number" min="0" id="importeDel" placeholder="Importe del enganche" disabled ><br>
            <label for="taza">Taza: </label><br><input type="number" min="0" id="taza" name="taza" placeholder="Taza" required><br>
            <label for="plazo">Plazo: </label><br><input type="number" min="0" id="plazo" name="plazo" placeholder="Plaza" required><br>
            <label for="comision">Comision: </label><br><input type="number" min="0" max="100" id="comision" name="comision" placeholder="Comision" onchange="comision();" required><br>
            <label for="saldo"> Saldo: </label><br><input type="number" min="0" id="saldo" name="saldo" placeholder="Saldo" disabled><br>
            <hr>
            <div class="botonC">
                <input type="submit" value="Generar">
            </div>
            
        </fieldset>
    </form>
</div>
<script src="{{asset('js/cotizacion.js')}}"></script>
</body>
@include('Menus.footer')
</html>
