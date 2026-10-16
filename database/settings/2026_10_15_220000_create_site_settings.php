<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // General
        $this->migrator->add('site.site_name_bn', 'ফ্যাক্টচেক বাংলাদেশ');
        $this->migrator->add('site.site_name_en', 'FactCheck Bangladesh');
        $this->migrator->add('site.tagline_bn', 'বাংলাদেশি সংবাদ ও সামাজিক যোগাযোগমাধ্যমের তথ্যানুসন্ধান ও ফ্যাক্ট-চেক উদ্যোগ');
        $this->migrator->add('site.tagline_en', 'Independent Fact-Checking & Digital Verification Initiative in Bangladesh');
        $this->migrator->add('site.site_url', 'https://factcheck.hostnibo.com');
        $this->migrator->add('site.timezone', 'Asia/Dhaka');
        $this->migrator->add('site.default_language', 'bn');
        $this->migrator->add('site.date_format', 'd F Y');

        // Branding
        $this->migrator->add('site.logo_light', null);
        $this->migrator->add('site.logo_dark', null);
        $this->migrator->add('site.favicon', null);
        $this->migrator->add('site.default_og_image', null);

        // Header Menu
        $this->migrator->add('site.header_menu', [
            ['label_bn' => 'হোম', 'label_en' => 'Home', 'url' => '/'],
            ['label_bn' => 'রাজনীতি', 'label_en' => 'Politics', 'url' => '/category/politics'],
            ['label_bn' => 'স্বাস্থ্য', 'label_en' => 'Health', 'url' => '/category/health'],
            ['label_bn' => 'ডিপফেক ও এআই', 'label_en' => 'Deepfake & AI', 'url' => '/category/ai-deepfake'],
            ['label_bn' => 'আমাদের সম্পর্কে', 'label_en' => 'About Us', 'url' => '/page/about'],
            ['label_bn' => 'দাবি পাঠান', 'label_en' => 'Submit Claim', 'url' => '/submit-claim'],
        ]);
        $this->migrator->add('site.enable_search', true);

        // Footer
        $this->migrator->add('site.footer_columns', [
            [
                'title_bn' => 'প্রাতিষ্ঠানিক নীতি',
                'title_en' => 'Editorial Principles',
                'links' => [
                    ['label_bn' => 'অনুসন্ধান পদ্ধতি', 'label_en' => 'Methodology', 'url' => '/page/methodology'],
                    ['label_bn' => 'অর্থায়ন ও মালিকানা', 'label_en' => 'Funding & Ownership', 'url' => '/page/funding'],
                    ['label_bn' => 'সংশোধন নীতি', 'label_en' => 'Corrections Policy', 'url' => '/page/corrections'],
                    ['label_bn' => 'নিরপেক্ষতা নীতি', 'label_en' => 'Non-Partisanship Policy', 'url' => '/page/editorial-policy'],
                ]
            ],
            [
                'title_bn' => 'আইনি ও যোগাযোগ',
                'title_en' => 'Legal & Contact',
                'links' => [
                    ['label_bn' => 'আমাদের সম্পর্কে', 'label_en' => 'About Us', 'url' => '/page/about'],
                    ['label_bn' => 'যোগাযোগ', 'label_en' => 'Contact Us', 'url' => '/page/contact'],
                    ['label_bn' => 'গোপনীয়তা নীতি', 'label_en' => 'Privacy Policy', 'url' => '/page/privacy'],
                    ['label_bn' => 'দাবি জমা দিন', 'label_en' => 'Submit Claim', 'url' => '/submit-claim'],
                ]
            ]
        ]);
        $this->migrator->add('site.copyright_text_bn', '© ২০২৬ ফ্যাক্টচেক বাংলাদেশ। সর্বস্বত্ব সংরক্ষিত। ইন্টারন্যাশনাল ফ্যাক্ট-চেকিং নেটওয়ার্ক (IFCN) নীতিমালা অনুসরণে পরিচালিত।');
        $this->migrator->add('site.copyright_text_en', '© 2026 FactCheck Bangladesh. All rights reserved. Operating under the International Fact-Checking Network (IFCN) Code of Principles.');
        $this->migrator->add('site.social_links', [
            ['platform' => 'Facebook', 'url' => 'https://facebook.com'],
            ['platform' => 'X (Twitter)', 'url' => 'https://x.com'],
            ['platform' => 'YouTube', 'url' => 'https://youtube.com']
        ]);
        $this->migrator->add('site.enable_newsletter_box', false);

        // Contact
        $this->migrator->add('site.contact_email', 'contact@factcheckbd.org');
        $this->migrator->add('site.contact_phone', '+880 1700-000000');
        $this->migrator->add('site.contact_address_bn', 'ঢাকা, বাংলাদেশ');
        $this->migrator->add('site.contact_address_en', 'Dhaka, Bangladesh');
    }
};
