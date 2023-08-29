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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('users');
            $table->unsignedBigInteger('homeowner_id')->nullable();
            $table->foreign('homeowner_id')->references('id')->on('users');
            $table->string('complaint_title');
            $table->string('complaint_desc');
            $table->json('complaint_updates')->nullable();
            $table->date('complaint_date');
            $table->string('complaint_photo')->nullable();
            $table->enum('complaint_status', [1, 2, 3])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
