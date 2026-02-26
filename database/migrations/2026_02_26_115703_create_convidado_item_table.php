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
        Schema::create('convidado_item', function (Blueprint $table) {
            $table->id();
            
            // Chave estrangeira para o convidado
            $table->foreignId('convidado_id')
                ->constrained('convidados')
                ->onDelete('cascade');

            // Chave estrangeira para o item
            $table->foreignId('item_id')
                ->constrained('itens')
                ->onDelete('cascade');

            // Campo opcional para a quantidade que ESTE convidado está levando
            $table->string('quantidade_levada')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convidado_item');
    }
};
