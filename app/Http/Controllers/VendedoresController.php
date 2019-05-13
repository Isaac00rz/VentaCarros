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
}
