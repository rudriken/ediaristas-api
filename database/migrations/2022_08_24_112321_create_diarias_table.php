<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diarias', function (Blueprint $table) {
            $table->id();

            $table->dateTime("data_atendimento");
            $table->integer("tempo_atendimento");

            $table->integer("status");
            $table->decimal("preco", 10, 2);
            $table->decimal("valor_comissao", 10, 2);

            $table->string("logradouro");
            $table->string("numero");
            $table->string("complemento")->nullable();
            $table->string("bairro");
            $table->string("cidade");
            $table->char("estado", 2);
            $table->integer("codigo_ibge");
            $table->char("cep", 9);

            $table->integer("quantidade_quartos");
            $table->integer("quantidade_salas");
            $table->integer("quantidade_cozinhas");
            $table->integer("quantidade_banheiros");
            $table->integer("quantidade_quintais");
            $table->integer("quantidade_outros");

            $table->text("observacoes")->nullable();

            $table->text("motivo_cancelamento")->nullable();

            $table->unsignedBigInteger("cliente_id");
            $table->foreign("cliente_id")->references("id")->on("users");

            $table->unsignedBigInteger("diarista_id");
            $table->foreign("diarista_id")->references("id")->on("users");

            $table->unsignedBigInteger("servico_id");
            $table->foreign("servico_id")->references("id")->on("servicos");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diarias');
    }
};
