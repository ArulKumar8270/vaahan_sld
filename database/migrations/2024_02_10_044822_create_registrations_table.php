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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing id column
            $table->string('date')->nullable();
            $table->string('vehicleregno')->nullable();
            $table->string('vehiclemanufacturingyear')->nullable();
            $table->string('chassisnum')->nullable();
            $table->string('engineno')->nullable();
            $table->string('vehiclemake')->nullable();
            $table->string('vehiclemodel')->nullable();
            $table->string('ownername')->nullable();
            $table->string('address')->nullable();
            $table->string('phoneo')->nullable();
            $table->string('rto')->nullable();
            $table->string('hologramnum')->nullable();
            $table->string('oldcertificatenum')->nullable();
            $table->string('oldcertificaterto')->nullable();
            $table->string('oldcertificatedate')->nullable();
            $table->string('remarks')->nullable();
            $table->string('red20mm')->nullable();
            $table->string('white20mm')->nullable();
            $table->string('red50mm')->nullable();
            $table->string('white50mm')->nullable();
            $table->string('yellow50mm')->nullable();
            $table->string('redReflector80mm')->nullable();
            $table->string('whiteReflector80mm')->nullable();
            $table->string('yellowReflector80mm')->nullable();
            $table->string('class3')->nullable();
            $table->string('class4')->nullable();
            $table->string('hologram')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('rcimage')->nullable();
            $table->string('frontimage')->nullable();
            $table->string('backimage')->nullable();
            $table->string('leftimage')->nullable();
            $table->string('rightimage')->nullable();
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
        Schema::dropIfExists('registrations');
    }
};
