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
            $table->enum('size', ['small', 'medium', 'big']);
            $table->unsignedBigInteger('category');
            $table->foreign('category')
                ->references('id')->on('food_categories')
                ->onDelete('cascade');
            $table->float('price', 8, 2);
            $table->string('description', 512)->nullable();
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
