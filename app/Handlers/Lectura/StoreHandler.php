<?php

namespace App\Handlers\Lectura;

use App\Interfaces\Handler;
use Illuminate\Http\Request;
use App\Models\Lectura;
use App\Models\Dispositivo;

class StoreHandler implements Handler
{
    public function setNext(Handler $handler): Handler
    {
        // No next handler
        return $this;
    }

    public function handle(Request $request)
    {
        $dispositivo = Dispositivo::where('dispositivo_codigo', $request->input('dispositivo_codigo'))->first();
        if (!$dispositivo)return response()->json(['error' => 'El dispositivo no existe.'], 400);
        $lectura = new Lectura();
        $lectura->dispositivo_id = $dispositivo->id;
        $lectura->dispositivo_codigo = $request->input('dispositivo_codigo');
        $lectura->fecha_hora = $request->input('fecha_hora');
        $lectura->lectura_energia = $request->input('lectura_energia');
        $lectura->lectura_agua = '20'; // Valor fijo, ajustar según sea necesario
        $lectura->save();

        return response()->json($lectura, 200);
    }
    
}
