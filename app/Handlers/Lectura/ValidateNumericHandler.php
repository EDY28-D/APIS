<?php

namespace App\Handlers\Lectura;

use App\Interfaces\Handler;
use Illuminate\Http\Request;

class ValidateNumericHandler implements Handler
{
    private $nextHandler;

    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(Request $request)
    {
        if (!is_numeric($request->input('lectura_energia'))) {
            return response()->json(['error' => 'La lectura de energia debe ser un valor numérico.'], 400);
        }

        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }

        return null;
    }
}
