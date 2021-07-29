<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesProductsTable extends Migration
{
    public function up()
    {
        Schema::create('prices_products', function (Blueprint $table) {
            $table->float('price');
            $table->foreignId('price_id')->constrained();
            $table->string('product_code');

            $table->foreign('product_code')->references('code')->on('products');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prices_products');
    }
}
