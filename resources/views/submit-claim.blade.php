@extends('layouts.app')

@section('content')
@php
    $lang = app()->getLocale();
    $settings = app(\App\Settings\SiteSettings::class);
@endphp

    <div style="max-width: 720px; margin: 0 auto;">
        <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 12px; line-height: 1.35;">
            {{ $lang === 'en' ? 'Submit a Claim for Verification' : 'দাবি বা সন্দেহজনক তথ্য যাচাইয়ের জন্য পাঠান' }}
        </h1>
        
        <p style="font-size: 16.5px; color: var(--text-muted); line-height: 1.8; margin-bottom: 28px;">
            {{ $lang === 'en' 
                ? 'Seen any suspicious post, manipulated photo, deepfake video, or viral rumor? Submit the link and details below. Our independent fact-checkers will investigate.' 
                : 'সামাজিক যোগাযোগমাধ্যম বা ইন্টারনেটে কোনো বিভ্রান্তিকর খবর, ভুয়া ফটোকার্ড, ডিপফেক ভিডিও কিংবা গুজব চোখে পড়লে নিচে তথ্য ও প্রমাণ জমা দিন। আমাদের তথ্যানুসন্ধান দল তা আন্তর্জাতিক মানদণ্ডে যাচাই করবে।' 
            }}
        </p>

        @if(session('success'))
            <div style="background: #E8F5E9; border: 1px solid #C8E6C9; color: #2E7D32; padding: 16px 20px; margin-bottom: 32px; font-family: var(--font-ui); font-size: 15px; border-radius: 2px;">
                <strong>{{ $lang === 'en' ? 'Success:' : 'সফলভাবে জমা হয়েছে:' }}</strong> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #FFEBEE; border: 1px solid #FFCDD2; color: #C62828; padding: 16px 20px; margin-bottom: 32px; font-family: var(--font-ui); font-size: 14.5px; border-radius: 2px;">
                <ul style="margin-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('claim.store') }}" method="POST" enctype="multipart/form-data" style="background: #FFF; border: 1px solid var(--border-rule); padding: 32px; border-radius: 2px;">
            @csrf

            <!-- Honeypot anti-spam field -->
            <div style="display: none;">
                <input type="text" name="website_hp" value="">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-family: var(--font-ui); font-size: 14.5px; font-weight: 600; margin-bottom: 8px;">
                    {{ $lang === 'en' ? 'Claim / Rumor Description *' : 'দাবি বা গুজবের বিবরণ *' }}
                </label>
                <textarea name="claim_text" rows="5" required placeholder="{{ $lang === 'en' ? 'Describe the claim, what is being alleged, or what looks suspicious...' : 'দাবিটি কী, কোথায় দেখেছেন বা কী বিভ্রান্তিকর মনে হচ্ছে বিস্তারিত লিখুন...' }}" style="width: 100%; border: 1px solid var(--border-rule); padding: 12px; font-family: var(--font-body); font-size: 15.5px; background: #FAFAF7; box-sizing: border-box;">{{ old('claim_text') }}</textarea>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-family: var(--font-ui); font-size: 14.5px; font-weight: 600; margin-bottom: 8px;">
                    {{ $lang === 'en' ? 'Link / Social Media URL (Facebook, YouTube, X, News)' : 'অনলাইন লিংক / সূত্র (ফেসবুক, টিকটক, ইউটিউব বা সংবাদ লিংক)' }}
                </label>
                <input type="url" name="claim_url" value="{{ old('claim_url') }}" placeholder="https://..." style="width: 100%; border: 1px solid var(--border-rule); padding: 12px; font-family: var(--font-ui); font-size: 14.5px; background: #FAFAF7; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-family: var(--font-ui); font-size: 14.5px; font-weight: 600; margin-bottom: 8px;">
                    {{ $lang === 'en' ? 'Screenshot or Photo Evidence (Optional, max 10MB)' : 'স্ক্রিনশট বা প্রামাণ্য ছবি (ঐচ্ছিক, সর্বোচ্চ ১০ মেগাবাইট)' }}
                </label>
                <input type="file" name="attachment" accept="image/*" style="font-family: var(--font-ui); font-size: 14px;">
            </div>

            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px;">
                <div>
                    <label style="display: block; font-family: var(--font-ui); font-size: 13.5px; font-weight: 600; margin-bottom: 6px;">
                        {{ $lang === 'en' ? 'Your Name (Optional)' : 'আপনার নাম (ঐচ্ছিক)' }}
                    </label>
                    <input type="text" name="submitter_name" value="{{ old('submitter_name') }}" style="width: 100%; border: 1px solid var(--border-rule); padding: 10px; font-family: var(--font-ui); font-size: 14px; background: #FAFAF7; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-family: var(--font-ui); font-size: 13.5px; font-weight: 600; margin-bottom: 6px;">
                        {{ $lang === 'en' ? 'Your Email (Optional)' : 'আপনার ইমেইল (ঐচ্ছিক)' }}
                    </label>
                    <input type="email" name="submitter_email" value="{{ old('submitter_email') }}" placeholder="you@example.com" style="width: 100%; border: 1px solid var(--border-rule); padding: 10px; font-family: var(--font-ui); font-size: 14px; background: #FAFAF7; box-sizing: border-box;">
                </div>
            </div>

            
            @if($settings->enable_turnstile && !empty($settings->turnstile_site_key))
                <div style="margin-bottom: 20px;">
                    <div class="cf-turnstile" data-sitekey="{{ $settings->turnstile_site_key }}" data-theme="light"></div>
                </div>
            @endif

            <button type="submit" style="background: var(--accent-red); color: #FFF; border: none; padding: 12px 28px; font-family: var(--font-ui); font-size: 15px; font-weight: 600; cursor: pointer; border-radius: 2px;">
                {{ $lang === 'en' ? 'Submit Claim to Newsroom →' : 'যাচাইয়ের জন্য জমা দিন →' }}
            </button>
        </form>
    </div>
@endsection
