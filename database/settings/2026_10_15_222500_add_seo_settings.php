<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Global SEO Module
        $this->migrator->add('site.seo_title_template', '%title% — %sitename%');
        $this->migrator->add('site.seo_default_meta_description_bn', 'বাংলাদেশি সামাজিক যোগাযোগমাধ্যম ও সংবাদমাধ্যমে প্রচারিত তথ্যের নিরপেক্ষ ও প্রামাণ্য অনুসন্ধান প্ল্যাটফর্ম।');
        $this->migrator->add('site.seo_default_meta_description_en', 'Independent fact-checking and digital verification platform investigating viral claims in Bangladesh.');
        $this->migrator->add('site.robots_txt_content', "User-agent: *\nAllow: /\nSitemap: https://factcheck.hostnibo.com/sitemap.xml\n");
        $this->migrator->add('site.google_verification_code', 'google-site-verification=placeholder');
        $this->migrator->add('site.bing_verification_code', '');
    }
};
