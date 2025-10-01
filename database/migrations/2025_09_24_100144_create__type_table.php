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
        // Vérifie si la table n'existe pas
        if (!Schema::hasTable('Type')) {
            Schema::create('Type', function (Blueprint $table) {
                $table->id();          
                $table->string('Nom');    
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprime la table si elle existe
        if (Schema::hasTable('Type')) {
            Schema::dropIfExists('Type');
        }
    }
};