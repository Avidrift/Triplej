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
        Schema::create('literacy_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_estudiante');
            $table->unsignedBigInteger('id_docente');
            $table->unsignedBigInteger('id_zona');
            $table->dateTime('fecha_hora_inicio');
            $table->dateTime('fecha_hora_fin');
            $table->boolean('validada')->default('1');
            $table->text('observaciones');
            $table->timestamps();

            $table->foreign('id_estudiante')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('id_docente')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('id_zona')->references('id')->on('zones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('literacy_hours');
    }
};
