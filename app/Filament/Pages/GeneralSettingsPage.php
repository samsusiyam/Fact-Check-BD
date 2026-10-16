<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class GeneralSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'General Settings';
    protected static ?string $title = 'General Publication Settings';
    protected static ?int $navigationSort = 1;
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
                Section::make('Basic Publication Identity')
                    ->description('Primary branding information for the fact-checking agency.')
                    ->schema([
                        TextInput::make('site_name_bn')->label('Publication Name')->required(),
                        TextInput::make('tagline_bn')->label('Motto / Tagline')->required(),
                        TextInput::make('site_url')->label('Primary Domain URL')->url()->required(),
                    ])->columns(3),

                Section::make('Website Header & Container Layout')
                    ->description('Choose how the header and main layout adapt across desktop and mobile devices.')
                    ->schema([
                        Select::make('header_layout')
                            ->label('Header Style & Logo Alignment')
                            ->options([
                                'centered' => 'Centered Brand Logo with Clean Sub-Row on Mobile',
                                'left_aligned' => 'Left-Aligned Logo with Inline Desktop Controls',
                            ])
                            ->default('centered')
                            ->required(),

                        Select::make('site_container_width')
                            ->label('Max Container Width')
                            ->options([
                                '1080px' => 'Editorial Standard (1080px)',
                                '1140px' => 'Expanded Grid (1140px)',
                                '1200px' => 'Full Modern (1200px)',
                            ])
                            ->default('1080px')
                            ->required(),
                    ])->columns(2),

                Section::make('Localization & Date Standards')
                    ->schema([
                        Select::make('timezone')
                            ->label('Timezone')
                            ->options([
                                'Asia/Dhaka' => 'Asia/Dhaka (UTC+6)',
                                'UTC' => 'UTC',
                            ])
                            ->default('Asia/Dhaka')
                            ->required(),

                        Select::make('default_language')
                            ->label('Default Site Language')
                            ->options([
                                'bn' => 'Bengali',
                                'en' => 'English',
                            ])
                            ->default('bn')
                            ->required(),

                        TextInput::make('date_format')
                            ->label('Date Format Standard')
                            ->default('d F Y')
                            ->required(),
                    ])->columns(3),
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

        Notification::make()->title('General settings updated successfully')->success()->send();
    }
}
