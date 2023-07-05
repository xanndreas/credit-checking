<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('domicile_address')->nullable();
            $table->string('office_address')->nullable();
            $table->string('guarantor_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
