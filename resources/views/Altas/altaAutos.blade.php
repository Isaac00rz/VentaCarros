@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tabla.css') }}"/>
<title>Alta Vendedor</title>
<div class="contenido">
    <fieldset>
        <legend>Alta Vendedor</legend>
        @if(session()->has('message')) 
            {{ session()->get('message') }} 
        @endif 
        <form role="form" name="form" method="post" action="{{ url('/Altas/Vendedor/altaVendedor') }}">
        @csrf
                    <table border="1" id="tab" style="display:inline-block;">
                        <tr id="cabecera">
                            <td class="tds">Nombre</td>
                            <td class="tds">Modelo</td>
                            <td class="tds">Marca</td>
                            <td class="tds">Precio</td>
                            <td class="tds">Eliminar</td>
                        </tr>
                        <tr>
                            <td class="tds"><input class="inputs" type="text" name="nombre[]" maxlength = "100" placeholder="Nombre" required></td>
                            <td class="tds"><input class="inputs" type="text" name="modelo[]" maxlength="100" placeholder="Modelo" required></td>
                            <td class="tds"><input class="inputs" type="text" name="marca[]" maxlength="100" placeholder="Marca" required></td>
                            <td class="tds"><input class="inputs" type="tel" name="precio[]" maxlength="10" placeholder="Precio" required></td>
                            <td class="tds"><input class="inputs" type="reset" class="noEliminar" value="Eliminar" /></td>
                        </tr>
            
                    </table>
                    <button id="add" type="button" ><b>Añadir registro</b></button>
                    <button id="aceptar" name="aceptar" type="submit"><b>Insertar registros</b></button>
                </form>
            </fieldset>
</div>
<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('js/tablaVendedor.js') }}"></script>
</body>
@include('Menus.footer')
</html>