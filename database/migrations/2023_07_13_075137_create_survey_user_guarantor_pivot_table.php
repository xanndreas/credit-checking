<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyUserGuarantorPivotTable extends Migration
{
    public function up()
    {
        Schema::create('survey_user_guarantors', function (Blueprint $table) {
            $table->unsignedBigInteger('user_guarantor_id');
            $table->foreign('user_guarantor_id', 'user_id_fk_8444229')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('survey_id');
            $table->foreign('survey_id', 'survey_id_fk_1243169')->references('id')->on('surveys')->onDelete('cascade');
        });
    }
};
