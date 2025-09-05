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
        Schema::table('literacy_hours', function (Blueprint $table) {
            // Agregar el campo hour_type después de id_student
            $table->enum('hour_type', ['school', 'learning'])
                  ->default('school')
                  ->after('id_student')
                  ->comment('Tipo de hora: school (colegio) o learning (aprendizaje autónomo)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('literacy_hours', function (Blueprint $table) {
            $table->dropColumn('hour_type');
        });
    }
};