<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VendedoresController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('Menus/vendedoresMenu');
    }

    public function formularioAlta(){
        return view('Altas/altaVendedores');
    }

    public function altaVendedor(Request $request){
        $array_nombre = $request->input('nombre');
        $array_ApellidoP = $request->input('apellidoP');
        $array_ApellidoM = $request->input('apellidoM');
        $array_telefono = $request->input('telefono');
        $array_email = $request->input('email');
        $contador = 0;
        $registros = count($array_nombre);

        foreach($array_nombre as $i=>$t) {
            $consulta = DB::table('vendedor')
            ->insert(['nombre'=> $array_nombre[$i],
            'apellidoP'=>$array_ApellidoP[$i],'apellidoM' => $array_ApellidoM[$i],
            'telefono'=>$array_telefono[$i],'email'=>$array_email[$i]]);
            $consulta2 = DB::table('users')
            ->insert(['name'=> $array_nombre[$i].$array_ApellidoP[$i].$array_ApellidoM[$i],
            'email'=>$array_email[$i],'password'=>bcrypt('12345678')]);
            $contador++;
        }
        if($registros==$contador){
            return redirect('Vendedores/Alta')->with('message', 'Datos Insertados'); ;
        }else{
            return redirect('Vendedores/Alta')->with('message', 'Datos No Insertados'); ;
        }
    }

    public function busqueda(){
        $consulta = DB::table('vendedor')
            ->select(DB::raw("id, CONCAT(nombre,' ',apellidoP,' ',apellidoM) as nombre, telefono, email")) 
            ->paginate(10);
        return view('/Busquedas/busquedaVendedor')->with('vendedores',$consulta);
    }

    public function formularioMod($idVendedor){
        $consulta = DB::table('vendedor')
            ->select('id','nombre','apellidoP','apellidoM','telefono','email') 
            ->where('id','=',$idVendedor)
            ->get();
        return view('/Modificacion/modificarVendedor')->with('vendedores',$consulta);
    }

    public function editarVendedor(Request $request){
        $nombre = $request->input('nombre');
        $apellidoP = $request->input('apellidoP');
        $apellidoM = $request->input('apellidoM');
        $telefono = $request->input('telefono');
        $email = $request->input('email');
        $idVendedor = $request->input('id');

        $consulta = DB::table('vendedor')
            ->where('id','=',$idVendedor)
            ->update(['nombre'=> $nombre,
            'apellidoP'=>$apellidoP,'apellidoM' => $apellidoM,
            'telefono'=>$telefono,'email'=>$email]);

        return redirect('Vendedores/BajaMod')->with('message', 'Datos Modificados');
}

    public function eliminar($idVendedor){
        $consulta = DB::table('vendedor')
            ->where('id','=',$idVendedor)
            ->delete();

        return redirect('Vendedores/BajaMod')->with('message', 'Datos Modificados');
    }

    public function buscarTodo(){
        $consulta = DB::table('vendedor')
            ->select(DB::raw("id, CONCAT(nombre,' ',apellidoP,' ',apellidoM) as nombre, telefono, email")) 
            ->paginate(10);
        return view('/Busquedas/busquedaAVendedor')->with('vendedores',$consulta);
    }

    public function buscarNombre(Request $request){
        $nombre = $request->input('nombre');

        $consulta = DB::table('vendedor')
            ->select(DB::raw("id, CONCAT(nombre,' ',apellidoP,' ',apellidoM) as nombre, telefono, email")) 
            ->where('nombre','like',"%".$nombre."%")
            ->paginate(10);
        return view('/Busquedas/busquedaAVendedor')->with('vendedores',$consulta);
    }
}
