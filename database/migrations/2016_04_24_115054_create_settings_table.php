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
			$table->increments('id');
			$table->integer('project_id')
				->unsigned();
			$table->increments('id');
			$table->integer('organization_id')
				->unsigned();

			// Constraints
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
			$table->foreign('project_id')
				->references('id')
				->on('projects')
				->onDelete('cascade');
			$table->foreign('organization_id')
				->references('id')
				->on('organizations')
				->onDelete('cascade');

			// Data
			$table->integer('xp')
				->default(1);

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
