@include('Menus.MenuAdmin')
<link rel="stylesheet" href="{{ asset('css/cotizacion.css') }}">
<title>Editar Cotizacion</title>
<div class="contenido">
    <form id = "alta" name = "alta" action="{{url('/Ventas/Editar/editarVenta')}}" method="post">
        @csrf
        <fieldset>
            <legend>Editar Cotizacion</legend>
            @foreach ($datos as $dat)
            <label for="fecha">Fecha: </label><br><input type="date" id="fecha" name="fecha" value="{{$dat->fecha}}" required><br>
            <label for="nombre">Cliente: </label><br>
            <select id="nombre" name="nombre" required>
                @foreach ($clientes as $cliente)
                    @if ($cliente->rfc==$dat->rfc)
                        <option value="{{$cliente->rfc}}" selected> {{$cliente->nombre}}</option>
                    @else
                        <option value="{{$cliente->rfc}}"> {{$cliente->nombre}}</option>
                    @endif
                @endforeach    
            </select><br>
            <label for="auto">Auto: </label><br>
            <select id="auto" name="auto" required>
                @foreach ($autos as $auto)
                    @if ($auto->id==$dat->auto)
                        <option value="{{$auto->id}}" selected> {{$auto->nombre}}</option>
                    @else
                        <option value="{{$auto->id}}"> {{$auto->nombre}}</option>
                    @endif
                @endforeach   
            </select><br>
            <label for="importe">Importe: </label><br><input type="number" min="0" id="importe" name="importe" placeholder="Importe" value="{{$dat->importe}}" onchange="importe();" required><br>
            <label for="descuento">Descuento: </label><br><input type="number" min="0" id="descuento" name="descuento" placeholder="Descuento" value="{{$dat->descuento}}" onchange="descuento();" required><br>
            <label for="enganche">Enganche: </label><br><input type="number" min="0" id="enganche" name="enganche" placeholder="Enganche" required value="{{$dat->enganche}}" onchange="importeDelEnganche();"><br>
            <label for="importeDel">Importe del enganche: </label><br><input type="number" min="0" id="importeDel" placeholder="Importe del enganche" disabled ><br>
            <label for="taza">Taza: </label><br><input type="number" min="0" id="taza" name="taza" placeholder="Taza" required value="{{$dat->tasa}}"><br>
            <label for="plazo">Plazo: </label><br><input type="number" min="0" id="plazo" name="plazo" placeholder="Plaza" required value="{{$dat->plazos}}"><br>
            <label for="comision">Comision: </label><br><input type="number" min="0" max="100" id="comision" name="comision" placeholder="Comision" value="{{$dat->comision}}" onchange="comision();" required><br>
            <label for="saldo"> Saldo: </label><br><input type="number" min="0" id="saldo" name="saldo" placeholder="Saldo" disabled><br>
            <input type="hidden" name="idVenta" value="{{$dat->id}}">
            @endforeach
            <hr>
            <div class="botonC">
                <input type="submit" value="Editar">
            </div>
            
        </fieldset>
    </form>
</div>
<script src="{{asset('js/cotizacion.js')}}"></script>
</body>
@include('Menus.footer')
</html>