@php
    if (!isset($themeSettings) || empty($themeSettings)) {
        $themeSettingsPath = storage_path('app/theme_settings.json');
        $themeSettings = [
            'logo_text' => 'দৈনিক ভোলা<span>জার্নাল</span>',
            'logo_image' => '',
            'footer_logo_image' => '',
            'primary_color' => '#111827',
            'accent_color' => '#c90000',
            'bg_site' => '#f4f5f8',
            'text_main' => '#1f2937',
            'contact_phone' => '01716-674375'
        ];
        if (file_exists($themeSettingsPath)) {
            $themeSettings = array_merge($themeSettings, json_decode(file_get_contents($themeSettingsPath), true) ?: []);
        }
    }

    $menuStructure = $themeSettings['menu_structure'] ?? [];
    $menuItems = [];
    
    if (!empty($menuStructure)) {
        $items = is_string($menuStructure) ? json_decode($menuStructure, true) : $menuStructure;
        
        $categoriesById = \App\Models\Category::whereIn('id', array_column($items, 'id'))->get()->keyBy('id');
        
        $currentParent = null;
        foreach ($items as $item) {
            $catId = $item['id'];
            $depth = $item['depth'] ?? 0;
            
            if (isset($categoriesById[$catId])) {
                $category = $categoriesById[$catId];
                if ($depth == 0) {
                    $currentParent = $catId;
                    $menuItems[$catId] = [
                        'category' => $category,
                        'children' => []
                    ];
                } else if ($currentParent !== null) {
                    $menuItems[$currentParent]['children'][] = $category;
                } else {
                    $menuItems[$catId] = [
                        'category' => $category,
                        'children' => []
                    ];
                }
            }
        }
    } else {
        $defaultCategories = \App\Models\Category::has('posts')->limit(10)->get();
        foreach ($defaultCategories as $cat) {
            $menuItems[$cat->id] = [
                'category' => $cat,
                'children' => []
            ];
        }
    }
@endphp

<!-- Overlay & Mobile Drawer -->
<div class="overlay" id="siteOverlay"></div>
<div class="mobile-drawer" id="mobileDrawer">
    <div class="mobile-drawer-header">
        @if(!empty($themeSettings['logo_image']) && file_exists(public_path($themeSettings['logo_image'])))
            <img src="{{ asset($themeSettings['logo_image']) }}?v={{ filemtime(public_path($themeSettings['logo_image'])) }}" alt="দৈনিক ভোলা জার্নাল" style="max-height: 40px; width: auto; max-width: 100%; object-fit: contain; display: inline-block;">
        @else
            <h3 class="footer-brand-title mb-0">{!! $themeSettings['logo_text'] ?? 'দৈনিক ভোলা<span>জার্নাল</span>' !!}</h3>
        @endif
        <button class="mobile-drawer-close" id="closeDrawer" aria-label="বন্ধ করুন"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <!-- Mobile Date inside Drawer -->
    <div class="py-2 px-1 text-white-50 border-bottom" style="font-size: 0.82rem; border-color: rgba(255,255,255,0.12) !important;">
        <i class="fa-regular fa-calendar-days text-danger me-1"></i>
        <span class="currentDateText"></span>
    </div>

    <ul class="mobile-drawer-links">
        <li><a href="{{ route('home') }}" class="mobile-drawer-link"><i class="fa-solid fa-house-chimney me-2"></i>প্রথম পাতা</a></li>
        @foreach($menuItems as $item)
            @php
                $cat = $item['category'];
                $children = $item['children'];
                $hasChildren = count($children) > 0;
            @endphp
            
            @if($hasChildren)
                <li>
                    <a href="{{ route('category', $cat->slug) }}" class="mobile-drawer-link d-flex justify-content-between align-items-center">
                        <span>{{ $cat->name }}</span>
                    </a>
                    <ul class="list-unstyled ps-3 ms-2 border-start" style="border-color: rgba(255,255,255,0.15) !important;">
                        @foreach($children as $child)
                            <li><a href="{{ route('category', $child->slug) }}" class="mobile-drawer-link py-1" style="font-size: 0.95rem; color: #cbd5e1;">— {{ $child->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li><a href="{{ route('category', $cat->slug) }}" class="mobile-drawer-link">{{ $cat->name }}</a></li>
            @endif
        @endforeach
        <li><a href="/epaper" class="mobile-drawer-link"><i class="fa-solid fa-newspaper me-2 text-danger"></i>ই-পেপার</a></li>
    </ul>

    <form action="{{ route('search') }}" method="GET" class="search-box" style="margin-top: 16px;">
        <input type="text" name="query" placeholder="অনুসন্ধান করুন..." class="search-input" style="width: 100%;">
        <button type="submit" class="search-icon-btn" aria-label="খুঁজুন"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>

    <!-- Mobile Drawer Social Links -->
    <div class="d-flex justify-content-center gap-3 pt-3 mt-auto border-top" style="border-color: rgba(255,255,255,0.12) !important;">
        <a href="{{ $themeSettings['social_facebook'] ?? '#' }}" target="_blank" class="text-white-50 hover-danger" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="{{ $themeSettings['social_twitter'] ?? '#' }}" target="_blank" class="text-white-50 hover-danger" title="Twitter / X"><i class="fa-brands fa-x-twitter"></i></a>
        <a href="{{ $themeSettings['social_youtube'] ?? '#' }}" target="_blank" class="text-white-50 hover-danger" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
        <a href="{{ $themeSettings['social_instagram'] ?? '#' }}" target="_blank" class="text-white-50 hover-danger" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
    </div>
</div>

<!-- ==========================================================================
     PART 1: Masthead — 3-Column Layout
     ========================================================================== -->
<header class="main-header">
    <div class="container">
        <div class="masthead-grid">

            {{-- ── COL 1: Logo + Date ── --}}
            <div class="masthead-col masthead-col-logo">
                <a href="{{ route('home') }}" class="d-inline-block masthead-logo-link">
                    @if(!empty($themeSettings['logo_image']) && file_exists(public_path($themeSettings['logo_image'])))
                        <img src="{{ asset($themeSettings['logo_image']) }}?v={{ filemtime(public_path($themeSettings['logo_image'])) }}"
                             alt="দৈনিক ভোলা জার্নাল"
                             class="masthead-logo-img">
                    @else
                        <h1 class="logo-text">{!! $themeSettings['logo_text'] ?? 'দৈনিক ভোলা<span>জার্নাল</span>' !!}</h1>
                        <div class="logo-tagline">সত্য ও ন্যায়ের সন্ধানে সার্বক্ষণিক</div>
                    @endif
                </a>
                <div class="masthead-date-box">
                    <i class="fa-regular fa-calendar-days text-danger me-1"></i>
                    <span class="currentDateText"></span>
                    <span class="mx-1 text-muted">|</span>
                    <span class="banglaDateText"></span>
                </div>
            </div>

            {{-- ── COL 2: Quick Links + Social + Search ── --}}
            <div class="masthead-col masthead-col-center">
                {{-- Quick links row --}}
                <div class="masthead-quicklinks">
                    <a href="/epaper" class="mql-item">
                        <i class="fa-solid fa-newspaper"></i> আজকের পত্রিকা
                    </a>
                    <span class="mql-sep"></span>
                    <a href="/epaper?tab=archive" class="mql-item">
                        <i class="fa-solid fa-folder-open"></i> আর্কাইভ
                    </a>
                    <span class="mql-sep"></span>
                    <a href="#" class="mql-item">
                        <i class="fa-solid fa-bookmark"></i> বিশেষ প্রতিবেদন
                    </a>
                </div>

                {{-- Social icons + Search row --}}
                <div class="masthead-social-search">
                    <div class="masthead-social">
                        <a href="{{ $themeSettings['social_facebook'] ?? '#' }}" target="_blank" title="Facebook" class="msd-link msd-fb"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="{{ $themeSettings['social_twitter'] ?? '#' }}" target="_blank" title="Twitter / X" class="msd-link msd-x"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="{{ $themeSettings['social_youtube'] ?? '#' }}" target="_blank" title="YouTube" class="msd-link msd-yt"><i class="fa-brands fa-youtube"></i></a>
                        <a href="{{ $themeSettings['social_instagram'] ?? '#' }}" target="_blank" title="Instagram" class="msd-link msd-ig"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                    <form action="{{ route('search') }}" method="GET" class="masthead-search">
                        <input type="text" name="query" value="{{ request('query') }}" placeholder="সংবাদ অনুসন্ধান করুন..." class="masthead-search-input">
                        <button type="submit" class="masthead-search-btn" aria-label="খুঁজুন">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── COL 3: Advertisement ── --}}
            <div class="masthead-col masthead-col-ad">
                <span class="header-ad-label">বিজ্ঞাপন</span>
                <div class="header-ad-box">
                    <span>বিজ্ঞাপনের জন্য যোগাযোগ করুন<br><strong>{{ $themeSettings['contact_phone'] ?? '01716-674375' }}</strong></span>
                </div>
            </div>

        </div>{{-- /.masthead-grid --}}

        {{-- Mobile date (shown on small screens only) --}}
        <div class="d-flex d-md-none align-items-center justify-content-center gap-1 pb-1 text-muted" style="font-size: 0.78rem; font-family: 'Noto Sans Bengali', sans-serif;">
            <i class="fa-regular fa-calendar-days text-danger"></i>
            <span class="currentDateText"></span>
        </div>
    </div>
</header>

<!-- ==========================================================================
     PART 2: Sticky Category Navigation Bar
     ========================================================================== -->
<nav class="nav-bar">
    <div class="container nav-container">

        {{-- Mobile Toggle --}}
        <button class="mobile-menu-toggle d-block d-md-none text-dark me-2" id="openDrawerMobile" aria-label="মেনু খুলুন">
            <i class="fa-solid fa-bars"></i>
        </button>

        {{-- Category Menu (desktop) --}}
        <ul class="nav-menu d-none d-md-flex">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" title="প্রথম পাতা">
                    <i class="fa-solid fa-house-chimney me-1" style="font-size: 0.9rem;"></i> প্রথম পাতা
                </a>
            </li>

            @php
                $topLevelItems = array_values($menuItems);
                $displayLimit  = 8;
                $visibleItems  = array_slice($topLevelItems, 0, $displayLimit);
                $dropdownItems = array_slice($topLevelItems, $displayLimit);
            @endphp

            @foreach($visibleItems as $item)
                @php
                    $cat         = $item['category'];
                    $children    = $item['children'];
                    $hasChildren = count($children) > 0;
                @endphp
                @if($hasChildren)
                    <li class="nav-item dropdown">
                        <a href="{{ route('category', $cat->slug) }}"
                           class="nav-link dropdown-toggle {{ request()->is('category/'.$cat->slug) ? 'active' : '' }}"
                           id="navbarDropdown{{ $cat->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $cat->name }} <i class="fa-solid fa-chevron-down ms-1" style="font-size: 0.65rem;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark animate fade-in"
                            aria-labelledby="navbarDropdown{{ $cat->id }}"
                            style="background-color: var(--primary); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; box-shadow: var(--shadow-lg);">
                            @foreach($children as $child)
                                <li><a class="dropdown-item py-2 px-3 {{ request()->is('category/'.$child->slug) ? 'active' : '' }}"
                                       href="{{ route('category', $child->slug) }}">{{ $child->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('category', $cat->slug) }}"
                           class="nav-link {{ request()->is('category/'.$cat->slug) ? 'active' : '' }}">{{ $cat->name }}</a>
                    </li>
                @endif
            @endforeach

            @if(count($dropdownItems) > 0)
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMore"
                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        আরও <i class="fa-solid fa-chevron-down ms-1" style="font-size: 0.65rem;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end animate fade-in"
                        aria-labelledby="navbarDropdownMore"
                        style="background-color: var(--primary); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; box-shadow: var(--shadow-lg);">
                        @foreach($dropdownItems as $item)
                            @php
                                $cat         = $item['category'];
                                $children    = $item['children'];
                                $hasChildren = count($children) > 0;
                            @endphp
                            @if($hasChildren)
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item py-2 px-3 d-flex justify-content-between align-items-center"
                                       href="{{ route('category', $cat->slug) }}">
                                        {{ $cat->name }} <i class="fa-solid fa-chevron-right ms-2" style="font-size: 0.7rem;"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark"
                                        style="background-color: var(--primary); border: 1px solid rgba(255,255,255,0.1); margin-left: 2px;">
                                        @foreach($children as $child)
                                            <li><a class="dropdown-item py-2 px-3"
                                                   href="{{ route('category', $child->slug) }}">{{ $child->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li><a class="dropdown-item py-2 px-3 {{ request()->is('category/'.$cat->slug) ? 'active' : '' }}"
                                       href="{{ route('category', $cat->slug) }}">{{ $cat->name }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif
        </ul>

    </div>
</nav>

<!-- Breaking News Ticker System (Daily Star Style) -->
@php
    $tickerPosts = \App\Models\Post::where('status', 'publish')->latest()->limit(8)->get();
@endphp
@if($tickerPosts->count() > 0)
    <div class="ticker-section">
        <div class="container">
            <div class="ticker-container">
                <div class="ticker-label">
                    <i class="fa-solid fa-bolt-lightning"></i>
                    <span>চলমান</span>
                </div>
                <div class="ticker-wrap">
                    <div class="ticker-marquee">
                        @foreach($tickerPosts as $post)
                            <a href="{{ route('post', $post->slug) }}" class="ticker-item">
                                <span class="ticker-bullet"></span>
                                {{ $post->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
