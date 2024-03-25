<?php

namespace App\Handlers\Lectura;

use App\Interfaces\Handler;
use Illuminate\Http\Request;
use App\Models\Lectura;

class CompareReadingHandler implements Handler
{
    private $nextHandler;

    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(Request $request)
    {
        $previousReading = Lectura::where('dispositivo_codigo', $request->input('dispositivo_codigo'))
            ->orderBy('fecha_hora', 'desc')
            ->first();

        if ($previousReading && $request->input('lectura_energia') < $previousReading->lectura_energia) {
            return response()->json(['error' => 'La lectura de energía debe ser mayor o igual a la lectura anterior.'], 400);
        }

        if ($this->nextHandler)return $this->nextHandler->handle($request);
        return null;
    }
}
