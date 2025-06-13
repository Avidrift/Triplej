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
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('document')->unique(); // Agregado unique para evitar duplicados
            $table->string('email')->unique(); // Nuevo: necesario para autenticación
            $table->timestamp('email_verified_at')->nullable(); // Nuevo: para verificación de email
            $table->string('password'); // Nuevo: necesario para autenticación
            $table->string('area'); // Mantenido tu campo original
            $table->date('entry_date')->nullable(); // Nuevo: fecha de ingreso del profesor
            $table->enum('status', ['active', 'inactive', 'retired'])->default('active'); // Nuevo: control de estado
            #$table->unsignedBigInteger('id_usuario_admin');
            $table->rememberToken(); // Nuevo: para "remember me" en login
            $table->timestamps();

           # $table->foreign('id_usuario_admin')->references('id')->on('admins')->onDelete('cascade');
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
