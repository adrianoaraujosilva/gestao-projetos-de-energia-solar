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
        Schema::create('equipamentos_projetos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('projeto_id');
            $table->foreign('projeto_id')
                ->references('id')
                ->on('projetos');
            $table->unsignedBigInteger('equipamento_id');
            $table->foreign('equipamento_id')
                ->references('id')
                ->on('equipamentos');
            $table->unique(['projeto_id', 'equipamento_id']);
            $table->decimal("quantidade", 9, 4);
            $table->string("descricao")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipamentos_projetos');
    }
};
