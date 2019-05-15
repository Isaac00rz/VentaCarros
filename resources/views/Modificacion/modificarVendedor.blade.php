@include('Menus.menuAdmin')
<link rel = "stylesheet" href = "{{ asset('css/tabla.css') }}"/>
<title>Editar Vendedor</title>
<div class="contenido">
    <fieldset>
        <legend>Editar Vendedor</legend>
        @if(session()->has('message')) 
            {{ session()->get('message') }} 
        @endif 
        <form role="form" name="form" method="post" action="{{ url('/Modificar/Vendedor/editarVendedor') }}">
            @csrf
                    <table border="1" id="tab" style="display:inline-block;">
                        <tr id="cabecera">
                            <td class="tds">Nombre</td>
                            <td class="tds">Apellido Paterno</td>
                            <td class="tds">Apellido Materno</td>
                            <td class="tds">Telefono</td>
                            <td class="tds">Email</td>
                        </tr>
                        <tr>
                        @foreach ($vendedores as $vendedor)
                        <td class="tds"><input class="inputs" type="text" name="nombre" maxlength = "100" placeholder="Nombre" value="{{$vendedor->nombre}}" required></td>
                            <td class="tds"><input class="inputs" type="text" name="apellidoP" maxlength="100" placeholder="Nombre Paterno" value="{{$vendedor->apellidoP}}" required></td>
                            <td class="tds"><input class="inputs" type="text" name="apellidoM" maxlength="100" placeholder="Nombre Materno" value="{{$vendedor->apellidoM}}" required></td>
                            <td class="tds"><input class="inputs" type="tel" name="telefono" maxlength="10" placeholder="Telefono" value="{{$vendedor->telefono}}" required></td>
                            <td class="tds"><input class="inputs" type="email" name="email" maxlength="100" placeholder="Correo" value="{{$vendedor->email}}" required></td>
                            <input type="hidden" name="id" value="{{$vendedor->id}}">
                        @endforeach
                        </tr>
            
                    </table>
                    <button id="aceptar" name="aceptar" type="submit"><b>Editar Vendedor</b></button>
                </form>
            </fieldset>
</div>
<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('js/tablaAlumno.js') }}"></script>
</body>
@include('Menus.footer')
</html>