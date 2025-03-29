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
    {   //name roll number registration number session passing year job information email ID mobile number photo
        Schema::create('ex_students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('department_id');
            $table->string('roll_number');
            $table->string('registration_number');
            $table->string('session');
            $table->string('passing_year');
            $table->string('job_information');
            $table->string('email');
            $table->string('mobile');
            $table->string('photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ex_students');
    }
};
