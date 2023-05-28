<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealerInformationsTable extends Migration
{
    public function up()
    {
        Schema::create('dealer_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sales_name');
            $table->string('models');
            $table->integer('number_of_units');
            $table->decimal('otr', 15, 2);
            $table->string('debt_principal');
            $table->string('down_payment')->nullable();
            $table->string('addm_addb');
            $table->float('effective_rates', 15, 2);
            $table->string('debtor_phone');
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
