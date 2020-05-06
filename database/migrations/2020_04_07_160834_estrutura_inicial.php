<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EstruturaInicial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('adm')->default(false);
            $table->boolean('bloqueado')->default(false);
            $table->string('NIF', 9)->nullable();
            $table->string('telefone')->nullable();
            $table->string('foto')->nullable();
        });

        Schema::create('categorias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->enum('tipo', ['D', 'R']);  // D-Despesa / R-Receita
        });

        Schema::create('contas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('nome', 30);
            $table->string('descricao')->nullable();
            $table->decimal('saldo_abertura', 11, 2)->default(0);
            $table->decimal('saldo_atual', 11, 2)->default(0);
            // Coluna não normalizada para simplificar desenvolvimento
            // Utilização opcional
            $table->date('data_ultimo_movimento')->nullable();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(['user_id', 'nome']);   // nome da conta é unico para cada user
        });

        Schema::create('movimentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('conta_id')->unsigned();
            $table->date('data');
            $table->decimal('valor', 11, 2);
            $table->decimal('saldo_inicial', 11, 2);
            $table->decimal('saldo_final', 11, 2);
            $table->enum('tipo', ['D', 'R']);  // D-Despesa / R-Receita
            $table->bigInteger('categoria_id')->unsigned()->nullable();
            $table->string('descricao')->nullable();
            $table->string('imagem_doc')->nullable();
            $table->softDeletes();

            $table->foreign('conta_id')->references('id')->on('contas');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->index(['conta_id', 'data']);
        });

        Schema::create('autorizacoes_contas', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('conta_id')->unsigned();
            $table->boolean('so_leitura')->default(true);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('conta_id')->references('id')->on('contas');
            $table->primary(['user_id', 'conta_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autorizacoes_contas');
        Schema::dropIfExists('movimentos');
        Schema::dropIfExists('contas');
        Schema::dropIfExists('categorias');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['adm', 'bloqueado', 'NIF', 'telefone', 'foto']);
        });
    }
}
