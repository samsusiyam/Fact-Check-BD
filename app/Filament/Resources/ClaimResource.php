<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClaimResource\Pages;
use App\Models\Category;
use App\Models\Claim;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

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

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('claim_text')
                    ->label('Claim / Rumor')
                    ->limit(55)
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('submitter_name')
                    ->label('Submitter')
                    ->default('Anonymous')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'investigating',
                        'success' => 'verified',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending Review',
                        'investigating' => 'Under Investigation',
                        'verified' => 'Fact-Checked',
                        'rejected' => 'Rejected',
                        default => ucfirst($state),
                    }),

                Tables\Columns\TextColumn::make('post.title_bn')
                    ->label('Linked Fact-Check')
                    ->limit(35)
                    ->placeholder('Not linked yet'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Review',
                        'investigating' => 'Under Investigation',
                        'verified' => 'Fact-Checked',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('convert_to_post')
                    ->label('Create Fact-Check Draft')
                    ->icon('heroicon-o-document-plus')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Convert Claim to Fact-Check Draft')
                    ->modalDescription('This will create a new draft Fact-Check post with this claim details and link it to this submission.')
                    ->visible(fn (Claim $record): bool => is_null($record->post_id))
                    ->action(function (Claim $record) {
                        $category = Category::first();
                        $user = auth()->user() ?? User::first();
                        $titleBn = Str::limit($record->claim_text, 90, '');
                        $uniqueSuffix = '-' . substr(md5(uniqid()), 0, 6);
                        $slug = Str::slug($titleBn) . $uniqueSuffix;
                        if (empty(trim(Str::slug($titleBn)))) {
                            $slug = 'claim-investigation' . $uniqueSuffix;
                        }

                        $post = Post::create([
                            'user_id' => $user?->id,
                            'category_id' => $category?->id,
                            'title_bn' => $titleBn,
                            'title_en' => 'Fact-Check: ' . Str::limit($record->claim_text, 70, ''),
                            'slug' => $slug,
                            'claim_text_bn' => $record->claim_text,
                            'claim_text_en' => $record->claim_text,
                            'claim_origin_bn' => $record->claim_url ?: 'পাঠকের সাবমিশন',
                            'claim_date' => $record->created_at->format('Y-m-d'),
                            'verdict' => 'false',
                            'status' => 'draft',
                        ]);

                        $record->update([
                            'post_id' => $post->id,
                            'status' => 'investigating',
                        ]);

                        Notification::make()
                            ->title('Fact-Check Draft created and linked successfully!')
                            ->success()
                            ->send();

                        return redirect()->to(PostResource::getUrl('edit', ['record' => $post->id]));
                    }),

                Tables\Actions\Action::make('mark_investigating')
                    ->label('Investigate')
                    ->icon('heroicon-o-magnifying-glass')
                    ->color('info')
                    ->visible(fn (Claim $record): bool => $record->status === 'pending')
                    ->action(fn (Claim $record) => $record->update(['status' => 'investigating'])),

                Tables\Actions\Action::make('mark_rejected')
                    ->label('Reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (Claim $record): bool => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(fn (Claim $record) => $record->update(['status' => 'rejected'])),

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
