<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenorsTable extends Migration
{
    public function up()
    {
        Schema::create('tenors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('year');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
