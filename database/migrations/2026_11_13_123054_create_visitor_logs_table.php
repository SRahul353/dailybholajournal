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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('session_id', 100)->nullable()->index();
            $table->string('device', 30)->default('Mobile')->index();
            $table->string('browser', 30)->default('Chrome')->index();
            $table->string('os', 40)->default('Android')->index();
            $table->text('url')->nullable();
            $table->string('page_title', 255)->nullable();
            $table->unsignedBigInteger('post_id')->nullable()->index();
            $table->text('referer')->nullable();
            $table->string('referer_source', 50)->default('Direct')->index();
            $table->timestamps();

            $table->index(['created_at', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};

