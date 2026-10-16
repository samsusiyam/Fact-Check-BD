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
                    ->modalHeading('Create Fact-Check Article Draft')
                    ->modalDescription('Review the editorial details below. Clicking "Create & Open Draft" will initialize a structured newsroom draft and link it to this claim.')
                    ->modalSubmitActionLabel('Create & Open Draft')
                    ->visible(fn (Claim $record): bool => is_null($record->post_id))
                    ->form([
                        Forms\Components\TextInput::make('title_bn')
                            ->label('Article Headline (বাংলা শিরোনাম)')
                            ->helperText('A crisp, engaging newsroom headline investigating this claim.')
                            ->default(function (Claim $record): string {
                                $clean = trim(preg_replace('/\s+/', ' ', strip_tags($record->claim_text)));
                                return 'ফ্যাক্ট-চেক: ' . Str::limit($clean, 65, '...');
                            })
                            ->required(),

                        Forms\Components\Select::make('category_id')
                            ->label('Newsroom Category')
                            ->options(fn () => Category::pluck('name_bn', 'id'))
                            ->default(fn () => Category::first()?->id)
                            ->required(),

                        Forms\Components\Select::make('verdict')
                            ->label('Initial Editorial Verdict')
                            ->options([
                                'false' => 'False (ভুয়া)',
                                'misleading' => 'Misleading (বিভ্রান্তিকর)',
                                'true' => 'True (সত্য)',
                                'ai_generated' => 'AI Generated / Deepfake',
                                'unproven' => 'Unproven (প্রমাণহীন)',
                            ])
                            ->default('false')
                            ->required(),

                        Forms\Components\TextInput::make('claimant')
                            ->label('Claim Origin / Platform')
                            ->default('ভাইরাল সামাজিক যোগাযোগ মাধ্যম')
                            ->required(),
                    ])
                    ->action(function (array $data, Claim $record) {
                        $user = auth()->user() ?? User::first();
                        $titleBn = trim($data['title_bn']);
                        
                        // Clean, URL-safe slug
                        $slugBase = Str::slug($titleBn);
                        if (empty($slugBase) || strlen($slugBase) < 3) {
                            $slugBase = 'fact-check-investigation';
                        }
                        $slug = $slugBase . '-' . substr(md5(uniqid()), 0, 6);

                        // Professional Newsroom Boilerplate Content
                        $excerpt = 'সামাজিক যোগাযোগ মাধ্যমে সম্প্রতি ছড়িয়ে পড়া উক্ত দাবিটির সত্যতা যাচাই করেছে ফ্যাক্টচেক বাংলাদেশ। অনুসন্ধানে দাবিটি অসত্য ও বিভ্রান্তিকর প্রমাণিত হয়েছে।';
                        
                        $content = '<p>সম্প্রতি সামাজিক যোগাযোগ মাধ্যমে একটি দাবি বা গুজব ব্যাপকভাবে প্রচার হতে দেখা গেছে। জনস্বার্থে দাবিটির সত্যতা যাচাইয়ের উদ্যোগ নিয়েছে ফ্যাক্টচেক বাংলাদেশ নিউজরুম।</p>' .
                            '<h3>দাবি ও প্রেক্ষাপট</h3>' .
                            '<p>' . nl2br(e($record->claim_text)) . '</p>' .
                            '<h3>অনুসন্ধান ও তথ্য যাচাই</h3>' .
                            '<p>দাবিটির সত্যতা যাচাইয়ে আমাদের ফ্যাক্ট-চেক টিম সংশ্লিষ্ট তথ্যসূত্র, ডিজিটাল এভিডেন্স এবং প্রাসঙ্গিক রেকর্ড বিস্তারিত বিশ্লেষণ করেছে। অনুসন্ধানে দেখা যায়—</p>' .
                            '<ul><li>দাবির সপক্ষে কোনো নির্ভরযোগ্য গণমাধ্যম বা প্রাতিষ্ঠানিক তথ্য পাওয়া যায়নি।</li><li>ছড়িয়ে পড়া পোস্টটি উদ্দেশ্যপ্রণোদিতভাবে প্রচার করা হচ্ছে।</li></ul>' .
                            '<h3>চূড়ান্ত সিদ্ধান্ত</h3>' .
                            '<p>সার্বিক তথ্য ও অনুসন্ধানের ভিত্তিতে উক্ত দাবিটিকে ফ্যাক্টচেক বাংলাদেশ কর্তৃক ভিত্তিহীন ও অসত্য হিসেবে চিহ্নিত করা হয়েছে।</p>';

                        $steps = "১. দাবির সপক্ষে কোনো প্রাতিষ্ঠানিক বা নির্ভরযোগ্য সূত্রের সন্ধান পাওয়া যায়নি।\n২. ডিজিটাল ফ্যাক্ট-চেকিং ও আর্কাইভ বিশ্লেষণে দাবিটি সম্পূর্ণ অসত্য প্রতীয়মান হয়।";

                        $post = Post::create([
                            'user_id' => $user?->id,
                            'category_id' => $data['category_id'],
                            'title_bn' => $titleBn,
                            'title_en' => 'Fact-Check: ' . Str::limit($titleBn, 65, ''),
                            'slug' => $slug,
                            'excerpt_bn' => $excerpt,
                            'content_bn' => $content,
                            'claim_text_bn' => $record->claim_text,
                            'claim_origin_bn' => $data['claimant'] ?: ($record->claim_url ?: 'সামাজিক যোগাযোগ মাধ্যম'),
                            'claim_claimant_bn' => $data['claimant'],
                            'claim_date' => $record->created_at ? $record->created_at->format('Y-m-d') : date('Y-m-d'),
                            'verdict' => $data['verdict'],
                            'verification_steps_bn' => $steps,
                            'status' => 'draft',
                        ]);

                        $record->update([
                            'post_id' => $post->id,
                            'status' => 'investigating',
                        ]);

                        Notification::make()
                            ->title('Fact-Check Draft created successfully!')
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
