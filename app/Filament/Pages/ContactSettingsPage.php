<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ContactSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Contact & Socials';
    protected static ?string $title = 'Newsroom Contact, Tipline & Social Links';
    protected static ?int $navigationSort = 4;
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
                Section::make('Direct Editorial Contacts')
                    ->description('Public communication channels for reader tips and inquiries.')
                    ->schema([
                        TextInput::make('contact_email')->label('Editorial Desk Email')->email()->required(),
                        TextInput::make('contact_phone')->label('Phone Number')->required(),
                        TextInput::make('whatsapp_number')->label('WhatsApp Tipline (with country code)')->placeholder('+8801700000000')->required(),
                        TextInput::make('contact_address_bn')->label('Newsroom Office Address')->required(),
                    ])->columns(2),

                Section::make('Social Media Profiles')
                    ->description('Official verified social channels displayed across headers and footers.')
                    ->schema([
                        Repeater::make('social_links')
                            ->label('Connected Channels')
                            ->schema([
                                TextInput::make('platform')->label('Platform')->placeholder('e.g. Facebook, X, YouTube')->required(),
                                TextInput::make('url')->label('Profile URL')->url()->required(),
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
        foreach ($state as $key => $value) {
            if (property_exists($settings, $key)) {
                $settings->{$key} = $value;
            }
        }
        $settings->save();

        Notification::make()->title('Contact & Social settings updated successfully')->success()->send();
    }
}
