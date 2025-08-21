<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maquina;

class MaquinaController extends Controller
{

    public function index()
    {

        $maquinas = Maquina::all();
        return $maquinas;
       
    }

    public function store(Request $request)
    {
        $maquina = new Maquina();
        $maquina->nombre = $request->nombre;
        $maquina->coeficiente = $request->coeficiente;

        $maquina->save();
        
    }

    public function show(string $id)
    {
        $maquina = Maquina::find($id);
        return $maquina;
       
    }

    public function update(Request $request, string $id)
    {
        $maquina = Maquina::findOrFail($request->id);
        $maquina->nombre = $request->nombre;
        $maquina->coeficiente = $request->coeficiente;

        $maquina->save();
        return $maquina;


    
    }

    public function destroy(string $id)
    {
        $maquina = Maquina::destroy($id);
        return $maquina;
    }
}
