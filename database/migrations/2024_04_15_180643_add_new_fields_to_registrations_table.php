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
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('sld_make')->nullable();
            $table->string('sld_model')->nullable();
            $table->string('sld_serial_no')->nullable();
            $table->string('rotor_seal_no')->nullable();
            $table->string('color')->nullable();
            $table->string('speed')->nullable();
            $table->string('testing_agency')->nullable();
            $table->string('tac_cop_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            //
        });
    }
};
