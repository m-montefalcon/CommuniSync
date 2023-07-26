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
        Schema::create('control_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visitor_id')->nullable();
            $table->foreign('visitor_id')->references('id')->on('users');
            $table->unsignedBigInteger('homeowner_id')->nullable();
            $table->foreign('homeowner_id')->references('id')->on('users');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('users');
            $table->unsignedBigInteger('personnel_id')->nullable();
            $table->foreign('personnel_id')->references('id')->on('users');
            $table->date('date');
            $table->time('time');
            $table->string('destination_person');
            $table->json('visit_members')->nullable();
            $table->enum('visit_status', [1, 2, 3, 4, 5])->default(1);
            $table->mediumText('qr_code')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_accesses');
    }
};
