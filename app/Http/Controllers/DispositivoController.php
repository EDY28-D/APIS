<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dispositivo;


class DispositivoController extends Controller
{
    // Listar todos los dispositivos
    public function index()
    {
        $dispositivos = Dispositivo::all();
        return response()->json($dispositivos);
    }

    // Crear un nuevo dispositivo
    public function store(Request $request)
    {
        $dispositivo = Dispositivo::create($request->all());
        return response()->json($dispositivo, 201);
    }

    // Mostrar un dispositivo específico
    public function show($id)
    {
        $dispositivo = Dispositivo::findOrFail($id);
        return response()->json($dispositivo);
    }

    // Actualizar un dispositivo
    public function update(Request $request, $id)
    {
        $dispositivo = Dispositivo::findOrFail($id);
        $dispositivo->update($request->all());
        return response()->json($dispositivo, 200);
    }

    // Eliminar un dispositivo
    public function destroy($id)
    {
        $dispositivo = Dispositivo::findOrFail($id);
        $dispositivo->delete();
        return response()->json(null, 204);
    }
    
}
