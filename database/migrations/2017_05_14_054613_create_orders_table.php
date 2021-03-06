<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->index()->default(0);
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->integer('billing_address_id')->index()->unsigned();
            $table->integer('shipping_address_id')->index()->unsigned();
            $table->string('phone',20)->nullable();
            $table->string('email');
            $table->tinyInteger('is_approved')->index()->default(0);
            $table->string('stripeToken')->nullable();
            $table->text('stripeOutcome')->nullable();
            $table->tinyInteger('is_new')->index()->unsigned()->default(1); // 1 = new, 0 = seen
            $table->text('special_request')->nullable();
            $table->float('shipping_price_dollars')->unsigned()->default(0);
            $table->float('discount_dollars')->unsigned()->default(0);
            $table->float('tax_dollars')->unsigned()->default(0);
            $table->float('total_dollars')->unsigned()->default(0);
            $table->integer('shipping_id')->unsigned()->default(0)->index();
            $table->date('shipping_date')->nullable();
            $table->string('tracking_number')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
