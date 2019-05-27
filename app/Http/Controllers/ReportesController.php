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

    public function clientesCompras(){
        $consulta = DB::table('cliente')
            ->join('venta','cliente.rfc','=','venta.idCliente')
            ->select('rfc','nombre','ciudad','estado')
            ->distinct()
            ->paginate(10);
    return view('/Busquedas/busquedaClientesCompras')->with('clientes',$consulta);
    }

    public function reporteCompras($rfc){
        $consulta = DB::table('cliente')
            ->join('venta','cliente.rfc','=','venta.idCliente')
            ->join('auto','auto.id','=','venta.idAuto')
            ->join('vendedor','vendedor.id','=', 'venta.idVendedor')
            ->select('cliente.nombre as cliente','auto.nombre as auto','vendedor.nombre as vendedor','venta.fecha','venta.plazos','venta.id')
            ->where('cliente.rfc','=',$rfc)
            ->get();
        

            $idVentas[] = 0;

            foreach ($consulta as $dat) {
                $cliente = $dat->cliente;
                $idVentas[] = $dat->id;
            }

            $consulta2 = DB::table('pago')
                ->join('venta', 'pago.idVenta','=','venta.id')
                ->join('cliente', 'cliente.rfc','=', 'venta.idCliente')
                ->select(DB::raw("if(count(*) = venta.Plazos, 1, 0) as Pagado, venta.id"))
                ->where('cliente.rfc','=',$rfc)
                ->whereIn('pago.idVenta',$idVentas)
                ->groupBy('venta.id','venta.plazos')
                ->get();
        
            return view('Reportes/reporteCompras')->with('compras',$consulta)->with('cliente',$cliente)
        ->with('rfc', $rfc)->with('pagado', $consulta2)->with('tamanio',count($consulta2));
    }

    public function reporteComprasPDF(Request $request){
        $rfc = $request->input('rfc');
        $consulta = DB::table('cliente')
            ->join('venta','cliente.rfc','=','venta.idCliente')
            ->join('auto','auto.id','=','venta.idAuto')
            ->join('vendedor','vendedor.id','=', 'venta.idVendedor')
            ->select('cliente.nombre as cliente','auto.nombre as auto','vendedor.nombre as vendedor','venta.fecha','venta.plazos','venta.id')
            ->where('cliente.rfc','=',$rfc)
            ->get();
        

            $idVentas[] = 0;
            
            foreach ($consulta as $dat) {
                $cliente = $dat->cliente;
                $idVentas[] = $dat->id;
            }

            $consulta2 = DB::table('pago')
                ->join('venta', 'pago.idVenta','=','venta.id')
                ->join('cliente', 'cliente.rfc','=', 'venta.idCliente')
                ->select(DB::raw("if(count(*) = venta.Plazos, 1, 0) as Pagado, venta.id"))
                ->where('cliente.rfc','=',$rfc)
                ->whereIn('pago.idVenta',$idVentas)
                ->groupBy('venta.id','venta.plazos')
                ->get();
            $control = 0;
            foreach ($consulta as  $dat) {
                $datos[] = $dat->auto;
                $datos[] = $dat->vendedor;
                $datos[] = $dat->fecha;
                foreach ($consulta2 as $dat2) {
                    if($dat->id == $pagado[$a]->id){
                        $control=1;
                        if($dat2->Pagado==1){
                            $datos[] = 'Pagado';
                        }else{
                            $datos[] = 'En deuda';
                        }
                    }
                }
                if($control==0){
                    $datos[] = 'En deuda';
                }
                $control=0;
                
            }
            $datos2[] = $cliente;
            $datos2[] = count($datos);

            $pdf = PDF::loadView('PDF/comprasPDF', ['datos' => $datos],['datos2' => $datos2]);
        return $pdf->download('compras.pdf');

    }

}
