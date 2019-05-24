@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tabla.css') }}"/>
<title>Alta Cliente</title>
<div class="contenido">
    <fieldset>
        <legend>Alta Cliente</legend>
        @if(session()->has('message')) 
            {{ session()->get('message') }} 
        @endif 
        <form role="form" name="form" method="post" action="{{ url('/Altas/Cliente/altaCliente') }}">
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
                            <td class="tds">Eliminar</td>
                        </tr>
                        <tr>
                        <td class="tds"><input class="inputs" type="text" name="rfc[]" maxlength = "50" placeholder="RFC" required></td>
                            <td class="tds"><input class="inputs" type="text" name="nombre[]" maxlength = "150" placeholder="Nombre" required></td>
                            <td class="tds"><input class="inputs" type="text" name="calle[]" maxlength="150" placeholder="Calle" required></td>
                            <td class="tds"><input class="inputs" type="number" name="noExterior[]" maxlength="10" placeholder="No Exterior" required></td>
                            <td class="tds"><input class="inputs" type="number" name="noInterior[]" maxlength="10" placeholder="No Interior" ></td>
                            <td class="tds"><input class="inputs" type="text" name="colonia[]" maxlength="150" placeholder="Colonia" required></td>
                            <td class="tds"><input class="inputs" type="text" name="ciudad[]" maxlength = "150" placeholder="Ciudad" required></td>
                            <td class="tds"><input class="inputs" type="text" name="estado[]" maxlength = "150" placeholder="Estado" required></td>
                            <td class="tds"><input class="inputs" type="reset" class="eliminar" value="Eliminar" /></td>
                        </tr>
            
                    </table>
                    <button id="add" type="button" ><b>Añadir registro</b></button>
                    <button id="aceptar" name="aceptar" type="submit"><b>Insertar registros</b></button>
                </form>
            </fieldset>
</div>
<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('js/tablaCliente.js') }}"></script>
</body>
@include('Menus.footer')
</html>