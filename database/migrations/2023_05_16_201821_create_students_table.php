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
            $table->id(); // Corregido: quitado el parámetro vacío
            $table->string('name');
            $table->string('last_name');
            $table->string('document')->unique(); // Agregado unique para evitar duplicados
            $table->string('email')->unique(); // Nuevo: necesario para autenticación
            $table->timestamp('email_verified_at')->nullable(); // Nuevo: para verificación de email
            $table->string('password'); // Nuevo: necesario para autenticación
            $table->string('grade');
            $table->date('star_date');
            $table->boolean('complete_service')->default(false); // Corregido: usar false en lugar de '0'
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active'); // Nuevo: control de estado
           # $table->unsignedBigInteger('id_usuario_admin');
            $table->rememberToken(); // Nuevo: para "remember me" en login
            $table->timestamps();

            #$table->foreign('id_usuario_admin')->references('id')->on('admins')->onDelete('cascade');
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
