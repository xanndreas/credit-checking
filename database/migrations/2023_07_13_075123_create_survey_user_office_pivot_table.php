<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyUserOfficePivotTable extends Migration
{
    public function up()
    {
        Schema::create('survey_user_offices', function (Blueprint $table) {
            $table->unsignedBigInteger('user_office_id');
            $table->foreign('user_office_id', 'user_id_fk_8444429')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('survey_id');
            $table->foreign('survey_id', 'survey_id_fk_1243769')->references('id')->on('surveys')->onDelete('cascade');
        });
    }
};
