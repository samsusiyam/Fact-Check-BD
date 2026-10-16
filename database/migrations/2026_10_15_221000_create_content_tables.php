<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_bn');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->text('description_bn')->nullable();
            $table->text('description_en')->nullable();
            $table->integer('order_column')->default(0);
            $table->timestamps();
        });

        // 2. Tags
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name_bn');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 3. Author Profiles
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio_bn')->nullable()->after('email');
            $table->text('bio_en')->nullable()->after('bio_bn');
            $table->string('designation_bn')->nullable()->after('bio_en');
            $table->string('designation_en')->nullable()->after('designation_bn');
            $table->string('avatar')->nullable()->after('designation_en');
            $table->string('twitter_url')->nullable()->after('avatar');
            $table->string('linkedin_url')->nullable()->after('twitter_url');
        });

        // 4. Posts (Fact-checks)
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            
            // Core editorial
            $table->string('title_bn');
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->text('excerpt_bn')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->longText('content_bn')->nullable();
            $table->longText('content_en')->nullable();
            
            // Fact-check specific structured fields
            $table->text('claim_text_bn');
            $table->text('claim_text_en')->nullable();
            $table->string('claim_claimant_bn')->nullable();
            $table->string('claim_claimant_en')->nullable();
            $table->string('claim_origin_bn')->nullable(); // Where spread (Facebook/TikTok/etc)
            $table->string('claim_origin_en')->nullable();
            $table->string('claim_date')->nullable();
            
            // Verdict
            $table->enum('verdict', [
                'false',         // ভুয়া
                'misleading',    // বিভ্রান্তিকর
                'true',          // সত্য
                'ai_generated',  // এআই-নির্মিত / ডিপফেক
                'unproven'       // অপ্রমাণিত
            ])->default('false');

            // Verification & Sources
            $table->longText('verification_steps_bn')->nullable();
            $table->longText('verification_steps_en')->nullable();
            $table->json('sources')->nullable(); // Repeater: title, url, type
            
            // Publishing & Lifecycle
            $table->enum('status', ['draft', 'scheduled', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('factcheck_updated_at')->nullable();
            $table->text('correction_note_bn')->nullable();
            $table->text('correction_note_en')->nullable();

            $table->boolean('is_lead')->default(false);
            $table->unsignedInteger('views_count')->default(0);

            $table->timestamps();
        });

        // Tag - Post pivot
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
        });

        // 5. Pages
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title_bn');
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->longText('content_bn');
            $table->longText('content_en')->nullable();
            $table->enum('template', ['default', 'full-width'])->default('default');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('categories');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bio_bn', 'bio_en', 'designation_bn', 'designation_en', 'avatar', 'twitter_url', 'linkedin_url']);
        });
    }
};
