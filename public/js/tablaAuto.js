$("#add").click(function () {
    var tds = '<tr>';
    tds += '<td style="width: 7.0%; min-width: 7.0%;"><input type="text" name="nombre[]" maxlength = "100" placeholder="Nombre" required style="text-align: center; min-width: 100%; width:100%;"></td>'
    tds += '<td style="width: 7.0%; min-width: 7.0%;"><input type="text" name="modelo[]" maxlength="100" placeholder="Apellido Paterno" required style="text-align: center; min-width: 100%; width:100%;"></td>'
    tds += '<td style="width: 7.0%; min-width: 7.0%;"><input type="text" name="marca[]" maxlength="100" placeholder="Apellido Materno" required style="text-align: center; min-width: 100%; width:100%;"></td>'
    tds += '<td style="width: 7.0%; min-width: 7.0%;"><input type="tel" name="precio[]" maxlength="10" placeholder="No Semestre" required style="text-align: center; min-width: 100%; width:100%;"></td>'
    tds += '<td style="width: 7.0%; min-width: 7.0%;"><input type="button" class="borrar" value="Eliminar" style="min-width: 100%; width:100%;"/></td>'
    tds += '</tr>';

    $("#tab").append(tds);
});

$(document).on('click', '.borrar', function (event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});