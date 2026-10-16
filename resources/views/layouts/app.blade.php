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
        <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Core Styles -->
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
            overflow-x: clip !important;
            position: relative;
            background-color: var(--bg-color);
            color: var(--text-dark);
            font-family: var(--font-serif);
            margin: 0 !important;
            padding: 0 !important;
            top: 0px !important;
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

        /* -------------------------------------------------------------
           TOP ANNOUNCEMENT BAR
           - Height max 36px, small text
           - Dismissible via localStorage
           - Hidden on mobile (<768px)
           ------------------------------------------------------------- */
        .top-announcement {
            background: #111111;
            color: #FFFFFF;
            font-family: var(--font-ui);
            font-size: 12.5px;
            border-bottom: 1px solid #222222;
            width: 100%;
            height: 36px;
            max-height: 36px;
            box-sizing: border-box;
            overflow: hidden;
            display: block;
        }

        .top-announcement.dismissed {
            display: none !important;
        }

        .top-announcement-inner {
            max-width: 1080px;
            margin: 0 auto;
            padding: 0 16px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-sizing: border-box;
        }

        .top-announcement-text {
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            padding-right: 28px;
            font-size: 12.5px;
            line-height: 36px;
        }

        .top-announcement a {
            display: inline-block;
            color: #FACC15 !important;
            text-decoration: underline !important;
            margin-left: 6px;
            font-weight: 700;
        }

        .top-announcement-close {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #999999;
            font-size: 19px;
            line-height: 1;
            cursor: pointer;
            padding: 4px 6px;
            transition: color 0.15s ease;
        }

        .top-announcement-close:hover {
            color: #FFFFFF;
        }

        @media (max-width: 767px) {
            .top-announcement {
                display: block !important;
                height: auto !important;
                max-height: none !important;
            }
            .top-announcement-inner {
                height: auto !important;
                padding: 7px 12px !important;
            }
            .top-announcement-text {
                font-size: 11.5px !important;
                line-height: 1.45 !important;
                white-space: normal !important;
                padding-right: 22px !important;
            }
            .top-announcement-close {
                right: 8px !important;
                font-size: 17px !important;
            }
        }

        /* -------------------------------------------------------------
           SITE HEADER BASE (Sticky, no shadow, clean 1px border)
           ------------------------------------------------------------- */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: #FFFFFF !important;
            border-bottom: 1px solid #E5E5E0 !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            width: 100%;
        }

        /* -------------------------------------------------------------
           DESKTOP & TABLET HEADER (min-width: 768px)
           Compact 1-row layout (64-72px, 56px when scrolled)
           ------------------------------------------------------------- */
        .desktop-header-wrap {
            display: none; /* hidden on mobile */
            align-items: center;
            gap: 32px;
            max-width: 1080px;
            margin: 0 auto;
            padding: 0 16px;
            height: 68px;
            box-sizing: border-box;
            transition: height 0.2s ease;
        }

        .site-header.header-scrolled .desktop-header-wrap {
            height: 56px;
        }

        .desktop-logo-link {
            display: inline-flex;
            align-items: center;
            flex-shrink: 0;
        }

        .desktop-logo-img {
            height: 38px;
            max-height: 40px;
            width: auto;
            display: block;
            object-fit: contain;
            transition: height 0.2s ease;
        }

        .site-header.header-scrolled .desktop-logo-img {
            height: 32px;
        }

        /* Desktop Nav: flex: 1, left-aligned */
        .desktop-nav {
            display: flex;
            align-items: center;
            gap: 22px;
            flex: 1;
            height: 100%;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .desktop-nav a {
            font-family: var(--font-ui);
            font-size: 16px;
            font-weight: 600;
            color: #111111;
            text-decoration: none;
            padding: 0;
            height: 100%;
            display: inline-flex;
            align-items: center;
            border-bottom: 2px solid transparent;
            transition: color 0.15s ease, border-color 0.15s ease;
            white-space: nowrap;
            box-sizing: border-box;
        }

        .desktop-nav a:hover,
        .desktop-nav a.active {
            color: #B3261E;
            border-bottom-color: #B3261E;
        }

        /* Right Side: Search, Lang Toggle, Claim Button */
        .desktop-header-right {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-left: auto;
            flex-shrink: 0;
            height: 100%;
        }

        /* Expandable Search Icon */
        .desktop-search-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .desktop-search-btn {
            background: transparent;
            border: none;
            padding: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #111111;
            border-radius: 2px;
            transition: color 0.15s ease;
        }

        .desktop-search-btn:hover {
            color: #B3261E;
        }

        .desktop-search-form {
            display: none;
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background: #FFFFFF;
            border: 1px solid #E5E5E0;
            border-radius: 2px;
            padding: 3px 8px 3px 12px;
            align-items: center;
            width: 260px;
            z-index: 60;
            box-sizing: border-box;
        }

        .desktop-search-form.open {
            display: flex;
        }

        .desktop-search-input {
            border: none;
            outline: none;
            background: transparent;
            font-family: var(--font-ui);
            font-size: 13.5px;
            width: 100%;
            padding: 5px 0;
            color: #111111;
        }

        .desktop-search-close {
            background: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #777777;
            padding: 0 4px;
            line-height: 1;
        }

        .desktop-search-close:hover {
            color: #111111;
        }

        /* Language Toggle: small, plain text style */
        .desktop-lang-toggle {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-family: var(--font-ui);
            font-size: 13.5px;
            font-weight: 600;
            color: #555555;
            user-select: none;
        }

        .desk-lang-btn {
            background: transparent;
            border: none;
            padding: 2px 2px;
            font-family: var(--font-ui);
            font-size: 13.5px;
            font-weight: 600;
            color: #555555;
            cursor: pointer;
            transition: color 0.15s ease;
        }

        .desk-lang-btn:hover {
            color: #111111;
        }

        .desk-lang-btn.active {
            color: #B3261E !important;
            font-weight: 700 !important;
        }

        .desk-lang-sep {
            color: #CCCCCC;
            font-size: 12px;
        }

        /* "দাবি পাঠান" Button: 40px height, 1px border/solid accent, border-radius max 2px */
        .desktop-claim-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            padding: 0 16px;
            background: #B3261E;
            color: #FFFFFF !important;
            border: 1px solid #B3261E;
            border-radius: 2px;
            font-family: var(--font-ui);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            box-sizing: border-box;
            transition: background 0.15s ease, border-color 0.15s ease, height 0.2s ease;
        }

        .site-header.header-scrolled .desktop-claim-btn {
            height: 36px;
        }

        .desktop-claim-btn:hover {
            background: #961F18;
            border-color: #961F18;
            color: #FFFFFF !important;
        }

        /* Tablet Hamburger Button (768px - 1023px) */
        .tablet-hamburger-btn {
            display: none;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            background: #FFFFFF;
            border: 1px solid #D1D5DB;
            border-radius: 2px;
            cursor: pointer;
            padding: 0;
            color: #111111;
        }

        /* Breakpoints for Tablet & Desktop */
        @media (min-width: 768px) and (max-width: 1023px) {
            .desktop-header-wrap {
                display: flex !important;
                gap: 16px;
            }
            .desktop-nav {
                display: none !important;
            }
            .tablet-hamburger-btn {
                display: inline-flex !important;
            }
            .desktop-header-right {
                gap: 14px;
            }
        }

        @media (min-width: 1024px) {
            .desktop-header-wrap {
                display: flex !important;
            }
            .desktop-nav {
                display: flex !important;
            }
            .tablet-hamburger-btn {
                display: none !important;
            }
        }

        @media (min-width: 768px) {
            .mobile-header-wrap {
                display: none !important;
            }
        }

        /* -------------------------------------------------------------
           MOBILE HEADER (<768px) — UNTOUCHED & IDENTICAL
           ------------------------------------------------------------- */
        @media (max-width: 767px) {
            .desktop-header-wrap {
                display: none !important;
            }
            .mobile-header-wrap {
                display: block !important;
                padding: 16px 0 14px 0;
            }
        }

        .mobile-header-wrap .header-top {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
        }

        .mobile-header-wrap .site-branding {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
        }

        .mobile-header-wrap .site-logo-img {
            max-height: 85px !important;
            width: auto !important;
            display: block !important;
            margin: 0 auto !important;
            object-fit: contain !important;
        }

        .mobile-header-wrap .site-tagline {
            font-family: var(--font-ui) !important;
            font-size: 13px !important;
            color: #4B5563 !important;
            margin-top: 8px !important;
            line-height: 1.45 !important;
            max-width: 320px !important;
            text-align: center !important;
        }

        .mobile-header-wrap .header-controls-row {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            margin-top: 24px !important;
            padding-top: 14px !important;
            border-top: 1px solid #E5E7EB !important;
            box-sizing: border-box !important;
        }

        .mobile-header-wrap .lang-pill-wrap {
            display: inline-flex !important;
            align-items: center !important;
            background: #F3F4F6 !important;
            border: 1px solid #E5E7EB !important;
            border-radius: 6px !important;
            padding: 2px !important;
        }

        .mobile-header-wrap .lang-pill {
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

        .mobile-header-wrap .lang-pill.active {
            background: #FFFFFF !important;
            color: #DC2626 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.08) !important;
        }

        .mobile-header-wrap .lang-pill-divider {
            width: 1px;
            height: 14px;
            background: #E5E7EB;
            margin: 0 1px;
        }

        .mobile-header-wrap .whatsapp-icon-btn {
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

        .mobile-header-wrap .mobile-toggle-btn {
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

        @media (max-width: 991px) {
            .footer-cols { grid-template-columns: 1fr; gap: 28px; }
            .footer-bottom { flex-direction: column; gap: 14px; text-align: center; }
            .home-grid { grid-template-columns: 1fr !important; gap: 32px !important; }
        }

        /* Google Translate & Frame Clean Suppression */
        .goog-te-banner-frame, 
        .goog-te-banner-frame.skiptranslate, 
        iframe.goog-te-banner-frame,
        .VIpgJd-ZVi9od-ORHb-OEVmcb,
        .VIpgJd-ZVi9od-aZ2wEe-wOHMyf,
        .VIpgJd-ZVi9od-aZ2wEe-wOHMyf-ti6hGc,
        #goog-gt-tt,
        .goog-te-balloon-frame,
        .skiptranslate,
        iframe.skiptranslate,
        body > .skiptranslate {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            width: 0 !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }

        .goog-tooltip, .goog-tooltip:hover {
            display: none !important;
        }

        .goog-text-highlight {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        #google_translate_element {
            display: none !important;
            position: absolute !important;
            top: -9999px !important;
            left: -9999px !important;
            height: 0 !important;
            width: 0 !important;
        }
    </style>
</head>
<body>
    @if(!empty($settings->enable_announcement) && !empty($settings->announcement_text_bn))
        <div id="topAnnouncementBar" class="top-announcement">
            <div class="top-announcement-inner">
                <div class="top-announcement-text">
                    {{ $settings->announcement_text_bn }}
                    @if(!empty($settings->announcement_link))
                        <a href="{{ $settings->announcement_link }}">{{ $settings->announcement_link_text_bn ?? 'বিস্তারিত' }} &rarr;</a>
                    @endif
                </div>
                <button type="button" class="top-announcement-close" onclick="dismissAnnouncement()" aria-label="Dismiss Notice">&times;</button>
            </div>
        </div>
    @endif

    <header class="site-header">
        <!-- DESKTOP & TABLET HEADER (min-width: 768px) -->
        <div class="desktop-header-wrap">
            <!-- Left: Logo (36-40px height) -->
            <a href="/" class="desktop-logo-link" title="{{ $siteName }}">
                <img src="{{ !empty($settings->logo_light) ? asset('storage/' . $settings->logo_light) : asset('storage/branding/logo.png') }}" alt="{{ $siteName }}" class="desktop-logo-img">
            </a>

            <!-- Tablet Hamburger Toggle (768px - 1023px) -->
            <button type="button" class="tablet-hamburger-btn" onclick="toggleDrawer()" aria-label="Toggle Navigation">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="6" x2="20" y2="6"></line>
                    <line x1="4" y1="12" x2="20" y2="12"></line>
                    <line x1="4" y1="18" x2="20" y2="18"></line>
                </svg>
            </button>

            <!-- Desktop Nav (flex: 1, left-aligned) -->
            <nav class="desktop-nav">
                @if(!empty($settings->header_menu))
                    @foreach($settings->header_menu as $menu)
                        <a href="{{ $menu['url'] }}" class="{{ request()->is(ltrim($menu['url'], '/') . '*') ? 'active' : '' }}">{{ $menu['label_bn'] }}</a>
                    @endforeach
                @else
                    <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">হোম</a>
                    <a href="/category/politics" class="{{ request()->is('category/politics*') ? 'active' : '' }}">রাজনীতি</a>
                    <a href="/category/health" class="{{ request()->is('category/health*') ? 'active' : '' }}">স্বাস্থ্য</a>
                    <a href="/category/ai-deepfake" class="{{ request()->is('category/ai-deepfake*') ? 'active' : '' }}">ডিপফেক ও এআই</a>
                    <a href="/page/about" class="{{ request()->is('page/about*') ? 'active' : '' }}">আমাদের সম্পর্কে</a>
                @endif
            </nav>

            <!-- Right: Search, Language Switcher, "দাবি পাঠান" button -->
            <div class="desktop-header-right">
                <!-- Search Icon with expandable input -->
                <div class="desktop-search-wrap" id="desktopSearchWrap">
                    <button type="button" class="desktop-search-btn" onclick="toggleDesktopSearch()" aria-label="অনুসন্ধান">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                    <form action="/search" method="GET" class="desktop-search-form" id="desktopSearchForm">
                        <input type="text" name="q" placeholder="অনুসন্ধান করুন..." class="desktop-search-input" id="desktopSearchInput" value="{{ request('q') }}">
                        <button type="button" class="desktop-search-close" onclick="toggleDesktopSearch()">&times;</button>
                    </form>
                </div>

                <!-- Language Toggle: small, plain text style -->
                <div class="desktop-lang-toggle notranslate" translate="no" title="Switch Language / ভাষা পরিবর্তন">
                    <button type="button" id="desk-btn-lang-bn" onclick="switchSiteLanguage('bn')" class="desk-lang-btn active">বাংলা</button>
                    <span class="desk-lang-sep">|</span>
                    <button type="button" id="desk-btn-lang-en" onclick="switchSiteLanguage('en')" class="desk-lang-btn">ENG</button>
                </div>

                <!-- "দাবি পাঠান" Button (40px height, 1px border/solid accent, border-radius max 2px) -->
                <a href="/submit-claim" class="desktop-claim-btn notranslate">দাবি পাঠান</a>
            </div>
        </div>

        <!-- MOBILE HEADER (<768px) — UNTOUCHED & IDENTICAL -->
        <div class="mobile-header-wrap">
            <div class="site-wrap">
                <div class="header-top">
                    <!-- Branding Logo Centered -->
                    <div class="site-branding">
                        <a href="/"><img src="{{ !empty($settings->logo_light) ? asset('storage/' . $settings->logo_light) : asset('storage/branding/logo.png') }}" alt="{{ $siteName }}" class="site-logo-img"></a>
                        <div class="site-tagline">Independent Fact-Checking & Digital Verification<br>Initiative in Bangladesh</div>
                    </div>

                    <!-- Controls Row: Left (Lang + WhatsApp), Right (Hamburger) -->
                    <div class="header-controls-row">
                        <!-- Left: Language Pill & WhatsApp -->
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="lang-pill-wrap notranslate" translate="no" title="Switch Language / ভাষা পরিবর্তন">
                                <button type="button" id="btn-lang-bn" onclick="switchSiteLanguage('bn')" class="lang-pill">বাংলা</button>
                                <span class="lang-pill-divider"></span>
                                <button type="button" id="btn-lang-en" onclick="switchSiteLanguage('en')" class="lang-pill">ENG</button>
                            </div>

                            <!-- WhatsApp Icon (FontAwesome Official) -->
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number ?? '8801700000000') }}" target="_blank" rel="noopener" class="whatsapp-icon-btn notranslate" title="WhatsApp Tipline" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                <i class="fa-brands fa-whatsapp" style="color: rgb(10, 113, 4); font-size: 27px; line-height: 1;"></i>
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
            </div>
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
                    <p style="margin-bottom: 8px; max-width: 380px; line-height: 1.6;">{{ $tagline }}</p>
                    <p style="font-size: 12px; color: #666666; margin-top: 0; margin-bottom: 16px; line-height: 1.4;">Independent Fact-Checking &amp; Digital Verification Initiative in Bangladesh</p>
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

    

    <!-- Bottom Google Translate Scripts & Layout Handlers -->
    <div id="google_translate_element" style="display:none !important; visibility:hidden !important; position:absolute; top:-9999px; left:-9999px; width:0; height:0;"></div>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'bn',
                includedLanguages: 'en,bn',
                autoDisplay: false
            }, 'google_translate_element');
        }

        function switchSiteLanguage(lang) {
            var btnBn = document.getElementById('btn-lang-bn');
            var btnEn = document.getElementById('btn-lang-en');
            var deskBtnBn = document.getElementById('desk-btn-lang-bn');
            var deskBtnEn = document.getElementById('desk-btn-lang-en');
            var host = window.location.hostname;

            if (lang === 'en') {
                if (btnEn) btnEn.classList.add('active');
                if (btnBn) btnBn.classList.remove('active');
                if (deskBtnEn) deskBtnEn.classList.add('active');
                if (deskBtnBn) deskBtnBn.classList.remove('active');

                var d = new Date();
                d.setTime(d.getTime() + (365*24*60*60*1000));
                var exp = "; expires=" + d.toUTCString();
                document.cookie = "googtrans=/bn/en; path=/; domain=" + host + exp;
                document.cookie = "googtrans=/bn/en; path=/; domain=." + host + exp;
                document.cookie = "googtrans=/bn/en; path=/" + exp;

                var select = document.querySelector('.goog-te-combo');
                if (select) {
                    select.value = 'en';
                    select.dispatchEvent(new Event('change'));
                } else {
                    window.location.reload();
                }
            } else {
                if (btnBn) btnBn.classList.add('active');
                if (btnEn) btnEn.classList.remove('active');
                if (deskBtnBn) deskBtnBn.classList.add('active');
                if (deskBtnEn) deskBtnEn.classList.remove('active');

                var paths = ['/', '/page', '/article', '/category'];
                ['googtrans', '__googtrans'].forEach(function(cName) {
                    paths.forEach(function(p) {
                        document.cookie = cName + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=' + p + ';';
                        document.cookie = cName + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=' + p + '; domain=' + host + ';';
                        document.cookie = cName + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=' + p + '; domain=.' + host + ';';
                    });
                });

                var select = document.querySelector('.goog-te-combo');
                if (select) {
                    select.value = 'bn';
                    select.dispatchEvent(new Event('change'));
                }
                setTimeout(function() {
                    window.location.href = window.location.pathname;
                }, 100);
            }
        }

        function syncActivePill() {
            var isEn = document.cookie.indexOf('googtrans=/bn/en') !== -1;
            var btnBn = document.getElementById('btn-lang-bn');
            var btnEn = document.getElementById('btn-lang-en');
            var deskBtnBn = document.getElementById('desk-btn-lang-bn');
            var deskBtnEn = document.getElementById('desk-btn-lang-en');

            if (isEn) {
                if (btnEn) btnEn.classList.add('active');
                if (btnBn) btnBn.classList.remove('active');
                if (deskBtnEn) deskBtnEn.classList.add('active');
                if (deskBtnBn) deskBtnBn.classList.remove('active');
            } else {
                if (btnBn) btnBn.classList.add('active');
                if (btnEn) btnEn.classList.remove('active');
                if (deskBtnBn) deskBtnBn.classList.add('active');
                if (deskBtnEn) deskBtnEn.classList.remove('active');
            }
        }

        document.addEventListener('DOMContentLoaded', syncActivePill);
        window.addEventListener('load', syncActivePill);

        // Sticky Header scroll height handler
        window.addEventListener('scroll', function() {
            var header = document.querySelector('.site-header');
            if (header) {
                if (window.scrollY > 30) {
                    header.classList.add('header-scrolled');
                } else {
                    header.classList.remove('header-scrolled');
                }
            }
        }, { passive: true });

        // Announcement dismissal via sessionStorage (reappears next browser session)
        function checkAnnouncementDismissal() {
            try {
                localStorage.removeItem('fc_announcement_dismissed'); // clear permanent legacy key
                if (sessionStorage.getItem('fc_announcement_dismissed') === '1') {
                    var el = document.getElementById('topAnnouncementBar');
                    if (el) el.classList.add('dismissed');
                }
            } catch (e) {}
        }
        function dismissAnnouncement() {
            var el = document.getElementById('topAnnouncementBar');
            if (el) el.classList.add('dismissed');
            try {
                sessionStorage.setItem('fc_announcement_dismissed', '1');
            } catch (e) {}
        }
        document.addEventListener('DOMContentLoaded', checkAnnouncementDismissal);

        // Expandable desktop search toggle
        function toggleDesktopSearch() {
            var form = document.getElementById('desktopSearchForm');
            var input = document.getElementById('desktopSearchInput');
            if (form) {
                form.classList.toggle('open');
                if (form.classList.contains('open') && input) {
                    input.focus();
                }
            }
        }
        document.addEventListener('click', function(e) {
            var wrap = document.getElementById('desktopSearchWrap');
            var form = document.getElementById('desktopSearchForm');
            if (wrap && form && !wrap.contains(e.target)) {
                form.classList.remove('open');
            }
        });
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

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
