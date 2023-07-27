<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyReportsTable extends Migration
{
    public function up()
    {
        Schema::create('survey_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('parking_access')->nullable();
            $table->longText('owner_status')->nullable();
            $table->longText('owner_beneficial')->nullable();
            $table->longText('office_note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
