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
        Schema::create('holding_taxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');            
            $table->unsignedBigInteger('tax_id');
            $table->string('due_year')->nullable();
            $table->string('current_year')->nullable();
            $table->string('amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holding_taxes');
    }
};
