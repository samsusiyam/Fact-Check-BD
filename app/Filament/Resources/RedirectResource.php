<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RedirectResource\Pages;
use App\Models\Redirect;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-circle';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'URL Redirects (301/302)';
    protected static ?string $pluralModelLabel = 'URL Redirects';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('source_path')
                    ->label('Source URL Path')
                    ->placeholder('/old-article-slug')
                    ->required(),

                Forms\Components\TextInput::make('target_url')
                    ->label('Target Destination URL')
                    ->placeholder('/article/new-slug or https://...')
                    ->required(),

                Forms\Components\Select::make('status_code')
                    ->label('HTTP Status Code')
                    ->options([
                        301 => '301 Permanent Redirect',
                        302 => '302 Temporary Redirect',
                    ])
                    ->default(301)
                    ->required(),

                Forms\Components\Toggle::make('is_active')
                    ->label('Active Redirect')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('source_path')->label('Source Path')->searchable(),
                Tables\Columns\TextColumn::make('target_url')->label('Target URL')->limit(30),
                Tables\Columns\BadgeColumn::make('status_code')
                    ->label('Status')
                    ->colors(['success' => 301, 'warning' => 302]),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
                Tables\Columns\TextColumn::make('hits')->label('Hits')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRedirects::route('/'),
            'create' => Pages\CreateRedirect::route('/create'),
            'edit' => Pages\EditRedirect::route('/{record}/edit'),
        ];
    }
}
