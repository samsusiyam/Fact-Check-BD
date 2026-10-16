@section('head_preloads')
    @if($post->getFirstMediaUrl('featured_image'))
        @php
            $artImgP = preg_replace('/\.(png|jpe?g)$/i', '.webp', $post->getFirstMediaUrl('featured_image'));
        @endphp
        <link rel="preload" href="{{ $artImgP }}" as="image" type="image/webp" fetchpriority="high">
    @endif
@endsection

@extends('layouts.app')

@php
    use App\Helpers\BnHelper;
    $lang = app()->getLocale();
    $title = $lang === 'en' && $post->title_en ? $post->title_en : $post->title_bn;
    $siteName = $settings->site_name_bn ?? 'ফ্যাক্টচেক বাংলাদেশ';
    $postExcerpt = $post->excerpt_bn ?: $post->claim_text_bn ?: strip_tags($post->content_bn);
    $featImg = $post->getFirstMediaUrl('featured_image') ?: asset('storage/branding/logo.png');
@endphp

@section('title', Str::limit($title, 48) . ' | ' . $siteName)
@section('meta_title', Str::limit($title, 55) . ' | ' . $siteName)
@section('meta_description', Str::limit(strip_tags($postExcerpt), 150))
@section('og_image', $featImg)
@section('og_type', 'article')

@section('content')
@php
    $lang = app()->getLocale();
    $title = $lang === 'en' && $post->title_en ? $post->title_en : $post->title_bn;
    $claim = $lang === 'en' && $post->claim_text_en ? $post->claim_text_en : $post->claim_text_bn;
    $claimant = $lang === 'en' && $post->claim_claimant_en ? $post->claim_claimant_en : $post->claim_claimant_bn;
    $verification = $lang === 'en' && $post->verification_steps_en ? $post->verification_steps_en : $post->verification_steps_bn;
    $articleContent = $lang === 'en' && $post->content_en ? $post->content_en : $post->content_bn;

    $ratingMap = [
        'false' => ['val' => '1', 'name' => 'False / ভুয়া'],
        'misleading' => ['val' => '2', 'name' => 'Misleading / বিভ্রান্তিকর'],
        'unproven' => ['val' => '3', 'name' => 'Unproven / অপ্রমাণিত'],
        'ai_generated' => ['val' => '1', 'name' => 'AI Generated / ডিপফেক'],
        'true' => ['val' => '5', 'name' => 'True / সত্য'],
    ];
    $rating = $ratingMap[$post->verdict] ?? ['val' => '1', 'name' => 'False'];
@endphp

    @php
        $schemaData = [
            '@context' => 'https://schema.org',
            '@type' => 'ClaimReview',
            'url' => url()->current(),
            'claimReviewed' => $claim,
            'datePublished' => $post->published_at->toIso8601String(),
            'itemReviewed' => [
                '@type' => 'CreativeWork',
                'author' => [
                    '@type' => 'Organization',
                    'name' => $claimant ?: 'Social Media / ইন্টারনেট ব্যবহারকারী',
                ],
                'datePublished' => $post->published_at->format('Y-m-d'),
            ],
            'author' => [
                '@type' => 'NewsMediaOrganization',
                'name' => 'ফ্যাক্টচেক বাংলাদেশ',
                'url' => 'https://factcheck.hostnibo.com',
            ],
            'reviewRating' => [
                '@type' => 'Rating',
                'ratingValue' => $rating['val'],
                'bestRating' => '5',
                'worstRating' => '1',
                'alternateName' => $rating['name'],
            ],
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    <article style="max-width: 720px; margin: 0 auto;">
        <h1 class="article-headline" style="font-size: 32px; font-weight: 700; line-height: 1.35; margin-bottom: 16px;">
            {{ $title }}
        </h1>

        <div style="font-family: var(--font-ui); font-size: 13.5px; color: var(--text-muted); border-bottom: 1px solid var(--border-rule); padding-bottom: 12px; margin-bottom: 24px; display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
            <span>প্রতিবেদক: <strong style="color: var(--text-main);">{{ $post->user?->name ?? 'ফ্যাক্টচেক ডেস্ক' }}</strong></span>
            <span>·</span>
            <span>প্রকাশ: {{ BnHelper::bnDate($post->published_at) }}</span>
            <span>·</span>
            <span>পড়ার সময়: {{ BnHelper::readingTime($articleContent . $verification) }}</span>
            <span>·</span>
            <span>সিদ্ধান্ত: <strong style="color: var(--accent-red);">{{ $post->getVerdictLabel($lang) }}</strong></span>
        </div>

        
        <!-- Prominent Fact-Check Verdict Stamp & Media (Newsroom Standard) -->
        <div class="verdict-box" style="background: #FFF; border: 1px solid var(--border-rule); border-top: 4px solid var(--accent-red); padding: 24px; margin-bottom: 28px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div>
                <div style="font-family: var(--font-ui); font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-muted); margin-bottom: 6px;">
                    {{ $lang === 'en' ? 'OFFICIAL VERDICT' : 'অফিসিয়াল ফ্যাক্টচেক সিদ্ধান্ত' }}
                </div>
                <div style="font-size: 28px; font-weight: 800; color: var(--accent-red); font-family: var(--font-body); display: flex; align-items: center; gap: 10px;">
                    <span>{{ $post->getVerdictLabel($lang) }}</span>
                </div>
            </div>
            <div style="text-align: right; font-family: var(--font-ui); font-size: 13px; color: var(--text-muted);">
                <div>{{ $lang === 'en' ? 'Review Date:' : 'যাচাইয়ের তারিখ:' }} <strong>{{ BnHelper::bnDate($post->published_at) }}</strong></div>
                <div style="margin-top: 4px;">{{ $lang === 'en' ? 'Reviewed by:' : 'অনুসন্ধানী দল:' }} <strong>{{ $post->user?->name ?? 'ফ্যাক্টচেক ডেস্ক' }}</strong></div>
            </div>
        </div>

        @if($post->getFirstMediaUrl('featured_image'))
            @php
                $artImgUrl = $post->getFirstMediaUrl('featured_image');
                $artWebpUrl = preg_replace('/\.(png|jpe?g)$/i', '.webp', $artImgUrl);
            @endphp
            <div style="margin-bottom: 30px; text-align: center;">
                <picture>
                    <source srcset="{{ $artWebpUrl }}" type="image/webp">
                    <img src="{{ $artImgUrl }}" alt="{{ $title }}" width="800" height="450" fetchpriority="high" style="width: 100%; height: auto; border: 1px solid var(--border-rule); max-height: 480px; object-fit: cover;">
                </picture>
            </div>
        @endif

<!-- Section 1: The Claim -->
        <section style="margin-bottom: 32px;">
            <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 10px; border-bottom: 1px solid var(--border-rule); padding-bottom: 6px;">
                {{ $lang === 'en' ? 'The Claim' : 'দাবি' }}
            </h3>
            <div style="background: #fff; border-left: 3px solid var(--accent-red); padding: 14px 18px; margin-bottom: 8px; font-size: 16.5px; color: #222;">
                {{ $claim }}
            </div>
            @if($claimant)
                <div style="font-family: var(--font-ui); font-size: 13px; color: var(--text-muted);">
                    {{ $lang === 'en' ? 'Claimant / Origin:' : 'দাবিদার ও প্রচারের উৎস:' }} {{ $claimant }} ({{ $post->claim_origin_bn }})
                </div>
            @endif
        </section>

        <!-- Section 2: Verification -->
        @if($verification)
            <section style="margin-bottom: 32px;">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 12px; border-bottom: 1px solid var(--border-rule); padding-bottom: 6px;">
                    {{ $lang === 'en' ? 'Fact-Check Verification' : 'যাচাই ও তথ্যানুসন্ধান' }}
                </h3>
                <div style="line-height: 1.8; font-size: 16.5px;">
                    {!! $verification !!}
                </div>
            </section>
        @endif

        @if($articleContent)
            <div style="line-height: 1.8; font-size: 16.5px; margin-bottom: 32px;">
                {!! $articleContent !!}
            </div>
        @endif

        <!-- Section 3: Sources -->
        @if(!empty($post->sources) && is_array($post->sources))
            <section style="margin-bottom: 32px; border-top: 1px solid var(--border-rule); padding-top: 20px;">
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 10px;">
                    {{ $lang === 'en' ? 'Sources & Evidence' : 'তথ্যসূত্র' }}
                </h3>
                <ol style="padding-left: 20px; font-family: var(--font-ui); font-size: 13.5px; line-height: 1.8;">
                    @foreach($post->sources as $source)
                        <li>
                            <a href="{{ $source['url'] }}" target="_blank" rel="noopener" style="color: var(--accent-red); text-decoration: underline;">
                                {{ $source['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ol>
            </section>
        @endif

        @if($post->correction_note_bn)
            <div style="background: #FFF8E1; border: 1px solid #FFE082; padding: 12px 16px; font-family: var(--font-ui); font-size: 13px; margin-top: 24px;">
                <strong>সংশোধনী ও অডিট নোট:</strong> {{ $post->correction_note_bn }}
            </div>
        @endif

        <!-- Social Share & Photocard -->
        <div style="border-top: 1px solid var(--border-rule); padding-top: 20px; margin-top: 32px; font-family: var(--font-ui); font-size: 13px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; gap: 12px; align-items: center;">
                <span style="font-weight: 700; color: var(--text-muted); text-transform: uppercase; font-size: 11.5px; letter-spacing: 0.05em;">শেয়ার করুন:</span>
                <!-- Facebook Icon -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" title="Share on Facebook" style="color: #1877F2; display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: #FFF; border: 1px solid var(--border-rule); border-radius: 2px; transition: all 0.2s;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <!-- X / Twitter Icon -->
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($title) }}" target="_blank" rel="noopener" title="Share on X" style="color: #000; display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: #FFF; border: 1px solid var(--border-rule); border-radius: 2px; transition: all 0.2s;">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <!-- WhatsApp Icon -->
                <a href="https://api.whatsapp.com/send?text={{ urlencode($title . ' ' . url()->current()) }}" target="_blank" rel="noopener" title="Share on WhatsApp" style="color: #25D366; display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: #FFF; border: 1px solid var(--border-rule); border-radius: 2px; transition: all 0.2s;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                </a>
                <!-- LinkedIn Icon -->
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" title="Share on LinkedIn" style="color: #0A66C2; display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: #FFF; border: 1px solid var(--border-rule); border-radius: 2px; transition: all 0.2s;">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                </a>
            </div>
            <div>
                <a href="{{ route('article.card', $post->slug) }}" target="_blank" style="background: #111; color: #FFF; padding: 7px 16px; border-radius: 2px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <span>ফটোকার্ড ভিউ / ডাউনলোড</span> 🖼
                </a>
            </div>
        </div>

        <!-- Related Fact Checks -->
        @if($relatedPosts->count() > 0)
            <div style="border-top: 2px solid var(--text-main); margin-top: 48px; padding-top: 24px;">
                <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 18px;">
                    {{ $lang === 'en' ? 'Related Fact-Checks' : 'সম্পর্কিত অন্যান্য অনুসন্ধান' }}
                </h3>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @foreach($relatedPosts as $rel)
                        <div style="border-bottom: 1px dashed var(--border-rule); padding-bottom: 12px;">
                            <h4 style="font-size: 17px; font-weight: 600; line-height: 1.4; margin-bottom: 4px;">
                                <a href="{{ route('article.show', $rel->slug) }}">{{ $rel->title_bn }}</a>
                            </h4>
                            <div style="font-family: var(--font-ui); font-size: 12px; color: var(--text-muted);">
                                <span style="color: var(--accent-red); font-weight: 700;">{{ $rel->getVerdictLabel($lang) }}</span>
                                <span>·</span>
                                <span>{{ BnHelper::bnDate($rel->published_at) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </article>
@endsection
