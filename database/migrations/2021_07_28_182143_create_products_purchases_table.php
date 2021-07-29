<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsPurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('products_purchases', function (Blueprint $table) {
            $table->foreignId('purchase_id')->constrained();
            $table->string('product_code');

            $table->foreign('product_code')->references('code')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_purchases');
    }
}
