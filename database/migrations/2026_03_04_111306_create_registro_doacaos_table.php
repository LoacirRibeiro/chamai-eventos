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
        Schema::create('registro_doacaos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('item_doacao_id')->constrained('item_doacaos')->onDelete('cascade');
        $table->string('nome_doador');
        $table->integer('quantidade_doada');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_doacaos');
    }
};
