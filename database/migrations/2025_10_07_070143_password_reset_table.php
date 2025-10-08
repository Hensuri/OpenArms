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
        Schema::create('password_reset', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('code_hash'); // hash dari 6-digit code
            $table->string('reset_token')->nullable()->index(); // uuid untuk akses ke halaman reset
            $table->timestamp('expires_at');
            $table->boolean('used')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset');
    }
};
