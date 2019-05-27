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
