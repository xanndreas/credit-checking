<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToApprovalsTable extends Migration
{
    public function up()
    {
        Schema::table('approvals', function (Blueprint $table) {
            $table->unsignedBigInteger('approval_user_id')->nullable();
            $table->foreign('approval_user_id', 'approval_user_fk_8121238')->references('id')->on('users');
            $table->unsignedBigInteger('dealer_information_id')->nullable();
            $table->foreign('dealer_information_id', 'dealer_information_fk_8123018')->references('id')->on('dealer_informations');
        });
    }
}
