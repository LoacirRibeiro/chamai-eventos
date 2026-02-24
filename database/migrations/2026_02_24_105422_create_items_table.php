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
    Schema::create('itens', function (Blueprint $table) {
        $table->id();
        $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
        
        $table->string('nome'); // Ex: Carne, Refrigerante, Bolo
        $table->string('quantidade')->nullable(); // Ex: 2kg, 3 garrafas
        
        // Relacionamento opcional: quem vai levar o item
        $table->foreignId('convidado_id')->nullable()->constrained('convidados')->onDelete('set null');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
