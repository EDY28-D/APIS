<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    use HasFactory;

    protected $table = 'dispositivos';

    protected $fillable = [
        'tipo_dispositivo',
        'dispositivo_codigo',
        'descripcion',
    ];


    public function lecturas(){
        $this->hasMany(Lectura::class);
    }
}
