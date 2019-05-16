<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VentasController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        return view('Menus/ventaMenu');
    }

    public function formulario(){
        $consulta = DB::table('cliente')
        ->select('rfc','nombre')
        ->get();
        $consulta2 = DB::table('auto')
        ->select(DB::raw("id, CONCAT(id+'-'+marca,'-',nombre,'-',modelo) as nombre"))
        ->get();
        return view('Altas/altaVentas')->with('clientes',$consulta)->with('autos',$consulta2);
    }

    public function altaCotizacion(Request $request){
        $cliente = $request->input('nombre');
        $auto = $request->input('auto');
        $fechaA = $request->input('fecha');
        $fechaN = explode('-', $fechaA);
        $importe = $request->input('importe');
        $descuento = $request->input('descuento');
        $enganche = $request->input('enganche');
        $plazos = $request->input('plazo');
        $taza = $request->input('taza');
        $comision = $request->input('comision');
        $idUser = Auth::id();
        $nombreVendedor = "";
        $nombreAuto = "";
        $nombreCliente = "";

        //Consulta
        $usuario  = DB::table('users')
        ->select('email')
        ->where('id','=',$idUser)
        ->get();

        foreach($usuario as $v){
            $email = $v->email;
        }
        $vendedor = DB::table('vendedor')
            ->select(DB::raw("CONCAT(nombre,' ',apellidoP,' ',apellidoM) as nombre, id"))
            ->where('email','=',$email)
            ->get();
        $autos = DB::table('auto')
            ->select(DB::raw("CONCAT(id+'-'+marca,'-',nombre,'-',modelo) as nombre"))
            ->where('id','=',$auto)
            ->get();   
        $clientes = DB::table('cliente')
            ->select('nombre')
            ->where('rfc','=',$cliente)
            ->get(); 
        foreach($vendedor as $v){
            $idVendedor = $v->id;
            $nombreVendedor = $v->nombre;
        }
        foreach($autos as $v){
            $nombreAuto = $v->nombre;
        }
        foreach($clientes as $v){
            $nombreCliente = $v->nombre;
        }
        //Alta
        $consulta = DB::table('venta')
            ->insertGetId(['idauto'=> $auto,
            'idvendedor'=>$idVendedor,'idcliente' => $cliente,
            'fecha'=>$fechaA,'descuento'=>$descuento,'enganche'=>$enganche,
            'plazos'=>$plazos,'tasa'=>$taza,'comision'=>$comision,'importe'=>$importe]);
        
        //Calculos
        $fecha = Carbon::now();
        $fecha->setYear($fechaN[0]);
        $fecha->setMonth($fechaN[1]);
        $fecha->setDay($fechaN[2]);
        $abono = 0.0;
        $abono2 = 0.0;
        $interes = 0.0;
        $mensualidad = 0.0;
        $fecha->addMonth(1);
        $importe = ($importe-$descuento)*(1+($comision/100));
        $importeEn = $importe * ($enganche/100);
        $saldo  = $importe-$importeEn;
        $abono = $saldo/$plazos;
        
        for($i = 0;$i<$plazos;$i++){
            $fecha->addMonth(1);
            $datos[] = $i+1;
            $datos[] = $fecha->format('d-m-Y');
            $interes = ($saldo * ($taza/100))/$plazos;
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
        $datosRaw[] = $nombreVendedor;
        $datosRaw[] = $nombreAuto;
        $datosRaw[] = $nombreCliente;



        return view('Altas/altaVentasR')->with('plazos', count($datos))
        ->with('datos',$datos)->with('datosRaw',$datosRaw);

    }

    public function generarPDF(Request $request){
        $datos = $request->input('datos');
        $vendedor = $request->input('vendedor');
        $auto = $request->input('auto');
        $cliente = $request->input('cliente');

        $datos[] = $vendedor;
        $datos[] = $auto;
        $datos[] = $cliente;   
            
        $pdf = PDF::loadView('PDF/tablaPDF', ['plazos' => count($datos)],['datos' => $datos]);
        return $pdf->stream('result.pdf');
    }

    public function busquedaA(){
        $consulta = DB::table('venta')
            ->join('auto','auto.id','=','venta.idauto')
            ->join('cliente','cliente.rfc','=','venta.idcliente')
            ->select(DB::raw("venta.id, cliente.nombre as cliente, CONCAT(auto.marca,'-',auto.nombre,'-',auto.modelo) as auto, venta.fecha, venta.importe"))
            ->paginate(15);
        return view('Busquedas/busquedaAVenta')->with('ventas',$consulta);
    }

    public function busqueda(){
        $consulta = DB::table('venta')
            ->join('auto','auto.id','=','venta.idauto')
            ->join('cliente','cliente.rfc','=','venta.idcliente')
            ->select(DB::raw("venta.id, cliente.nombre as cliente, CONCAT(auto.marca,'-',auto.nombre,'-',auto.modelo) as auto, venta.fecha, venta.importe"))
            ->paginate(15);
        return view('Busquedas/busquedaVentas')->with('ventas',$consulta);
    }

    public function buscarCliente(Request $request){
        $nombre = $request->input('nombre');
        $consulta = DB::table('venta')
            ->join('auto','auto.id','=','venta.idauto')
            ->join('cliente','cliente.rfc','=','venta.idcliente')
            ->select(DB::raw("venta.id, cliente.nombre as cliente, CONCAT(auto.marca,'-',auto.nombre,'-',auto.modelo) as auto, venta.fecha, venta.importe"))
            ->where('cliente.nombre','like','%'.$nombre.'%')
            ->paginate(15);
        return view('Busquedas/busquedaAVenta')->with('ventas',$consulta);
    }

    public function buscarCliente2(Request $request){
        $nombre = $request->input('nombre');
        $consulta = DB::table('venta')
            ->join('auto','auto.id','=','venta.idauto')
            ->join('cliente','cliente.rfc','=','venta.idcliente')
            ->select(DB::raw("venta.id, cliente.nombre as cliente, CONCAT(auto.marca,'-',auto.nombre,'-',auto.modelo) as auto, venta.fecha, venta.importe"))
            ->where('cliente.nombre','like','%'.$nombre.'%')
            ->paginate(15);
        return view('Busquedas/busquedaVentas')->with('ventas',$consulta);
    }

    public function busquedaVer($idCotizacion){
        //Consulta
        $consulta = DB::table('venta')
            ->join('auto','auto.id','=','venta.idauto')
            ->join('cliente','cliente.rfc','=','venta.idcliente')
            ->join('vendedor','venta.idVendedor','=','vendedor.id')
            ->select(DB::raw("venta.id, cliente.nombre as cliente,CONCAT(auto.id,'-',auto.marca,'-',auto.nombre,'-',auto.modelo) as auto,CONCAT(vendedor.nombre,' ',vendedor.apellidoP,' ',vendedor.apellidoM) as vendedor, venta.fecha, venta.importe, descuento, enganche, plazos,tasa,comision"))
            ->where('venta.id','=',$idCotizacion)
            ->get();
        //Obtencion de datos    
        foreach ($consulta as $dat) {
            $fechaA = $dat->fecha;
            $fechaN = explode('-', $fechaA);
            $importe = $dat->importe;
            $descuento = $dat->descuento;
            $enganche = $dat->enganche;
            $plazos = $dat->plazos;
            $taza = $dat->tasa;
            $comision = $dat->comision;
            $nombreVendedor = $dat->vendedor;
            $nombreAuto = $dat->auto;
            $nombreCliente = $dat->cliente;
        }

        //Calculos
        $fecha = Carbon::now();
        $fecha->setYear($fechaN[0]);
        $fecha->setMonth($fechaN[1]);
        $fecha->setDay($fechaN[2]);
        $abono = 0.0;
        $abono2 = 0.0;
        $interes = 0.0;
        $mensualidad = 0.0;
        $fecha->addMonth(1);
        $importe = ($importe-$descuento)*(1+($comision/100));
        $importeEn = $importe * ($enganche/100);
        $saldo  = $importe-$importeEn;
        $abono = $saldo/$plazos;
        
        for($i = 0;$i<$plazos;$i++){
            $fecha->addMonth(1);
            $datos[] = $i+1;
            $datos[] = $fecha->format('d-m-Y');
            $interes = ($saldo * ($taza/100))/$plazos;
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
        $datosRaw[] = $nombreVendedor;
        $datosRaw[] = $nombreAuto;
        $datosRaw[] = $nombreCliente;

        return view('Altas/altaVentasR')->with('plazos', count($datos))
        ->with('datos',$datos)->with('datosRaw',$datosRaw);
    }

    public function editar($idVenta){
        $consulta = DB::table('cliente')
        ->select('rfc','nombre')
        ->get();
        $consulta2 = DB::table('auto')
        ->select(DB::raw("id, CONCAT(id+'-'+marca,'-',nombre,'-',modelo) as nombre"))
        ->get();
        $consulta3 = DB::table('venta')
            ->join('auto','auto.id','=','venta.idauto')
            ->join('cliente','cliente.rfc','=','venta.idcliente')
            ->join('vendedor','venta.idVendedor','=','vendedor.id')
            ->select(DB::raw("venta.id, cliente.rfc as rfc,auto.id as auto,vendedor.id as vendedor, venta.fecha, venta.importe, descuento, enganche, plazos,tasa,comision"))
            ->where('venta.id','=',$idVenta)
            ->get();
        return view('/Modificacion/modificarVenta')->with('datos',$consulta3)->with('clientes',$consulta)->with('autos',$consulta2);
    }

    public function editarVenta(Request $request){
        $id = $request->input('idVenta');
        $cliente = $request->input('nombre');
        $auto = $request->input('auto');
        $fechaA = $request->input('fecha');
        $fechaN = explode('-', $fechaA);
        $importe = $request->input('importe');
        $descuento = $request->input('descuento');
        $enganche = $request->input('enganche');
        $plazos = $request->input('plazo');
        $taza = $request->input('taza');
        $comision = $request->input('comision');
        $idUser = Auth::id();
        $nombreVendedor = "";
        $nombreAuto = "";
        $nombreCliente = "";

        //Consulta
        $usuario  = DB::table('users')
        ->select('email')
        ->where('id','=',$idUser)
        ->get();

        foreach($usuario as $v){
            $email = $v->email;
        }
        $vendedor = DB::table('vendedor')
            ->select(DB::raw("CONCAT(nombre,' ',apellidoP,' ',apellidoM) as nombre, id"))
            ->where('email','=',$email)
            ->get();
        $autos = DB::table('auto')
            ->select(DB::raw("CONCAT(id+'-'+marca,'-',nombre,'-',modelo) as nombre"))
            ->where('id','=',$auto)
            ->get();   
        $clientes = DB::table('cliente')
            ->select('nombre')
            ->where('rfc','=',$cliente)
            ->get(); 
        foreach($vendedor as $v){
            $idVendedor = $v->id;
            $nombreVendedor = $v->nombre;
        }
        foreach($autos as $v){
            $nombreAuto = $v->nombre;
        }
        foreach($clientes as $v){
            $nombreCliente = $v->nombre;
        }
        //Edicion
        $consulta = DB::table('venta')
            ->where('id','=',$id)
            ->update(['idauto'=> $auto,
            'idvendedor'=>$idVendedor,'idcliente' => $cliente,
            'fecha'=>$fechaA,'descuento'=>$descuento,'enganche'=>$enganche,
            'plazos'=>$plazos,'tasa'=>$taza,'comision'=>$comision,'importe'=>$importe]);
        
        //Calculos
        $fecha = Carbon::now();
        $fecha->setYear($fechaN[0]);
        $fecha->setMonth($fechaN[1]);
        $fecha->setDay($fechaN[2]);
        $abono = 0.0;
        $abono2 = 0.0;
        $interes = 0.0;
        $mensualidad = 0.0;
        $fecha->addMonth(1);
        $importe = ($importe-$descuento)*(1+($comision/100));
        $importeEn = $importe * ($enganche/100);
        $saldo  = $importe-$importeEn;
        $abono = $saldo/$plazos;
        
        for($i = 0;$i<$plazos;$i++){
            $fecha->addMonth(1);
            $datos[] = $i+1;
            $datos[] = $fecha->format('d-m-Y');
            $interes = ($saldo * ($taza/100))/$plazos;
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
        $datosRaw[] = $nombreVendedor;
        $datosRaw[] = $nombreAuto;
        $datosRaw[] = $nombreCliente;



        return view('Altas/altaVentasR')->with('plazos', count($datos))
        ->with('datos',$datos)->with('datosRaw',$datosRaw);
    }

    public function eliminar($idCotizacion){
        $consulta = DB::table('cotizaciones')
        ->where('id','=',$idCotizacion)
        ->delete();
        return redirect('/Cotizacion/ModBaja');
    }
}
