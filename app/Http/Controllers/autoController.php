<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class autoController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        return view('Menus/autoMenu');
    }
    
    public function formularioAlta(){
        return view('Altas/altaAutos');
    }
public function altaAuto(Request $request){
        $array_nombre = $request->input('nombre');
        $array_Modelo = $request->input('modelo');
        $array_Marca = $request->input('marca');
        $array_Precio = $request->input('precio');
        $contador = 0;
        $registros = count($array_nombre);

        foreach($array_nombre as $i=>$t) {
            $consulta = DB::table('auto')
            ->insert(['nombre'=> $array_nombre[$i],
            'modelo'=>$array_Modelo[$i],'marca' => $array_Marca[$i],
            'precio'=>$array_Precio[$i]]);

            $contador++;
        }
        if($registros==$contador){
            return redirect('Autos/Alta')->with('message', 'Datos Insertados'); ;
        }else{
            return redirect('Autos/Alta')->with('message', 'Datos No Insertados'); ;
        }
    }
public function busqueda(){
        $consulta = DB::table('auto')
            ->select(DB::raw("id,nombre,modelo,marca, precio")) 
            ->paginate(10);
        return view('/Busquedas/busquedaAuto')->with('autos',$consulta);
    }
    
    public function eliminar($idAuto){
        $consulta = DB::table('auto')
            ->where('id','=',$idAuto)
            ->delete();

        return redirect('Autos/BajaMod')->with('message', 'Datos Modificados');
    }
    public function formularioMod($idAuto){
        $consulta = DB::table('auto')
            ->select('id','nombre','modelo','marca','precio') 
            ->where('id','=',$idAuto)
            ->get();
        return view('/Modificacion/modificarAuto')->with('autos',$consulta);
    }
public function editarAuto(Request $request){
        $nombre = $request->input('nombre');
        $modelo = $request->input('modelo');
        $marca = $request->input('marca');
        $precio = $request->input('precio');
        $idAuto = $request->input('id');

        $consulta = DB::table('auto')
            ->where('id','=',$idAuto)
            ->update(['nombre'=> $nombre,
            'modelo'=>$modelo,'marca' => $marca,
            'precio'=>$precio]);

        return redirect('Autos/BajaMod')->with('message', 'Datos Modificados');
}
public function buscarTodo(){
        $consulta = DB::table('auto')
            ->select(DB::raw("id,nombre,modelo,marca,precio")) 
            ->paginate(10);
        return view('/Busquedas/busquedaAAuto')->with('autos',$consulta);
    }
     public function buscarNombre(Request $request){
        $nombre = $request->input('nombre');

        $consulta = DB::table('auto')
            ->select(DB::raw("id,nombre, modelo, marca,precio")) 
            ->where('nombre','like',"%".$nombre."%")
            ->paginate(10);
        return view('/Busquedas/busquedaAAuto')->with('autos',$consulta);
    }
}

