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
        Schema::create('block_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('homeowner_id')->nullable();
            $table->foreign('homeowner_id')->references('id')->on('users');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('users');
            $table->string('user_name')->unique()->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('contact_number')->nullable();
            $table->date('blocked_date');
            $table->string('block_reason');
            $table->enum('block_status', [1,2,3])->default(1);
            $table->string('block_status_response_description')->nullable();

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('block_lists');
    }
};
