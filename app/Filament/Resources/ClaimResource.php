<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClaimResource\Pages;
use App\Models\Claim;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClaimResource extends Resource
{
    protected static ?string $model = Claim::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationGroup = 'Editorial Work';
    protected static ?string $navigationLabel = 'Claim Submissions';
    protected static ?string $pluralModelLabel = 'Public Claims & Submissions';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Submitted Claim Details')
                    ->schema([
                        Forms\Components\Textarea::make('claim_text')
                            ->label('Claim / Rumor Description')
                            ->rows(4)
                            ->columnSpanFull()
                            ->required(),

                        Forms\Components\TextInput::make('claim_url')
                            ->label('Social Media / Reference Link')
                            ->url()
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('attachment_path')
                            ->label('Evidence Screenshot / Photo')
                            ->image()
                            ->directory('claims')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Submitter Info')
                    ->schema([
                        Forms\Components\TextInput::make('submitter_name')->label('Submitter Name'),
                        Forms\Components\TextInput::make('submitter_email')->label('Submitter Email')->email(),
                        Forms\Components\TextInput::make('submitter_phone')->label('Submitter Phone'),
                        Forms\Components\TextInput::make('ip_address')->label('IP Address')->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Editorial Action')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending Review',
                                'investigating' => 'Under Investigation',
                                'verified' => 'Fact-Checked / Verified',
                                'rejected' => 'Rejected / Not Verifiable',
                            ])
                            ->default('pending')
                            ->required(),

                        Forms\Components\Select::make('post_id')
                            ->label('Link to Published Fact-Check Post')
                            ->relationship('post', 'title_bn')
                            ->searchable()
                            ->preload(),

                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Internal Newsroom Notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Received')->dateTime('d M Y, H:i')->sortable(),
                Tables\Columns\TextColumn::make('claim_text')->label('Claim Text')->limit(50)->searchable(),
                Tables\Columns\TextColumn::make('submitter_name')->label('Submitter')->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'investigating',
                        'success' => 'verified',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('post.title_bn')->label('Linked Post')->limit(30),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'investigating' => 'Investigating',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClaims::route('/'),
            'create' => Pages\CreateClaim::route('/create'),
            'edit' => Pages\EditClaim::route('/{record}/edit'),
        ];
    }
}
