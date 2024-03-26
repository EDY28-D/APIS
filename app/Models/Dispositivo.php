<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    use HasFactory;

    protected $table = 'dispositivos';

    protected $fillable = [
<<<<<<< HEAD
       
=======
>>>>>>> ae32b943c544804868406b89d3de9b1a85b1d8f6
        'tipo_dispositivo',
        'dispositivo_codigo',
        'descripcion',
    ];


    public function lecturas(){
        $this->hasMany(Lectura::class);
    }
}
