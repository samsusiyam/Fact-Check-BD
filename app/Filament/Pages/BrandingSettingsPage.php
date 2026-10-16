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
        $this->form->fill([
            'logo_light' => $settings->logo_light,
            'logo_dark' => $settings->logo_dark,
            'favicon' => $settings->favicon,
            'default_og_image' => $settings->default_og_image,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Logos & Visual Identity')
                    ->description('Upload publication logos and favicons. Uploaded files are stored permanently in public storage.')
                    ->schema([
                        FileUpload::make('logo_light')
                            ->label('Primary Logo (Light / Canvas)')
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public'),

                        FileUpload::make('logo_dark')
                            ->label('Dark Mode Logo (Optional)')
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public'),

                        FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public'),

                        FileUpload::make('default_og_image')
                            ->label('Default Social Share Image (1200x630)')
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public'),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(SiteSettings $settings): void
    {
        $state = $this->form->getState();

        // If an array is returned by FileUpload, pick the first file path or string
        foreach (['logo_light', 'logo_dark', 'favicon', 'default_og_image'] as $field) {
            if (isset($state[$field])) {
                $val = $state[$field];
                if (is_array($val)) {
                    $val = array_values($val)[0] ?? null;
                }
                if (!empty($val)) {
                    $settings->{$field} = (string) $val;
                }
            }
        }

        $settings->save();

        // Refill form with fresh saved data so it never disappears from view!
        $this->form->fill([
            'logo_light' => $settings->logo_light,
            'logo_dark' => $settings->logo_dark,
            'favicon' => $settings->favicon,
            'default_og_image' => $settings->default_og_image,
        ]);

        Notification::make()->title('Branding updated and saved successfully!')->success()->send();
    }
}
