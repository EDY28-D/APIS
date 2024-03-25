<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lectura extends Model
{
    use HasFactory;

    protected $table = 'lecturas';

    protected $fillable = [
        'dispositivo_id',
        'fecha_hora',
        'dispositivo_codigo',
    ];

    public function dispositivo()
    {
        return $this->belongsTo(Dispositivo::class, 'dispositivo_id');
    }
}
