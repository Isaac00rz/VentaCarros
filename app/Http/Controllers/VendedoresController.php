<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VendedoresController extends Controller
{
    public function index(){
        if(Auth::check()){
            return view('Menus/vendedoresMenu');

        }else{
            return redirect('/login');
        }
    }

    public function formularioAlta(){
        if(Auth::check()){
            return view('Altas/altaVendedores');

        }else{
            return redirect('/login');
        }
    }

    public function altaVendedor(Request $request){
        if(Auth::check()){
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

                $contador++;
            }
            if($registros==$contador){
                return redirect('Vendedores/Alta')->with('message', 'Datos Insertados'); ;
            }else{
                return redirect('Vendedores/Alta')->with('message', 'Datos No Insertados'); ;
            }
        }else{
            return redirect('/login');
        }
    }

    public function busqueda(){
        if(Auth::check()){
            $consulta = DB::table('vendedor')
            ->select(DB::raw("id, CONCAT(nombre,' ',apellidoP,' ',apellidoM) as nombre, telefono, email")) 
            ->paginate(10);
            return view('/Busquedas/busquedaVendedor')->with('vendedores',$consulta);

        }else{
            return redirect('/login');
        }
    }

    public function formularioMod($idVendedor){
        if(Auth::check()){
            $consulta = DB::table('vendedor')
            ->select('id','nombre','apellidoP','apellidoM','telefono','email') 
            ->where('id','=',$idVendedor)
            ->get();
            return view('/Modificacion/modificarVendedor')->with('vendedores',$consulta);

        }else{
            return redirect('/login');
        }
    }

    public function editarVendedor(Request $request){
        if(Auth::check()){
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
        }else{
            return redirect('/login');
        }
    }

    public function eliminar($idVendedor){
        if(Auth::check()){
            $consulta = DB::table('vendedor')
                ->where('id','=',$idVendedor)
                ->delete();

            return redirect('Vendedores/BajaMod')->with('message', 'Datos Modificados');
        }else{
            return redirect('/login');
        }
    }

    public function buscarTodo(){
        if(Auth::check()){
            $consulta = DB::table('vendedor')
            ->select(DB::raw("id, CONCAT(nombre,' ',apellidoP,' ',apellidoM) as nombre, telefono, email")) 
            ->paginate(10);
            return view('/Busquedas/busquedaAVendedor')->with('vendedores',$consulta);

        }else{
            return redirect('/login');
        }
    }

    public function buscarNombre(Request $request){
        if(Auth::check()){
            $nombre = $request->input('nombre');

            $consulta = DB::table('vendedor')
            ->select(DB::raw("id, CONCAT(nombre,' ',apellidoP,' ',apellidoM) as nombre, telefono, email")) 
            ->where('nombre','like',"%".$nombre."%")
            ->paginate(10);
            return view('/Busquedas/busquedaAVendedor')->with('vendedores',$consulta);
        }else{
            return redirect('/login');
        }
    }
}
