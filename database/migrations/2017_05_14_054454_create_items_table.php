<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
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
            $table->string('title');
            // $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->tinyInteger('status')->unsigned()->index()->default(1); // 0 = unavailable, 1 = available, 2 = sold
            $table->integer('qty')->unsigned()->index()->default(1);
            $table->tinyInteger('is_featured')->unsigned()->index()->default(0);
            $table->integer('cart_count')->index()->default(0);
            $table->float('price_dollars')->default(0);
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
    }
}
