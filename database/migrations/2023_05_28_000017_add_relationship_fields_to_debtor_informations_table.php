<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDebtorInformationsTable extends Migration
{
    public function up()
    {
        Schema::table('debtor_informations', function (Blueprint $table) {
            $table->unsignedBigInteger('auto_planner_information_id')->nullable();
            $table->foreign('auto_planner_information_id', 'auto_planner_information_fk_8543016')->references('id')->on('auto_planners');
        });
    }
}
