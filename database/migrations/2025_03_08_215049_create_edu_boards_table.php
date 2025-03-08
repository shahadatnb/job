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
        Schema::create('edu_boards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('edu_level_id');
            $table->foreign('edu_level_id')->references('id')->on('edu_levels')->onDelete('cascade');            
            $table->string('name');
            $table->unsignedTinyInteger('is_active')->default(1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edu_boards');
    }
};
