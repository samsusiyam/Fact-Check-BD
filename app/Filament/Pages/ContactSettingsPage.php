<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ContactSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Editorial Contacts & Tipline';
    protected static ?string $title = 'Newsroom Contacts, Tipline & Office Details';
    protected static ?int $navigationSort = 4;
    protected static string $view = 'filament.pages.manage-site-settings';

    public ?array $data = [];

    public function mount(SiteSettings $settings): void
    {
        $this->form->fill([
            'contact_email' => $settings->contact_email,
            'contact_phone' => $settings->contact_phone,
            'whatsapp_number' => $settings->whatsapp_number,
            'contact_address_bn' => $settings->contact_address_bn,
            'contact_address_en' => $settings->contact_address_en,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Direct Editorial Contacts & Verification Tipline')
                    ->description('Official communication channels displayed in headers, footers, and claim pages for public inquiries.')
                    ->schema([
                        TextInput::make('contact_email')
                            ->label('Editorial Desk Email')
                            ->email()
                            ->required(),

                        TextInput::make('contact_phone')
                            ->label('Phone Number')
                            ->required(),

                        TextInput::make('whatsapp_number')
                            ->label('WhatsApp Verification Tipline (with country code)')
                            ->placeholder('+8801761844048')
                            ->required(),

                        TextInput::make('contact_address_bn')
                            ->label('Office Address (Bengali)')
                            ->required(),

                        TextInput::make('contact_address_en')
                            ->label('Office Address (English)')
                            ->required(),
                    ])
                    ->columns(2),
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

        Notification::make()
            ->title('Editorial contact settings updated successfully')
            ->success()
            ->send();
    }
}
