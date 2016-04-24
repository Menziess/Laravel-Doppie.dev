<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')
                  ->unsigned()
                  ->nullable();

            // Constraints
			$table->foreign('user_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('set null');

			$table->string('original_name');
			$table->string('original_extension');
			$table->string('original_mime_type')->nullable();

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
		Schema::dropIfExists('files');
	}
}
