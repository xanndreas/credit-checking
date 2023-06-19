<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtorInformationsTable extends Migration
{
    public function up()
    {
        Schema::create('debtor_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('debtor_name');
            $table->string('id_type');
            $table->string('id_number');
            $table->string('shareholders');
            $table->string('shareholder_id_number');
            $table->string('partner_name')->nullable();
            $table->string('guarantor_id_number')->nullable();
            $table->string('guarantor_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
