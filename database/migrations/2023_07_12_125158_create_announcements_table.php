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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by'); //relationship to user model
            $table->foreign('created_by')->references('id')->on('users');//relationship to user model
            $table->string('created_by_name');
            $table->string('announcement_title');
            $table->string('announcement_description');
            $table->string('announcement_photo')->nullable();
            $table->date('announcement_date');
            $table->json('role');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
