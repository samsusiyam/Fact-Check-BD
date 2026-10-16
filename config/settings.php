<?php

return [
    "settings" => [
        App\Settings\SiteSettings::class,
    ],
    "repositories" => [
        "database" => [
            "type" => Spatie\LaravelSettings\SettingsRepositories\DatabaseSettingsRepository::class,
            "model" => null,
            "table" => null,
            "connection" => null,
        ],
    ],
    "default_repository" => "database",
    "cache" => [
        "enabled" => env("SETTINGS_CACHE_ENABLED", true),
        "store" => null,
        "prefix" => null,
        "ttl" => null,
    ],
    "auto_discover_settings" => [
        app_path("Settings"),
    ],
    "discovered_settings_cache_path" => base_path("bootstrap/cache/settings.php"),
];
