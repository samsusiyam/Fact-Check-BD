<?php

namespace App\Filament\Pages;

use App\Services\MailConfigService;
use App\Settings\SiteSettings;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Mail;

class MailSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Mail & SMTP';
    protected static ?string $title = 'Email Service & SMTP Configurations';
    protected static ?int $navigationSort = 8;
    protected static string $view = 'filament.pages.manage-site-settings';

    public ?array $data = [];

    public function mount(SiteSettings $settings): void
    {
        $this->form->fill([
            'mail_mailer' => $settings->mail_mailer ?: 'sendmail',
            'mail_host' => $settings->mail_host ?: '127.0.0.1',
            'mail_port' => $settings->mail_port ?: 587,
            'mail_username' => $settings->mail_username,
            'mail_password' => $settings->mail_password,
            'mail_encryption' => $settings->mail_encryption ?: 'tls',
            'mail_from_address' => $settings->mail_from_address ?: 'no-reply@hostnibo.com',
            'mail_from_name' => $settings->mail_from_name ?: 'FactCheck BD',
            'notification_recipient_email' => $settings->notification_recipient_email ?: 'contact@hostnibo.com',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Mail Driver & Delivery')
                    ->description('Select whether to send emails using local cPanel Sendmail or external SMTP server.')
                    ->schema([
                        Select::make('mail_mailer')
                            ->label('Mail Delivery Protocol')
                            ->options([
                                'sendmail' => 'Local Server Sendmail (cPanel Default)',
                                'smtp' => 'SMTP Server (Custom / Remote SMTP)',
                            ])
                            ->default('sendmail')
                            ->live()
                            ->required(),
                    ]),

                Section::make('SMTP Server Settings')
                    ->description('Configure SMTP credentials if SMTP driver is selected above.')
                    ->schema([
                        TextInput::make('mail_host')
                            ->label('SMTP Host')
                            ->placeholder('e.g. mail.datacorelink.com or smtp.gmail.com')
                            ->default('127.0.0.1'),

                        TextInput::make('mail_port')
                            ->label('SMTP Port')
                            ->numeric()
                            ->default(587),

                        Select::make('mail_encryption')
                            ->label('Encryption')
                            ->options([
                                'tls' => 'TLS (STARTTLS - Standard 587)',
                                'ssl' => 'SSL (Port 465)',
                                'none' => 'None / Plain (Port 25)',
                            ])
                            ->default('tls'),

                        TextInput::make('mail_username')
                            ->label('SMTP Username / Email')
                            ->placeholder('e.g. no-reply@hostnibo.com'),

                        TextInput::make('mail_password')
                            ->label('SMTP Password')
                            ->password()
                            ->revealable(),
                    ])
                    ->columns(3)
                    ->visible(fn ($get) => $get('mail_mailer') === 'smtp'),

                Section::make('Sender Identity & Newsroom Alert Inbox')
                    ->description('Email addresses used for outgoing emails and receiving internal notifications.')
                    ->schema([
                        TextInput::make('mail_from_address')
                            ->label('Outgoing From Email')
                            ->email()
                            ->required(),

                        TextInput::make('mail_from_name')
                            ->label('Outgoing Sender Display Name')
                            ->required(),

                        TextInput::make('notification_recipient_email')
                            ->label('Newsroom Desk Alert Recipient Email')
                            ->helperText('All public claim submissions will send an instant editorial alert to this address.')
                            ->email()
                            ->required()
                            ->columnSpanFull(),
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

        MailConfigService::applySettings();

        Notification::make()
            ->title('Mail & SMTP settings updated successfully')
            ->success()
            ->send();
    }
}
