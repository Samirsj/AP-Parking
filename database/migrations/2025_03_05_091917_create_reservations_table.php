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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Utilisateur qui réserve
            $table->foreignId('parking_id')->constrained('parking')->onDelete('cascade'); // Place attribuée
            $table->timestamp('date_debut')->useCurrent(); // Date et heure de début
            $table->timestamp('date_fin')->nullable(); // Date et heure de fin
            $table->boolean('active')->default(true); // Statut de la réservation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
