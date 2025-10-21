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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // donation name
            $table->bigInteger('target_amount'); // donation target (ex: 1000000)
            $table->text('description'); // donation description
            $table->string('category'); // category (humanity, environment, etc)
            $table->string('cover_image')->nullable(); // cover image path
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            // membuat relasi ke tabel users
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**i
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
