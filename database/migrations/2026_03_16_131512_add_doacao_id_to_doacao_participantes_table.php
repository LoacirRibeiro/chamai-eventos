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
        Schema::table('doacao_participantes', function (Blueprint $table) {
            $table->foreignId('doacao_id')
              ->after('id') 
              ->constrained('doacoes') // Nome da sua tabela de campanhas
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
        Schema::table('doacao_participantes', function (Blueprint $table) {
        $table->dropForeign(['doacao_id']);
        $table->dropColumn('doacao_id');
    
        });
    }
};
