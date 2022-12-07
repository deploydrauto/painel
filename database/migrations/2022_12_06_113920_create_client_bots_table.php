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
        Schema::create('client_bots', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('id_user');
            $table->string('nome');
            $table->string('telefone');
            $table->string('plano');
            $table->string('status');
            $table->string('data_atv');
            $table->string('meio');
            $table->string('ip');
            $table->timestamps();
        });
       
        Schema::create('game_ip_user', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_game');
            $table->string('hash');
            $table->timestamps();
        });
        Schema::create('game_sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('sessid');
            $table->string('time');
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
        Schema::dropIfExists('client_bots');
        Schema::dropIfExists('clients_per_game');

    }
};
