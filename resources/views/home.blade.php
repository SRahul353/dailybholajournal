@extends('layouts.app')

@section('title', 'দৈনিক ভোলা জার্নাল | Daily Bhola Journal - সত্য ও ন্যায়ের সন্ধানে সার্বক্ষণিক')

@section('styles')
<style>
    /* ==========================================================================
       The Daily Star Bangla Authentic Broad-sheet Layout Design
       ========================================================================== */

    /* Helpers & Typography */
    .font-serif {
        font-family: 'Noto Serif Bengali', serif !important;
    }
    .hover-danger:hover {
        color: var(--accent, #c90000) !important;
    }

    /* Top Lead Section Grid (2-Column Asymmetrical Grid like Daily Star) */
    .top-lead-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        margin-bottom: 28px;
    }
    @media (min-width: 768px) {
        .top-lead-grid {
            grid-template-columns: 1.45fr 1fr;
        }
    }

    /* Big Lead Article Card */
    .main-lead-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }
    .main-lead-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }
    .main-lead-img-box {
        position: relative;
        width: 100%;
        height: 260px;
        overflow: hidden;
        background-color: #e2e8f0;
    }
    @media (min-width: 768px) {
        .main-lead-img-box {
            height: 340px;
        }
    }
    .main-lead-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .main-lead-card:hover .main-lead-img {
        transform: scale(1.03);
    }
    .main-lead-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background-color: var(--accent, #c90000);
        color: #ffffff;
        padding: 4px 12px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 0.84rem;
        z-index: 10;
        box-shadow: 0 4px 8px rgba(201, 0, 0, 0.3);
    }
    .main-lead-body {
        padding: 22px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
    .main-lead-headline {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.5rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 12px;
        line-height: 1.35;
    }
    @media (min-width: 768px) {
        .main-lead-headline {
            font-size: 1.95rem;
        }
    }
    .main-lead-headline a:hover {
        color: var(--accent, #c90000);
    }
    .main-lead-excerpt {
        color: #374151;
        font-size: 0.98rem;
        margin-bottom: 16px;
        line-height: 1.65;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .main-lead-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 0.82rem;
        color: #6b7280;
        border-top: 1px solid #f1f5f9;
        padding-top: 12px;
    }

    /* Sub-Leads List (Column 2) */
    .sub-leads-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        height: 100%;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }
    .sub-leads-header {
        border-bottom: 2px solid #111827;
        padding-bottom: 8px;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .sub-leads-header h3 {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.25rem;
        font-weight: 800;
        margin: 0;
        color: #111827;
        position: relative;
    }
    .sub-leads-header h3::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 40px;
        height: 2px;
        background-color: var(--accent, #c90000);
    }
    .sub-lead-item {
        display: flex;
        gap: 12px;
        align-items: center;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        transition: transform 0.2s ease;
    }
    .sub-lead-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .sub-lead-item:hover {
        transform: translateX(3px);
    }
    .sub-lead-thumb-box {
        width: 105px;
        height: 74px;
        border-radius: 6px;
        overflow: hidden;
        flex-shrink: 0;
        background-color: #f1f5f9;
    }
    .sub-lead-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .sub-lead-item:hover .sub-lead-thumb {
        transform: scale(1.06);
    }
    .sub-lead-info {
        flex-grow: 1;
        min-width: 0;
    }
    .sub-lead-title {
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1.45;
        color: #111827;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .sub-lead-title a:hover {
        color: var(--accent, #c90000);
    }
    .sub-lead-time {
        font-size: 0.76rem;
        color: #94a3b8;
    }

    /* Bhola District News Module */
    .district-news-bar {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-left: 4px solid var(--accent, #c90000);
        border-radius: 8px;
        padding: 18px 22px;
        margin-bottom: 28px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }
    .district-news-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
    }
    .district-news-header i {
        color: var(--accent, #c90000);
        font-size: 1.4rem;
    }
    .district-news-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.25rem;
        font-weight: 800;
        color: #111827;
        margin: 0;
    }
    .district-controls {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }
    @media (min-width: 640px) {
        .district-controls {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    .district-select-box {
        padding: 8px 14px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.92rem;
        color: #374151;
        outline: none;
        background-color: #ffffff;
        font-weight: 600;
    }
    .district-select-box:focus {
        border-color: var(--accent, #c90000);
        box-shadow: 0 0 0 3px rgba(201, 0, 0, 0.1);
    }
    .district-search-btn {
        background-color: var(--accent, #c90000);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    .district-search-btn:hover {
        background-color: #a50000;
    }
    .district-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 14px;
        align-items: center;
        font-size: 0.85rem;
    }
    .district-pill {
        background-color: #f1f5f9;
        color: #374151;
        padding: 3px 12px;
        border-radius: 20px;
        font-weight: 600;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .district-pill:hover {
        background-color: var(--accent, #c90000);
        color: #ffffff;
        border-color: var(--accent, #c90000);
    }

    /* Daily Star Signature Category Section Headings */
    .daily-star-section-head {
        border-bottom: 2px solid #111827;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        padding-bottom: 6px;
        position: relative;
    }
    .daily-star-sec-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.45rem;
        font-weight: 800;
        color: #111827;
        margin: 0;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        position: relative;
    }
    .daily-star-sec-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: var(--accent, #c90000);
    }
    .daily-star-more-link {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--accent, #c90000);
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .daily-star-more-link:hover {
        color: #111827;
    }

    /* Layout Type 1: 1 Medium Lead + 3 Horizontal Cards (e.g. বাংলাদেশ, রাজনীতি) */
    .cat-split-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    @media (min-width: 768px) {
        .cat-split-grid {
            grid-template-columns: 1.25fr 1fr;
        }
    }
    .cat-lead-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .cat-lead-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.06);
    }
    .cat-lead-img-box {
        position: relative;
        height: 220px;
        overflow: hidden;
        background-color: #e2e8f0;
    }
    .cat-lead-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .cat-lead-card:hover .cat-lead-img {
        transform: scale(1.05);
    }
    .cat-lead-content {
        padding: 16px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .cat-lead-title {
        font-size: 1.28rem;
        font-weight: 800;
        line-height: 1.4;
        color: #111827;
        margin-bottom: 8px;
    }
    .cat-lead-title a:hover {
        color: var(--accent, #c90000);
    }
    .cat-lead-excerpt {
        font-size: 0.92rem;
        color: #4b5563;
        line-height: 1.6;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cat-side-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        justify-content: space-between;
    }
    .cat-side-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        display: flex;
        gap: 12px;
        align-items: center;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }
    .cat-side-card:hover {
        transform: translateX(3px);
        border-color: var(--accent, #c90000);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .cat-side-thumb-box {
        width: 95px;
        height: 70px;
        border-radius: 6px;
        overflow: hidden;
        flex-shrink: 0;
        background-color: #f1f5f9;
    }
    .cat-side-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .cat-side-content {
        flex-grow: 1;
        min-width: 0;
    }
    .cat-side-title {
        font-size: 0.94rem;
        font-weight: 700;
        line-height: 1.4;
        color: #111827;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cat-side-title a:hover {
        color: var(--accent, #c90000);
    }

    /* Layout Type 2: 4-Column Card Grid (e.g. বাণিজ্য, খেলা, বিনোদন) */
    .cat-grid-4 {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }
    @media (min-width: 576px) {
        .cat-grid-4 {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (min-width: 992px) {
        .cat-grid-4 {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    .cat-grid-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .cat-grid-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.08);
        border-color: var(--accent, #c90000);
    }
    .cat-grid-img-box {
        position: relative;
        height: 150px;
        overflow: hidden;
        background-color: #e2e8f0;
    }
    .cat-grid-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .cat-grid-card:hover .cat-grid-img {
        transform: scale(1.05);
    }
    .cat-grid-content {
        padding: 12px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .cat-grid-title {
        font-size: 0.94rem;
        font-weight: 700;
        line-height: 1.45;
        color: #111827;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cat-grid-title a:hover {
        color: var(--accent, #c90000);
    }

    /* Multimedia Showcase (Video & Photo - Dark Theme) */
    .multimedia-strip {
        background-color: #0f172a;
        padding: 32px;
        margin: 36px 0 16px 0;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    .multimedia-strip-head {
        border-bottom: 2px solid rgba(255, 255, 255, 0.12);
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        padding-bottom: 8px;
    }
    .multimedia-strip-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.45rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0;
        position: relative;
    }
    .multimedia-strip-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: var(--accent, #c90000);
    }
    .multimedia-grid-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 18px;
    }
    @media (min-width: 640px) {
        .multimedia-grid-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (min-width: 1024px) {
        .multimedia-grid-row {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    .multimedia-item-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.25s ease;
    }
    .multimedia-item-card:hover {
        transform: translateY(-4px);
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--accent, #c90000);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
    }
    .multimedia-thumb-container {
        position: relative;
        height: 155px;
        background: #000;
        overflow: hidden;
    }
    .multimedia-thumb-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.85;
        transition: transform 0.3s ease;
    }
    .multimedia-item-card:hover .multimedia-thumb-img {
        transform: scale(1.05);
        opacity: 0.95;
    }
    .play-badge-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 44px;
        height: 44px;
        background-color: var(--accent, #c90000);
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(201, 0, 0, 0.4);
        padding-left: 3px;
        transition: transform 0.25s ease;
    }
    .multimedia-item-card:hover .play-badge-icon {
        transform: translate(-50%, -50%) scale(1.12);
        background-color: #ffffff;
        color: var(--accent, #c90000);
    }
</style>
@endsection

@section('content')

    <!-- ==========================================================================
         The Daily Star Signature Main Broadsheet Stream with Persistent Right Rail
         ========================================================================== -->
    <div class="row g-4">
        <!-- Main Content Area (8 Columns on Large Desktop) -->
        <div class="col-lg-8 col-xl-8">
            
            <!-- 1. The Daily Star Signature Top Fold (Lead Story + Sub-Leads) -->
            <div class="top-lead-grid">
                <!-- Main Lead Story -->
                <div>
                    @if($leadPost)
                        <article class="main-lead-card">
                            <div class="main-lead-img-box">
                                <span class="main-lead-badge">
                                    {{ $leadPost->categories->first() ? $leadPost->categories->first()->name : 'শীর্ষ সংবাদ' }}
                                </span>
                                <img src="{{ $leadPost->featured_image_url }}" alt="{{ $leadPost->title }}" class="main-lead-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=800'">
                            </div>
                            <div class="main-lead-body">
                                <div>
                                    <h2 class="main-lead-headline">
                                        <a href="{{ route('post', $leadPost->slug) }}">{{ $leadPost->title }}</a>
                                    </h2>
                                    <p class="main-lead-excerpt">
                                        {!! Str::limit(strip_tags($leadPost->content), 220) !!}
                                    </p>
                                </div>
                                <div class="main-lead-meta">
                                    <span><i class="fa-solid fa-user-pen text-danger me-1"></i>{{ $leadPost->user ? $leadPost->user->name : 'ভোলা জার্নাল ডেস্ক' }}</span>
                                    <span><i class="fa-regular fa-clock me-1"></i>{{ $leadPost->created_at->diffForHumans() }}</span>
                                    <span><i class="fa-regular fa-eye me-1"></i>{{ $leadPost->views_count }} বার পঠিত</span>
                                </div>
                            </div>
                        </article>
                    @else
                        <div class="p-4 text-center border rounded bg-white">
                            <p class="text-muted m-0">কোন সংবাদ পাওয়া যায়নি।</p>
                        </div>
                    @endif
                </div>

                <!-- Sub-Leads List (3-4 Stories) -->
                <div>
                    <div class="sub-leads-card">
                        <div class="sub-leads-header">
                            <h3>শীর্ষ খবর</h3>
                            <small class="text-muted"><i class="fa-solid fa-circle text-danger me-1" style="font-size: 0.55rem;"></i>তাজা খবর</small>
                        </div>
                        @forelse($subLeadPosts as $post)
                            <article class="sub-lead-item">
                                <div class="sub-lead-thumb-box">
                                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="sub-lead-thumb" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=200'" loading="lazy">
                                </div>
                                <div class="sub-lead-info">
                                    <h4 class="sub-lead-title">
                                        <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                    </h4>
                                    <div class="sub-lead-time">
                                        <i class="fa-regular fa-clock me-1"></i>{{ $post->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </article>
                        @empty
                            <p class="text-muted py-2 m-0 text-center">শীর্ষ খবর পাওয়া যায়নি।</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- 2. Bhola District Grassroots News Module (ভোলা জেলার সংবাদ) -->
            <div class="district-news-bar">
                <div class="district-news-header">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <div>
                        <h3 class="district-news-title">ভোলা জেলার সংবাদ</h3>
                        <small class="text-muted">ভোলার ৭টি উপজেলার তৃণমূলের খবরাখবর</small>
                    </div>
                </div>
                <div class="district-controls">
                    <select class="district-select-box" id="upazilaSelect" onchange="loadUnions()">
                        <option value="">উপজেলা নির্বাচন করুন</option>
                        <option value="ভোলা সদর">ভোলা সদর</option>
                        <option value="চরফ্যাশন">চরফ্যাশন</option>
                        <option value="লালমোহন">লালমোহন</option>
                        <option value="বোরহানউদ্দিন">বোরহানউদ্দিন</option>
                        <option value="তজুমদ্দিন">তজুমদ্দিন</option>
                        <option value="দৌলতখান">দৌলতখান</option>
                        <option value="মনপুরা">মনপুরা</option>
                    </select>
                    <select class="district-select-box" id="unionSelect" disabled>
                        <option value="">ইউনিয়ন নির্বাচন করুন</option>
                    </select>
                    <button class="district-search-btn" onclick="searchBholaNews()">
                        <i class="fa-solid fa-magnifying-glass me-1"></i>খুঁজুন
                    </button>
                </div>
                <div class="district-pills">
                    <span class="fw-bold text-muted">উপজেলা:</span>
                    <a href="{{ route('search') }}?query={{ urlencode('ভোলা সদর') }}" class="district-pill">ভোলা সদর</a>
                    <a href="{{ route('search') }}?query={{ urlencode('চরফ্যাশন') }}" class="district-pill">চরফ্যাশন</a>
                    <a href="{{ route('search') }}?query={{ urlencode('লালমোহন') }}" class="district-pill">লালমোহন</a>
                    <a href="{{ route('search') }}?query={{ urlencode('বোরহানউদ্দিন') }}" class="district-pill">বোরহানউদ্দিন</a>
                    <a href="{{ route('search') }}?query={{ urlencode('তজুমদ্দিন') }}" class="district-pill">তজুমদ্দিন</a>
                    <a href="{{ route('search') }}?query={{ urlencode('মনপুরা') }}" class="district-pill">মনপুরা</a>
                    <a href="{{ route('search') }}?query={{ urlencode('দৌলতখান') }}" class="district-pill">দৌলতখান</a>
                </div>
            </div>

            <!-- 3. Mid-Leaderboard Ad Slot (728x90) -->
            <div class="my-4 text-center">
                <span style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 4px;">বিজ্ঞাপন</span>
                <div style="width: 100%; height: 90px; background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 6px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8; font-size: 0.85rem;">
                    <span class="fw-bold">বিজ্ঞাপনের জন্য স্থান নির্ধারিত (728x90)</span>
                    <small style="color: #cbd5e1;">দৈনিক ভোলা জার্নাল ডিজিটাল বিজ্ঞাপন</small>
                </div>
            </div>

            <!-- 4. Thematic Category Streams (Daily Star Signature Sections) -->
            @php $sectionIndex = 0; @endphp
            @foreach($categoriesWithPosts as $cat)
                @if($cat->posts->count() > 0)
                    <section class="mb-5">
                        <div class="daily-star-section-head">
                            <h3 class="daily-star-sec-title">
                                <span>{{ $cat->display_name ?? $cat->name }}</span>
                            </h3>
                            <a href="{{ route('category', $cat->slug) }}" class="daily-star-more-link">
                                <span>আরও খবর</span>
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </div>

                        @if($sectionIndex % 2 == 0)
                            <!-- Layout Style A: 1 Lead + 3 Horizontal Cards -->
                            <div class="cat-split-grid">
                                <div class="cat-split-left d-flex flex-column">
                                    @php $firstPost = $cat->posts->first(); @endphp
                                    @if($firstPost)
                                        <article class="cat-lead-card">
                                            <div class="cat-lead-img-box">
                                                <img src="{{ $firstPost->featured_image_url }}" alt="{{ $firstPost->title }}" class="cat-lead-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=500'" loading="lazy">
                                            </div>
                                            <div class="cat-lead-content">
                                                <h4 class="cat-lead-title">
                                                    <a href="{{ route('post', $firstPost->slug) }}">{{ $firstPost->title }}</a>
                                                </h4>
                                                <p class="cat-lead-excerpt">
                                                    {!! Str::limit(strip_tags($firstPost->content), 140) !!}
                                                </p>
                                                <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="font-size: 0.78rem; color: #94a3b8;">
                                                    <span><i class="fa-regular fa-clock me-1"></i>{{ $firstPost->created_at->diffForHumans() }}</span>
                                                    <span><i class="fa-regular fa-eye me-1"></i>{{ $firstPost->views_count }}</span>
                                                </div>
                                            </div>
                                        </article>
                                    @endif
                                </div>

                                <div class="cat-side-list">
                                    @foreach($cat->posts->skip(1)->take(3) as $post)
                                        <article class="cat-side-card">
                                            <div class="cat-side-thumb-box">
                                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="cat-side-thumb" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=200'" loading="lazy">
                                            </div>
                                            <div class="cat-side-content">
                                                <h4 class="cat-side-title">
                                                    <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                                </h4>
                                                <small class="text-muted" style="font-size: 0.76rem;">
                                                    <i class="fa-regular fa-clock me-1"></i>{{ $post->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Layout Style B: 4-Column Card Grid -->
                            <div class="cat-grid-4">
                                @foreach($cat->posts->take(4) as $post)
                                    <article class="cat-grid-card">
                                        <div class="cat-grid-img-box">
                                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="cat-grid-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'" loading="lazy">
                                        </div>
                                        <div class="cat-grid-content">
                                            <h4 class="cat-grid-title">
                                                <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                            </h4>
                                            <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="font-size: 0.76rem; color: #94a3b8;">
                                                <span><i class="fa-regular fa-clock me-1"></i>{{ $post->created_at->diffForHumans() }}</span>
                                                <span><i class="fa-regular fa-eye me-1"></i>{{ $post->views_count }}</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    </section>
                    @php $sectionIndex++; @endphp
                @endif
            @endforeach

        </div>

        <!-- Right Persistent Rail / Sidebar (4 Columns on Desktop) -->
        <div class="col-lg-4 col-xl-4">
            @include('layouts.partials.sidebar')
        </div>
    </div>

    <!-- ==========================================================================
         Multimedia Showcase / Popular Highlights (Sleek Dark Theme)
         ========================================================================== -->
    <div class="multimedia-strip">
        <div class="multimedia-strip-head">
            <h3 class="multimedia-strip-title">
                <i class="fa-solid fa-fire-flame-curved me-2 text-danger"></i>জনপ্রিয় সংবাদ
            </h3>
            <a href="#" class="daily-star-more-link text-white">
                <span>আরও খবর</span>
                <i class="fa-solid fa-angle-right ms-1"></i>
            </a>
        </div>
        <div class="multimedia-grid-row">
            @forelse($popularPosts->take(4) as $post)
                <article class="multimedia-item-card">
                    <div class="multimedia-thumb-container">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="multimedia-thumb-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'" loading="lazy">
                        <span class="main-lead-badge" style="top: 10px; left: 10px; font-size: 0.75rem; padding: 2px 8px;">
                            {{ $post->categories->first()?->name ?? 'জনপ্রিয়' }}
                        </span>
                    </div>
                    <div class="p-3 flex-grow-1 d-flex flex-column justify-content-between">
                        <h4 class="m-0" style="font-size: 0.94rem; font-weight: 700; color: #e2e8f0; line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <a href="{{ route('post', $post->slug) }}" class="text-white hover-danger">{{ $post->title }}</a>
                        </h4>
                        <div class="d-flex align-items-center justify-content-between mt-2 pt-2 border-top" style="border-color: rgba(255,255,255,0.1) !important; font-size: 0.76rem; color: #94a3b8;">
                            <span><i class="fa-regular fa-clock me-1"></i>{{ $post->created_at->diffForHumans() }}</span>
                            <span><i class="fa-regular fa-eye me-1"></i>{{ $post->views_count }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-white-50 text-center py-4">কোন জনপ্রিয় সংবাদ পাওয়া যায়নি।</p>
            @endforelse
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // Bhola district Upazilas and Unions data map
    const upazilaUnions = {
        "ভোলা সদর": ["পূর্ব ইলিশা", "পশ্চিম ইলিশা", "বাপ্তা", "ধনিয়া", "আলীনগর", "চরসামাইয়া", "ভেদুরিয়া", "চরশিবলি", "রাজাপুর", "উত্তর দিঘলদী", "দক্ষিণ দিঘলদী", "কাচিয়া", "শিবপুর"],
        "চরফ্যাশন": ["ওসমানগঞ্জ", "আসলামপুর", "জিন্নাহগড়", "আমিনাবাদ", "চরমাদ্রাজ", "চরকলমি", "হাজারীগঞ্জ", "এওয়াজপুর", "জাহানপুর", "নীলকমল", "নূরাবাদ", "কুকরী মুকরী", "ঢালচর", "মজিবনগর"],
        "লালমোহন": ["কালমা", "চরভূতা", "লর্ড হার্ডিঞ্জ", "ধলীগৌরনগর", "বদরপুর", "লালমোহন", "চর উমেদ"],
        "বোরহানউদ্দিন": ["গঙ্গাপুর", "সাচড়া", "দেউলা", "টবগী", "পক্ষিয়া", "বড় মানিকা", "কুতুবা", "কাচিয়া", "হাসাননগর"],
        "তজুমদ্দিন": ["বড় মলংচড়া", "সোনাপুর", "চাঁদপুর", "চাচড়া", "শম্ভুপুর"],
        "দৌলতখান": ["মদনপুর", "মেদুয়া", "চরপাতা", "উত্তর জয়নগর", "দক্ষিণ জয়নগর", "চরখলিফা", "সৈয়দপুর", "ভবানীপুর", "হাজিপুর"],
        "মনপুরা": ["মনপুরা", "হাজিরহাট", "উত্তর সাকুচিয়া", "দক্ষিণ সাকুচিয়া"]
    };

    function loadUnions() {
        const upazilaSelect = document.getElementById('upazilaSelect');
        const unionSelect = document.getElementById('unionSelect');
        const selectedUpazila = upazilaSelect.value;

        unionSelect.innerHTML = '<option value="">ইউনিয়ন নির্বাচন করুন</option>';

        if (selectedUpazila && upazilaUnions[selectedUpazila]) {
            unionSelect.disabled = false;
            upazilaUnions[selectedUpazila].forEach(union => {
                const option = document.createElement('option');
                option.value = union;
                option.textContent = union;
                unionSelect.appendChild(option);
            });
        } else {
            unionSelect.disabled = true;
        }
    }

    function searchBholaNews() {
        const unionSelect = document.getElementById('unionSelect');
        const union = unionSelect ? unionSelect.value : '';
        if (union) {
            window.location.href = `{{ route('search') }}?query=${encodeURIComponent(union)}`;
        } else {
            const upazilaSelect = document.getElementById('upazilaSelect');
            const upazila = upazilaSelect ? upazilaSelect.value : '';
            if (upazila) {
                window.location.href = `{{ route('search') }}?query=${encodeURIComponent(upazila)}`;
            } else {
                alert('অনুগ্রহ করে উপজেলা বা ইউনিয়ন নির্বাচন করুন।');
            }
        }
    }

    function selectQuickUpazila(upazilaName) {
        window.location.href = `{{ route('search') }}?query=${encodeURIComponent(upazilaName)}`;
    }
</script>
@endsection
