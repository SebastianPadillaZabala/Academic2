<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';
    protected $fillable = [
        'cantidad_cursos', 'suscripcion'. 'id_user'
    ];
    protected $primaryKey = 'id_alum';
    
    static public $atributos=['cantidad_cursos', 'suscripcion'];
}
