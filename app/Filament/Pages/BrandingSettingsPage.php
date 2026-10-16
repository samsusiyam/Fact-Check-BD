<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class BrandingSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Branding & Assets';
    protected static ?string $title = 'Branding & Visual Assets';
    protected static ?int $navigationSort = 2;
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
                Section::make('Logos & Visual Identity')
                    ->description('Upload publication logos and favicons in SVG, PNG or WebP.')
                    ->schema([
                        FileUpload::make('logo_light')
                            ->label('Primary Logo (Light / Canvas)')
                            ->image()
                            ->directory('branding')
                            ->helperText('SVG recommended for razor-sharp rendering on Retina displays'),
                        FileUpload::make('logo_dark')
                            ->label('Dark Mode Logo (Optional)')
                            ->image()
                            ->directory('branding'),
                        FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->directory('branding')
                            ->helperText('SVG or 32x32 PNG icon for browser tabs'),
                        FileUpload::make('default_og_image')
                            ->label('Default Social Share Image (1200x630)')
                            ->image()
                            ->directory('branding'),
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

        Notification::make()->title('Branding updated successfully')->success()->send();
    }
}
