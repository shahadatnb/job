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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->references('id')->on('companies')->nullable();            
            $table->unsignedBigInteger('designation_id')->references('id')->on('designations')->nullable();            
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('responsibility')->nullable();
            $table->text('qualifications')->nullable();
            $table->string('location')->nullable();
            $table->string('vacancy')->nullable();
            $table->string('job_nature')->nullable();
            $table->unsignedBigInteger('education_level_id')->nullable();
            $table->unsignedSmallInteger('age_limit')->nullable()->comment('Age Limit in Year');
            $table->date('last_date')->nullable()->comment('Date Line');
            $table->string('salary')->nullable();
            $table->unsignedTinyInteger('nagotiable')->default(0)->nullable();
            $table->unsignedTinyInteger('status')->default(1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
