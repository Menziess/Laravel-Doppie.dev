<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                  ->unsigned()
                  ->nullable();
            $table->integer('organization_id')
                  ->unsigned()
                  ->nullable();
            $table->integer('resource_id')
                  ->unsigned()
                  ->nullable();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
            $table->foreign('organization_id')
                  ->references('id')
                  ->on('organizations')
                  ->onDelete('set null');
            $table->foreign('resource_id')
                  ->references('id')
                  ->on('resources')
                  ->onDelete('set null');

            $table->string('name');
            $table->text('header');

            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(true);

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
        Schema::dropIfExists('projects');
    }
}
