<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rider_id');
            $table->foreign('rider_id')->references('id')->on('riders')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade')->nullable();
            $table->string('mobile', 16);
            $table->string('address', 30);
            $table->decimal('long', 10, 7);
            $table->decimal('lat', 10, 7);
            $table->string('email', 50)->nullable();
            $table->string('payment_type', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->string('order_delivery_type', 20);
            $table->dateTime('received_at')->nullable();
            $table->dateTime('preparing_at')->nullable();
            $table->dateTime('otw_at')->nullable()->comment('on the way - when the driver left the restaurant');
            $table->dateTime('delivered_at')->nullable();
            $table->timestamps();
            $table->softdeletes();

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
};
