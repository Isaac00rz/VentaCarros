@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tabla.css') }}"/>
<title>Editar Cliente</title>
<div class="contenido">
    <fieldset>
        <legend>Editar Cliente</legend>
        @if(session()->has('message')) 
            {{ session()->get('message') }} 
        @endif 
        <form role="form" name="form" method="post" action="{{ url('/Modificar/Cliente/editarCliente') }}">
            @csrf
                    <table border="1" id="tab" style="display:inline-block;">
                        <tr id="cabecera">
                        <td class="tds">RFC</td>
                            <td class="tds">Nombre</td>
                            <td class="tds">Calle</td>
                            <td class="tds">No Exterior</td>
                            <td class="tds">No Interior</td>
                            <td class="tds">Colonia</td>
                            <td class="tds">Ciudad</td>
                            <td class="tds">Estado</td>
                        </tr>
                        <tr>
                        @foreach ($clientes as $cliente)
                            <td class="tds"><input class="inputs" type="text" name="rfc" maxlength = "50" placeholder="RFC" value="{{$cliente->rfc}}" required></td>
                            <td class="tds"><input class="inputs" type="text" name="nombre" maxlength = "150" placeholder="Nombre" value="{{$cliente->nombre}}" required></td>
                            <td class="tds"><input class="inputs" type="text" name="calle" maxlength="150" placeholder="Calle" value="{{$cliente->calle}}" required></td>
                            <td class="tds"><input class="inputs" type="number" name="noExterior" maxlength="10" placeholder="No Exterior" value="{{$cliente->noExterior}}" required></td>
                            <td class="tds"><input class="inputs" type="number" name="noInterior" maxlength="10" placeholder="No Interior" value="{{$cliente->noInterior}}"></td>
                            <td class="tds"><input class="inputs" type="text" name="colonia" maxlength="150" placeholder="Colonia" value="{{$cliente->colonia}}" required></td>
                            <td class="tds"><input class="inputs" type="text" name="ciudad" maxlength="150" placeholder="Ciudad" value="{{$cliente->ciudad}}" required></td>
                            <td class="tds"><input class="inputs" type="text" name="estado" maxlength="150" placeholder="Estado" value="{{$cliente->estado}}" required></td>

                            <input type="hidden" name="rfcA" value="{{$cliente->rfc}}">
                        @endforeach
                        </tr>
            
                    </table>
                    <button id="aceptar" name="aceptar" type="submit"><b>Editar Cliente</b></button>
                </form>
            </fieldset>
</div>
<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('js/tablaAlumno.js') }}"></script>
</body>
@include('Menus.footer')
</html>