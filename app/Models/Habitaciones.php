<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitaciones extends Model
{
    protected $table = 'tipo_habitaciones_sedes';

    protected $fillable = ["id_sedes", "tipo", "habitaciones"];
}
