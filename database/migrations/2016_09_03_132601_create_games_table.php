<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('owner_id')
                  ->unsigned()
                  ->nullable();

            $table->foreign('owner_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->boolean('is_public')->default(true);
            $table->string('type')->nullable();
            $table->text('score')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('games');
    }
}

