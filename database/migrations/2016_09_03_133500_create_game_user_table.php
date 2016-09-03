<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_user', function(Blueprint $table)
        {
            $table->integer('game_id')->unsigned()->index()->nullable();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('set null');
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->integer('team_id')->nullable();

            $table->json('score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_user');
    }
}
