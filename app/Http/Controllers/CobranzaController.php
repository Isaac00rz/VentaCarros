<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
}