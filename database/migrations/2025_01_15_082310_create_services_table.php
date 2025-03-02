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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->enum('lan', ['bn', 'en'])->default('bn');
            $table->unsignedTinyInteger('status')->default(1)->remarks('1=Pending,2=Accept,3=Reject');
            $table->string('name');
            $table->string('other_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('nid')->nullable();
            $table->string('phone')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->string('blood_group')->nullable();            
            $table->string('holding')->nullable();
            $table->string('road')->nullable();
            $table->string('village');
            $table->string('ward');
            $table->string('post_office')->nullable();
            $table->string('post_code')->nullable();
            $table->unsignedInteger('upazilla_id');
            $table->unsignedInteger('district_id');
            $table->string('country')->nullable();
            $table->string('parmanent_holding')->nullable();
            $table->string('parmanent_road')->nullable();
            $table->string('parmanent_village');
            $table->string('parmanent_ward');
            $table->string('parmanent_post_office')->nullable();
            $table->string('parmanent_post_code')->nullable();
            $table->unsignedInteger('parmanent_upazilla_id');
            $table->unsignedInteger('parmanent_district_id');
            $table->string('parmanent_country')->nullable();            
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('approved_rejected_by')->nullable();
            $table->string('approved_rejected_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
