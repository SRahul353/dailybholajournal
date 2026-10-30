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
        Schema::create('opinion_submissions', function (Blueprint $table) {
            $table->id();
            
            // Author Details
            $table->string('author_name');
            $table->string('author_email');
            $table->string('author_phone');
            $table->string('author_designation')->nullable();
            $table->text('author_bio')->nullable();
            $table->string('author_photo')->nullable();
            
            // Article Details
            $table->string('title');
            $table->string('topic')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            
            // Editorial Review & Status
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('admin_notes')->nullable();
            $table->foreignId('approved_post_id')->nullable()->constrained('posts')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opinion_submissions');
    }
};
