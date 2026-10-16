<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Administration';
    protected static ?string $navigationLabel = 'Staff & Roles';
    protected static ?string $pluralModelLabel = 'Staff & Editorial Roles';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Full Name')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->unique(User::class, 'email', ignoreRecord: true),

                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),

                Forms\Components\Select::make('roles')
                    ->label('Editorial Role')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('designation')
                    ->label('Designation / Job Title')
                    ->placeholder('e.g. Senior Fact-Checker'),

                Forms\Components\Textarea::make('bio')
                    ->label('Staff Biography (IFCN Requirement)')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Staff Name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email Address')->searchable(),
                Tables\Columns\BadgeColumn::make('roles.name')->label('Role'),
                Tables\Columns\TextColumn::make('designation')->label('Designation'),
                Tables\Columns\TextColumn::make('created_at')->label('Joined')->dateTime('d M Y')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
