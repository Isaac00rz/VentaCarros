<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CobranzaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        $consulta = DB::table('cliente')
            ->select(DB::raw("RFC,nombre, CONCAT(ciudad,' ',estado,' ',colonia,' No Interior',NoInterior,' No Exterior',NoExterior,' ',calle)as direccion")) 
            ->paginate(10);
        return view('/Menus/cobranzaMenu')->with('clientes',$consulta);
    }
    public function buscarCliente(Request $request){
        $rfc = $request->input('rfc');
        $consulta = DB::table('cliente')
            ->select(DB::raw("RFC,nombre, CONCAT(ciudad,' ',estado,' ',colonia,' No Interior',NoInterior,' No Exterior',NoExterior,' ',calle)as direccion"))
            ->where('RFC','=',$rfc)
            ->paginate(10);
        return view('/Menus/cobranzaMenu')->with('clientes',$consulta);
    }
    public function buscarCompras($rfc){
        $consulta = DB::table('venta')
            ->join('auto','auto.id','=','venta.idauto')
            ->join('pago','pago.IdVenta','=','venta.id')
            ->select('venta.id','auto.marca','auto.modelo','auto.nombre','venta.importe','venta.enganche',DB::raw('SUM(pago.importe)as pagoTotal'))
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
            ->select('fecha','plazos','tasa','importe')
            ->where('id','=',$idVenta)
            ->get();
        $fechaVenta = $consulta[0]->fecha;
        $plazos = $consulta[0]->plazos;
        $fechaPago = new Carbon($fechaVenta);
        $fechaActual = Carbon::now();
        $mensualidad = ($consulta[0]->importe)/$plazos;
        $importeTasa = (($consulta[0]->tasa)/100)*($mensualidad);
        for($cont=0;$cont<$plazos;$cont++){
            $fechaPago->addMonth(1);
            $consulta = DB::table('pago')
                ->select('fecha','mensualidad','interesImporte','diasRetraso')
                ->where([
                    ['idVenta','=',$idVenta],
                    ['fecha','=',$fechaPago->toDateString()],
                ])
                ->get();
            
            if(count($consulta)>0){
                $fecha[] = $fechaPago->toDateString();
                $mensualidades[] = $consulta[0]->mensualidad;
                $intereses[] = $consulta[0]->interesImporte;
                $diasRetraso[] = $consulta[0]->diasRetraso;
                $estado[] = "Pagado";
            }else if($fechaPago->lt($fechaActual)){
                $fecha[] = $fechaPago->toDateString();
                $mensualidades[] = $mensualidad;
                $intereses[] = $importeTasa+(50*($fechaPago->diffInDays($fechaActual)));
                $diasRetraso[] = $fechaPago->diffInDays($fechaActual);
                $estado[] = "Pago con retraso";
            }else if($fechaPago->gt($fechaActual)){
                $fecha[] = $fechaPago->toDateString();
                $mensualidades[] = $mensualidad;
                $intereses[] = $importeTasa;
                $diasRetraso[] = 0;
                $estado[] = "Proximo";
            }
        }
        

        return view('/Menus/prueba')
            ->with('fechas',$fecha)
            ->with('mensualidades',$mensualidades)
            ->with('intereses',$intereses)
            ->with('diasRetraso',$diasRetraso)
            ->with('estados',$estado)
            ->with('pruebas',$mensualidad);
    }
}