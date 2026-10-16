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
    <title>@yield('title', $siteName . ' - ' . $tagline)</title>
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="theme-color" content="#111111">
    <meta name="description" content="@yield('meta_description', $settings->meta_description_bn ?? $tagline)">

    <!-- Open Graph / Facebook -->
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('meta_title', $siteName . ' - ' . $tagline)">
    <meta property="og:description" content="@yield('meta_description', $settings->meta_description_bn ?? $tagline)">
    <meta property="og:image" content="@yield('og_image', !empty($settings->logo_light) ? asset('storage/' . $settings->logo_light) : asset('storage/branding/logo.png'))">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('meta_title', $siteName . ' - ' . $tagline)">
    <meta name="twitter:description" content="@yield('meta_description', $settings->meta_description_bn ?? $tagline)">
    <meta name="twitter:image" content="@yield('og_image', !empty($settings->logo_light) ? asset('storage/' . $settings->logo_light) : asset('storage/branding/logo.png'))">

    <!-- Favicon & Icons -->
    @if(!empty($settings->favicon))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings->favicon) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . $settings->favicon) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('storage/branding/logo.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/branding/logo.png') }}">
    @endif

    <!-- Optimized Self-Hosted Font & Image Preloads -->
    <link rel="preload" href="/fonts/font_00_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4I3mYvNY.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/font_02_hYkhPvggTvnzO14VSXltirUdnnkt1pwmWrprmO7RjE0a5BtdKyg8JCJZ.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/font_01_hYkhPvggTvnzO14VSXltirUdnnkt1pwmWrprmO7RjE0a5BtdKzo8JA.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/font_05_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4MXmY.woff2" as="font" type="font/woff2" crossorigin>
    @yield('head_preloads')
    @php
        $preloadLogo = !empty($settings->logo_light) ? asset('storage/' . $settings->logo_light) : asset('storage/branding/logo.png');
        $preloadLogoWebp = preg_replace('/\.(png|jpe?g)$/i', '.webp', $preloadLogo);
        $preloadLogoMobileWebp = preg_replace('/\.(png|jpe?g)$/i', '_mobile.webp', $preloadLogo);
    @endphp
    <link rel="preload" href="{{ $preloadLogoMobileWebp }}" as="image" type="image/webp" media="(max-width: 767px)" fetchpriority="high">
    <link rel="preload" href="{{ $preloadLogoWebp }}" as="image" type="image/webp" media="(min-width: 768px)" fetchpriority="high">

    <!-- Core Styles -->
    <style>
@font-face{font-family:'Noto Sans Bengali';font-style:normal;font-weight:400;font-stretch:100%;font-display:swap;src:url(/fonts/font_00_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4I3mYvNY.woff2) format('woff2');unicode-range:U+0951-0952,U+0964-0965,U+0980-09FE,U+1CD0,U+1CD2,U+1CD5-1CD6,U+1CD8,U+1CE1,U+1CEA,U+1CED,U+1CF2,U+1CF5-1CF7,U+200C-200D,U+20B9,U+25CC,U+A8F1,U+11DF0-11DF1}@font-face{font-family:'Noto Sans Bengali';font-style:normal;font-weight:400;font-stretch:100%;font-display:swap;src:url(/fonts/font_04_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4P3mYvNY.woff2) format('woff2');unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C4,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Noto Sans Bengali';font-style:normal;font-weight:400;font-stretch:100%;font-display:swap;src:url(/fonts/font_05_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4MXmY.woff2) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}@font-face{font-family:'Noto Sans Bengali';font-style:normal;font-weight:500;font-stretch:100%;font-display:swap;src:url(/fonts/font_00_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4I3mYvNY.woff2) format('woff2');unicode-range:U+0951-0952,U+0964-0965,U+0980-09FE,U+1CD0,U+1CD2,U+1CD5-1CD6,U+1CD8,U+1CE1,U+1CEA,U+1CED,U+1CF2,U+1CF5-1CF7,U+200C-200D,U+20B9,U+25CC,U+A8F1,U+11DF0-11DF1}@font-face{font-family:'Noto Sans Bengali';font-style:normal;font-weight:500;font-stretch:100%;font-display:swap;src:url(/fonts/font_04_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4P3mYvNY.woff2) format('woff2');unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C4,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Noto Sans Bengali';font-style:normal;font-weight:500;font-stretch:100%;font-display:swap;src:url(/fonts/font_05_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4MXmY.woff2) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}@font-face{font-family:'Noto Sans Bengali';font-style:normal;font-weight:600;font-stretch:100%;font-display:swap;src:url(/fonts/font_00_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4I3mYvNY.woff2) format('woff2');unicode-range:U+0951-0952,U+0964-0965,U+0980-09FE,U+1CD0,U+1CD2,U+1CD5-1CD6,U+1CD8,U+1CE1,U+1CEA,U+1CED,U+1CF2,U+1CF5-1CF7,U+200C-200D,U+20B9,U+25CC,U+A8F1,U+11DF0-11DF1}@font-face{font-family:'Noto Sans Bengali';font-style:normal;font-weight:600;font-stretch:100%;font-display:swap;src:url(/fonts/font_04_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4P3mYvNY.woff2) format('woff2');unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C4,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Noto Sans Bengali';font-style:normal;font-weight:600;font-stretch:100%;font-display:swap;src:url(/fonts/font_05_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4MXmY.woff2) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}@font-face{font-family:'Noto Sans Bengali';font-style:normal;font-weight:700;font-stretch:100%;font-display:swap;src:url(/fonts/font_00_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4I3mYvNY.woff2) format('woff2');unicode-range:U+0951-0952,U+0964-0965,U+0980-09FE,U+1CD0,U+1CD2,U+1CD5-1CD6,U+1CD8,U+1CE1,U+1CEA,U+1CED,U+1CF2,U+1CF5-1CF7,U+200C-200D,U+20B9,U+25CC,U+A8F1,U+11DF0-11DF1}@font-face{font-family:'Noto Sans Bengali';font-style:normal;font-weight:700;font-stretch:100%;font-display:swap;src:url(/fonts/font_04_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4P3mYvNY.woff2) format('woff2');unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C4,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Noto Sans Bengali';font-style:normal;font-weight:700;font-stretch:100%;font-display:swap;src:url(/fonts/font_05_Cn-fJsCGWQxOjaGwMQ6fIiMywrNJIky6nvd8BjzVMvJx2mc4MXmY.woff2) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}@font-face{font-family:'Noto Serif Bengali';font-style:normal;font-weight:400;font-stretch:100%;font-display:swap;src:url(/fonts/font_02_hYkhPvggTvnzO14VSXltirUdnnkt1pwmWrprmO7RjE0a5BtdKyg8JCJZ.woff2) format('woff2');unicode-range:U+0951-0952,U+0964-0965,U+0980-09FE,U+1CD0,U+1CD2,U+1CD5-1CD6,U+1CD8,U+1CE1,U+1CEA,U+1CED,U+1CF2,U+1CF5-1CF7,U+200C-200D,U+20B9,U+25CC,U+A8F1,U+11DF0-11DF1}@font-face{font-family:'Noto Serif Bengali';font-style:normal;font-weight:400;font-stretch:100%;font-display:swap;src:url(/fonts/font_03_hYkhPvggTvnzO14VSXltirUdnnkt1pwmWrprmO7RjE0a5BtdKzQ8JCJZ.woff2) format('woff2');unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C4,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Noto Serif Bengali';font-style:normal;font-weight:400;font-stretch:100%;font-display:swap;src:url(/fonts/font_01_hYkhPvggTvnzO14VSXltirUdnnkt1pwmWrprmO7RjE0a5BtdKzo8JA.woff2) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}@font-face{font-family:'Noto Serif Bengali';font-style:normal;font-weight:600;font-stretch:100%;font-display:swap;src:url(/fonts/font_02_hYkhPvggTvnzO14VSXltirUdnnkt1pwmWrprmO7RjE0a5BtdKyg8JCJZ.woff2) format('woff2');unicode-range:U+0951-0952,U+0964-0965,U+0980-09FE,U+1CD0,U+1CD2,U+1CD5-1CD6,U+1CD8,U+1CE1,U+1CEA,U+1CED,U+1CF2,U+1CF5-1CF7,U+200C-200D,U+20B9,U+25CC,U+A8F1,U+11DF0-11DF1}@font-face{font-family:'Noto Serif Bengali';font-style:normal;font-weight:600;font-stretch:100%;font-display:swap;src:url(/fonts/font_03_hYkhPvggTvnzO14VSXltirUdnnkt1pwmWrprmO7RjE0a5BtdKzQ8JCJZ.woff2) format('woff2');unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C4,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Noto Serif Bengali';font-style:normal;font-weight:600;font-stretch:100%;font-display:swap;src:url(/fonts/font_01_hYkhPvggTvnzO14VSXltirUdnnkt1pwmWrprmO7RjE0a5BtdKzo8JA.woff2) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}@font-face{font-family:'Noto Serif Bengali';font-style:normal;font-weight:700;font-stretch:100%;font-display:swap;src:url(/fonts/font_02_hYkhPvggTvnzO14VSXltirUdnnkt1pwmWrprmO7RjE0a5BtdKyg8JCJZ.woff2) format('woff2');unicode-range:U+0951-0952,U+0964-0965,U+0980-09FE,U+1CD0,U+1CD2,U+1CD5-1CD6,U+1CD8,U+1CE1,U+1CEA,U+1CED,U+1CF2,U+1CF5-1CF7,U+200C-200D,U+20B9,U+25CC,U+A8F1,U+11DF0-11DF1}@font-face{font-family:'Noto Serif Bengali';font-style:normal;font-weight:700;font-stretch:100%;font-display:swap;src:url(/fonts/font_03_hYkhPvggTvnzO14VSXltirUdnnkt1pwmWrprmO7RjE0a5BtdKzQ8JCJZ.woff2) format('woff2');unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C4,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Noto Serif Bengali';font-style:normal;font-weight:700;font-stretch:100%;font-display:swap;src:url(/fonts/font_01_hYkhPvggTvnzO14VSXltirUdnnkt1pwmWrprmO7RjE0a5BtdKzo8JA.woff2) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}picture{display:block;width:100%}.desktop-logo-img,.mobile-logo-img{aspect-ratio:auto}.lead-headline{font-size:28px;font-weight:700;line-height:1.35;margin-bottom:12px}.skip-link{position:absolute;top:-100px;left:16px;background:#B3261E;color:#ffffff !important;padding:10px 18px;z-index:99999;font-family:var(--font-ui);font-size:14px;font-weight:600;text-decoration:none;border-radius:2px;box-shadow:0 4px 12px rgba(0,0,0,0.15);transition:top 0.2s ease}.skip-link:focus{top:16px;outline:2px solid #111}:root{--bg-color:#FAFAF7;--text-dark:#111111;--text-muted:#555555;--border-rule:#E5E5E0;--accent-red:#B3261E;--font-serif:'Noto Serif Bengali',Georgia,serif;--font-ui:'Noto Sans Bengali',-apple-system,BlinkMacSystemFont,sans-serif}html,body{max-width:100vw !important;overflow-x:clip !important;position:relative;background-color:var(--bg-color);color:var(--text-dark);font-family:var(--font-serif);margin:0 !important;padding:0 !important;top:0px !important;-webkit-font-smoothing:antialiased}*,*:before,*:after{box-sizing:border-box !important}.site-wrap{max-width:1080px;margin:0 auto;padding:0 20px;box-sizing:border-box;width:100%}a{color:inherit;text-decoration:none}.top-announcement{background:#111111;color:#FFFFFF;font-family:var(--font-ui);font-size:12.5px;border-bottom:1px solid #222222;width:100%;height:36px;max-height:36px;box-sizing:border-box;overflow:hidden;display:block}.top-announcement.dismissed{display:none !important}.top-announcement-inner{max-width:1080px;margin:0 auto;padding:0 16px;height:36px;display:flex;align-items:center;justify-content:center;position:relative;box-sizing:border-box}.top-announcement-text{text-align:center;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;padding-right:28px;font-size:12.5px;line-height:36px}.top-announcement a{display:inline-block;color:#FACC15 !important;text-decoration:underline !important;margin-left:6px;font-weight:700}.top-announcement-close{position:absolute;right:14px;top:50%;transform:translateY(-50%);background:transparent;border:none;color:#999999;font-size:19px;line-height:1;cursor:pointer;padding:4px 6px;transition:color 0.15s ease}.top-announcement-close:hover{color:#FFFFFF}@media (max-width:767px){.top-announcement{display:block !important;height:36px !important;max-height:36px !important;overflow:hidden !important;box-sizing:border-box !important}.top-announcement-inner{height:36px !important;padding:0 46px 0 12px !important;display:flex !important;align-items:center !important;justify-content:flex-start !important;position:relative !important;box-sizing:border-box !important}.top-announcement-text{font-size:13px !important;line-height:36px !important;white-space:nowrap !important;overflow:hidden !important;text-overflow:ellipsis !important;text-align:left !important;padding:0 !important;margin:0 !important;width:100% !important}.desktop-announcement-text{display:none !important}.mobile-announcement-text{display:inline !important}.top-announcement-close{position:absolute !important;right:0 !important;top:50% !important;transform:translateY(-50%) !important;width:44px !important;height:44px !important;min-width:44px !important;min-height:44px !important;display:inline-flex !important;align-items:center !important;justify-content:center !important;font-size:20px !important;color:#888888 !important;background:transparent !important;border:none !important;padding:0 !important;cursor:pointer !important;box-sizing:border-box !important}}@media (max-width:350px){.mobile-announcement-text{display:none !important}}.site-header{position:sticky;top:0;z-index:50;background:#FFFFFF !important;border-bottom:1px solid #E5E5E0 !important;margin:0 !important;padding:0 !important;box-shadow:none !important;width:100%}.desktop-header-wrap{display:none;align-items:center;gap:32px;max-width:1080px;margin:0 auto;padding:0 16px;height:68px;box-sizing:border-box;transition:height 0.2s ease}.site-header.header-scrolled .desktop-header-wrap{height:56px}.desktop-logo-link{display:inline-flex;align-items:center;flex-shrink:0}.desktop-logo-img{height:58px;max-height:60px;width:auto;display:block;object-fit:contain;transition:height 0.2s ease}.site-header.header-scrolled .desktop-logo-img{height:46px}.desktop-nav{display:flex;align-items:center;gap:22px;flex:1;height:100%;margin:0;padding:0;list-style:none}.desktop-nav a{font-family:var(--font-ui);font-size:16px;font-weight:600;color:#111111;text-decoration:none;padding:0;height:100%;display:inline-flex;align-items:center;border-bottom:2px solid transparent;transition:color 0.15s ease,border-color 0.15s ease;white-space:nowrap;box-sizing:border-box}.desktop-nav a:hover,.desktop-nav a.active{color:#B3261E;border-bottom-color:#B3261E}.desktop-nav a:focus-visible{outline:2px solid #B3261E !important;outline-offset:4px !important;color:#B3261E !important;border-bottom-color:#B3261E !important}.desktop-claim-btn:focus-visible,.desktop-search-btn:focus-visible,.desktop-lang-btn:focus-visible,.mobile-hamburger-btn:focus-visible,.mobile-nav-item:focus-visible,.mobile-drawer-close-btn:focus-visible,.top-announcement-close:focus-visible{outline:2px solid #B3261E !important;outline-offset:2px !important}.desktop-header-right{display:flex;align-items:center;gap:20px;margin-left:auto;flex-shrink:0;height:100%}.desktop-search-wrap{position:relative;display:flex;align-items:center}.desktop-search-btn{background:transparent;border:none;padding:6px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;color:#111111;border-radius:2px;transition:color 0.15s ease}.desktop-search-btn:hover{color:#B3261E}.desktop-search-form{display:none;position:absolute;right:0;top:50%;transform:translateY(-50%);background:#FFFFFF;border:1px solid #E5E5E0;border-radius:2px;padding:3px 8px 3px 12px;align-items:center;width:260px;z-index:60;box-sizing:border-box}.desktop-search-form.open{display:flex}.desktop-search-input{border:none;outline:none;background:transparent;font-family:var(--font-ui);font-size:13.5px;width:100%;padding:5px 0;color:#111111}.desktop-search-close{background:transparent;border:none;font-size:18px;cursor:pointer;color:#777777;padding:0 4px;line-height:1}.desktop-search-close:hover{color:#111111}.desktop-lang-toggle{display:inline-flex;align-items:center;gap:5px;font-family:var(--font-ui);font-size:13.5px;font-weight:600;color:#555555;user-select:none}.desk-lang-btn{background:transparent;border:none;padding:2px 2px;font-family:var(--font-ui);font-size:13.5px;font-weight:600;color:#555555;cursor:pointer;transition:color 0.15s ease}.desk-lang-btn:hover{color:#111111}.desk-lang-btn.active{color:#B3261E !important;font-weight:700 !important}.desk-lang-sep{color:#CCCCCC;font-size:12px}.desktop-claim-btn{display:inline-flex;align-items:center;justify-content:center;height:40px;padding:0 16px;background:#B3261E;color:#FFFFFF !important;border:1px solid #B3261E;border-radius:2px;font-family:var(--font-ui);font-size:14px;font-weight:600;text-decoration:none;white-space:nowrap;box-sizing:border-box;transition:background 0.15s ease,border-color 0.15s ease,height 0.2s ease}.site-header.header-scrolled .desktop-claim-btn{height:36px}.desktop-claim-btn:hover{background:#961F18;border-color:#961F18;color:#FFFFFF !important}.tablet-hamburger-btn{display:none;align-items:center;justify-content:center;width:38px;height:38px;background:#FFFFFF;border:1px solid #D1D5DB;border-radius:2px;cursor:pointer;padding:0;color:#111111}@media (min-width:768px) and (max-width:1023px){.desktop-header-wrap{display:flex !important;gap:16px}.desktop-nav{display:none !important}.tablet-hamburger-btn{display:inline-flex !important}.desktop-header-right{gap:14px}}@media (min-width:1024px){.desktop-header-wrap{display:flex !important}.desktop-nav{display:flex !important}.tablet-hamburger-btn{display:none !important}}@media (min-width:768px){.mobile-header-wrap{display:none !important}}@media (max-width:767px){.site-header{height:72px !important;padding:0 !important;margin:0 !important;position:sticky !important;top:0 !important;z-index:50 !important;background:#FFFFFF !important;border-bottom:1px solid #E5E5E0 !important;box-shadow:none !important;box-sizing:border-box !important}.mobile-header-wrap{display:flex !important;align-items:center !important;justify-content:space-between !important;height:72px !important;padding:0 16px !important;width:100% !important;box-sizing:border-box !important;margin:0 !important}.mobile-logo-link{display:inline-flex !important;align-items:center !important;height:100% !important;text-decoration:none !important;flex-shrink:0 !important}.mobile-logo-img{height:48px !important;max-height:52px !important;min-height:46px !important;width:auto !important;display:block !important;object-fit:contain !important}.mobile-hamburger-btn{display:inline-flex !important;align-items:center !important;justify-content:center !important;width:44px !important;height:44px !important;min-width:44px !important;min-height:44px !important;background:#F8F9FA !important;border:1px solid #E5E7EB !important;border-radius:6px !important;cursor:pointer !important;padding:0 !important;color:#111111 !important;flex-shrink:0 !important}.mobile-drawer-overlay{display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.65);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);z-index:9998;opacity:0;transition:opacity 0.2s ease}.mobile-drawer-overlay.open{display:block !important;opacity:1 !important}.mobile-drawer{position:fixed;top:0;left:0;right:0;width:100%;max-height:88vh;background:#FFFFFF;border-bottom:2px solid #E5E5E0;border-radius:0 0 12px 12px;z-index:9999;padding:16px 20px 24px 20px;box-sizing:border-box;display:none;flex-direction:column;overflow-y:auto;box-shadow:0 16px 36px rgba(0,0,0,0.22)}.mobile-drawer.open{display:flex !important}.mobile-drawer-header{display:flex;align-items:center;justify-content:space-between;padding-bottom:12px;margin-bottom:14px;border-bottom:1px solid #E5E5E0}.mobile-drawer-title{font-family:var(--font-ui);font-size:16px;font-weight:700;color:#111111}.mobile-drawer-close-btn{width:44px;height:44px;min-width:44px;min-height:44px;display:inline-flex;align-items:center;justify-content:center;background:#F3F4F6;border:1px solid #E5E7EB;border-radius:6px;color:#111827;cursor:pointer;padding:0}.mobile-search-box{position:relative;display:flex;align-items:center;width:100%}.mobile-search-input{width:100%;height:44px;padding:0 44px 0 14px;font-family:var(--font-ui);font-size:14px;border:1px solid #E5E5E0;border-radius:4px;outline:none;box-sizing:border-box;background:#FAFAF7}.mobile-search-input:focus{border-color:#B3261E;background:#FFFFFF}.mobile-search-submit{position:absolute;right:2px;top:2px;width:40px;height:40px;display:flex;align-items:center;justify-content:center;background:transparent;border:none;color:#6B7280;cursor:pointer}.mobile-nav-list{display:flex;flex-direction:column;margin:0;padding:0}.mobile-nav-item{height:48px;min-height:48px;display:flex;align-items:center;font-family:var(--font-ui);font-size:16px;font-weight:600;color:#111111;border-bottom:1px solid #EBEBE6;text-decoration:none;padding:0 4px;transition:color 0.15s ease}.mobile-nav-item:hover,.mobile-nav-item.active{color:#B3261E}.mobile-drawer-divider{height:1px;background:#E5E5E0;margin:16px 0;width:100%}.mobile-drawer-bottom{display:flex;flex-direction:column;gap:12px}.mobile-drawer-lang{display:flex;align-items:center;justify-content:space-between;height:44px;padding:0 4px}.mobile-lang-btn-group{display:inline-flex;align-items:center;gap:4px}.mobile-lang-btn{height:44px;min-width:44px;padding:0 10px;background:transparent;border:none;font-family:var(--font-ui);font-size:15px;font-weight:600;color:#555555;cursor:pointer;display:inline-flex;align-items:center;justify-content:center}.mobile-lang-btn.active{color:#B3261E !important;font-weight:700 !important}.mobile-lang-sep{color:#CCCCCC;font-size:13px}.mobile-drawer-whatsapp{display:flex;align-items:center;gap:10px;height:44px;min-height:44px;padding:0 14px;background:#F0FDF4;border:1px solid #BBF7D0;border-radius:4px;color:#166534 !important;font-family:var(--font-ui);font-size:14.5px;font-weight:600;text-decoration:none;box-sizing:border-box}.mobile-drawer-claim-btn{display:flex;align-items:center;justify-content:center;height:44px;min-height:44px;background:#B3261E;color:#FFFFFF !important;border:1px solid #B3261E;border-radius:4px;font-family:var(--font-ui);font-size:15px;font-weight:600;text-decoration:none;box-sizing:border-box}}@media (max-width:767px){.top-announcement{display:block !important;height:auto !important;max-height:none !important;overflow:visible !important;box-sizing:border-box !important;padding:0 !important}.top-announcement-inner{height:auto !important;min-height:36px !important;padding:8px 46px 8px 14px !important;display:flex !important;align-items:center !important;justify-content:flex-start !important;position:relative !important;box-sizing:border-box !important}.top-announcement-text{font-size:12.5px !important;line-height:1.45 !important;white-space:normal !important;word-break:break-word !important;overflow:visible !important;text-overflow:clip !important;text-align:left !important;padding:0 !important;margin:0 !important;width:100% !important}.top-announcement-inner{height:auto !important;min-height:38px !important;padding:9px 48px 9px 14px !important;display:flex !important;align-items:center !important;justify-content:flex-start !important;position:relative !important;box-sizing:border-box !important}.top-announcement-close{position:absolute !important;right:4px !important;top:50% !important;transform:translateY(-50%) !important;width:44px !important;height:44px !important;min-width:44px !important;min-height:44px !important;display:inline-flex !important;align-items:center !important;justify-content:center !important;font-size:24px !important;line-height:1 !important;color:#A0AEC0 !important;background:transparent !important;border:none !important;padding:0 !important;cursor:pointer !important;box-sizing:border-box !important}}@media (min-width:768px) and (max-width:1023px){.mobile-drawer-overlay{display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.45);z-index:9998}.mobile-drawer{position:fixed;top:0;right:-300px;width:300px;height:100%;background:#FFFFFF;border-left:1px solid #E5E5E0;z-index:9999;padding:24px;box-sizing:border-box;transition:right 0.25s ease;display:flex;flex-direction:column;overflow-y:auto}.mobile-drawer.open{right:0 !important}.mobile-nav-item{height:44px;display:flex;align-items:center;font-family:var(--font-ui);font-size:15px;font-weight:600;color:#111;border-bottom:1px solid #EBEBE6;text-decoration:none}}@media (min-width:1024px){.mobile-drawer,.mobile-drawer-overlay{display:none !important}}.site-main{padding:36px 0 60px 0;min-height:50vh}.site-footer{border-top:1px solid var(--border-rule);padding:44px 0 24px 0;background:#F4F4F0;font-family:var(--font-ui);font-size:13.5px;color:var(--text-muted)}.footer-cols{display:grid;grid-template-columns:2fr 1fr 1fr;gap:40px;margin-bottom:32px}.footer-col h4{font-size:14px;font-weight:700;color:#111;margin-top:0;margin-bottom:14px;text-transform:uppercase;letter-spacing:0.5px}.footer-col ul{list-style:none;padding:0 !important;margin:0 !important}.footer-col li{margin-bottom:9px}.footer-col li a{color:var(--text-dark)}.footer-col li a:hover{color:var(--accent-red)}.footer-bottom{border-top:1px solid #E5E5E0;padding-top:20px;display:flex;justify-content:space-between;align-items:center;font-size:12.5px}@media (max-width:991px){.footer-cols{grid-template-columns:1fr;gap:28px}.footer-bottom{flex-direction:column;gap:14px;text-align:center}.home-grid{grid-template-columns:1fr !important;gap:32px !important}}.goog-te-banner-frame,.goog-te-banner-frame.skiptranslate,iframe.goog-te-banner-frame,.VIpgJd-ZVi9od-ORHb-OEVmcb,.VIpgJd-ZVi9od-aZ2wEe-wOHMyf,.VIpgJd-ZVi9od-aZ2wEe-wOHMyf-ti6hGc,#goog-gt-tt,.goog-te-balloon-frame,.skiptranslate,iframe.skiptranslate,body>.skiptranslate{display:none !important;visibility:hidden !important;height:0 !important;width:0 !important;opacity:0 !important;pointer-events:none !important}.goog-tooltip,.goog-tooltip:hover{display:none !important}.goog-text-highlight{background-color:transparent !important;border:none !important;box-shadow:none !important}#google_translate_element{display:none !important;position:absolute !important;top:-9999px !important;left:-9999px !important;height:0 !important;width:0 !important}
</style>
    <script>
        (function() {
            try {
                if (localStorage.getItem('fc_announcement_dismissed') === '1' || sessionStorage.getItem('fc_announcement_dismissed') === '1') {
                    document.documentElement.classList.add('fc-announcement-hidden');
                }
            } catch(e) {}
        })();
    </script>
    <style>
        html.fc-announcement-hidden #topAnnouncementBar {
            display: none !important;
        }
    </style>
</head>
<body>
    <a href="#main-content" class="skip-link">মূল বিষয়বস্তুতে যান (Skip to Content)</a>
    @if(!empty($settings->enable_announcement) && !empty($settings->announcement_text_bn))
        <div id="topAnnouncementBar" class="top-announcement">
            <div class="top-announcement-inner">
                <div class="top-announcement-text">
                    {{ $settings->announcement_text_bn }}
                    @if(!empty($settings->announcement_link))
                        <a href="{{ $settings->announcement_link }}">{{ $settings->announcement_link_text_bn ?? 'দাবি পাঠান' }} &rarr;</a>
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
            @php
                $siteLogoSrc = !empty($settings->logo_light) ? asset('storage/' . $settings->logo_light) : asset('storage/branding/logo.png');
                $siteLogoWebp = preg_replace('/\.(png|jpe?g)$/i', '.webp', $siteLogoSrc);
            @endphp
            <a href="/" class="desktop-logo-link" title="{{ $siteName }}">
                <picture>
                    <source srcset="{{ $siteLogoWebp }}" type="image/webp">
                    <img src="{{ $siteLogoSrc }}" alt="{{ $siteName }}" class="desktop-logo-img" width="174" height="58" fetchpriority="high" decoding="async">
                </picture>
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
                        <button type="button" class="desktop-search-close" onclick="toggleDesktopSearch()" aria-label="অনুসন্ধান বন্ধ করুন">&times;</button>
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

        <!-- MOBILE HEADER (<768px) — ONE COMPACT 56px ROW -->
        <div class="mobile-header-wrap">
            <!-- Left: Logo (height 28-32px, auto width) -->
            @php
                $siteLogoMobileWebp = preg_replace('/\.(png|jpe?g)$/i', '_mobile.webp', $siteLogoSrc);
            @endphp
            <a href="/" class="mobile-logo-link" title="{{ $siteName }}">
                <picture>
                    <source srcset="{{ $siteLogoMobileWebp }}" type="image/webp">
                    <img src="{{ $siteLogoSrc }}" alt="{{ $siteName }}" class="mobile-logo-img" width="144" height="48" fetchpriority="high">
                </picture>
            </a>

            <!-- Right: Hamburger Menu Button (44x44 tap target, aria-label, aria-expanded) -->
            <button type="button" class="mobile-hamburger-btn" onclick="toggleDrawer()" aria-label="Toggle Navigation Menu" aria-expanded="false" id="mobileMenuButton">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="6" x2="20" y2="6"></line>
                    <line x1="4" y1="12" x2="20" y2="12"></line>
                    <line x1="4" y1="18" x2="20" y2="18"></line>
                </svg>
            </button>
        </div>
    </header>


    <!-- Mobile Navigation Panel (Full-Width with blurred backdrop) -->
    <div id="drawerOverlay" class="mobile-drawer-overlay" onclick="toggleDrawer()"></div>
    <div id="mobileDrawer" class="mobile-drawer" role="dialog" aria-modal="true" aria-label="Mobile Navigation">
        <!-- Drawer Header with Title and Close Button -->
        <div class="mobile-drawer-header">
            <span class="mobile-drawer-title">মেনু ও নেভিগেশন</span>
            <button type="button" class="mobile-drawer-close-btn" onclick="toggleDrawer()" aria-label="Close Menu">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Search Input -->
        <form action="/search" method="GET" style="margin: 0 0 14px 0;">
            <div class="mobile-search-box">
                <input type="text" name="q" placeholder="অনুসন্ধান করুন..." class="mobile-search-input" value="{{ request('q') }}">
                <button type="submit" class="mobile-search-submit" aria-label="Search">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>
        </form>

        <!-- Nav Links Stacked (each 48px tall, 16px font, 1px bottom border) -->
        <nav class="mobile-nav-list">
            @if(!empty($settings->header_menu))
                @foreach($settings->header_menu as $menu)
                    <a href="{{ $menu['url'] }}" onclick="toggleDrawer()" class="mobile-nav-item {{ request()->is(ltrim($menu['url'], '/') . '*') ? 'active' : '' }}">{{ $menu['label_bn'] }}</a>
                @endforeach
            @else
                <a href="/" onclick="toggleDrawer()" class="mobile-nav-item {{ request()->is('/') ? 'active' : '' }}">হোম</a>
                <a href="/category/politics" onclick="toggleDrawer()" class="mobile-nav-item {{ request()->is('category/politics*') ? 'active' : '' }}">রাজনীতি</a>
                <a href="/category/health" onclick="toggleDrawer()" class="mobile-nav-item {{ request()->is('category/health*') ? 'active' : '' }}">স্বাস্থ্য</a>
                <a href="/category/ai-deepfake" onclick="toggleDrawer()" class="mobile-nav-item {{ request()->is('category/ai-deepfake*') ? 'active' : '' }}">ডিপফেক ও এআই</a>
                <a href="/page/about" onclick="toggleDrawer()" class="mobile-nav-item {{ request()->is('page/about*') ? 'active' : '' }}">আমাদের সম্পর্কে</a>
            @endif
        </nav>

        <!-- 1px Divider -->
        <div class="mobile-drawer-divider"></div>

        <!-- Language toggle, WhatsApp and "দাবি পাঠান" button -->
        <div class="mobile-drawer-bottom">
            <div class="mobile-drawer-lang notranslate" translate="no">
                <span style="font-size: 14.5px; color: #4B5563; font-weight: 600;">ভাষা পরিবর্তন:</span>
                <div class="mobile-lang-btn-group">
                    <button type="button" id="btn-lang-bn" onclick="switchSiteLanguage('bn')" class="mobile-lang-btn active">বাংলা</button>
                    <span class="mobile-lang-sep">|</span>
                    <button type="button" id="btn-lang-en" onclick="switchSiteLanguage('en')" class="mobile-lang-btn">ENG</button>
                </div>
            </div>

            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number ?? '8801700000000') }}" target="_blank" rel="noopener" class="mobile-drawer-whatsapp notranslate" title="WhatsApp Tipline">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="#25D366" style="flex-shrink: 0;" aria-hidden="true">
                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.634.053-1.849-.444-1.503-.615-2.477-2.146-2.551-2.247-.075-.1-.611-.814-.611-1.554 0-.74.385-1.103.522-1.253.136-.15.298-.187.397-.187.099 0 .198.001.284.006.09.004.21-.034.328.25.123.297.42 1.026.457 1.101.037.075.062.163.013.262-.05.1-.075.163-.15.25-.075.088-.158.196-.226.264-.075.075-.153.158-.066.308.087.15.388.641.833 1.037.573.51 1.057.668 1.206.743.15.075.237.063.325-.038.087-.101.374-.436.474-.586.099-.15.2-.125.336-.075.137.05.867.409 1.016.484.15.075.249.112.286.175.037.063.037.362-.107.767zM12 2C6.477 2 2 6.477 2 12c0 1.891.523 3.662 1.434 5.176L2 22l4.966-1.399A9.956 9.956 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/>
                </svg>
                <span>হোয়াটসঅ্যাপ টিপলাইন (WhatsApp)</span>
            </a>

            <a href="/submit-claim" onclick="toggleDrawer()" class="mobile-drawer-claim-btn notranslate">
                দাবি পাঠান (Submit Claim) &rarr;
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="site-main" id="main-content">
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

    <script>
function googleTranslateElementInit(){new google.translate.TranslateElement({pageLanguage:'bn',includedLanguages:'en,bn',autoDisplay:false},'google_translate_element')}
function loadGoogleTranslate(cb){if(window.googleTranslateLoaded){if(typeof cb==='function')cb();return;}window.googleTranslateLoaded=true;var s=document.createElement('script');s.async=true;s.src='//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';if(typeof cb==='function')s.onload=cb;document.body.appendChild(s)}
function switchSiteLanguage(l){if(l==='en'&&!window.googleTranslateLoaded){loadGoogleTranslate(function(){setTimeout(function(){switchSiteLanguage('en')},250)});return;}var bBn=document.getElementById('btn-lang-bn'),bEn=document.getElementById('btn-lang-en'),dBn=document.getElementById('desk-btn-lang-bn'),dEn=document.getElementById('desk-btn-lang-en'),h=window.location.hostname;if(l==='en'){if(bEn)bEn.classList.add('active');if(bBn)bBn.classList.remove('active');if(dEn)dEn.classList.add('active');if(dBn)dBn.classList.remove('active');var exp='; expires='+new Date(Date.now()+31536000000).toUTCString();document.cookie='googtrans=/bn/en; path=/; domain='+h+exp;document.cookie='googtrans=/bn/en; path=/; domain=.'+h+exp;document.cookie='googtrans=/bn/en; path=/'+exp;var sel=document.querySelector('.goog-te-combo');if(sel){sel.value='en';sel.dispatchEvent(new Event('change'))}else{window.location.reload()}}else{if(bBn)bBn.classList.add('active');if(bEn)bEn.classList.remove('active');if(dBn)dBn.classList.add('active');if(dEn)dEn.classList.remove('active');['googtrans','__googtrans'].forEach(function(c){['/','/page','/article','/category'].forEach(function(p){document.cookie=c+'=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path='+p+';';document.cookie=c+'=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path='+p+'; domain='+h+';';document.cookie=c+'=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path='+p+'; domain=.'+h+';'})});var sel=document.querySelector('.goog-te-combo');if(sel){sel.value='bn';sel.dispatchEvent(new Event('change'))}setTimeout(function(){window.location.href=window.location.pathname},80)}}
function syncActivePill(){var isEn=document.cookie.indexOf('googtrans=/bn/en')!==-1,bBn=document.getElementById('btn-lang-bn'),bEn=document.getElementById('btn-lang-en'),dBn=document.getElementById('desk-btn-lang-bn'),dEn=document.getElementById('desk-btn-lang-en');if(isEn){if(bEn)bEn.classList.add('active');if(bBn)bBn.classList.remove('active');if(dEn)dEn.classList.add('active');if(dBn)dBn.classList.remove('active')}else{if(bBn)bBn.classList.add('active');if(bEn)bEn.classList.remove('active');if(dBn)dBn.classList.add('active');if(dEn)dEn.classList.remove('active')}}
function dismissAnnouncement(){var el=document.getElementById('topAnnouncementBar');if(el)el.classList.add('dismissed');try{localStorage.setItem('fc_announcement_dismissed','1');sessionStorage.setItem('fc_announcement_dismissed','1')}catch(e){}}
function toggleDesktopSearch(){var f=document.getElementById('desktopSearchForm'),i=document.getElementById('desktopSearchInput');if(f){f.classList.toggle('open');if(f.classList.contains('open')&&i)i.focus()}}
function toggleDrawer(){var d=document.getElementById('mobileDrawer'),o=document.getElementById('drawerOverlay'),b=document.getElementById('mobileMenuButton');if(!d)return;if(d.classList.contains('open')){d.classList.remove('open');if(o){o.classList.remove('open');o.style.display='none'}if(b)b.setAttribute('aria-expanded','false');document.body.style.overflow=''}else{d.classList.add('open');if(o){o.style.display='block';setTimeout(function(){o.classList.add('open')},10)}if(b)b.setAttribute('aria-expanded','true');document.body.style.overflow='hidden'}}
document.addEventListener('DOMContentLoaded',function(){syncActivePill();var h=document.querySelector('.site-header');if(h){var ticking=false;window.addEventListener('scroll',function(){if(!ticking){window.requestAnimationFrame(function(){if(window.scrollY>30){h.classList.add('header-scrolled')}else{h.classList.remove('header-scrolled')}ticking=false;});ticking=true;}},{passive:true})};document.addEventListener('click',function(e){var w=document.getElementById('desktopSearchWrap'),f=document.getElementById('desktopSearchForm');if(w&&f&&!w.contains(e.target))f.classList.remove('open')})});
</script>
</body>
</html>
