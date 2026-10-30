@php
    $themeSettingsPath = storage_path('app/theme_settings.json');
    $themeSettings = [
        'logo_text' => 'দৈনিক ভোলা<span>জার্নাল</span>',
        'logo_image' => '',
        'footer_logo_image' => '',
        'primary_color' => '#111827',
        'accent_color' => '#c90000',
        'bg_site' => '#f0f1f5',
        'text_main' => '#1e1e2f',
        'font_family' => "'Noto Sans Bengali', 'Outfit', sans-serif",
        'custom_css' => '',
        'footer_text' => 'দৈনিক ভোলা জার্নাল জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র ও ডিজিটাল ই-পেপার। আমরা অত্যন্ত সততা, নিষ্ঠা ও নিরপেক্ষতার সাথে সব ধরণের স্থানীয় ও জাতীয় সংবাদ সবার আগে প্রকাশ করি।',
        'social_facebook' => '#',
        'social_twitter' => '#',
        'social_youtube' => '#',
        'social_instagram' => '#',
        'contact_address' => 'বার্তা ও বাণিজ্যিক কার্যালয়- ভোলা সদর, ভোলা।',
        'contact_phone' => '01716-674375',
        'contact_email' => 'news.dailybholajournal@gmail.com',
        'editorial_publisher' => 'সামিয়া তালুকদার',
        'editorial_executive_editor' => 'ইসমাইল হোসেন আরিফ',
        'copyright_text' => 'দৈনিক ভোলা জার্নাল। সর্বস্বত্ব সংরক্ষিত।'
    ];
    if (file_exists($themeSettingsPath)) {
        $themeSettings = array_merge($themeSettings, json_decode(file_get_contents($themeSettingsPath), true));
    }
@endphp
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary SEO Meta Tags -->
    <title>@yield('title', 'দৈনিক ভোলা জার্নাল | Daily Bhola Journal - সত্য ও ন্যায়ের সন্ধানে সার্বক্ষণিক')</title>
    <meta name="description" content="@yield('meta_description', $themeSettings['footer_text'] ?? 'দৈনিক ভোলা জার্নাল - ভোলা জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র। আমরা অত্যন্ত সততা, নিষ্ঠা ও নিরপেক্ষতার সাথে সব ধরণের স্থানীয় ও জাতীয় সংবাদ সবার আগে প্রকাশ করি।')">
    <meta name="keywords" content="@yield('meta_keywords', 'দৈনিক ভোলা জার্নাল, ভোলা জার্নাল, ভোলা নিউজ, daily bhola journal, bhola journal, bhola news, dainik bholajournal, bholajournal, bhola newspaper')">
    <meta name="author" content="দৈনিক ভোলা জার্নাল">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('canonical_url', request()->url())">
    
    <!-- Open Graph / Facebook Meta Tags -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'দৈনিক ভোলা জার্নাল | Daily Bhola Journal')">
    <meta property="og:description" content="@yield('og_description', $themeSettings['footer_text'] ?? 'দৈনিক ভোলা জার্নাল - ভোলা জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র।')">
    <meta property="og:image" content="@yield('og_image', asset($themeSettings['logo_image'] ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=800'))">
    <meta property="og:url" content="@yield('og_url', request()->url())">
    <meta property="og:site_name" content="দৈনিক ভোলা জার্নাল">
    <meta property="og:locale" content="bn_BD">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'দৈনিক ভোলা জার্নাল | Daily Bhola Journal')">
    <meta name="twitter:description" content="@yield('og_description', $themeSettings['footer_text'] ?? 'দৈনিক ভোলা জার্নাল - ভোলা জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র।')">
    <meta name="twitter:image" content="@yield('og_image', asset($themeSettings['logo_image'] ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=800'))">
    
    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700;800;900&family=Noto+Serif+Bengali:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap 5.3.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        :root {
            --primary: {{ $themeSettings['primary_color'] ?? '#1a1a2e' }};      /* Jugantor Dark Navy */
            --primary-light: #2d2d44;
            --accent: {{ $themeSettings['accent_color'] ?? '#e70d0d' }};       /* Jugantor Red */
            --accent-hover: #c60b0b;
            --accent-light: #fff1f1;
            --bg-site: {{ $themeSettings['bg_site'] ?? '#f0f1f5' }};      /* Soft Gray Background */
            --bg-card: #ffffff;
            --text-main: {{ $themeSettings['text_main'] ?? '#1e1e2f' }};    /* Deep charcoal */
            --text-dark: {{ $themeSettings['primary_color'] ?? '#1a1a2e' }};    /* Deep dark */
            --text-light: #6b7280;   /* Cool grey */
            --border-color: #e5e7eb;  /* Clean gray border */
            --shadow-sm: 0 1px 3px rgba(26, 26, 46, 0.06);
            --shadow-md: 0 4px 8px -1px rgba(26, 26, 46, 0.1), 0 2px 4px -1px rgba(26, 26, 46, 0.05);
            --shadow-lg: 0 10px 25px -5px rgba(26, 26, 46, 0.1), 0 8px 16px -8px rgba(26, 26, 46, 0.06);
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Basic Resets & Aesthetics */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: {!! $themeSettings['font_family'] ?? "'Noto Sans Bengali', 'Outfit', sans-serif" !!};
            background-color: var(--bg-site);
            color: var(--text-main);
            line-height: 1.7;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: var(--transition);
        }

        /* Container Layout */
        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ==========================================================================
           3-Column Newspaper Header (Masthead + Sticky Nav)
           ========================================================================== */

        /* ── Part 1: Masthead ── */
        .main-header {
            background-color: #ffffff;
            padding: 14px 0 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        /* 3-column CSS Grid layout for desktop */
        .masthead-grid {
            display: grid;
            grid-template-columns: 350px 1fr 300px;
            gap: 24px;
            align-items: center;
        }

        .masthead-col {
            display: flex;
            flex-direction: column;
        }

        /* COL 1 – Logo + date */
        .masthead-col-logo {
            align-items: flex-start;
            gap: 8px;
        }

        .masthead-logo-link {
            line-height: 1;
        }

        .masthead-logo-img {
            max-height: 75px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            display: block;
        }

        .masthead-date-box {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            font-size: 0.8rem;
            color: #475569;
            font-weight: 600;
            font-family: 'Noto Sans Bengali', sans-serif;
            gap: 2px;
            padding-top: 4px;
        }

        /* COL 2 – Quick links, social, search (Aligned to right) */
        .masthead-col-center {
            gap: 10px;
            justify-content: center;
            align-items: flex-end;
            border-left: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
            padding: 0 20px;
        }

        /* Quick links */
        .masthead-quicklinks {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
            flex-wrap: wrap;
            width: 100%;
        }

        .mql-item {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.82rem;
            font-weight: 700;
            color: #374151;
            text-decoration: none;
            padding: 4px 10px;
            border-radius: 20px;
            background: #f3f4f6;
            transition: var(--transition);
            font-family: 'Noto Sans Bengali', sans-serif;
            white-space: nowrap;
        }

        .mql-item i {
            color: var(--accent, #c90000);
            font-size: 0.78rem;
        }

        .mql-item:hover {
            background: var(--accent, #c90000);
            color: #ffffff;
        }

        .mql-item:hover i {
            color: #ffffff;
        }

        .mql-sep {
            display: inline-block;
            width: 1px;
            height: 16px;
            background: #d1d5db;
            margin: 0 2px;
        }

        /* Social + Search row */
        .masthead-social-search {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            width: 100%;
        }

        .masthead-social {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .masthead-social-label {
            font-size: 0.72rem;
            color: #9ca3af;
            font-weight: 600;
            letter-spacing: 0.5px;
            white-space: nowrap;
            margin-right: 2px;
            font-family: 'Noto Sans Bengali', sans-serif;
        }

        .msd-link {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 0.82rem;
            text-decoration: none;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .msd-fb  { background: #e7f0fb; color: #1877f2; }
        .msd-x   { background: #f0f0f0; color: #111827; }
        .msd-yt  { background: #fdecea; color: #ff0000; }
        .msd-ig  { background: #fce7f3; color: #e1306c; }

        .msd-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.12);
        }

        /* Masthead Search */
        .masthead-search {
            display: flex;
            align-items: center;
            position: relative;
            flex: 1;
            max-width: 260px;
        }

        .masthead-search-input {
            width: 100%;
            padding: 7px 36px 7px 14px;
            border: 1px solid #d1d5db;
            border-radius: 50px;
            font-size: 0.83rem;
            outline: none;
            background: #f8fafc;
            color: #111827;
            font-family: 'Noto Sans Bengali', sans-serif;
            transition: var(--transition);
        }

        .masthead-search-input:focus {
            border-color: var(--accent, #c90000);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(201,0,0,0.08);
        }

        .masthead-search-btn {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            padding: 0;
            color: #9ca3af;
            cursor: pointer;
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .masthead-search-btn:hover { color: var(--accent, #c90000); }

        /* COL 3 – Ad */
        .masthead-col-ad {
            align-items: stretch;
            gap: 4px;
        }

        .header-ad-label {
            font-size: 0.68rem;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            text-align: center;
        }

        .header-ad-box {
            flex: 1;
            min-height: 80px;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border: 1px dashed #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-sm);
            color: #94a3b8;
            font-size: 0.82rem;
            font-family: 'Outfit', sans-serif;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            text-align: center;
            line-height: 1.5;
        }

        .header-ad-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100px;
            width: 50px;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            transform: skewX(-15deg);
            animation: shineAd 6s infinite;
        }

        @keyframes shineAd {
            0%   { left: -100px; }
            15%  { left: 100%;   }
            100% { left: 100%;   }
        }

        .header-ad-box:hover {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #64748b;
            border-color: #94a3b8;
        }

        /* Logo text fallback */
        .logo-text {
            font-family: 'Noto Serif Bengali', serif;
            font-size: 3.2rem;
            font-weight: 900;
            color: var(--primary);
            letter-spacing: -1.5px;
            line-height: 1;
            margin: 0;
        }

        .logo-text span { color: var(--accent); }

        .logo-tagline {
            font-size: 0.82rem;
            color: var(--text-light);
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 6px;
            text-transform: uppercase;
        }

        /* ── Part 2: Sticky Nav Bar ── */
        .nav-bar {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-top: 1px solid #e5e7eb;
            border-bottom: 2px solid var(--accent, #c90000);
        }

        .nav-container {
            display: flex;
            align-items: center;
            height: 48px;
            gap: 4px;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            height: 100%;
            align-items: center;
            margin: 0;
            padding: 0;
            flex-grow: 1;
        }

        .nav-item {
            height: 100%;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0 11px;
            height: 100%;
            font-weight: 700;
            font-size: 1rem;
            color: #111827;
            transition: var(--transition);
            border-bottom: 3px solid transparent;
            font-family: 'Noto Sans Bengali', sans-serif;
            white-space: nowrap;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--accent, #c90000);
            border-bottom-color: var(--accent, #c90000);
            background-color: transparent;
        }

        .nav-home-icon {
            font-size: 1.15rem;
        }

        /* Search Bar Widget */
        .search-box {
            display: flex;
            align-items: center;
            position: relative;
        }

        .search-input {
            padding: 6px 14px 6px 36px;
            border: 1px solid #d1d5db;
            border-radius: 50px;
            font-size: 0.85rem;
            outline: none;
            width: 170px;
            transition: var(--transition);
            font-family: inherit;
            background-color: #f8fafc;
            color: #111827;
        }

        .search-input:focus {
            width: 220px;
            border-color: var(--accent, #c90000);
            box-shadow: 0 0 0 3px rgba(201, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .search-input::placeholder {
            color: #94a3b8;
        }

        .search-icon-btn {
            position: absolute;
            left: 12px;
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            outline: none;
        }

        .search-icon-btn:hover {
            color: var(--accent, #c90000);
        }

        /* Mobile Hamburger */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.4rem;
            color: var(--primary);
            cursor: pointer;
            outline: none;
        }

        /* Breaking News Ticker System */
        .ticker-section {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 8px 0;
            display: flex;
            align-items: center;
            font-family: 'Noto Sans Bengali', sans-serif;
        }

        .ticker-container {
            display: flex;
            align-items: center;
            width: 100%;
            overflow: hidden;
        }

        .ticker-label {
            background-color: var(--accent);
            color: #ffffff;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            margin-right: 16px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 3px 6px rgba(227, 28, 37, 0.15);
            animation: pulseTicker 2s infinite;
        }

        @keyframes pulseTicker {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        .ticker-wrap {
            flex-grow: 1;
            overflow: hidden;
            white-space: nowrap;
        }

        .ticker-marquee {
            display: inline-block;
            animation: marquee 60s linear infinite;
            padding-left: 100%;
        }

        .ticker-marquee:hover {
            animation-play-state: paused;
        }

        @keyframes marquee {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-100%, 0, 0); }
        }

        .ticker-item {
            display: inline-flex;
            align-items: center;
            color: var(--text-main);
            font-size: 0.95rem;
            font-weight: 600;
            margin-right: 32px;
            transition: var(--transition);
        }

        .ticker-item:hover {
            color: var(--accent);
        }

        .ticker-bullet {
            width: 6px;
            height: 6px;
            background-color: var(--accent);
            border-radius: 50%;
            margin-right: 10px;
            display: inline-block;
        }

        /* Main Content Layout */
        .main-content {
            padding: 24px 0 48px 0;
            min-height: calc(100vh - 450px);
        }

        /* Premium Sidebar Widget Styles */
        .sidebar-card {
            background-color: var(--bg-card);
            border-radius: var(--radius-md);
            padding: 20px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
        }

        .sidebar-title {
            font-family: 'Noto Serif Bengali', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 16px;
            padding-bottom: 6px;
            border-bottom: 2px solid var(--accent);
            display: inline-block;
        }

        /* Sidebar Popular list styling globally */
        .sidebar-popular-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-popular-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
        }

        .sidebar-popular-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .sidebar-popular-img-box {
            width: 80px;
            height: 60px;
            border-radius: var(--radius-sm, 6px);
            overflow: hidden;
            flex-shrink: 0;
            background-color: #f1f5f9;
        }

        .sidebar-popular-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .sidebar-popular-item:hover .sidebar-popular-img {
            transform: scale(1.05);
        }

        .sidebar-popular-title {
            font-size: 0.95rem;
            font-weight: 600;
            line-height: 1.4;
            margin: 0;
        }

        .sidebar-popular-title a:hover {
            color: var(--accent);
        }

        /* Kalbela-Style Modern Clean Footer */
        .kalbela-footer {
            background-color: #f8fafc;
            color: #334155;
            border-top: 3px solid var(--accent, #c90000);
            font-family: 'Noto Sans Bengali', sans-serif;
            font-size: 0.90rem;
        }

        .k-footer-brand .k-footer-title {
            font-family: 'Noto Serif Bengali', serif;
            font-size: 1.85rem;
            font-weight: 800;
            color: #0f172a;
        }

        .k-footer-brand .k-footer-title a {
            color: #0f172a;
            text-decoration: none;
        }

        .k-footer-brand .k-footer-title span {
            color: var(--accent, #c90000);
        }

        .k-footer-tagline {
            font-size: 0.84rem;
            color: #64748b;
            font-weight: 500;
        }

        .k-footer-nav .k-nav-row a {
            color: #1e293b;
            font-size: 0.92rem;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .k-footer-nav .k-nav-row a:hover {
            color: var(--accent, #c90000);
            text-decoration: underline;
        }

        .k-footer-nav .sep {
            margin: 0 8px;
            color: #cbd5e1;
            font-size: 0.8rem;
        }

        .k-footer-nav .k-nav-secondary a {
            color: #64748b;
            font-size: 0.86rem;
            font-weight: 500;
        }

        .k-footer-nav .k-nav-secondary a:hover {
            color: var(--accent, #c90000);
        }

        .k-editorial-box, .k-contact-box {
            font-size: 0.90rem;
        }

        .k-editorial-line {
            line-height: 1.6;
            color: #334155;
        }

        .k-label {
            font-weight: 700;
            color: #0f172a;
            margin-right: 4px;
        }

        .k-val {
            color: #475569;
        }

        .k-val:hover {
            color: var(--accent, #c90000);
        }

        .k-social-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .k-social-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            color: #ffffff !important;
            font-size: 0.90rem;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .k-social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            color: #ffffff !important;
        }

        .k-social-btn.fb { background-color: #1877f2; }
        .k-social-btn.yt { background-color: #ff0000; }
        .k-social-btn.tw { background-color: #000000; }
        .k-social-btn.ig { background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%); }
        .k-social-btn.wa { background-color: #25d366; }

        .k-copyright {
            font-size: 0.84rem;
            color: #64748b;
        }

        .k-warning {
            font-size: 0.82rem;
            color: #94a3b8;
        }

        /* Mobile Drawer Drawer Style */
        .mobile-drawer {
            position: fixed;
            top: 0;
            left: -300px;
            width: 280px;
            height: 100%;
            background-color: var(--primary);
            z-index: 10000;
            padding: 24px;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            gap: 24px;
            color: #ffffff;
            font-family: 'Noto Sans Bengali', sans-serif;
        }

        .mobile-drawer.open {
            left: 0;
        }

        .mobile-drawer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 12px;
        }

        .mobile-drawer-close {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.4rem;
            cursor: pointer;
            outline: none;
        }

        .mobile-drawer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding: 0;
            margin: 0;
        }

        .mobile-drawer-link {
            font-size: 1.1rem;
            font-weight: 600;
            display: block;
            padding: 6px 0;
            transition: var(--transition);
        }

        .mobile-drawer-link:hover {
            color: var(--accent);
            padding-left: 6px;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(10, 17, 40, 0.5);
            backdrop-filter: blur(3px);
            z-index: 9999;
            display: none;
        }

        .overlay.show {
            display: block;
        }

        /* Responsive Media Queries */
        @media (max-width: 1024px) {
            .nav-menu {
                display: none;
            }
            .mobile-menu-toggle {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .logo-text {
                font-size: 2.2rem;
                text-align: center;
            }
            .logo-tagline {
                text-align: center;
            }
            .main-header {
                padding: 12px 0;
            }
            /* Collapse masthead grid to single column on mobile */
            .masthead-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }
            .masthead-col-logo {
                align-items: center;
                text-align: center;
            }
            .masthead-col-center,
            .masthead-col-ad {
                display: none; /* hidden on mobile; drawer handles these */
            }
            .masthead-date-box {
                display: none; /* replaced by the separate mobile date bar */
            }
            .top-bar-content {
                flex-direction: column;
                gap: 8px;
                text-align: center;
            }
            .top-socials {
                border-left: none;
                padding-left: 0;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 12px;
            }
            .logo-text {
                font-size: 1.8rem;
            }
            .main-header {
                padding: 8px 0;
            }
            .top-bar {
                font-size: 0.75rem;
                padding: 6px 0;
            }
            .ticker-item {
                font-size: 0.85rem;
            }
            .main-content {
                padding: 16px 0 32px 0;
            }
        }

        /* Hover Dropdowns and Sub-dropdowns Styling */
        @media (min-width: 1025px) {
            .nav-item.dropdown:hover > .dropdown-menu {
                display: block;
                opacity: 1;
                visibility: visible;
                margin-top: 0;
                transform: translateY(0);
            }
            
            .nav-item.dropdown > .nav-link i {
                transition: transform 0.2s ease-in-out;
            }
            .nav-item.dropdown:hover > .nav-link i {
                transform: rotate(180deg);
            }

            .dropdown-menu {
                display: block;
                opacity: 0;
                visibility: hidden;
                transform: translateY(10px);
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                margin-top: 5px;
            }
            
            /* Nested Sub-menus positioning */
            .dropdown-submenu {
                position: relative;
            }
            
            .dropdown-submenu > .dropdown-menu {
                top: 0;
                left: 100%;
                margin-top: -6px;
                margin-left: 0px;
                border-radius: 0 var(--radius-md) var(--radius-md) var(--radius-md);
            }
            
            .dropdown-submenu:hover > .dropdown-menu {
                display: block;
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
        }

        /* Fade-in Animation for Bootstrap 5 Dropdowns */
        .animate {
            animation-duration: 0.2s;
            animation-fill-mode: both;
        }
        .fade-in {
            animation-name: fadeIn;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Scroll Reveal Animation */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Reading Progress Bar */
        .reading-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), #ff6b35);
            z-index: 10001;
            transition: width 0.1s linear;
            box-shadow: 0 0 8px rgba(231, 13, 13, 0.4);
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 44px;
            height: 44px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 50%;
            font-size: 1.1rem;
            cursor: pointer;
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(231, 13, 13, 0.3);
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }
        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .back-to-top:hover {
            background: var(--accent-hover);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(231, 13, 13, 0.4);
        }

        /* Custom Selection */
        ::selection {
            background-color: var(--accent);
            color: #ffffff;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #c4c4c4;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }

        /* Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
            html { scroll-behavior: auto; }
            .reveal { opacity: 1; transform: none; }
        }

        /* Card Image Overlay on Hover */
        .news-grid-img-box::after,
        .lead-image-box::after,
        .side-lead-img-box::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.15) 0%, transparent 50%);
            opacity: 0;
            transition: var(--transition);
            pointer-events: none;
        }
        .news-grid-card:hover .news-grid-img-box::after,
        .lead-news-card:hover .lead-image-box::after,
        .side-lead-card:hover .side-lead-img-box::after {
            opacity: 1;
        }

        /* Jugantor-style accent border on sections */
        .section-accent-border {
            border-left: 4px solid var(--accent);
            padding-left: 12px;
        }

        {!! $themeSettings['custom_css'] ?? '' !!}
    </style>
    @yield('styles')
</head>
<body>

    @include('layouts.partials.header')

    <!-- Main Content Area -->
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    @include('layouts.partials.footer')

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" title="উপরে যান">
        <i class="fa-solid fa-chevron-up"></i>
    </button>

    <!-- Scroll Reveal & Back-to-Top Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Back to top
            const backToTop = document.getElementById('backToTop');
            if (backToTop) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 400) {
                        backToTop.classList.add('visible');
                    } else {
                        backToTop.classList.remove('visible');
                    }
                });
                backToTop.addEventListener('click', function() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // Scroll reveal
            const reveals = document.querySelectorAll('.reveal');
            if (reveals.length > 0) {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('revealed');
                        }
                    });
                }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
                reveals.forEach(function(el) { observer.observe(el); });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
