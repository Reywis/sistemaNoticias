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
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('centro');
            $table->string('telefonos')->nullable();
            $table->string('curso');
            $table->date('fecha_inicio');
            $table->string('dias_curso')->nullable();
            $table->string('horas')->nullable();
            $table->string('duracion')->nullable(); // para adjunto
            $table->string('requisitos')->nullable(); // para adjunto
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
