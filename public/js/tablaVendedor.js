$("#add").click(function () {
    var tds = '<tr>';
    tds += '<td style="width: 7.0%; min-width: 7.0%;"><input type="text" name="nombre[]" maxlength = "100" placeholder="Nombre" required style="text-align: center; min-width: 100%; width:100%;"></td>'
    tds += '<td style="width: 7.0%; min-width: 7.0%;"><input type="text" name="apellidoP[]" maxlength="100" placeholder="Apellido Paterno" required style="text-align: center; min-width: 100%; width:100%;"></td>'
    tds += '<td style="width: 7.0%; min-width: 7.0%;"><input type="text" name="apellidoM[]" maxlength="100" placeholder="Apellido Materno" required style="text-align: center; min-width: 100%; width:100%;"></td>'
    tds += '<td style="width: 7.0%; min-width: 7.0%;"><input type="tel" name="telefono[]" maxlength="10" placeholder="Telefono" required style="text-align: center; min-width: 100%; width:100%;"></td>'
    tds += '<td style="width: 7.0%; min-width: 7.0%;"><input type="email" name="email[]" maxlength="100" placeholder="Correo" required style="text-align: center; min-width: 100%; width:100%;"></td>'
    tds += '<td style="width: 7.0%; min-width: 7.0%;"><input type="button" class="borrar" value="Eliminar" style="min-width: 100%; width:100%;"/></td>'
    tds += '</tr>';

    $("#tab").append(tds);
});

$(document).on('click', '.borrar', function (event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});