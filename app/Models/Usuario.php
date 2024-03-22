<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'correo_electronico',
        'contraseña',
        'tipo_usuario',
    ];

    public function dispositivos()
    {
        return $this->hasMany(Dispositivo::class, 'id_usuario');
    }
}
