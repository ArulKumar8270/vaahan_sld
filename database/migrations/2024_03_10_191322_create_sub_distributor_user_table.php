<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubDistributorUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_distributor_user', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('phone_number', 100)->unique()->nullable();
            $table->string('email_id', 100)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('user_name', 100)->nullable();
            $table->string('password', 100)->nullable();
            $table->string('dealer_name', 100)->nullable();
            $table->string('manufacturer_id', 100)->nullable();
            $table->string('distributor_id', 100)->nullable();
            $table->string('manufacturer_name', 100)->nullable();
            $table->string('distributor_name', 100)->nullable();
            $table->string('quantity', 100)->nullable();
            $table->string('product_name', 100)->nullable();
            $table->string('quantity_price', 100)->nullable();
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
        Schema::dropIfExists('sub_distributor_user');
    }
}
