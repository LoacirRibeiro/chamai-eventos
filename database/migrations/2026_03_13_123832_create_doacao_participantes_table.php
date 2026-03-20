<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('doacao_participantes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('doacao_itens_id')->constrained()->onDelete('cascade');
        $table->string('nome');
        $table->integer('quantidade')->default(1);
        $table->string('whatsapp');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doacao_participantes');
    }
};
