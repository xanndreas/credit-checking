<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDealerInformationsTable extends Migration
{
    public function up()
    {
        Schema::table('dealer_informations', function (Blueprint $table) {
            $table->unsignedBigInteger('dealer_id')->nullable();
            $table->foreign('dealer_id', 'dealer_fk_8543018')->references('id')->on('dealers');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id', 'product_fk_8543020')->references('id')->on('products');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id', 'brand_fk_8543021')->references('id')->on('brands');
            $table->unsignedBigInteger('insurance_id')->nullable();
            $table->foreign('insurance_id', 'insurance_fk_8543026')->references('id')->on('insurances');
            $table->unsignedBigInteger('tenors_id')->nullable();
            $table->foreign('tenors_id', 'tenors_fk_8543028')->references('id')->on('tenors');
            $table->unsignedBigInteger('debtor_information_id')->nullable();
            $table->foreign('debtor_information_id', 'debtor_information_fk_8543034')->references('id')->on('debtor_informations');
        });
    }
}
