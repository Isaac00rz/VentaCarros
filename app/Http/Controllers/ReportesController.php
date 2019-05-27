<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('Menus/reportesMenu');
    }

    public function listaVendedores(){
        $consulta = DB::table('vendedor')
            ->select(DB::raw("id, CONCAT(nombre,' ',apellidoP,' ',apellidoM) as nombre, telefono, email")) 
            ->paginate(10);
        return view('/Busquedas/busquedaVendedorReporte')->with('vendedores',$consulta);
    }

	public function listaClientes(){
        $consulta = DB::table('cliente')
            ->select(DB::raw("RFC, nombre, CONCAT(ciudad,' ',colonia,' ',calle) as direccion")) 
            ->paginate(10);
        return view('/Busquedas/busquedaPagoCliente')->with('clientes',$consulta);
    }

    public function comisionVendedor($idVendedor){
        $total = 0;
        $consulta = DB::table('venta')
            ->join('cliente','venta.idCliente','=','cliente.rfc')
            ->select('venta.id','venta.comision','venta.importe','venta.fecha','cliente.nombre') 
            ->where('idVendedor','=',$idVendedor)
            ->get();
        $consulta2 = DB::table('vendedor')
        ->select(DB::raw("CONCAT(nombre,' ',apellidoP,' ',apellidoM) as nombre")) 
        ->where('id','=',$idVendedor)
        ->get();   

        foreach ($consulta as $venta) {
            $comision[] = ($venta->importe * (($venta->comision/100)));
        }
        for ($i=0; $i < count($comision); $i++) { 
            $total+=$comision[$i];
       }

        return view('/Reportes/reporteComision')
        ->with('ventas',$consulta)
        ->with('comisiones',$comision)
        ->with('vendedor',$consulta2[0]->nombre)
        ->with('id',$idVendedor)
        ->with('total',$total);
    }
	//Ver pagos
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
        return view('/Busquedas/comprasCliente')->with('compras',$consulta)->with('nombre',$consultaName);
    }
	
	public function pagosClientes($idVenta){
        $fecha = Carbon::now();
        $fecha = $fecha->toDateString();
        $consultaInfo = DB::table('venta')
            ->join('cliente','cliente.RFC','=','venta.IdCliente')
            ->join('auto','venta.IdAuto','=','auto.id')
            ->select('venta.id','cliente.nombre',DB::raw("CONCAT(auto.nombre,' ',auto.modelo,' ',auto.marca) as auto"),'venta.importe','venta.enganche','venta.plazos')
            ->where('venta.id','=',$idVenta)
            ->get();
        
        $pagos = DB::table('pago')
            ->select('fecha','mensualidad','interesImporte','diasRetraso')
            ->where('idVenta','=',$idVenta)
            ->get();
        
        return view('/Reportes/reportePagos')->with('info',$consultaInfo)->with('pagos',$pagos);
    }
	
    public function comisionPDF(Request $request){
        $id = $request->input('id');
        $total = 0;
        $consulta = DB::table('venta')
            ->join('cliente','venta.idCliente','=','cliente.rfc')
            ->select('venta.id','venta.comision','venta.importe','venta.fecha','cliente.nombre') 
            ->where('idVendedor','=',$id)
            ->get();
        $consulta2 = DB::table('vendedor')
        ->select(DB::raw("CONCAT(nombre,' ',apellidoP,' ',apellidoM) as nombre")) 
        ->where('id','=',$id)
        ->get();   

        foreach ($consulta as $venta) {
            $datos[] = $venta->id;
            $datos[] = $venta->nombre;
            $datos[] = $venta->fecha;
            $datos[] = ($venta->importe * (($venta->comision/100)));
            $total+= ($venta->importe * (($venta->comision/100)));
        }
        
       $datos2[] = $consulta2[0]->nombre;
       $datos2[] = $total;
       $datos2[] = count($datos);
        $pdf = PDF::loadView('PDF/comisionPDF', ['datos' => $datos],['datos2' => $datos2]);
        return $pdf->download('comision.pdf');
    }

}
