<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Claims table (Public Submissions for Fact-Checking)
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->string('submitter_name')->nullable();
            $table->string('submitter_email')->nullable();
            $table->string('submitter_phone')->nullable();
            $table->text('claim_text');
            $table->string('claim_url')->nullable();
            $table->string('attachment_path')->nullable();
            $table->enum('status', ['pending', 'investigating', 'verified', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('post_id')->nullable()->constrained('posts')->nullOnDelete(); // Linked fact check if verified
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        // 2. Newsletter Subscribers table
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamp('subscribed_at')->useCurrent();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('claims');
    }
};
