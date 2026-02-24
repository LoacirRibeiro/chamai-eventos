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
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        // Mantemos user_id para o Laravel saber automaticamente que o evento pertence a um usuário
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        
        $table->string('titulo'); // Em vez de title
        $table->text('descricao')->nullable(); // Em vez de description
        $table->datetime('data_horario'); // Em vez de date_time
        $table->string('local'); // Em vez de location
        $table->string('slug')->unique(); // Mantemos 'slug' por ser um termo técnico de URL
        
        $table->timestamps(); // Cria 'created_at' e 'updated_at' automaticamente
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
