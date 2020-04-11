<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 65);
            $table->timestamps();
        });

        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('item_id');
            $table->integer('quantity')->default(0);
            $table->integer('op_type');
            $table->timestamps();
        });

        Schema::create('stock_balances', function (Blueprint $table) {                    
            $table->integer('item_id')->unique();
            $table->integer('balance_quantity')->default(0);
            $table->integer('op_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('stock_balances');
    }
}
