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
    <h1 style="font-size: 26px; font-weight: 700; margin-bottom: 8px;">
        {{ $lang === 'en' ? $category->name_en : $category->name_bn }}
    </h1>
    <p style="font-family: var(--font-ui); font-size: 14px; color: var(--text-muted); border-bottom: 1px solid var(--border-rule); padding-bottom: 16px; margin-bottom: 24px;">
        {{ $category->description_bn }}
    </p>

    @foreach($posts as $post)
        <div style="border-bottom: 1px solid var(--border-rule); padding: 16px 0;">
            <div style="font-family: var(--font-ui); font-size: 12px; margin-bottom: 4px;">
                <span style="color: var(--accent-red); font-weight: 700;">{{ $post->getVerdictLabel($lang) }}</span>
                · <span>{{ BnHelper::bnDate($post->published_at) }}</span>
            </div>
            <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 4px;">
                <a href="{{ route('article.show', $post->slug) }}">
                    {{ $lang === 'en' && $post->title_en ? $post->title_en : $post->title_bn }}
                </a>
            </h2>
            <p style="font-size: 14.5px; color: #555;">{{ $post->excerpt_bn }}</p>
        </div>
    @endforeach

    <div style="margin-top: 24px;">{{ $posts->links() }}</div>
@endsection
