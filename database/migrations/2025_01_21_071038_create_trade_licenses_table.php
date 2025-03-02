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
        Schema::create('trade_licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');            
            $table->string('bussiness_name')->nullable();
            $table->string('proprietor_name')->nullable();
            $table->string('bussiness_nature')->nullable();
            $table->string('bussiness_type')->nullable();
            $table->string('address')->nullable();
            $table->string('upazilla_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('region')->nullable();
            $table->string('word')->nullable();
            $table->string('tin')->nullable();
            $table->string('bin')->nullable();
            $table->string('email')->nullable();
            $table->unsignedMediumInteger('financial_year_id')->nullable();
            $table->date('bussiness_start_date')->nullable();
            $table->decimal('new_fee', 10, 2)->nullable();
            $table->decimal('renewal_fee', 10, 2)->nullable();
            $table->decimal('due_fee', 10, 2)->nullable();
            $table->decimal('surcharge_fee', 10, 2)->nullable();
            $table->decimal('currection_fee', 10, 2)->nullable();
            $table->decimal('signboard_fee', 10, 2)->nullable();
            $table->decimal('income_tax', 10, 2)->nullable();
            $table->decimal('vat', 10, 2)->nullable();
            $table->decimal('total_fee', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_licenses');
    }
};
