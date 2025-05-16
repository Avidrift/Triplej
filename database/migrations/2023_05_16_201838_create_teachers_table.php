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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id('id_docente');
            $table->unsignedInteger('id_usuario_admin');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('documento');
            $table->string('area');
            $table->timestamps();

            $table->foreign('id_usuario_admin')->reference('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
