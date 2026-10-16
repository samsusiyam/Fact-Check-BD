<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.mail_mailer', 'sendmail');
        $this->migrator->add('site.mail_host', '127.0.0.1');
        $this->migrator->add('site.mail_port', 587);
        $this->migrator->add('site.mail_username', null);
        $this->migrator->add('site.mail_password', null);
        $this->migrator->add('site.mail_encryption', 'tls');
        $this->migrator->add('site.mail_from_address', 'no-reply@hostnibo.com');
        $this->migrator->add('site.mail_from_name', 'FactCheck BD');
        $this->migrator->add('site.notification_recipient_email', 'contact@hostnibo.com');
    }

    public function down(): void
    {
        $this->migrator->delete('site.mail_mailer');
        $this->migrator->delete('site.mail_host');
        $this->migrator->delete('site.mail_port');
        $this->migrator->delete('site.mail_username');
        $this->migrator->delete('site.mail_password');
        $this->migrator->delete('site.mail_encryption');
        $this->migrator->delete('site.mail_from_address');
        $this->migrator->delete('site.mail_from_name');
        $this->migrator->delete('site.notification_recipient_email');
    }
};
