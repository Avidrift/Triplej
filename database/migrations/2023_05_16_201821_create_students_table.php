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
        Schema::create('students', function (Blueprint $table) {
            $table->id('id_estudiante');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('documento');
            $table->string('grado');
            $table->date('fecha_inicio');
            $table->boolean('servicio_completado')->default('0');
            $table->unsignedBigInteger('id_usuario_admin');
            $table->timestamps();

            $table->foreign('id_usuario_admin')->reference('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
