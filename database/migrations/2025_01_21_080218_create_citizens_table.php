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
        Schema::create('citizens', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_bn')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('father_name')->nullable();
            $table->string('father_name_bn')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_name_bn')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_name_bn')->nullable();
            $table->string('nid')->nullable();
            $table->string('phone')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('holding')->nullable();
            $table->string('holding_bn')->nullable();
            $table->string('road')->nullable();
            $table->string('road_bn')->nullable();
            $table->string('village')->nullable();
            $table->string('village_bn')->nullable();
            $table->string('ward')->nullable();
            $table->string('post_office')->nullable();
            $table->string('post_office_bn')->nullable();
            $table->string('post_code')->nullable();
            $table->string('post_code_bn')->nullable();
            $table->unsignedInteger('upazilla_id');
            $table->unsignedInteger('district_id');
            $table->string('country')->nullable();
            $table->string('parmanent_holding')->nullable();
            $table->string('parmanent_holding_bn')->nullable();
            $table->string('parmanent_road')->nullable();
            $table->string('parmanent_road_bn')->nullable();
            $table->string('parmanent_village');
            $table->string('parmanent_village_bn')->nullable();
            $table->string('parmanent_ward');
            $table->string('parmanent_post_office')->nullable();
            $table->string('parmanent_post_office_bn')->nullable();
            $table->string('parmanent_post_code')->nullable();
            $table->string('parmanent_post_code_bn')->nullable();
            $table->unsignedInteger('parmanent_upazilla_id');
            $table->unsignedInteger('parmanent_district_id');
            $table->string('parmanent_country')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizens');
    }
};
