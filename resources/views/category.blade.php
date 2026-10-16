@extends('layouts.app')

@php
    use App\Helpers\BnHelper;
    $lang = app()->getLocale();
    $catName = $lang === 'en' ? $category->name_en : $category->name_bn;
    $siteName = $settings->site_name_bn ?? 'ফ্যাক্টচেক বাংলাদেশ';
@endphp

@section('title', $catName . ' | ' . $siteName)
@section('meta_title', $catName . ' - ফ্যাক্টচেক অনুসন্ধান | ' . $siteName)
@section('meta_description', Str::limit(strip_tags($category->description_bn ?? $catName . ' সম্পর্কিত সর্বশেষ যাচাই ও তথ্য অনুসন্ধান প্রতিবেদন'), 150))

@section('content')
    <div style="margin-bottom: 24px; border-bottom: 2px solid var(--accent-red); padding-bottom: 12px;">
        <h1 style="font-size: 26px; font-weight: 700; margin: 0 0 6px 0; color: var(--text-dark);">
            {{ $catName }}
        </h1>
        @if(!empty($category->description_bn))
            <p style="font-family: var(--font-ui); font-size: 14px; color: var(--text-muted); margin: 0;">
                {{ $category->description_bn }}
            </p>
        @endif
    </div>

    <style>
        .cat-article-item {
            border-bottom: 1px solid var(--border-rule);
            padding: 20px 0;
            display: flex;
            gap: 18px;
            align-items: flex-start;
        }
        .cat-thumb-box {
            flex-shrink: 0;
            width: 140px;
            height: 95px;
            overflow: hidden;
            border: 1px solid var(--border-rule);
        }
        @media (max-width: 480px) {
            .cat-article-item {
                gap: 12px;
                padding: 16px 0;
            }
            .cat-thumb-box {
                width: 105px;
                height: 72px;
            }
        }
    </style>

    <div style="display: flex; flex-direction: column;">
        @forelse($posts as $post)
            <article class="cat-article-item">
                @if($post->getFirstMediaUrl('featured_image'))
                    @php
                        $thumbImgUrl = $post->getFirstMediaUrl('featured_image');
                        $thumbWebpUrl = preg_replace('/\.(png|jpe?g)$/i', '.webp', $thumbImgUrl);
                    @endphp
                    <div class="cat-thumb-box">
                        <a href="{{ route('article.show', $post->slug) }}">
                            <picture>
                                <source srcset="{{ $thumbWebpUrl }}" type="image/webp">
                                <img src="{{ $thumbImgUrl }}" alt="{{ $post->title_bn }}" width="140" height="95" loading="lazy" decoding="async" style="width: 100%; height: 100%; aspect-ratio: 140 / 95; object-fit: cover; display: block;">
                            </picture>
                        </a>
                    </div>
                @endif
                <div style="flex: 1; min-width: 0;">
                    <div style="font-family: var(--font-ui); font-size: 12px; margin-bottom: 5px; display: flex; align-items: center; gap: 8px;">
                        <span style="color: var(--accent-red); font-weight: 700; text-transform: uppercase;">{{ $post->getVerdictLabel($lang) }}</span>
                        <span style="color: #999;">·</span>
                        <span style="color: var(--text-muted);">{{ BnHelper::bnDate($post->published_at) }}</span>
                    </div>
                    <h2 style="font-size: 17.5px; font-weight: 700; line-height: 1.4; margin: 0 0 6px 0;">
                        <a href="{{ route('article.show', $post->slug) }}" style="color: var(--text-dark);">
                            {{ $lang === 'en' && $post->title_en ? $post->title_en : $post->title_bn }}
                        </a>
                    </h2>
                    @if($post->excerpt_bn)
                        <p style="font-family: var(--font-serif); font-size: 13.5px; color: var(--text-muted); line-height: 1.5; margin: 0;">
                            {{ Str::limit($post->excerpt_bn, 130) }}
                        </p>
                    @endif
                </div>
            </article>
        @empty
            <p style="font-family: var(--font-ui); font-size: 15px; color: var(--text-muted); padding: 30px 0;">
                এই বিভাগে বর্তমানে কোনো ফ্যাক্টচেক প্রতিবেদন নেই।
            </p>
        @endforelse
    </div>

    <div style="margin-top: 24px;">{{ $posts->links() }}</div>
@endsection
