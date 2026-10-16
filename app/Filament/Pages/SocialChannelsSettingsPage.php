<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SocialChannelsSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-share';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Social Channels';
    protected static ?string $title = 'Social Media Profiles & Icons';
    protected static ?int $navigationSort = 5;
    protected static string $view = 'filament.pages.manage-site-settings';

    public ?array $data = [];

    public function mount(SiteSettings $settings): void
    {
        $this->form->fill([
            'social_links' => $settings->social_links ?? [],
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Social Media Profiles (Header & Footer Icons)')
                    ->description('Manage social channels with icons automatically rendered across the website.')
                    ->schema([
                        Repeater::make('social_links')
                            ->label('Social Profiles')
                            ->schema([
                                Select::make('platform')
                                    ->label('Platform')
                                    ->options([
                                        'facebook' => 'Facebook',
                                        'twitter' => 'X / Twitter',
                                        'youtube' => 'YouTube',
                                        'linkedin' => 'LinkedIn',
                                        'instagram' => 'Instagram',
                                        'whatsapp' => 'WhatsApp Channel',
                                    ])
                                    ->required(),
                                TextInput::make('url')
                                    ->label('Channel / Profile URL')
                                    ->url()
                                    ->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(3),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(SiteSettings $settings): void
    {
        $state = $this->form->getState();
        $settings->social_links = $state['social_links'] ?? [];
        $settings->save();

        Notification::make()->title('Social media channels saved successfully')->success()->send();
    }
}
