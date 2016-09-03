<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Delete extends Migration
{
    const AFTER = '_foreign';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('project_user');
        Schema::dropIfExists('organization_project');
        Schema::dropIfExists('organization_user');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('organizations');
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
}
