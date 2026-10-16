<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.enable_turnstile', false);
        $this->migrator->add('site.turnstile_site_key', '');
        $this->migrator->add('site.turnstile_secret_key', '');
    }
};
