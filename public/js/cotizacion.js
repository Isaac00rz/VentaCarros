function importeDelEnganche(){
    var importeEn = 0.0;
    var saldo = 0.0;
    var importe = parseFloat(document.getElementById('importe').value);
    var enganche = parseFloat(document.getElementById('enganche').value);

    importeEn = importe * (enganche/100);
    saldo  = importe-importeEn;
    document.getElementById('importeDel').value = importeEn;
    document.getElementById('saldo').value = saldo;
}

function importe(){
    var importe = parseFloat(document.getElementById('importe').value);
    document.getElementById('saldo').value = importe;
}

function descuento(){
    var importe = parseFloat(document.getElementById('importe').value);
    var descuento = parseFloat(document.getElementById('descuento').value);
    var saldo = 0.0
    saldo = importe-descuento;
    document.getElementById('saldo').value = saldo;
}

function comision(){
    var saldo = parseFloat(document.getElementById('saldo').value);
    var comision = parseFloat(document.getElementById('comision').value);
    var saldoF = 0.0
    saldoF = saldo*(1+(comision/100));
    document.getElementById('saldo').value = saldoF;
}