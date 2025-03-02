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
        Schema::create('heirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');            
            $table->string('name')->nullable();
            $table->date('dob')->nullable();
            $table->string('relation')->nullable();
            $table->string('gender')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heirs');
    }
};
