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
        Schema::create('student_education', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->unsignedBigInteger('edu_level_id');
            $table->foreign('edu_level_id')->references('id')->on('edu_levels')->onDelete('cascade');
            $table->unsignedBigInteger('edu_group_id');
            $table->foreign('edu_group_id')->references('id')->on('edu_groups')->onDelete('cascade');
            $table->unsignedBigInteger('edu_board_id');
            $table->foreign('edu_board_id')->references('id')->on('edu_boards')->onDelete('cascade');
            $table->string('roll_no')->nullable();
            $table->string('reg_no')->nullable();
            $table->string('passing_year')->nullable();
            $table->string('gpa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_education');
    }
};
