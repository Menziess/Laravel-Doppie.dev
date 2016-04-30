<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->bigInteger('facebook_id')
				->unsigned()
				->unique()
				->nullable();

			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('email')
				->nullable()
				->unique();

			$table->string('password')->nullable();
			$table->boolean('is_admin')->default(false);
			$table->boolean('is_active')->default(true);

			$table->rememberToken();
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
		Schema::dropIfExists('users');
	}
}
