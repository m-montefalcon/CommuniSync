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
        Schema::create('verification_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('user_name')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('contact_number');
            $table->string('house_no')->nullable();
            $table->string('family_member')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('manual_visit_option')->nullable();
            $table->string('photo')->nullable();
            $table->enum('role', [1, 2, 3, 4])->default(1);
            $table->string('email');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_requests');
    }
};
