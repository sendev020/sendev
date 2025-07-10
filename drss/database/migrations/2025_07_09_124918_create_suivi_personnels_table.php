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
        Schema::create('suivi_personnels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['congé', 'absence', 'retard', 'permission', 'maladie']);
            $table->text('motif')->nullable();
            $table->date('date_debut');
            $table->date('date_fin')->nullable(); // utile pour congés/maladies
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suivi_personnels');
    }
};
