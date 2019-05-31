<?php

namespace App\Helpers;

use Carbon\Carbon;

 class CalculosHelper {
   
    public static function calcularPlanPago($fechaN,$importe,$descuento,$enganche,$plazos,$taza) {
        $fecha = Carbon::now();
        $fecha->setYear($fechaN[0]);
        $fecha->setMonth($fechaN[1]);
        $fecha->setDay($fechaN[2]);
        $abono = 0.0;
        $abono2 = 0.0;
        $interes = 0.0;
        $mensualidad = 0.0;
        $importe = ($importe-$descuento);
        $importeEn = $importe * ($enganche/100);
        $saldo  = $importe-$importeEn;
        $abono = $saldo/$plazos;
        
        for($i = 0;$i<$plazos;$i++){
            $fecha->addMonth(1);
            $datos[] = $i+1;
            $datos[] = $fecha->format('d-m-Y');
            $interes = ($saldo * ($taza/100));
            $mensualidad = $abono+$interes;
            $saldo = $saldo - $abono;
            if($saldo<0){
                $saldo = 0;
            }
            $datos[] = round($abono,2);
            $datos[] = round($interes,2);
            $datos[] = round($mensualidad,2);
            $datos[] = round($saldo,2);
            
        }

        return $datos;
    }
}