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
        if (!Schema::hasTable('Evenement')) {
            // Crée la table si elle n'existe pas
            Schema::create('Evenement', function (Blueprint $table) {
                $table->id();
                $table->string('Nom');
                $table->text('Description')->nullable();
                $table->foreignId('TypeId')->constrained('Type')->onDelete('cascade');
                $table->date('Date')->nullable();
                $table->timestamps();
            });
        } else {
            // Ajoute uniquement les colonnes manquantes
            Schema::table('Evenement', function (Blueprint $table) {
                if (!Schema::hasColumn('Evenement', 'Description')) {
                    $table->text('Description')->nullable()->after('Nom');
                }
                if (!Schema::hasColumn('Evenement', 'TypeId')) {
                    $table->foreignId('TypeId')->constrained('types')->onDelete('cascade')->after('Description');
                }
                if (!Schema::hasColumn('Evenement', 'Date')) {
                    $table->date('Date')->nullable()->after('TypeId');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('Evenement')) {
            Schema::table('Evenement', function (Blueprint $table) {
                if (Schema::hasColumn('Evenement', 'Description')) {
                    $table->dropColumn('Description');
                }
                if (Schema::hasColumn('Evenement', 'TypeId')) {
                    $table->dropForeign(['TypeId']);
                    $table->dropColumn('TypeId');
                }
                if (Schema::hasColumn('Evenement', 'Date')) {
                    $table->dropColumn('Date');
                }
            });
        }
    }
};