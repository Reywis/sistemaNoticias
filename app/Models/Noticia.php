<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;
    protected $fillable = ['centro','telefonos','curso','fecha_inicio','dias_curso','horas','duracion','requisitos','estado','email','forma_curso'];
}
