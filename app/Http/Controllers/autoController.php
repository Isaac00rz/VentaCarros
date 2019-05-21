<?php

namespace App\Http\Controllers;

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

public function busqueda(){
        $consulta = DB::table('auto')
            ->select(DB::raw("id, CONCAT(nombre,' ',modelo,' ',marca) as nombre, precio")) 
            ->paginate(10);
        return view('/Busquedas/busquedaAutor')->with('autos',$consulta);
    }

public function buscarTodo(){
        $consulta = DB::table('auto')
            ->select(DB::raw("id, CONCAT(nombre,' ',modelo,' ',marca) as nombre, precio")) 
            ->paginate(10);
        return view('/Busquedas/busquedaAAuto')->with('autos',$consulta);
    }
}
