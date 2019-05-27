<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CotizacionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function formulario(){
        $consulta = DB::table('cliente')
        ->select('rfc','nombre')
        ->get();
        $consulta2 = DB::table('auto')
        ->select(DB::raw("id, CONCAT(id+'-'+marca,'-',nombre,'-',modelo) as nombre, precio"))
        ->get();
        return view('Altas/altaCotizacion')->with('clientes',$consulta)->with('autos',$consulta2)
        ->with('tamanio',count($consulta2));
    }

    public function index(){
        return view('Menus/cotizacionMenu');
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
        $consulta = DB::table('cotizaciones')
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
        $importe = ($importe-$descuento);
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


        return view('Altas/altaCotizacionR')->with('plazos', count($datos))
        ->with('datos',$datos)->with('datosRaw',$datosRaw)->with('idCotizacion',$consulta);

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
        return $pdf->download('result.pdf');
    }

    public function venta(Request $request){
        $id = $request->input('idCotizacion');

        $consulta = DB::table('cotizaciones')
            ->join('auto','auto.id','=','cotizaciones.idauto')
            ->join('cliente','cliente.rfc','=','cotizaciones.idcliente')
            ->join('vendedor','cotizaciones.idVendedor','=','vendedor.id')
            ->select(DB::raw("cotizaciones.id, cliente.nombre as cliente, CONCAT(auto.marca,'-',auto.nombre,'-',auto.modelo) as auto,CONCAT(vendedor.nombre,' ',vendedor.apellidoP,' ',vendedor.apellidoM) as vendedor,cotizaciones.idAuto, cotizaciones.idVendedor,cotizaciones.idCliente,cotizaciones.fecha, cotizaciones.importe,descuento,enganche,plazos,tasa,comision,importe"))
            ->where('cotizaciones.id','=',$id)
            ->get();
        foreach ($consulta as $cotizacion ) {
            $consulta2 = DB::table('venta')
            ->insertGetId([
                'idAuto'=>$cotizacion->idAuto,'idVendedor'=>$cotizacion->idVendedor,'idCliente'=>$cotizacion->idCliente,
                'fecha'=>$cotizacion->fecha,'descuento'=>$cotizacion->descuento,'enganche'=>$cotizacion->enganche,
                'plazos'=>$cotizacion->plazos,'tasa'=>$cotizacion->tasa,'comision'=>$cotizacion->comision,
                'importe'=>$cotizacion->importe
                ]);
                
            $fechaA = $cotizacion->fecha;
            $fechaN = explode('-', $fechaA);
            $importe = $cotizacion->importe;
            $descuento = $cotizacion->descuento;
            $enganche = $cotizacion->enganche;
            $plazos = $cotizacion->plazos;
            $taza = $cotizacion->tasa;
            $comision = $cotizacion->comision;
            $nombreVendedor = $cotizacion->vendedor;
            $nombreAuto = $cotizacion->auto;
            $nombreCliente = $cotizacion->cliente;    

            $consulta3 = DB::table('cotizaciones')
            ->where('id','=',$id)
            ->delete();
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
        $importe = ($importe-$descuento);
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

    public function busquedaA(){
        $consulta = DB::table('cotizaciones')
            ->join('auto','auto.id','=','cotizaciones.idauto')
            ->join('cliente','cliente.rfc','=','cotizaciones.idcliente')
            ->select(DB::raw("cotizaciones.id, cliente.nombre as cliente, CONCAT(auto.marca,'-',auto.nombre,'-',auto.modelo) as auto, cotizaciones.fecha, cotizaciones.importe"))
            ->paginate(15);
        return view('Busquedas/busquedaACotizacion')->with('cotizaciones',$consulta);
    }

    public function busqueda(){
        $consulta = DB::table('cotizaciones')
            ->join('auto','auto.id','=','cotizaciones.idauto')
            ->join('cliente','cliente.rfc','=','cotizaciones.idcliente')
            ->select(DB::raw("cotizaciones.id, cliente.nombre as cliente, CONCAT(auto.marca,'-',auto.nombre,'-',auto.modelo) as auto, cotizaciones.fecha, cotizaciones.importe"))
            ->paginate(15);
        return view('Busquedas/busquedaCotizacion')->with('cotizaciones',$consulta);
    }

    public function buscarCliente(Request $request){
        $nombre = $request->input('nombre');
        $consulta = DB::table('cotizaciones')
            ->join('auto','auto.id','=','cotizaciones.idauto')
            ->join('cliente','cliente.rfc','=','cotizaciones.idcliente')
            ->select(DB::raw("cotizaciones.id, cliente.nombre as cliente, CONCAT(auto.marca,'-',auto.nombre,'-',auto.modelo) as auto, cotizaciones.fecha, cotizaciones.importe"))
            ->where('cliente.nombre','like','%'.$nombre.'%')
            ->paginate(15);
        return view('Busquedas/busquedaACotizacion')->with('cotizaciones',$consulta);
    }
    public function buscarCliente2(Request $request){
        $nombre = $request->input('nombre');
        $consulta = DB::table('cotizaciones')
            ->join('auto','auto.id','=','cotizaciones.idauto')
            ->join('cliente','cliente.rfc','=','cotizaciones.idcliente')
            ->select(DB::raw("cotizaciones.id, cliente.nombre as cliente, CONCAT(auto.marca,'-',auto.nombre,'-',auto.modelo) as auto, cotizaciones.fecha, cotizaciones.importe"))
            ->where('cliente.nombre','like','%'.$nombre.'%')
            ->paginate(15);
        return view('Busquedas/busquedaCotizacion')->with('cotizaciones',$consulta);
    }

    public function busquedaVer($idCotizacion){
        //Consulta
        $consulta = DB::table('cotizaciones')
            ->join('auto','auto.id','=','cotizaciones.idauto')
            ->join('cliente','cliente.rfc','=','cotizaciones.idcliente')
            ->join('vendedor','cotizaciones.idVendedor','=','vendedor.id')
            ->select(DB::raw("cotizaciones.id, cliente.nombre as cliente,CONCAT(auto.id,'-',auto.marca,'-',auto.nombre,'-',auto.modelo) as auto,CONCAT(vendedor.nombre,' ',vendedor.apellidoP,' ',vendedor.apellidoM) as vendedor, cotizaciones.fecha, cotizaciones.importe, descuento, enganche, plazos,tasa,comision"))
            ->where('cotizaciones.id','=',$idCotizacion)
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
        $importe = ($importe-$descuento);
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

        return view('Altas/altaCotizacionR')->with('plazos', count($datos))
        ->with('datos',$datos)->with('datosRaw',$datosRaw)->with('idCotizacion',$idCotizacion);
    }

    public function editar($idCotizacion){
        $consulta = DB::table('cliente')
        ->select('rfc','nombre')
        ->get();
        $consulta2 = DB::table('auto')
        ->select(DB::raw("id, CONCAT(id+'-'+marca,'-',nombre,'-',modelo) as nombre"))
        ->get();
        $consulta3 = DB::table('cotizaciones')
            ->join('auto','auto.id','=','cotizaciones.idauto')
            ->join('cliente','cliente.rfc','=','cotizaciones.idcliente')
            ->join('vendedor','cotizaciones.idVendedor','=','vendedor.id')
            ->select(DB::raw("cotizaciones.id, cliente.rfc as rfc,auto.id as auto,vendedor.id as vendedor, cotizaciones.fecha, cotizaciones.importe, descuento, enganche, plazos,tasa,comision"))
            ->where('cotizaciones.id','=',$idCotizacion)
            ->get();
        return view('/Modificacion/modificarCotizacion')->with('datos',$consulta3)->with('clientes',$consulta)->with('autos',$consulta2);
    }

    public function editarCotizacion(Request $request){
        $id = $request->input('idCotizacion');
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
        $consulta = DB::table('cotizaciones')
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
        $importe = ($importe-$descuento);
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



        return view('Altas/altaCotizacionR')->with('plazos', count($datos))
        ->with('datos',$datos)->with('datosRaw',$datosRaw)->with('idCotizacion',$id);
    }

    public function eliminar($idCotizacion){
        $consulta = DB::table('cotizaciones')
        ->where('id','=',$idCotizacion)
        ->delete();
        return redirect('/Cotizacion/ModBaja');
    }
}