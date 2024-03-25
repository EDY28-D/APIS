<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\Handler;
use App\Handlers\Lectura\ValidateNumericHandler;
use App\Handlers\Lectura\CompareReadingHandler;
use App\Handlers\Lectura\StoreHandler;

class ChainOfResponsibility
{
    private $chain;

    public function __construct()
    {
        $this->buildChain();
    }

    private function buildChain()
    {
        $this->chain = new ValidateNumericHandler();
        $this->chain->setNext(new CompareReadingHandler())
            ->setNext(new StoreHandler());
    }

    public function store(Request $request)
    {
        return $this->chain->handle($request);
    }
}
