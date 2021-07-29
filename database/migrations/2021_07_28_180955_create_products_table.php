<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('code')->primary();
            $table->string('name');
            $table->text('description');
            $table->mediumInteger('stock');
            $table->smallInteger('minimum');
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreignId('category_id')->constrained();
            $table->foreignId('provider_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
