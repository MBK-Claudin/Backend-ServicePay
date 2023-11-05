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
        Schema::create('demande_services', function (Blueprint $table) {
            $table->foreignId('client_id')
      ->constrained(table: 'clients')
      ->onUpdate('cascade')
      ->onDelete('cascade');
      $table->foreignId('service_id')
      ->constrained(table: 'services')
      ->onUpdate('cascade')
      ->onDelete('cascade');
            $table->primary('service_id', 'client_id');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('adresse');
            $table->string('statut')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_services');
    }
};







