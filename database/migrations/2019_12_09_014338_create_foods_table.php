<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 256);
            $table->unsignedBigInteger('category');
            $table->foreign('category')
                ->references('id')->on('food_categories')
                ->onDelete('cascade');
            $table->float('very_small_price', 8, 2);
            $table->float('small_price', 8, 2);
            $table->float('medium_price', 8, 2);
            $table->float('large_price', 8, 2);
            $table->float('very_large_price', 8, 2);
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foods');
    }
}
