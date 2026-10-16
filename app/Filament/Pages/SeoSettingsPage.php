<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SeoSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'SEO & Webmaster';
    protected static ?string $title = 'Search Engine Optimization & Webmaster Keys';
    protected static ?int $navigationSort = 5;
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
                Section::make('Search Engine Meta Configurations')
                    ->schema([
                        TextInput::make('seo_title_template')
                            ->label('Browser Title Template')
                            ->default('%s — FactCheck Bangladesh')
                            ->required(),

                        Textarea::make('seo_default_meta_description_bn')
                            ->label('Default Meta Description')
                            ->rows(3)
                            ->required(),
                    ]),

                Section::make('Robots.txt & Crawlers')
                    ->schema([
                        Textarea::make('robots_txt_content')
                            ->label('Dynamic robots.txt Directives')
                            ->rows(5)
                            ->required(),
                    ]),

                Section::make('Webmaster Verification')
                    ->schema([
                        TextInput::make('google_verification_code')
                            ->label('Google Search Console HTML Verification Code')
                            ->placeholder('google-site-verification token'),

                        TextInput::make('bing_verification_code')
                            ->label('Bing Webmaster Verification Code')
                            ->placeholder('msvalidate.01 token'),
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

        Notification::make()->title('SEO settings updated successfully')->success()->send();
    }
}
