<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Custom Scripts & Tracking
        $this->migrator->add('site.header_scripts', '');
        $this->migrator->add('site.footer_scripts', '');
        $this->migrator->add('site.google_analytics_id', '');

        // Cookie Consent Banner
        $this->migrator->add('site.enable_cookie_banner', true);
        $this->migrator->add('site.cookie_banner_text_bn', 'আমরা পাঠকের অভিজ্ঞতা উন্নয়ন ও বিশ্লেষণের সুবিধার্থে কুকিজ ব্যবহার করি।');
        $this->migrator->add('site.cookie_banner_text_en', 'We use cookies to improve user experience and analyze reader traffic.');
        $this->migrator->add('site.cookie_privacy_page_url', '/page/privacy');

        // Advertisement / Sponsor Banners
        $this->migrator->add('site.enable_ads', false);
        $this->migrator->add('site.ad_header_code', '');
        $this->migrator->add('site.ad_sidebar_code', '');
        $this->migrator->add('site.ad_article_bottom_code', '');

        // Editorial Announcement Banner
        $this->migrator->add('site.enable_announcement', true);
        $this->migrator->add('site.announcement_text_bn', 'জরুরি তথ্য যাচাই বা গুজবের সত্যতা জানতে আপনার দাবি আমাদের কাছে পাঠান।');
        $this->migrator->add('site.announcement_text_en', 'Send us your suspicious claims or viral rumors for editorial verification.');
        $this->migrator->add('site.announcement_link', '/submit-claim');
        $this->migrator->add('site.announcement_link_text_bn', 'দাবি পাঠান →');
        $this->migrator->add('site.announcement_link_text_en', 'Submit Claim →');
    }
};
