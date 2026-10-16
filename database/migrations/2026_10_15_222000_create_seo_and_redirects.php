<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add SEO fields to Posts
        Schema::table('posts', function (Blueprint $table) {
            $table->string('seo_title_bn')->nullable()->after('excerpt_en');
            $table->string('seo_title_en')->nullable()->after('seo_title_bn');
            $table->text('meta_description_bn')->nullable()->after('seo_title_en');
            $table->text('meta_description_en')->nullable()->after('meta_description_bn');
            $table->string('canonical_url')->nullable()->after('meta_description_en');
            $table->boolean('noindex')->default(false)->after('canonical_url');
        });

        // 2. Add SEO fields to Pages
        Schema::table('pages', function (Blueprint $table) {
            $table->string('seo_title_bn')->nullable()->after('template');
            $table->string('seo_title_en')->nullable()->after('seo_title_bn');
            $table->text('meta_description_bn')->nullable()->after('seo_title_en');
            $table->text('meta_description_en')->nullable()->after('meta_description_bn');
            $table->boolean('noindex')->default(false)->after('meta_description_en');
        });

        // 3. Redirects Table (301 Permanent Redirect Manager)
        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->string('source_path')->unique();
            $table->string('target_url');
            $table->integer('status_code')->default(301);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('hits')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('redirects');
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['seo_title_bn', 'seo_title_en', 'meta_description_bn', 'meta_description_en', 'noindex']);
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['seo_title_bn', 'seo_title_en', 'meta_description_bn', 'meta_description_en', 'canonical_url', 'noindex']);
        });
    }
};
