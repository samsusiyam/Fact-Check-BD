<?php

namespace App\Services;

use App\Settings\SiteSettings;
use Illuminate\Support\Facades\Config;

class MailConfigService
{
    public static function applySettings(): void
    {
        try {
            $settings = app(SiteSettings::class);

            $mailer = $settings->mail_mailer ?: 'sendmail';

            Config::set('mail.default', $mailer);

            if ($mailer === 'smtp') {
                Config::set('mail.mailers.smtp.host', $settings->mail_host ?: '127.0.0.1');
                Config::set('mail.mailers.smtp.port', (int) ($settings->mail_port ?: 587));
                Config::set('mail.mailers.smtp.encryption', $settings->mail_encryption ?: null);
                Config::set('mail.mailers.smtp.username', $settings->mail_username ?: null);
                Config::set('mail.mailers.smtp.password', $settings->mail_password ?: null);
            }

            if (!empty($settings->mail_from_address)) {
                Config::set('mail.from.address', $settings->mail_from_address);
                Config::set('mail.from.name', $settings->mail_from_name ?: 'FactCheck BD');
            }
        } catch (\Throwable $e) {
            // Log fallback error
        }
    }
}
