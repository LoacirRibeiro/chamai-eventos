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
    Schema::create('convidados', function (Blueprint $table) {
        $table->id();
        // Relacionamento com a tabela de eventos
        $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
        
        $table->string('nome');
        $table->string('contato')->nullable(); // Pode ser Whats ou E-mail
        $table->string('token_acesso')->unique(); // Para o link VIP
        $table->enum('presenca', ['pendente', 'confirmado', 'recusado'])->default('pendente');
        
        $table->timestamps(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convidados');
    }
};
