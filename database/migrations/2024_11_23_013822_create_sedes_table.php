<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sedes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ciudad');
            $table->longText('direccion');
            $table->string('nit');
            $table->integer('total_habitaciones');
            $table->timestamps();
        });

        Schema::create('tipo_habitaciones_sedes', function (Blueprint $table) {
            $table->id();
            $table->integer('id_sedes');
            $table->string('tipo');
            $table->integer('habitaciones');
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sedes');
        Schema::dropIfExists('tipo_habitaciones_sedes');
    }
};
