@php
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
        @if(!empty($themeSettings['logo_image']))
            <img src="{{ asset($themeSettings['logo_image']) }}" alt="দৈনিক ভোলা জার্নাল" style="max-height: 38px; display: inline-block;">
        @else
            <h3 class="footer-brand-title">{!! $themeSettings['logo_text'] ?? 'দৈনিক ভোলা<span>জার্নাল</span>' !!}</h3>
        @endif
        <button class="mobile-drawer-close" id="closeDrawer"><i class="fa-solid fa-xmark"></i></button>
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
        <li><a href="/epaper" class="mobile-drawer-link"><i class="fa-solid fa-newspaper me-2"></i>ই-পেপার</a></li>
    </ul>
    <form action="{{ route('search') }}" method="GET" class="search-box" style="margin-top: 16px;">
        <input type="text" name="query" placeholder="অনুসন্ধান করুন..." class="search-input" style="width: 100%;">
        <button type="submit" class="search-icon-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
</div>

<!-- Top Utility Bar (Daily Star Style) -->
<div class="top-bar">
    <div class="container d-flex justify-content-center justify-content-md-between align-items-center">
        <div class="date-time text-center text-md-start">
            <i class="fa-solid fa-calendar-days text-danger me-1"></i>
            <span id="currentDate"></span>
            <span style="color: rgba(255, 255, 255, 0.25); margin: 0 8px;">|</span>
            <span id="banglaDate"></span>
        </div>
        <div class="top-nav-links d-none d-md-flex align-items-center gap-3">
            <a href="/epaper" class="top-nav-link"><i class="fa-solid fa-newspaper me-1 text-danger"></i>ই-পেপার</a>
            <span style="color: rgba(255, 255, 255, 0.25)">|</span>
            <a href="#" class="top-nav-link">English</a>
            <div class="top-socials">
                <a href="{{ $themeSettings['social_facebook'] ?? '#' }}" target="_blank" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="{{ $themeSettings['social_twitter'] ?? '#' }}" target="_blank" title="Twitter / X"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="{{ $themeSettings['social_youtube'] ?? '#' }}" target="_blank" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                <a href="{{ $themeSettings['social_instagram'] ?? '#' }}" target="_blank" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Branding Header Section (Masthead & Header Ad) -->
<header class="main-header">
    <div class="container">
        <div class="row align-items-center">
            <!-- Logo & Tagline -->
            <div class="col-12 col-md-4 col-lg-4 text-center text-md-start mb-3 mb-md-0">
                <div class="header-logo">
                    <a href="{{ route('home') }}">
                        @if(!empty($themeSettings['logo_image']))
                            <img src="{{ asset($themeSettings['logo_image']) }}" alt="দৈনিক ভোলা জার্নাল" style="max-height: 58px; display: inline-block;">
                        @else
                            <h1 class="logo-text" style="font-size: 2.5rem; margin: 0; line-height: 1;">{!! $themeSettings['logo_text'] ?? 'দৈনিক ভোলা<span>জার্নাল</span>' !!}</h1>
                            <div class="logo-tagline" style="font-size: 0.8rem; color: #6b7280; letter-spacing: 1px; font-weight: 600; margin-top: 4px;">সত্য ও ন্যায়ের সন্ধানে সার্বক্ষণিক</div>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Header Banner Ad Space (728x90) -->
            <div class="col-12 col-md-8 col-lg-8 d-none d-md-flex justify-content-end align-items-center">
                <div class="header-ad-frame text-end">
                    <span class="header-ad-label">বিজ্ঞাপন</span>
                    <div class="header-ad-box" style="width: 100%; max-width: 520px; height: 80px;">
                        <span>বিজ্ঞাপনের জন্য যোগাযোগ করুন: {{ $themeSettings['contact_phone'] ?? '01716-674375' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Navigation Header Sticky Bar (Daily Star Style) -->
<nav class="nav-bar">
    <div class="container nav-container">
        <!-- Mobile Toggle Button -->
        <button class="mobile-menu-toggle d-block d-md-none text-dark me-2" id="openDrawerMobile">
            <i class="fa-solid fa-bars"></i>
        </button>

        <ul class="nav-menu d-none d-md-flex">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fa-solid fa-house-chimney me-1" style="font-size: 0.9rem;"></i> প্রথম পাতা
                </a>
            </li>
            
            @php
                $topLevelItems = array_values($menuItems);
                $displayLimit = 9;
                
                $visibleItems = array_slice($topLevelItems, 0, $displayLimit);
                $dropdownItems = array_slice($topLevelItems, $displayLimit);
            @endphp
            
            <!-- Visible Menu Items -->
            @foreach($visibleItems as $item)
                @php
                    $cat = $item['category'];
                    $children = $item['children'];
                    $hasChildren = count($children) > 0;
                @endphp
                
                @if($hasChildren)
                    <li class="nav-item dropdown">
                        <a href="{{ route('category', $cat->slug) }}" class="nav-link dropdown-toggle {{ request()->is('category/' . $cat->slug) ? 'active' : '' }}" id="navbarDropdown{{ $cat->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $cat->name }} <i class="fa-solid fa-chevron-down ms-1" style="font-size: 0.7rem;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark animate fade-in" aria-labelledby="navbarDropdown{{ $cat->id }}" style="background-color: var(--primary); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; box-shadow: var(--shadow-lg);">
                            @foreach($children as $child)
                                <li><a class="dropdown-item py-2 px-3 {{ request()->is('category/' . $child->slug) ? 'active' : '' }}" href="{{ route('category', $child->slug) }}">{{ $child->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('category', $cat->slug) }}" class="nav-link {{ request()->is('category/' . $cat->slug) ? 'active' : '' }}">{{ $cat->name }}</a>
                    </li>
                @endif
            @endforeach
            
            <!-- "More" (আরও) Dropdown if total items > 9 -->
            @if(count($dropdownItems) > 0)
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMore" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        আরও <i class="fa-solid fa-chevron-down ms-1" style="font-size: 0.7rem;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end animate fade-in" aria-labelledby="navbarDropdownMore" style="background-color: var(--primary); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; box-shadow: var(--shadow-lg);">
                        @foreach($dropdownItems as $item)
                            @php
                                $cat = $item['category'];
                                $children = $item['children'];
                                $hasChildren = count($children) > 0;
                            @endphp
                            @if($hasChildren)
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item py-2 px-3 d-flex justify-content-between align-items-center" href="{{ route('category', $cat->slug) }}">
                                        {{ $cat->name }} <i class="fa-solid fa-chevron-right ms-2" style="font-size: 0.7rem;"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark" style="background-color: var(--primary); border: 1px solid rgba(255,255,255,0.1); margin-left: 2px;">
                                        @foreach($children as $child)
                                            <li><a class="dropdown-item py-2 px-3" href="{{ route('category', $child->slug) }}">{{ $child->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li><a class="dropdown-item py-2 px-3 {{ request()->is('category/' . $cat->slug) ? 'active' : '' }}" href="{{ route('category', $cat->slug) }}">{{ $cat->name }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif
        </ul>

        <div class="d-flex align-items-center gap-2">
            <a href="/epaper" class="btn btn-sm btn-outline-danger d-none d-lg-inline-flex align-items-center me-2" style="font-size: 0.82rem; font-weight: 700; border-radius: 4px; padding: 4px 10px;">
                <i class="fa-solid fa-newspaper me-1"></i> ই-পেপার
            </a>
            <form action="{{ route('search') }}" method="GET" class="search-box">
                <input type="text" name="query" value="{{ request('query') }}" placeholder="খুঁজুন..." class="search-input">
                <button type="submit" class="search-icon-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
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
