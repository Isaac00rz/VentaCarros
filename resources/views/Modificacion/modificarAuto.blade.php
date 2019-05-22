@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tabla.css') }}"/>
<title>Editar Auto</title>
<div class="contenido">
    <fieldset>
        <legend>Editar Auto</legend>
        @if(session()->has('message')) 
            {{ session()->get('message') }} 
        @endif 
        <form role="form" name="form" method="post" action="{{ url('/Modificar/Auto/editarAuto') }}">
            @csrf
                    <table border="1" id="tab" style="display:inline-block;">
                        <tr id="cabecera">
                            <td class="tds">Nombre</td>
                            <td class="tds">Modelo</td>
                            <td class="tds">Marca</td>
                            <td class="tds">Precio</td>
                        </tr>
                        <tr>
                        @foreach ($autos as $auto)
                        <td class="tds"><input class="inputs" type="text" name="nombre" maxlength = "100" placeholder="Nombre" value="{{$auto->nombre}}" required></td>
                            <td class="tds"><input class="inputs" type="text" name="modelo" maxlength="100" placeholder="Modelo" value="{{$auto->modelo}}" required></td>
                            <td class="tds"><input class="inputs" type="text" name="marca" maxlength="100" placeholder="Marca" value="{{$auto->marca}}" required></td>
                            <td class="tds"><input class="inputs" type="number" name="precio" maxlength="10" placeholder="Precio" value="{{$auto->precio}}" required></td>
                            <input type="hidden" name="id" value="{{$auto->id}}">
                        @endforeach
                        </tr>
                    </table>
                    <button id="aceptar" name="aceptar" type="submit"><b>Editar Auto</b></button>
                </form>
            </fieldset>
</div>
<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('js/tablaAlumno.js') }}"></script>
</body>
@include('Menus.footer')
</html>