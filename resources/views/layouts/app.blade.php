@php
    $settings = $settings ?? app(\App\Settings\SiteSettings::class);
    $siteName = $settings->site_name_bn ?? 'ফ্যাক্টচেক বাংলাদেশ';
    $tagline = $settings->tagline_bn ?? 'বাংলাদেশি সংবাদ ও তথ্যের সত্যতা যাচাইয়ের স্বাধীন উদ্যোগ';
@endphp
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $siteName)</title>

    @if(!empty($settings->favicon))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings->favicon) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        :root {
            --bg-color: #FAFAF7;
            --text-dark: #111111;
            --text-muted: #555555;
            --border-rule: #E5E5E0;
            --accent-red: #B3261E;
            --font-serif: 'Noto Serif Bengali', Georgia, serif;
            --font-ui: 'Noto Sans Bengali', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        html, body {
            max-width: 100vw !important;
            overflow-x: hidden !important;
            position: relative;
            background-color: var(--bg-color);
            color: var(--text-dark);
            font-family: var(--font-serif);
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        *, *:before, *:after {
            box-sizing: border-box !important;
        }

        .site-wrap {
            max-width: 1080px;
            margin: 0 auto;
            padding: 0 20px;
            box-sizing: border-box;
            width: 100%;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* Top Bar Announcement */
        .top-announcement {
            background: #111;
            color: #FFF;
            font-family: var(--font-ui);
            font-size: 13px;
            padding: 9px 0;
            border-bottom: 1px solid #222;
            text-align: center;
        }
        .top-announcement a {
            color: #FACC15;
            text-decoration: underline;
            margin-left: 8px;
            font-weight: 600;
        }

        /* Header Match */
        .site-header {
            background: #FFFFFF !important;
            padding: 18px 0 16px 0 !important;
            border-bottom: 1px solid #E5E7EB !important;
        }

        .header-top {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
        }

        .site-branding {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
        }

        .site-logo-img {
            max-height: 48px !important;
            width: auto !important;
            display: block !important;
            margin: 0 auto !important;
            object-fit: contain !important;
        }

        .site-tagline {
            font-family: var(--font-ui) !important;
            font-size: 13px !important;
            color: #4B5563 !important;
            margin-top: 8px !important;
            line-height: 1.45 !important;
            max-width: 320px !important;
            text-align: center !important;
        }

        /* Sub Header / Control Row with comfortable spacing */
        .header-controls-row {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            margin-top: 24px !important;
            padding-top: 14px !important;
            border-top: 1px solid #E5E7EB !important;
            box-sizing: border-box !important;
        }

        /* Segmented Pill Language Switcher */
        .lang-pill-wrap {
            display: inline-flex !important;
            align-items: center !important;
            background: #F3F4F6 !important;
            border: 1px solid #E5E7EB !important;
            border-radius: 6px !important;
            padding: 2px !important;
        }

        .lang-pill {
            background: transparent !important;
            border: none !important;
            padding: 4px 11px !important;
            border-radius: 4px !important;
            font-family: var(--font-ui) !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #4B5563 !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
        }

        .lang-pill.active {
            background: #FFFFFF !important;
            color: #DC2626 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.08) !important;
        }

        .lang-pill-divider {
            width: 1px;
            height: 14px;
            background: #E5E7EB;
            margin: 0 1px;
        }

        /* WhatsApp Outline Button */
        .whatsapp-icon-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 32px !important;
            height: 32px !important;
            color: #25D366 !important;
            text-decoration: none !important;
            flex-shrink: 0 !important;
            background: transparent !important;
        }

        /* Mobile Hamburger Toggle */
        .mobile-toggle-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 40px !important;
            height: 40px !important;
            background: #FFFFFF !important;
            border: 1px solid #D1D5DB !important;
            border-radius: 6px !important;
            cursor: pointer !important;
            padding: 0 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
        }

        /* Desktop Nav Menu */
        .header-nav {
            display: flex;
            align-items: center;
            gap: 22px;
            border-top: 1px solid var(--border-rule);
            margin-top: 14px;
            padding-top: 12px;
            font-family: var(--font-ui);
            font-size: 14.5px;
            font-weight: 600;
        }
        .header-nav a {
            padding: 4px 0;
            border-bottom: 2px solid transparent;
            color: var(--text-dark);
        }
        .header-nav a:hover {
            border-bottom-color: var(--accent-red);
            color: var(--accent-red);
        }
        .header-nav .search-box {
            margin-left: auto;
        }
        .search-input {
            border: 1px solid var(--border-rule);
            padding: 6px 12px;
            font-family: var(--font-ui);
            font-size: 13px;
            background: #FFF;
            border-radius: 2px;
            outline: none;
        }

        /* Mobile Drawer */
        .mobile-drawer-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
        }
        .mobile-drawer {
            position: fixed;
            top: 0; right: -280px;
            width: 280px; height: 100%;
            background: #FAFAF7;
            border-left: 1px solid var(--border-rule);
            z-index: 9999;
            padding: 24px;
            box-sizing: border-box;
            transition: right 0.25s ease-in-out;
            display: flex; flex-direction: column; gap: 16px;
            overflow-y: auto;
        }
        .mobile-drawer.open { right: 0; }
        .mobile-drawer a {
            font-family: var(--font-ui);
            font-size: 15px; font-weight: 600;
            padding: 8px 0; border-bottom: 1px solid #EBEBE6;
            color: var(--text-dark);
        }

        /* Main Content */
        .site-main {
            padding: 36px 0 60px 0;
            min-height: 50vh;
        }

        /* Footer */
        .site-footer {
            border-top: 1px solid var(--border-rule);
            padding: 44px 0 24px 0;
            background: #F4F4F0;
            font-family: var(--font-ui);
            font-size: 13.5px;
            color: var(--text-muted);
        }
        .footer-cols {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 32px;
        }
        .footer-col h4 {
            font-size: 14px;
            font-weight: 700;
            color: #111;
            margin-top: 0;
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .footer-col ul { list-style: none; padding: 0 !important; margin: 0 !important; }
        .footer-col li { margin-bottom: 9px; }
        .footer-col li a { color: var(--text-dark); }
        .footer-col li a:hover { color: var(--accent-red); }
        .footer-bottom {
            border-top: 1px solid #E5E5E0;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12.5px;
        }

        /* Breakpoints */
        @media (max-width: 991px) {
            .header-nav { display: none !important; }
            .mobile-toggle-btn { display: inline-flex !important; }
            .footer-cols { grid-template-columns: 1fr; gap: 28px; }
            .footer-bottom { flex-direction: column; gap: 14px; text-align: center; }
            .home-grid { grid-template-columns: 1fr !important; gap: 32px !important; }
        }

        @media (min-width: 992px) {
            .mobile-toggle-btn { display: none !important; }
            .mobile-drawer { display: none !important; }
            .mobile-drawer-overlay { display: none !important; }
        }
    </style>

    
    <!-- Google Translate Integration -->
    <style>
        .goog-te-banner-frame, .goog-te-banner-frame.skiptranslate, iframe.goog-te-banner-frame {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
        }
        body { top: 0px !important; position: static !important; }
        .goog-tooltip, .goog-tooltip:hover { display: none !important; }
        .goog-text-highlight { background-color: transparent !important; border: none !important; box-shadow: none !important; }
        #google_translate_element, .skiptranslate { display: none !important; }
    
        
        /* EXACT SCREENSHOT HEADER & SUB-HEADER FIX */
        .site-header {
            background: #FFFFFF !important;
            padding: 16px 0 16px 0 !important;
            border-bottom: 1px solid #E5E7EB !important;
        }

        .header-top {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
        }

        .site-branding {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
        }

        .site-logo-img {
            max-height: 48px !important;
            width: auto !important;
            display: block !important;
            margin: 0 auto !important;
            object-fit: contain !important;
        }

        .site-tagline {
            font-family: var(--font-ui) !important;
            font-size: 13px !important;
            color: #4B5563 !important;
            margin-top: 8px !important;
            line-height: 1.45 !important;
            max-width: 320px !important;
            text-align: center !important;
        }

        /* Controls row with generous top spacing and no tight line */
        .header-controls-row {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            margin-top: 22px !important;
            padding-top: 16px !important;
            border-top: 1px solid #E5E7EB !important;
            box-sizing: border-box !important;
        }

        /* Segmented Pill Language Switcher */
        .lang-pill-wrap {
            display: inline-flex !important;
            align-items: center !important;
            background: #F3F4F6 !important;
            border: 1px solid #E5E7EB !important;
            border-radius: 6px !important;
            padding: 2px !important;
        }

        .lang-pill {
            background: transparent !important;
            border: none !important;
            padding: 5px 12px !important;
            border-radius: 4px !important;
            font-family: var(--font-ui) !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #4B5563 !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
        }

        .lang-pill.active {
            background: #FFFFFF !important;
            color: #DC2626 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.08) !important;
        }

        .lang-pill-divider {
            width: 1px;
            height: 14px;
            background: #E5E7EB;
            margin: 0 1px;
        }

        /* WhatsApp Outline Button (Matching Screenshot exactly) */
        .whatsapp-icon-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 34px !important;
            height: 34px !important;
            color: #25D366 !important;
            text-decoration: none !important;
            flex-shrink: 0 !important;
            background: transparent !important;
        }

        /* Mobile Hamburger Toggle (White square with thin light-gray border) */
        .mobile-toggle-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 40px !important;
            height: 40px !important;
            background: #FFFFFF !important;
            border: 1px solid #D1D5DB !important;
            border-radius: 6px !important;
            cursor: pointer !important;
            padding: 0 !important;
            color: #111827 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
        }

        @media (min-width: 992px) {
            .mobile-toggle-btn {
                display: none !important;
            }
        }

    </style>
    <div id="google_translate_element" style="display:none;"></div>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'bn',
                includedLanguages: 'en,bn',
                autoDisplay: false
            }, 'google_translate_element');
        }

        function switchSiteLanguage(lang) {
            if (lang === 'bn') {
                // Clear all possible cookies across all domain paths
                var host = window.location.hostname;
                var domainParts = host.split('.');
                var paths = ['/', '/page', '/article', '/category'];
                
                // Clear googtrans
                ['googtrans', '__googtrans'].forEach(function(cName) {
                    paths.forEach(function(p) {
                        document.cookie = cName + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=' + p + ';';
                        document.cookie = cName + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=' + p + '; domain=' + host + ';';
                        document.cookie = cName + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=' + p + '; domain=.' + host + ';';
                    });
                });
                
                // Direct DOM revert if Google Combo is present
                var select = document.querySelector('#google_translate_element select');
                if (select) {
                    select.value = 'bn';
                    select.dispatchEvent(new Event('change'));
                }
                
                // Force reload clean
                setTimeout(function() {
                    window.location.href = window.location.pathname;
                }, 100);
            } else if (lang === 'en') {
                var host = window.location.hostname;
                document.cookie = "googtrans=/bn/en; path=/; domain=" + host;
                document.cookie = "googtrans=/bn/en; path=/; domain=." + host;
                document.cookie = "googtrans=/bn/en; path=/;";
                
                var select = document.querySelector('#google_translate_element select');
                if (select) {
                    select.value = 'en';
                    select.dispatchEvent(new Event('change'));
                } else {
                    window.location.reload();
                }
            }
        }
    
        document.addEventListener('DOMContentLoaded', function() {
            var isEnglish = document.cookie.indexOf('googtrans=/bn/en') !== -1;
            var btnBn = document.getElementById('btn-lang-bn');
            var btnEn = document.getElementById('btn-lang-en');
            if (btnBn && btnEn) {
                if (isEnglish) {
                    btnEn.classList.add('active');
                    btnBn.classList.remove('active');
                } else {
                    btnBn.classList.add('active');
                    btnEn.classList.remove('active');
                }
            }
        });

    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</head>
<body>
    @if(!empty($settings->enable_announcement) && !empty($settings->announcement_text_bn))
        <div class="top-announcement">
            {{ $settings->announcement_text_bn }}
            @if(!empty($settings->announcement_link))
                <a href="{{ $settings->announcement_link }}">{{ $settings->announcement_link_text_bn ?? 'বিস্তারিত' }} &rarr;</a>
            @endif
        </div>
    @endif

    <header class="site-header">
        <div class="site-wrap">
            <div class="header-top">
                <!-- Branding Logo Centered -->
                <div class="site-branding">
                    <a href="/"><img src="{{ asset('storage/branding/logo.png') }}" alt="{{ $siteName }}" class="site-logo-img"></a>
                    <div class="site-tagline">Independent Fact-Checking & Digital Verification<br>Initiative in Bangladesh</div>
                </div>

                <!-- Controls Row: Left (Lang + WhatsApp), Right (Hamburger) -->
                <div class="header-controls-row">
                    <!-- Left: Language Pill & WhatsApp -->
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div class="lang-pill-wrap" title="Switch Language / ভাষা পরিবর্তন">
                            <button type="button" id="btn-lang-bn" onclick="switchSiteLanguage('bn')" class="lang-pill">বাংলা</button>
                            <span class="lang-pill-divider"></span>
                            <button type="button" id="btn-lang-en" onclick="switchSiteLanguage('en')" class="lang-pill">ENG</button>
                        </div>

                        <!-- WhatsApp Icon (Clean outline SVG) -->
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number ?? '8801700000000') }}" target="_blank" rel="noopener" class="whatsapp-icon-btn" title="WhatsApp Tipline">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" stroke="#25D366" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M16.5 14.5c-.3-.2-1.7-.8-2-.9-.3-.1-.5-.1-.7.2-.2.3-.7.9-.9 1.1-.2.2-.3.2-.6.1-.3-.2-1.2-.5-2.4-1.5-.9-.8-1.5-1.7-1.7-2-.2-.3 0-.5.1-.6.1-.1.3-.3.4-.5.1-.2.2-.3.3-.5.1-.2 0-.4 0-.5-.1-.1-.7-1.6-.9-2.2-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1 2.9 1.2 3.1c.2.2 2 3.1 5 4.3.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4-.1-.2-.3-.3-.6-.5z" fill="#25D366"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Right: Hamburger Menu Button (Clean 3-bar box) -->
                    <button type="button" class="mobile-toggle-btn" onclick="toggleDrawer()" aria-label="Toggle Navigation">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" y1="6" x2="20" y2="6"></line>
                            <line x1="4" y1="12" x2="20" y2="12"></line>
                            <line x1="4" y1="18" x2="20" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Desktop Nav Menu -->
            <nav class="header-nav">
                @if(!empty($settings->header_menu))
                    @foreach($settings->header_menu as $menu)
                        <a href="{{ $menu['url'] }}">{{ $menu['label_bn'] }}</a>
                    @endforeach
                @else
                    <a href="/">হোম</a>
                    <a href="/category/politics">রাজনীতি</a>
                    <a href="/category/health">স্বাস্থ্য</a>
                    <a href="/category/ai-deepfake">ডিপফেক ও এআই</a>
                    <a href="/page/about">আমাদের সম্পর্কে</a>
                @endif
                <div class="search-box">
                    <form action="/search" method="GET" style="margin: 0; display: flex;">
                        <input type="text" name="q" placeholder="অনুসন্ধান করুন..." class="search-input" value="{{ request('q') }}">
                    </form>
                </div>
            </nav>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div id="drawerOverlay" class="mobile-drawer-overlay" onclick="toggleDrawer()"></div>
    <div id="mobileDrawer" class="mobile-drawer">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-rule); padding-bottom: 12px;">
            <span style="font-weight: 700; font-size: 16px;">মেনু</span>
            <button type="button" onclick="toggleDrawer()" style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
        </div>

        <form action="/search" method="GET" style="margin: 8px 0;">
            <input type="text" name="q" placeholder="অনুসন্ধান করুন..." class="search-input" style="width: 100%; box-sizing: border-box;" value="{{ request('q') }}">
        </form>

        @if(!empty($settings->header_menu))
            @foreach($settings->header_menu as $menu)
                <a href="{{ $menu['url'] }}">{{ $menu['label_bn'] }}</a>
            @endforeach
        @else
            <a href="/">হোম</a>
            <a href="/category/politics">রাজনীতি</a>
            <a href="/category/health">স্বাস্থ্য</a>
            <a href="/category/ai-deepfake">ডিপফেক ও এআই</a>
            <a href="/page/about">আমাদের সম্পর্কে</a>
        @endif
        <a href="/submit-claim" style="color: var(--accent-red); font-weight: 700;">দাবি পাঠান (Tipline)</a>
    </div>

    <!-- Main Content -->
    <main class="site-main">
        <div class="site-wrap">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="site-wrap">
            <div class="footer-cols">
                <!-- Col 1: About & Social Icons -->
                <div>
                    <h4 style="font-size: 15px; font-weight: 700; color: #111; margin-bottom: 12px;">{{ $siteName }}</h4>
                    <p style="margin-bottom: 16px; max-width: 380px; line-height: 1.6;">{{ $tagline }}</p>
                    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                        @if(!empty($settings->social_links))
                            @foreach($settings->social_links as $item)
                                @php
                                    $p = strtolower($item['platform'] ?? '');
                                    $url = $item['url'] ?? '#';
                                @endphp
                                @if(str_contains($p, 'facebook'))
                                    <a href="{{ $url }}" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 50%; background: #1877F2; color: #FFF;" title="Facebook">
                                        <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </a>
                                @elseif(str_contains($p, 'twitter') || str_contains($p, 'x'))
                                    <a href="{{ $url }}" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 50%; background: #000; color: #FFF;" title="X (Twitter)">
                                        <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 22.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    </a>
                                @elseif(str_contains($p, 'youtube'))
                                    <a href="{{ $url }}" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 50%; background: #FF0000; color: #FFF;" title="YouTube">
                                        <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    </a>
                                @elseif(str_contains($p, 'linkedin'))
                                    <a href="{{ $url }}" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 50%; background: #0A66C2; color: #FFF;" title="LinkedIn">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9v8.37h2.79V10.9H6.46M7.86 6.5a1.63 1.63 0 0 0-1.63 1.63c0 .9.73 1.63 1.63 1.63.9 0 1.63-.73 1.63-1.63C9.49 7.23 8.76 6.5 7.86 6.5Z"/></svg>
                                    </a>
                                @elseif(str_contains($p, 'instagram'))
                                    <a href="{{ $url }}" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 50%; background: #E4405F; color: #FFF;" title="Instagram">
                                        <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    </a>
                                @endif
                            @endforeach
                        @else
                            <a href="https://facebook.com" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 50%; background: #1877F2; color: #FFF;"><svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                            <a href="https://x.com" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 50%; background: #000; color: #FFF;"><svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 22.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                            <a href="https://youtube.com" target="_blank" rel="noopener" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 50%; background: #FF0000; color: #FFF;"><svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                        @endif
                    </div>
                </div>

                <!-- Col 2: Policy & Editorial Principles -->
                <div class="footer-col">
                    <h4>প্রাতিষ্ঠানিক নীতি</h4>
                    <ul>
                        @if(!empty($settings->footer_columns[0]['links']))
                            @foreach($settings->footer_columns[0]['links'] as $link)
                                <li><a href="{{ $link['url'] }}">{{ $link['label_bn'] }}</a></li>
                            @endforeach
                        @else
                            <li><a href="/page/methodology">অনুসন্ধান পদ্ধতি</a></li>
                            <li><a href="/page/funding">অর্থায়ন ও মালিকানা</a></li>
                            <li><a href="/page/corrections">সংশোধন নীতি</a></li>
                            <li><a href="/page/editorial-policy">নিরপেক্ষতা নীতি</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Col 3: Legal & Contact -->
                <div class="footer-col">
                    <h4>আইনি ও যোগাযোগ</h4>
                    <ul>
                        @if(!empty($settings->footer_columns[1]['links']))
                            @foreach($settings->footer_columns[1]['links'] as $link)
                                <li><a href="{{ $link['url'] }}">{{ $link['label_bn'] }}</a></li>
                            @endforeach
                        @else
                            <li><a href="/page/about">আমাদের সম্পর্কে</a></li>
                            <li><a href="/page/contact">যোগাযোগ</a></li>
                            <li><a href="/page/privacy">গোপনীয়তা নীতি</a></li>
                            <li><a href="/submit-claim">দাবি জমা দিন</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>{{ $settings->copyright_text_bn ?? '© ২০২৬ ফ্যাক্টচেক বাংলাদেশ। সর্বস্বত্ব সংরক্ষিত। ইন্টারন্যাশনাল ফ্যাক্ট-চেকিং নেটওয়ার্ক (IFCN) নীতিমালা অনুসরণে পরিচালিত।' }}</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleDrawer() {
            const drawer = document.getElementById('mobileDrawer');
            const overlay = document.getElementById('drawerOverlay');
            if (drawer.classList.contains('open')) {
                drawer.classList.remove('open');
                overlay.style.display = 'none';
            } else {
                drawer.classList.add('open');
                overlay.style.display = 'block';
            }
        }
    </script>
</body>
</html>
