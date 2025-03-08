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
        Schema::create('edu_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('is_diploma')->default(0)->nullable();
            $table->unsignedTinyInteger('serial')->default(0)->nullable();
            $table->unsignedTinyInteger('is_active')->default(1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edu_levels');
    }
};
