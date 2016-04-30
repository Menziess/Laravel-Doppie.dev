<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles', function (Blueprint $table) {

			// Id's
			$table->increments('id');
			$table->integer('user_id')
				  ->unsigned();
			$table->integer('resource_id')
				  ->unsigned()
				  ->nullable();

			// Constraints
			$table->foreign('user_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('cascade');
			$table->foreign('resource_id')
				  ->references('id')
				  ->on('resources')
				  ->onDelete('set null');

			// Data
			$table->string('gender')
				  ->nullable();
			$table->timestamp('date_of_birth')
				  ->nullable();
			$table->string('latitude')
				->nullable();
			$table->string('longitude')
				->nullable();

			// Tokens & statistics
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
		Schema::dropIfExists('profiles');
	}
}
