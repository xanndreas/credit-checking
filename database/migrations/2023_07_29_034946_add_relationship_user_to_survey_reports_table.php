<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipUserToSurveyReportsTable extends Migration
{
    public function up()
    {
        Schema::table('survey_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('surveyor_id')->nullable();
            $table->foreign('surveyor_id', 'surveyor_id_fk_822228')->references('id')->on('users');
        });
    }
}
