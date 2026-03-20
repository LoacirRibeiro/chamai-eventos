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
        Schema::create('doacao_itens', function (Blueprint $table) {
        $table->id();
        // Chave estrangeira ligada à tabela de doacoes (Opção A)
        $table->foreignId('doacao_id')->constrained('doacoes')->onDelete('cascade');
        $table->string('nome'); // Ex: Arroz, Cobertores, Fraldas G
        $table->integer('quantidade_meta'); // Quantidade que a campanha precisa
        $table->integer('quantidade_arrecadada')->default(0); // O que já foi prometido/entregue
        $table->string('unidade_medida')->default('un'); // un, kg, litros, cestas
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doacao_itens');
    }
};
