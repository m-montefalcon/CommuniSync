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
            $table->unsignedBigInteger('admin_id'); //relationship to user model
            $table->foreign('admin_id')->references('id')->on('users');//relationship to user model
            $table->string('announcement_title');
            $table->longText('announcement_description');
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
