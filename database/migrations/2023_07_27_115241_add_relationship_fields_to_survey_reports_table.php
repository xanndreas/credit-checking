<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSurveyReportsTable extends Migration
{
    public function up()
    {
        Schema::table('survey_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('survey_id')->nullable();
            $table->foreign('survey_id', 'survey_report_survey_fk_811228')->references('id')->on('surveys');
        });
    }
}
