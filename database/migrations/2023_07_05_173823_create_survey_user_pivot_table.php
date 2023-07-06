<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('survey_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_8121369')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('survey_id');
            $table->foreign('survey_id', 'survey_id_fk_1213769')->references('id')->on('surveys')->onDelete('cascade');
        });
    }
}
