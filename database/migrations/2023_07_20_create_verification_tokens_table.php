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
        Schema::create('verification_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('token');
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            if (!Schema::hasColumn('password_reset_tokens', 'expires_at')) {
                $table->timestamp('expires_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_tokens');

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('password_reset_tokens', 'expires_at')) {
                $table->dropColumn('expires_at');
            }
        });
    }
};
