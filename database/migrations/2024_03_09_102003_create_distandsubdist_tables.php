<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('distributor', function (Blueprint $table) {
            $table->id();
            $table->string('dealerName')->nullable();
            $table->string('red20mm')->nullable();
            $table->string('red50mm')->nullable();
            $table->string('white20mm')->nullable();
            $table->string('white50mm')->nullable();
            $table->string('yellow50mm')->nullable();
            $table->string('yellow80mm')->nullable();
            $table->string('redReflector80mm')->nullable();
            $table->string('whiteReflector80mm')->nullable();
            $table->string('yellowReflector80mm')->nullable();
            $table->string('class3')->nullable();
            $table->string('class4')->nullable();
            $table->string('hologram')->nullable();
            $table->string('invoiceNumber')->nullable();
            $table->string('distributer_id')->nullable()->default(null);
            $table->string('subdistributer_id')->nullable()->default(null);
            $table->string('dealer_id')->nullable()->default(null);
            $table->string('manufacturer_id')->nullable()->default(null);
            $table->string('distributer_name')->nullable()->default(null);
            $table->string('sub_distributer_name')->nullable()->default(null);
            $table->string('dealer_name')->nullable()->default(null);
            $table->string('manufacturer_name')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('dealer', function (Blueprint $table) {
            $table->id();
            $table->string('dealerName')->nullable();
            $table->string('red20mm')->nullable();
            $table->string('red50mm')->nullable();
            $table->string('white20mm')->nullable();
            $table->string('white50mm')->nullable();
            $table->string('yellow50mm')->nullable();
            $table->string('yellow80mm')->nullable();
            $table->string('redReflector80mm')->nullable();
            $table->string('whiteReflector80mm')->nullable();
            $table->string('yellowReflector80mm')->nullable();
            $table->string('class3')->nullable();
            $table->string('class4')->nullable();
            $table->string('hologram')->nullable();
            $table->string('invoiceNumber')->nullable();
            $table->string('distributer_id')->nullable()->default(null);
            $table->string('subdistributer_id')->nullable()->default(null);
            $table->string('dealer_id')->nullable()->default(null);
            $table->string('manufacturer_id')->nullable()->default(null);
            $table->string('distributer_name')->nullable()->default(null);
            $table->string('sub_distributer_name')->nullable()->default(null);
            $table->string('dealer_name')->nullable()->default(null);
            $table->string('manufacturer_name')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('subDistributor', function (Blueprint $table) {
            $table->id();
            $table->string('dealerName')->nullable();
            $table->string('red20mm')->nullable();
            $table->string('red50mm')->nullable();
            $table->string('white20mm')->nullable();
            $table->string('white50mm')->nullable();
            $table->string('yellow50mm')->nullable();
            $table->string('yellow80mm')->nullable();
            $table->string('redReflector80mm')->nullable();
            $table->string('whiteReflector80mm')->nullable();
            $table->string('yellowReflector80mm')->nullable();
            $table->string('class3')->nullable();
            $table->string('class4')->nullable();
            $table->string('hologram')->nullable();
            $table->string('invoiceNumber')->nullable();
            $table->string('distributer_id')->nullable()->default(null);
            $table->string('subdistributer_id')->nullable()->default(null);
            $table->string('dealer_id')->nullable()->default(null);
            $table->string('manufacturer_id')->nullable()->default(null);
            $table->string('distributer_name')->nullable()->default(null);
            $table->string('sub_distributer_name')->nullable()->default(null);
            $table->string('dealer_name')->nullable()->default(null);
            $table->string('manufacturer_name')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributor');
        Schema::dropIfExists('subDistributor');
    }
};
