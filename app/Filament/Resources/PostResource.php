<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Editorial Work';
    protected static ?string $navigationLabel = 'Fact-Check Articles';
    protected static ?string $pluralModelLabel = 'Fact-Check Articles';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Editorial Content')
                            ->schema([
                                Forms\Components\TextInput::make('title_bn')
                                    ->label('Article Headline')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                Forms\Components\TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->required()
                                    ->unique(Post::class, 'slug', ignoreRecord: true),

                                Forms\Components\Textarea::make('excerpt_bn')
                                    ->label('Executive Summary / Excerpt')
                                    ->rows(3)
                                    ->required(),

                                Forms\Components\RichEditor::make('content_bn')
                                    ->label('Full Fact-Check Investigation')
                                    ->required(),
                            ]),

                        Forms\Components\Section::make('ClaimReview Investigation Schema')
                            ->schema([
                                Forms\Components\Textarea::make('claim_text_bn')
                                    ->label('Claim Being Investigated')
                                    ->rows(2)
                                    ->required(),

                                Forms\Components\TextInput::make('claim_claimant_bn')
                                    ->label('Claimant / Originator')
                                    ->placeholder('e.g. Viral Facebook Post / PhotoCard'),

                                Forms\Components\DatePicker::make('claim_date')
                                    ->label('Date Claim Appeared'),

                                Forms\Components\Select::make('verdict')
                                    ->label('Official Editorial Verdict')
                                    ->options([
                                        'false' => 'False',
                                        'misleading' => 'Misleading',
                                        'true' => 'True',
                                        'ai_generated' => 'AI Generated / Deepfake',
                                        'unproven' => 'Unproven',
                                    ])
                                    ->default('false')
                                    ->required(),

                                Forms\Components\Textarea::make('verification_steps_bn')
                                    ->label('Verdict Justification / Key Findings')
                                    ->rows(3)
                                    ->required(),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Publishing & Metadata')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'in_review' => 'In Editorial Review',
                                        'published' => 'Published',
                                        'archived' => 'Archived',
                                    ])
                                    ->default('draft')
                                    ->required(),

                                Forms\Components\Select::make('category_id')
                                    ->label('Category')
                                    ->relationship('category', 'name_bn')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\Select::make('user_id')
                                    ->label('Byline Fact-Checker')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Publish Date & Time')
                                    ->default(now()),

                                Forms\Components\Toggle::make('is_lead')
                                    ->label('Featured Top Investigation')
                                    ->default(false),

                                SpatieMediaLibraryFileUpload::make('featured_image')
                                    ->label('Featured Investigation Photo')
                                    ->collection('featured_image')
                                    ->image(),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('featured_image')
                    ->label('Thumbnail')
                    ->collection('featured_image'),

                Tables\Columns\TextColumn::make('title_bn')
                    ->label('Headline')
                    ->searchable()
                    ->limit(45),

                Tables\Columns\BadgeColumn::make('verdict')
                    ->label('Verdict')
                    ->colors([
                        'danger' => 'false',
                        'warning' => 'misleading',
                        'success' => 'true',
                        'info' => 'ai_generated',
                        'secondary' => 'unproven',
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'draft',
                        'primary' => 'in_review',
                        'success' => 'published',
                    ]),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Fact-Checker'),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
