<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use Illuminate\Http\Request;
use App\Models\Lectura;

class LecturaController extends Controller
{
    // Listar todas las lecturas
    protected $chainOfResponsibility;

    public function __construct(ChainOfResponsibility $chainOfResponsibility)
    {
        $this->chainOfResponsibility = $chainOfResponsibility;
    }

    public function store(Request $request)
    {
        return $this->chainOfResponsibility->store($request);
    }
    
    public function index()
    {
        $lecturas = Lectura::all();
        return response()->json($lecturas);
    }


    // Mostrar una lectura específica
    public function show($id)
    {
        $lectura = Lectura::findOrFail($id);
        return response()->json($lectura);
    }
    public function getDiviseData($dispositivo_codigo)
    {
        $divice_reads = Lectura::where('dispositivo_codigo', $dispositivo_codigo)->get();
        return response()->json($divice_reads);
    }
    public function getReadsBetweenDate($dispositivo_codigo, Request $request)
    {
        $fechaActual = date('Y-m-d H:i:s');
        $primerDiaDelMes = date('Y-m-01');
        $startDate = $request->input('start_date') ?: $primerDiaDelMes;
        $endDate = $request->input('end_date') ?: $fechaActual;
        $query = Lectura::where('dispositivo_codigo', $dispositivo_codigo);
        if ($startDate && $endDate) {
            $query->whereBetween('fecha_hora', [$startDate, $endDate]);
        }
         $deviceReads = $query->get();
        return response()->json($deviceReads);
    }
    // Actualizar una lectura
    public function update(Request $request, $id)
    {
        $lectura = Lectura::findOrFail($id);
        $lectura->update($request->all());
        return response()->json($lectura, 200);
    }

    // Eliminar una lectura
    public function destroy($id)
    {
        $lectura = Lectura::findOrFail($id);
        $lectura->delete();
        return response()->json(null, 204);
    }
}
