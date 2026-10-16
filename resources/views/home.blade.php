@section('head_preloads')
    @if($leadPost && $leadPost->getFirstMediaUrl('featured_image'))
        @php
            $leadImgP = preg_replace('/\.(png|jpe?g)$/i', '.webp', $leadPost->getFirstMediaUrl('featured_image'));
        @endphp
        <link rel="preload" href="{{ $leadImgP }}" as="image" type="image/webp" fetchpriority="high">
    @endif
@endsection

@extends('layouts.app')

@section('content')
@php
    use App\Helpers\BnHelper;
    $lang = app()->getLocale();
    $settings = app(\App\Settings\SiteSettings::class);
@endphp

    <div class="home-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 48px;">
        <!-- Left: Main Content & Stories -->
        <div>
            @if($leadPost)
                <div style="border-bottom: 2px solid var(--text-dark); padding-bottom: 28px; margin-bottom: 36px;">
                    <div style="font-family: var(--font-ui); font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--accent-red); margin-bottom: 8px;">
                        {{ $lang === 'en' ? 'Top Investigation' : 'শীর্ষ অনুসন্ধান' }}
                    </div>

                    @if($leadPost->getFirstMediaUrl('featured_image'))
                        @php
                            $leadImgUrl = $leadPost->getFirstMediaUrl('featured_image');
                            $leadWebpUrl = preg_replace('/\.(png|jpe?g)$/i', '.webp', $leadImgUrl);
                        @endphp
                        <div style="margin-bottom: 18px; overflow: hidden; border: 1px solid var(--border-rule);">
                            <a href="{{ route('article.show', $leadPost->slug) }}">
                                <picture>
                                    <source srcset="{{ $leadWebpUrl }}" type="image/webp">
                                    <img src="{{ $leadImgUrl }}" alt="{{ $leadPost->title_bn }}" width="700" height="394" fetchpriority="high" decoding="async" style="width: 100%; height: auto; aspect-ratio: 16 / 9; display: block; object-fit: cover; max-height: 420px;">
                                </picture>
                            </a>
                        </div>
                    @endif

                    <h2 class="lead-headline" style="font-size: 28px; font-weight: 700; line-height: 1.35; margin-bottom: 12px;">
                        <a href="{{ route('article.show', $leadPost->slug) }}" style="color: var(--text-dark);">
                            {{ $leadPost->title_bn }}
                        </a>
                    </h2>
                    <p style="font-size: 16px; line-height: 1.7; color: var(--text-muted); margin-bottom: 16px;">
                        {{ $leadPost->excerpt_bn }}
                    </p>
                    <div style="font-family: var(--font-ui); font-size: 13.5px; color: var(--text-muted); display: flex; gap: 14px; align-items: center; flex-wrap: wrap;">
                        <span style="color: var(--accent-red); font-weight: 700;">{{ $leadPost->getVerdictLabel($lang) }}</span>
                        <span>·</span>
                        <span>{{ $leadPost->category ? $leadPost->category->name_bn : '' }}</span>
                        <span>·</span>
                        <span>{{ BnHelper::bnDate($leadPost->published_at) }}</span>
                    </div>
                </div>
            @endif

            <!-- List of Fact Checks -->
            <div style="display: flex; flex-direction: column;">
                @foreach($posts as $post)
                    <article style="border-bottom: 1px solid var(--border-rule); padding: 22px 0; display: flex; gap: 20px; align-items: flex-start;">
                        @if($post->getFirstMediaUrl('featured_image'))
                            @php
                                $thumbImgUrl = $post->getFirstMediaUrl('featured_image');
                                $thumbWebpUrl = preg_replace('/\.(png|jpe?g)$/i', '.webp', $thumbImgUrl);
                            @endphp
                            <div style="flex-shrink: 0; width: 140px; height: 95px; overflow: hidden; border: 1px solid var(--border-rule);">
                                <a href="{{ route('article.show', $post->slug) }}">
                                    <picture>
                                        <source srcset="{{ $thumbWebpUrl }}" type="image/webp">
                                        <img src="{{ $thumbImgUrl }}" alt="{{ $post->title_bn }}" width="140" height="95" loading="lazy" decoding="async" style="width: 100%; height: 100%; aspect-ratio: 140 / 95; object-fit: cover; display: block;">
                                    </picture>
                                </a>
                            </div>
                        @endif

                        <div style="flex: 1;">
                            <h3 style="font-size: 19px; font-weight: 600; line-height: 1.4; margin-top: 0; margin-bottom: 6px;">
                                <a href="{{ route('article.show', $post->slug) }}" style="color: var(--text-dark);">
                                    {{ $post->title_bn }}
                                </a>
                            </h3>
                            <p style="font-size: 14.5px; color: var(--text-muted); margin-bottom: 8px; line-height: 1.5;">
                                {{ Str::limit($post->excerpt_bn, 120) }}
                            </p>
                            <div style="font-family: var(--font-ui); font-size: 12.5px; color: var(--text-muted); display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                                <span style="color: var(--accent-red); font-weight: 700;">{{ $post->getVerdictLabel($lang) }}</span>
                                <span>·</span>
                                <span>{{ $post->category ? $post->category->name_bn : '' }}</span>
                                <span>·</span>
                                <span>{{ BnHelper::bnDate($post->published_at) }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="margin-top: 32px;">
                {{ $posts->links() }}
            </div>
        </div>

        <!-- Right: Editorial Sidebar -->
        <aside>
            <div style="border: 1px solid var(--border-rule); padding: 24px; background: #FFF; margin-bottom: 32px;">
                <h4 style="font-family: var(--font-ui); font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; color: var(--accent-red);">
                    {{ $lang === 'en' ? 'Submit Claim' : 'দাবি বা গুজব পাঠান' }}
                </h4>
                <p style="font-family: var(--font-ui); font-size: 13.5px; color: var(--text-muted); line-height: 1.6; margin-bottom: 16px;">
                    {{ $lang === 'en' ? 'Seen any viral social media post or suspicious photo that looks fake? Report it to our newsroom.' : 'ফেসবুক বা ইন্টারনেটে কোনো সন্দেহজনক ফটোকার্ড বা ভিডিও চোখে পড়েছে? যাচাইয়ের জন্য আমাদের পাঠান।' }}
                </p>
                <a href="{{ route('claim.create') }}" style="display: block; text-align: center; background: var(--accent-red); color: #fff; font-family: var(--font-ui); font-size: 13.5px; font-weight: 600; padding: 10px; border-radius: 2px;">
                    {{ $lang === 'en' ? 'Send Suspicious Link' : 'তথ্য বা লিংক পাঠান' }}
                </a>
            </div>

            <div style="border-top: 1px solid var(--border-rule); padding-top: 24px;">
                <h4 style="font-family: var(--font-ui); font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px;">
                    {{ $lang === 'en' ? 'Categories' : 'বিভাগসমূহ' }}
                </h4>
                <ul style="list-style: none; font-family: var(--font-ui); font-size: 14px; padding: 0;">
                    @foreach($categories as $category)
                        <li style="margin-bottom: 10px; border-bottom: 1px dashed var(--border-rule); padding-bottom: 8px;">
                            <a href="{{ route('category.show', $category->slug) }}" style="display: flex; justify-content: space-between;">
                                <span>{{ $category->name_bn }}</span>
                                <span style="color: var(--text-muted); font-size: 12px;">({{ BnHelper::bnNum($category->posts()->published()->count()) }})</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
@endsection
