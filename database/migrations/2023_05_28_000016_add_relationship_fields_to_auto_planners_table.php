<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAutoPlannersTable extends Migration
{
    public function up()
    {
        Schema::table('auto_planners', function (Blueprint $table) {
            $table->unsignedBigInteger('auto_planner_name_id')->nullable();
            $table->foreign('auto_planner_name_id', 'auto_planner_name_fk_8542881')->references('id')->on('users');
        });
    }
}
