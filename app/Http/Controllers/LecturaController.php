<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use Illuminate\Http\Request;
use App\Models\Lectura;

class LecturaController extends Controller
{
    // Listar todas las lecturas
    public function index()
    {
        // $lecturas = Lectura::with('Dispositivo')->get();
        $lecturasFiltradas = Lectura::with('Dispositivo')
            ->whereHas('Dispositivo', function ($query) {
                $query->where('usuario_log', 2);
            })
            ->get();

        return response()->json($lecturasFiltradas);
    }

    // Crear una nueva lectura
    public function store(Request $request)
    {
        // Validate if the lectura_energia is numeric
        if (!is_numeric($request->input('lectura_energia'))) {
            return response()->json(['error' => 'La lectura de energía debe ser un valor numérico.'], 400);
        }

        // Get the previous reading
        $dispositivo = Dispositivo::where('codigo', $request->input('id_dispositivo'))->first();
        
        $previousReading = Lectura::where('id_dispositivo', $request->input('id_dispositivo'))
            ->orderBy('fecha_hora', 'desc')
            ->first();

        // Check if there is a previous reading and compare it with the current one
        if ($previousReading && $request->input('lectura_energia') < $previousReading->lectura_energia) {
            return response()->json(['error' => 'La lectura de energía debe ser mayor o igual a la lectura anterior.'], 400);
        }


        // Create a new Lectura instance and save it
        $lectura = new Lectura();
        $lectura->id_dispositivo = $request->input('id_dispositivo');
        $lectura->fecha_hora = $request->input('fecha_hora');
        $lectura->lectura_energia = $request->input('lectura_energia');
        $lectura->save();

        return response()->json($lectura, 200);
    }


    // Mostrar una lectura específica
    public function show($id)
    {
        $lectura = Lectura::findOrFail($id);
        return response()->json($lectura);
    }
    public function getDiviseData($id_dispositivo)
    {
        $divice_reads = Lectura::where('id_dispositivo', $id_dispositivo)->get();
        return response()->json($divice_reads);
    }
    public function getReadsBetweenDate($id, Request $request)
    {
        // Obtenemos las fechas de inicio y fin del objeto Request
        // Obtener la fecha actual
        $fechaActual = date('Y-m-d');

        // Calcular el primer día del mes actual
        $primerDiaDelMes = date('Y-m-01');

        // Asignar valores a $startDate y $endDate
        $startDate = $request->input('start_date') ?: $primerDiaDelMes;
        $endDate = $request->input('end_date') ?: $fechaActual;


        // Filtramos por fecha si se proporcionan las fechas de inicio y fin
        // $query = Lectura::where('id_dispositivo', $id);
        // if ($startDate && $endDate) {
        //     $query->whereBetween('fecha_hora', [$startDate, $endDate]);
        // }
        $usuarioLogueadoId = $id;
        $lecturasFiltradas = Lectura::with('Dispositivo')

            ->whereHas('Dispositivo', function ($query) use ($usuarioLogueadoId, $startDate, $endDate) {
                $query->where('usuario_log', $usuarioLogueadoId)->whereBetween('fecha_hora', [$startDate, $endDate]);
            })
            ->get();


        // // Ejecutamos la consulta y obtenemos los registros de lectura
        // $deviceReads = $query->get();

        // Devolvemos los registros de lectura en formato JSON
        return response()->json($lecturasFiltradas);
    }
    // Actualizar una lectura
    public function update(Request $request, $id)
    {
        $lectura = Lectura::findOrFail($id);
        $lectura->update($request->all());
        return response()->json($lectura, 200);
        //  return response()->json('Registro actualizado');
    }

    // Eliminar una lectura
    public function destroy($id)
    {
        $lectura = Lectura::findOrFail($id);
        $lectura->delete();
        return response()->json(null, 204);
    }
}
