<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface Handler
{
    public function setNext(Handler $handler): Handler;

    public function handle(Request $request);
}
