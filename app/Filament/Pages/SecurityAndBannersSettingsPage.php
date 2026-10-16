<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SecurityAndBannersSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Banners & Security';
    protected static ?string $title = 'Alerts, Cookies & Anti-Spam (Turnstile)';
    protected static ?int $navigationSort = 7;
    protected static string $view = 'filament.pages.manage-site-settings';

    public ?array $data = [];

    public function mount(SiteSettings $settings): void
    {
        $this->form->fill($settings->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Cloudflare Turnstile CAPTCHA')
                    ->description('Protect claim submission forms and newsletter signups with invisible Cloudflare Turnstile.')
                    ->schema([
                        Toggle::make('enable_turnstile')->label('Enable Cloudflare Turnstile')->default(false),
                        TextInput::make('turnstile_site_key')->label('Turnstile Site Key'),
                        TextInput::make('turnstile_secret_key')->label('Turnstile Secret Key')->password(),
                    ])->columns(3),

                Section::make('Top Alert / Announcement Bar')
                    ->schema([
                        Toggle::make('enable_announcement')->label('Show Announcement Bar')->default(true),
                        TextInput::make('announcement_text_bn')
                            ->label('Announcement Notice Text')
                            ->required(),
                        TextInput::make('announcement_link')->label('Target URL Path / Link')->required(),
                        TextInput::make('announcement_link_text_bn')->label('Action Button Text')->default('বিস্তারিত')->required(),
                    ])->columns(3),

                Section::make('GDPR / Cookie Consent Notice')
                    ->schema([
                        Toggle::make('enable_cookie_banner')->label('Enable Cookie Notice Banner')->default(true),
                        TextInput::make('cookie_privacy_page_url')->label('Privacy Policy Path')->default('/page/privacy')->required(),
                        Textarea::make('cookie_banner_text_bn')
                            ->label('Cookie Consent Message')
                            ->rows(2)
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Monetization & Ads')
                    ->schema([
                        Toggle::make('enable_ads')->label('Enable Advertisements Site-Wide')->default(false),
                        Textarea::make('ad_header_code')->label('Header Ad Banner (728x90)')->rows(3),
                        Textarea::make('ad_sidebar_code')->label('Sidebar Ad Banner (300x250)')->rows(3),
                        Textarea::make('ad_article_bottom_code')->label('Article Bottom Ad Banner')->rows(3),
                    ])->columns(2),

                Section::make('Custom Scripts & GA4')
                    ->schema([
                        TextInput::make('google_analytics_id')->label('Google Analytics ID (G-XXXXXXXXXX)'),
                        Textarea::make('header_scripts')->label('Custom Header Scripts')->rows(4),
                        Textarea::make('footer_scripts')->label('Custom Footer Scripts')->rows(4),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(SiteSettings $settings): void
    {
        $state = $this->form->getState();
        foreach ($state as $key => $value) {
            if (property_exists($settings, $key)) {
                $settings->{$key} = $value;
            }
        }
        $settings->save();

        Notification::make()->title('Security, Banners & Ads updated successfully')->success()->send();
    }
}
