<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('Menus/clientesMenu');
    }

    public function formularioAlta(){
        return view('Altas/altaClientes');
    }

    public function altaCliente(Request $request){
        $array_rfc = $request->input('rfc');
        $array_nombre = $request->input('nombre');
        $array_calle = $request->input('calle');
        $array_noExt = $request->input('noExterior');
        $array_noInt = $request->input('noInterior','0');
        $array_colonia = $request->input('colonia');
        $array_ciudad = $request->input('ciudad');
        $array_estado = $request->input('estado');
        $contador = 0;
        $registros = count($array_nombre);
        
        foreach($array_nombre as $i=>$t) {
            $consulta = DB::table('cliente')
            ->insert([
            'rfc'=> $array_rfc[$i],
            'nombre'=> $array_nombre[$i],
            'calle'=> $array_calle[$i],
            'noExterior'=> $array_noExt[$i],
            'noInterior'=> $array_noInt[$i],
            'colonia'=>$array_colonia[$i],
            'ciudad'=>$array_ciudad[$i],
            'estado'=> $array_estado[$i]
            ]);

            $contador++;
        }
        if($registros==$contador){
            return redirect('Clientes/Alta')->with('message', 'Datos Insertados'); ;
        }else{
            return redirect('Clientes/Alta')->with('message', 'Datos No Insertados'); ;
        }
    }

    public function busqueda(){
        $consulta = DB::table('cliente')
            ->select('rfc','nombre','calle','noExterior','noInterior','colonia','ciudad','estado') 
            ->paginate(10);
        return view('/Busquedas/busquedaCliente')->with('clientes',$consulta);
    }

    public function formularioMod($idCliente){
        $consulta = DB::table('cliente')
            ->select('rfc','nombre','calle','noExterior','noInterior','colonia','ciudad','estado') 
            ->where('rfc','=',$idCliente)
            ->get();
        return view('/Modificacion/modificarCliente')->with('clientes',$consulta);
    }

    public function editarCliente(Request $request){
        $rfc = $request->input('rfc');
        $nombre = $request->input('nombre');
        $calle = $request->input('calle');
        $noExt = $request->input('noExterior');
        $noInt = $request->input('noInterior');
        $colonia = $request->input('colonia');
        $ciudad = $request->input('ciudad');
        $estado = $request->input('estado');
        $idCliente = $request->input('rfcA');

        $consulta = DB::table('cliente')
            ->where('rfc','=',$idCliente)
            ->update(['rfc'=>$rfc,'nombre'=> $nombre,
            'calle'=>$calle,'noExterior' => $noExt,
            'noInterior'=>$noInt,'colonia'=>$colonia,
            'ciudad'=>$ciudad,'estado'=>$estado]);

        return redirect('Clientes/BajaMod')->with('message', 'Datos Modificados');
}

    public function eliminar($idCliente){
        $comprobar = DB::table('venta')
        ->select('id')
        ->where('idCliente','=',$idCliente)
        ->get();

        if(count($comprobar)>0){
            return redirect('Clientes/BajaMod')->with('message', 'Cliente no eliminado, hay registros existentes en venta');
        }else{

        $consulta = DB::table('cliente')
            ->where('rfc','=',$idCliente)
            ->delete();

        return redirect('Clientes/BajaMod')->with('message', 'Datos Modificados');
        }
    }

    public function buscarTodo(){
        $consulta = DB::table('cliente')
            ->select(DB::raw("rfc, nombre, calle, noExterior, noInterior, colonia, ciudad, estado")) 
            ->paginate(10);
        return view('/Busquedas/busquedaACliente')->with('clientes',$consulta);
    }

    public function buscarNombre(Request $request){
        $nombre = $request->input('nombre');

        $consulta = DB::table('cliente')
            ->select(DB::raw("rfc, nombre, calle, noExterior, noInterior, colonia, ciudad, estado")) 
            ->where('nombre','like',"%".$nombre."%")
            ->paginate(10);
        return view('/Busquedas/busquedaACliente')->with('clientes',$consulta);
    }

    public function search(Request $request){
        if($request->ajax()){
            $output="";
            $respuesta = $request->search;

            if($respuesta==''){
                $output.='<tr>'.
                '<td>'.'</td>'.
                    '<td>'.'</td>'.
                    '<td>'.'</td>'.
                    '<td>'.'</td>'.
                    '<td>'.'</td>'.
                    '<td>'.'</td>'.
                    '<td>'.'</td>'.
                    '<td>'.'</td>'.
                '</tr>';
            }else{
                $clientes=DB::table('cliente')
                ->select(DB::raw("rfc, nombre, calle, noExterior, noInterior, colonia, ciudad, estado"))
                ->where('nombre','LIKE','%'.$request->search."%")
                ->get();
            if($clientes){
                foreach ($clientes as $key => $cliente) {
                    $output.='<tr>'.
                    '<td>'.$cliente->rfc.'</td>'.
                    '<td>'.$cliente->nombre.'</td>'.
                    '<td>'.$cliente->calle.'</td>'.
                    '<td>'.$cliente->noExterior.'</td>'.
                    '<td>'.$cliente->noInterior.'</td>'.
                    '<td>'.$cliente->colonia.'</td>'.
                    '<td>'.$cliente->ciudad.'</td>'.
                    '<td>'.$cliente->estado.'</td>'.
                    '</tr>';
                }
            }
            
            return Response($output);
            }
        }
    }
}