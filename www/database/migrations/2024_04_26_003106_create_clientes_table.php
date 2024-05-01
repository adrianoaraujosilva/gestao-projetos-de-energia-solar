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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('integrador_id');
            $table->foreign('integrador_id')
                ->references('id')
                ->on('integradores');
            $table->string('nome', 100);
            $table->string('email');
            $table->unique(['email', 'integrador_id']);
            $table->string("telefone", 15);
            $table->string("cpf_cnpj", 14);
            $table->unique(['cpf_cnpj', 'integrador_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
