<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->float('total');
            $table->timestamps();

            $table->foreignId('provider_id')->constrained();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
