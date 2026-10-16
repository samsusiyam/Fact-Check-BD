<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{
    // General
    public string $site_name_bn;
    public string $site_name_en;
    public string $tagline_bn;
    public string $tagline_en;
    public string $site_url;
    public string $timezone;
    public string $default_language;
    public string $date_format;

    // Branding
    public ?string $logo_light;
    public ?string $logo_dark;
    public ?string $favicon;
    public ?string $default_og_image;
    public string $header_layout;
    public string $site_container_width;

    // Header
    public array $header_menu;
    public bool $enable_search;

    // Footer
    public array $footer_columns;
    public string $copyright_text_bn;
    public string $copyright_text_en;
    public array $social_links;
    public bool $enable_newsletter_box;

    // Contact
    public string $contact_email;
    public string $contact_phone;
    public string $contact_address_bn;
    public string $contact_address_en;
    public ?string $whatsapp_number;

    // SEO
    public string $seo_title_template;
    public string $seo_default_meta_description_bn;
    public string $seo_default_meta_description_en;
    public string $robots_txt_content;
    public ?string $google_verification_code;
    public ?string $bing_verification_code;

    // Scripts & Tracking
    public ?string $header_scripts;
    public ?string $footer_scripts;
    public ?string $google_analytics_id;

    // Cookie Consent
    public bool $enable_cookie_banner;
    public string $cookie_banner_text_bn;
    public string $cookie_banner_text_en;
    public string $cookie_privacy_page_url;

    // Monetization / Ads
    public bool $enable_ads;
    public ?string $ad_header_code;
    public ?string $ad_sidebar_code;
    public ?string $ad_article_bottom_code;

    // Announcement Bar
    public bool $enable_announcement;
    public string $announcement_text_bn;
    public string $announcement_text_en;
    public ?string $announcement_link;
    public string $announcement_link_text_bn;
    public string $announcement_link_text_en;

    // Cloudflare Turnstile CAPTCHA
    public bool $enable_turnstile;
    public ?string $turnstile_site_key;
    public ?string $turnstile_secret_key;

    // Mail & SMTP Notifications
    public ?string $mail_mailer;
    public ?string $mail_host;
    public ?int $mail_port;
    public ?string $mail_username;
    public ?string $mail_password;
    public ?string $mail_encryption;
    public ?string $mail_from_address;
    public ?string $mail_from_name;
    public ?string $notification_recipient_email;

    public static function group(): string
    {
        return 'site';
    }
}
