@extends('layouts.app')

@section('content')
@php
    use App\Helpers\BnHelper;
    $lang = app()->getLocale();
@endphp

    <div style="max-width: 840px; margin: 0 auto;">
        <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 8px;">
            {{ $lang === 'en' ? 'Search Results' : 'অনুসন্ধানের ফলাফল' }}
        </h1>
        <p style="font-family: var(--font-ui); font-size: 14px; color: var(--text-muted); margin-bottom: 24px;">
            "{{ $q }}" এর জন্য মোট {{ BnHelper::bnNum($posts->total()) }}টি প্রতিবেদন পাওয়া গেছে।
        </p>

        @if($posts->count() > 0)
            <div style="display: flex; flex-direction: column;">
                @foreach($posts as $post)
                    <article style="border-bottom: 1px solid var(--border-rule); padding: 18px 0;">
                        <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 6px;">
                            <a href="{{ route('article.show', $post->slug) }}">{{ $post->title_bn }}</a>
                        </h2>
                        <p style="font-size: 15px; color: var(--text-muted); margin-bottom: 8px;">
                            {{ $post->excerpt_bn }}
                        </p>
                        <div style="font-family: var(--font-ui); font-size: 12.5px; color: var(--text-muted); display: flex; gap: 10px;">
                            <span style="color: var(--accent-red); font-weight: 700;">{{ $post->getVerdictLabel($lang) }}</span>
                            <span>·</span>
                            <span>{{ BnHelper::bnDate($post->published_at) }}</span>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="margin-top: 32px;">
                {{ $posts->appends(['q' => $q])->links() }}
            </div>
        @else
            <div style="padding: 48px 0; text-align: center; font-family: var(--font-ui); color: var(--text-muted);">
                কোনো প্রতিবেদন পাওয়া যায়নি। অনুগ্রহ করে সঠিক কি-ওয়ার্ড দিয়ে আবার চেষ্টা করুন।
            </div>
        @endif
    </div>
@endsection
