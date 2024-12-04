<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sedes extends Model
{
    protected $table = 'sedes';

    protected $fillable = ["nombre", "ciudad", "direccion", "nit", "total_habitaciones"];
}
