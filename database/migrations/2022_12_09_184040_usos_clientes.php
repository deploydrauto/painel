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
        Schema::create('usos_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('client_bots');
            $table->foreignId('user_id')->constrained('users');
            $table->string('user_agent');
            $table->string('ip');
            $table->string('bot')->nullable();
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
        //
    }
};
