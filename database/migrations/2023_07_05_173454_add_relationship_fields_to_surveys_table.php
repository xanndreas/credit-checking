<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSurveysTable extends Migration
{
    public function up()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->unsignedBigInteger('approval_id')->nullable();
            $table->foreign('approval_id', 'approval_fk_8112318')->references('id')->on('approvals');
            $table->unsignedBigInteger('requester_id')->nullable();
            $table->foreign('requester_id', 'requester_fk_8121218')->references('id')->on('users');
        });
    }
}
