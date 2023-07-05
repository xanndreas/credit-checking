<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSurveyPivotTable extends Migration
{
    public function up()
    {
        Schema::create('user_survey', function (Blueprint $table) {
            $table->unsignedBigInteger('survey_id');
            $table->foreign('survey_id', 'survey_id_fk_8123769')->references('id')->on('surveys')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_8512369')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
