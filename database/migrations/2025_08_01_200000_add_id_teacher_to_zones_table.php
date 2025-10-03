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
        Schema::table('zones', function (Blueprint $table) {
            // Verificar si la columna NO existe antes de agregarla
            if (!Schema::hasColumn('zones', 'id_teacher')) {
                $table->unsignedBigInteger('id_teacher')->nullable()->after('id_company');
                $table->foreign('id_teacher')->references('id')->on('teachers')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zones', function (Blueprint $table) {
            // Verificar si la columna existe antes de eliminarla
            if (Schema::hasColumn('zones', 'id_teacher')) {
                $table->dropForeign(['id_teacher']);
                $table->dropColumn('id_teacher');
            }
        });
    }
};