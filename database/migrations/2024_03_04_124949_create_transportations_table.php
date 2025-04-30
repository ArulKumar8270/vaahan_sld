<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transportations', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('material');
            $table->string('location');
            $table->string('vehicle_number');
            $table->string('from_company_name');
            $table->decimal('from_total_amount', 10, 2);
            $table->string('from_phone_no');
            $table->string('to_company_name');
            $table->decimal('to_total_amount', 10, 2);
            $table->string('to_phone_number');
            $table->decimal('paid_amount', 10, 2);
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
        Schema::dropIfExists('transportations');
    }
};
