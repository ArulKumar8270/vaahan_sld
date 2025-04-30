<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufacturerUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacturer_user', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->string('email_id')->nullable();
            $table->string('address')->nullable();
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('manufacturer_name')->nullable();
            $table->string('quantity')->nullable();
            $table->string('product_name')->nullable();
            $table->string('quantity_price')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manufacturer_user');
    }
}
