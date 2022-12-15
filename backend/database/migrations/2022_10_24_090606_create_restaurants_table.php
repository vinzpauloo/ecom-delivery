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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade')->nullable()->comment('1 owner of the restaurant');
            $table->string('name', 50)->required();
            $table->string('permit', 20)->unique();
            $table->string('building_number', 10)->nullable();
            $table->string('street', 50);
            $table->string('city', 50);
            $table->string('branch', 50)->nullable();
            $table->string('landline', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('social_link', 255);
            $table->string('photo', 30);
            $table->decimal('long', 10, 7)->nullable();
            $table->decimal('lat', 10, 7)->nullable();
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
        Schema::dropIfExists('restaurants');
    }
};
