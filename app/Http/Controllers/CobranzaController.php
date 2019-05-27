<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class CobranzaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        $consulta = DB::table('cliente')
            ->select(DB::raw("RFC,nombre, CONCAT('Colonia:',colonia,' No Exterior: ',NoExterior,' Calle:',calle)as direccion")) 
            ->paginate(10);
        return view('/Menus/cobranzaMenu')->with('clientes',$consulta);
    }
    public function buscarCliente(Request $request){
        $rfc = $request->input('rfc');
        $consulta = DB::table('cliente')
            ->select(DB::raw("RFC,nombre, CONCAT('Colonia:',colonia,' No Exterior: ',NoExterior,' Calle:',calle)as direccion"))
            ->where('RFC','=',$rfc)
            ->paginate(10);
        return view('/Menus/cobranzaMenu')->with('clientes',$consulta);
    }
    public function buscarCompras($rfc){
        $consulta = DB::table('venta')
            ->join('auto','auto.id','=','venta.idauto')
            ->select('venta.id','auto.marca','auto.modelo','auto.nombre','venta.importe','venta.enganche')
            ->where('venta.IdCliente','like','%'.$rfc.'%')
            ->groupBy('venta.id','auto.marca','auto.modelo','auto.nombre','venta.importe','venta.enganche')
            ->paginate(10);
        
        $consultaName = DB::table('cliente')
            ->select('nombre')
            ->where('rfc','=',$rfc)
            ->get();
        return view('/Menus/comprasCliente')->with('compras',$consulta)->with('nombre',$consultaName);
    }
    /*
        eq() equals
        ne() not equals
        gt() greater than
        gte() greater than or equals
        lt() less than
        lte() less than or equals
    */
    public function redirectToPagos($idVenta){
        $consulta = DB::table('venta')
            ->select('fecha','plazos','tasa','importe','idCliente','enganche')
            ->where('id','=',$idVenta)
            ->get();        
        $fechaVenta = $consulta[0]->fecha;
        $idCliente = $consulta[0]->idCliente;
        $plazos = $consulta[0]->plazos;
        $fechaPago = new Carbon($fechaVenta);
        $fechaActual = Carbon::now();
        $enganche = (($consulta[0]->enganche)/100)*$consulta[0]->importe;
        $importe = ($consulta[0]->importe)-$enganche;
        $mensualidad = ($importe)/$plazos;
        $aPagar = $importe;
        $tasa = (($consulta[0]->tasa)/100);
        $importeTasa = 0;
        $restante = 0;
        $opcionPay = 0;
        for($cont=0;$cont<$plazos;$cont++){
            $fechaPago->addMonth(1);
            $consulta = DB::table('pago')
                ->select('fecha','mensualidad','interesImporte','diasRetraso')
                ->where([
                    ['idVenta','=',$idVenta],
                    ['fecha','=',$fechaPago->toDateString()],
                ])
                ->get();
            $importeTasa = $tasa*($aPagar);
            $aPagar = $aPagar - $mensualidad;
            if(count($consulta)>0){
                $fecha[] = $fechaPago->toDateString();
                $mensualidades[] = $consulta[0]->mensualidad;
                $restante = $restante+($consulta[0]->mensualidad);
                $opcionPay = $opcionPay+1;
                $intereses[] = $consulta[0]->interesImporte;
                $fechaTemp = new Carbon($fechaPago);
                
                if(($consulta[0]->diasRetraso)<0){
                    $diasRetraso[] = 0;
                    $fechaPagos[] = $fechaTemp->addDay(($consulta[0]->diasRetraso)-1)->toDateString();
                }else if(($consulta[0]->diasRetraso)>0){
                    $diasRetraso[] = $consulta[0]->diasRetraso;
                    $fechaPagos[] = $fechaTemp->addDay(($consulta[0]->diasRetraso))->toDateString();
                }else if(($consulta[0]->diasRetraso)==0){
                    $diasRetraso[] = 0;
                    $fechaPagos[] = $fechaTemp->addDay(($consulta[0]->diasRetraso))->toDateString();
                }
                $estado[] = "Pagado";
            }else if($fechaPago->gt($fechaActual) 
                     || ($fechaPago->toDateString())==($fechaActual->toDateString())){
                $fecha[] = $fechaPago->toDateString();
                $mensualidades[] = $mensualidad;
                $intereses[] = $importeTasa;
                $diasRetraso[] = 0;
                $estado[] = "Proximo";
                $fechaPagos[]= "----";
            }else if($fechaPago->lt($fechaActual)){
                $fecha[] = $fechaPago->toDateString();
                $mensualidades[] = $mensualidad;
                $intereses[] = $importeTasa+(50*($fechaPago->diffInDays($fechaActual)));
                $diasRetraso[] = $fechaPago->diffInDays($fechaActual);
                $estado[] = "Atrasado";
                $fechaPagos[]= "----";
            }
            
        }
        $nombreCliente = DB::table('cliente')
            ->select('cliente.nombre')
            ->where('RFC','=',$idCliente)
            ->get();
        
        return view('/Altas/cobranza')
            ->with('fechas',$fecha)
            ->with('mensualidades',$mensualidades)
            ->with('intereses',$intereses)
            ->with('diasRetraso',$diasRetraso)
            ->with('estados',$estado)
            ->with('pruebas',$mensualidad)
            ->with('nombreCliente',$nombreCliente[0]->nombre)
            ->with('fechaPagos',$fechaPagos)
            ->with('idVenta',$idVenta)
            ->with('aPagar',round(($importe-$restante),2))
            ->with('putButtonPosition',$opcionPay);
        //return view('/Altas/prueba')->with('prueba',$fechaActual->toDateString());
    }
    
    public function pagar(Request $request){
        $idVenta = $request->input('idVenta');
        $interes = $request->input('interes');
        $mensualidad= $request->input('mensualidad');
        $fechaMensualidad = new Carbon($request->input('fechaMensualidad'));
        $fechaActual = Carbon::now();
        $diasRetrasoAdelanto = $fechaMensualidad->diffInDays($fechaActual);
        if($fechaMensualidad->gt($fechaActual)){
            $diasRetrasoAdelanto = -$diasRetrasoAdelanto;
        }else{
            $diasRetrasoAdelanto = $diasRetrasoAdelanto;
        }
        $consulta = DB::table('venta')
            ->select('idCliente')
            ->where('id','=',$idVenta)
            ->get();
        $idCliente = $consulta[0]->idCliente;
        DB::table('pago')
            ->insert(
            ['IdCliente'=>$idCliente,'idVenta'=>$idVenta,'Fecha'=>$fechaMensualidad,'Mensualidad'=>$mensualidad,'InteresImporte'=>$interes,'DiasRetraso'=>$diasRetrasoAdelanto]
        );
        //return view('/Altas/prueba')->with('prueba',$diasRetrasoAdelanto);
        return redirect("/Cobranza/Pagos/{$idVenta}");
        
    }
    
    public function generarPdf($idVenta){
        $fecha = Carbon::now();
        $fecha = $fecha->toDateString();
        $consultaInfo = DB::table('venta')
            ->join('cliente','cliente.RFC','=','venta.IdCliente')
            ->join('auto','venta.IdAuto','=','auto.id')
            ->select('cliente.nombre',DB::raw("CONCAT(auto.nombre,' ',auto.modelo,' ',auto.marca) as auto"),'venta.importe','venta.enganche','venta.plazos')
            ->where('venta.id','=',$idVenta)
            ->get();
        
        $pagos = DB::table('pago')
            ->select('fecha','mensualidad','interesImporte','diasRetraso')
            ->where('idVenta','=',$idVenta)
            ->get();
        
        $pdf = PDF::loadView('PDF/pagosReporte',['datos' => $consultaInfo],['pagos' => $pagos]);
        return $pdf->stream();
    }
}