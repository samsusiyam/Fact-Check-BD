<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.header_layout', 'centered');
        $this->migrator->add('site.site_container_width', '1080px');
    }

    public function down(): void
    {
        $this->migrator->delete('site.header_layout');
        $this->migrator->delete('site.site_container_width');
    }
};
