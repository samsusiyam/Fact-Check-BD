<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class NavigationSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-left';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Navigation & Menus';
    protected static ?string $title = 'Header & Footer Menus Management';
    protected static ?int $navigationSort = 3;
    protected static string $view = 'filament.pages.manage-site-settings';

    public ?array $data = [];

    public function mount(SiteSettings $settings): void
    {
        $this->form->fill([
            'header_menu' => $settings->header_menu ?? [],
            'footer_columns' => $settings->footer_columns ?? [],
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Header Main Navigation')
                    ->description('Primary navigation links displayed across the site header.')
                    ->schema([
                        Repeater::make('header_menu')
                            ->label('Header Menu Links')
                            ->schema([
                                TextInput::make('label_bn')->label('Title')->required(),
                                TextInput::make('url')->label('URL Path')->placeholder('/category/health')->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(4),
                    ]),

                Section::make('Footer Columns & Policy Menus')
                    ->description('Organize footer columns and their institutional/legal links.')
                    ->schema([
                        Repeater::make('footer_columns')
                            ->label('Footer Columns')
                            ->schema([
                                TextInput::make('title_bn')->label('Column Heading')->required(),
                                Repeater::make('links')
                                    ->label('Column Links')
                                    ->schema([
                                        TextInput::make('label_bn')->label('Link Title')->required(),
                                        TextInput::make('url')->label('URL Path')->required(),
                                    ])
                                    ->columns(2),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(SiteSettings $settings): void
    {
        $state = $this->form->getState();
        $settings->header_menu = $state['header_menu'] ?? [];
        $settings->footer_columns = $state['footer_columns'] ?? [];
        $settings->save();

        Notification::make()->title('Navigation and Footer menus updated successfully')->success()->send();
    }
}
