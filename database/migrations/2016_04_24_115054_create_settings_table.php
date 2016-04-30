<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function (Blueprint $table) {

			// Id's
			$table->increments('id');
			$table->integer('user_id')
				->unsigned();

			// Constraints
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');

			// Data
			$table->integer('integer_setting')
				->default(1)
				->nullable();
			$table->boolean('boolean_setting')
				->default(true);

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
		Schema::dropIfExists('settings');
	}
}
