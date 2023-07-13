<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyUserDomicilePivotTable extends Migration
{
    public function up()
    {
        Schema::create('survey_user_domiciles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_domicile_id');
            $table->foreign('user_domicile_id', 'user_id_fk_8121129')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('survey_id');
            $table->foreign('survey_id', 'survey_id_fk_1113769')->references('id')->on('surveys')->onDelete('cascade');
        });
    }
};
