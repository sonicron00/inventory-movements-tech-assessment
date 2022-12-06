<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'purchases',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->date('transaction_date')->default(today());
                $table->integer('product_id')->nullable(false);
                $table->integer('quantity')->nullable(false);
                $table->float('price')->nullable(false);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'purchases',
            function (Blueprint $table) {
                Schema::dropIfExists('purchases');
            }
        );
    }
}
