@php
    if (!isset($popularPosts) || $popularPosts->isEmpty()) {
        $popularPosts = \App\Models\Post::where('status', 'publish')
            ->orderBy('views_count', 'desc')
            ->latest()
            ->limit(8)
            ->get();
    }
    if (!isset($latestPosts) || $latestPosts->isEmpty()) {
        $latestPosts = \App\Models\Post::where('status', 'publish')
            ->latest()
            ->limit(8)
            ->get();
    }
    if (!isset($opinionPosts) || $opinionPosts->isEmpty()) {
        $opinionPosts = \App\Models\Post::with('user')
            ->where('status', 'publish')
            ->whereHas('categories', function($q) {
                $q->whereIn('categories.slug', ['opinion', 'editorial'])
                  ->orWhere('categories.name', 'LIKE', '%মতামত%')
                  ->orWhere('categories.name', 'LIKE', '%সম্পাদকীয়%')
                  ->orWhere('categories.name', 'LIKE', '%কলাম%');
            })
            ->latest()
            ->limit(8)
            ->get();

        if ($opinionPosts->count() < 3) {
            $fallback = \App\Models\Post::with('user')
                ->where('status', 'publish')
                ->whereNotIn('id', $opinionPosts->pluck('id'))
                ->latest()
                ->limit(4 - $opinionPosts->count())
                ->get();
            $opinionPosts = $opinionPosts->merge($fallback);
        }
    }
    $bnNumbers = [1=>'১', 2=>'২', 3=>'৩', 4=>'৪', 5=>'৫', 6=>'৬', 7=>'৭', 8=>'৮'];
@endphp

<style>
    /* ==========================================================================
       Sidebar Rail Component Styles (Prothom Alo & Daily Star Bangla Standard)
       ========================================================================== */
    .sidebar-sticky {
        position: static; /* Sticky turned off as requested */
    }

    /* ── Tabbed Feed Widget (সর্বশেষ, সর্বাধিক পঠিত ও মতামত) ── */
    .sidebar-tabbed-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
    }
    .sidebar-tab-header {
        display: flex;
        background-color: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        position: relative;
    }
    .sidebar-tab-nav-btn {
        flex: 1;
        padding: 12px 4px;
        border: none;
        background: transparent;
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.90rem;
        font-weight: 700;
        color: #64748b;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: all 0.25s ease;
        position: relative;
        white-space: nowrap;
    }
    .sidebar-tab-nav-btn::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: transparent;
        transition: all 0.25s ease;
    }
    .sidebar-tab-nav-btn.active {
        color: var(--accent, #c90000);
        background: #ffffff;
    }
    .sidebar-tab-nav-btn.active::after {
        background: var(--accent, #c90000);
        height: 3px;
    }
    .sidebar-tab-nav-btn:hover:not(.active) {
        color: #111827;
        background: #f1f5f9;
    }
    .sidebar-tab-pane {
        display: none;
        padding: 12px 14px;
        animation: sidebarFadeIn 0.25s ease;
    }
    .sidebar-tab-pane.active {
        display: block;
    }
    @keyframes sidebarFadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .sidebar-feed-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
    }
    .sidebar-feed-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: transform 0.2s ease;
    }
    .sidebar-feed-item:last-child {
        border-bottom: none;
        padding-bottom: 2px;
    }
    .sidebar-feed-item:hover {
        transform: translateX(3px);
    }
    /* 1 to 8 Serial Number Badges */
    .sidebar-rank-badge {
        width: 24px;
        height: 24px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.88rem;
        font-weight: 800;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    .sidebar-rank-badge-latest {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }
    .sidebar-feed-item:hover .sidebar-rank-badge-latest {
        background: var(--accent, #c90000);
        color: #ffffff;
        border-color: var(--accent, #c90000);
    }
    .sidebar-rank-top-1 {
        background: var(--accent, #c90000);
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(201, 0, 0, 0.35);
    }
    .sidebar-rank-top-2 {
        background: #111827;
        color: #ffffff;
    }
    .sidebar-rank-top-3 {
        background: #1f2937;
        color: #ffffff;
    }
    .sidebar-rank-other {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    .sidebar-rank-badge-opinion {
        background: #fef2f2;
        color: var(--accent, #c90000);
        border: 1px solid #fee2e2;
    }
    .sidebar-feed-item:hover .sidebar-rank-badge-opinion {
        background: var(--accent, #c90000);
        color: #ffffff;
        border-color: var(--accent, #c90000);
    }

    /* Thumbnail Box alongside news in sidebar */
    .sidebar-feed-thumb-box {
        width: 74px;
        height: 52px;
        border-radius: 6px;
        overflow: hidden;
        flex-shrink: 0;
        background-color: #e2e8f0;
        position: relative;
    }
    .sidebar-feed-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }
    .sidebar-feed-item:hover .sidebar-feed-thumb {
        transform: scale(1.08);
    }

    .sidebar-feed-content {
        flex-grow: 1;
        min-width: 0;
    }
    .sidebar-feed-title {
        font-family: 'Noto Serif Bengali', serif !important;
        font-size: 0.92rem;
        font-weight: 700;
        line-height: 1.42;
        color: #111827;
        margin: 0 0 3px 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .sidebar-feed-title a {
        color: #111827;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .sidebar-feed-title a:hover {
        color: var(--accent, #c90000);
    }
    .sidebar-feed-meta {
        font-size: 0.74rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 4px;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .sidebar-feed-meta i {
        color: var(--accent, #c90000);
        font-size: 0.72rem;
    }

    /* ── Dedicated Opinion Column Widget (মতামত ও কলাম) ── */
    .sidebar-opinion-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
        transition: box-shadow 0.25s ease;
    }
    .sidebar-opinion-card:hover {
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.07);
    }
    .sidebar-opinion-head {
        padding: 12px 16px;
        border-bottom: 2px solid #111827;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
        position: relative;
    }
    .sidebar-opinion-head::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 44px;
        height: 2px;
        background-color: var(--accent, #c90000);
    }
    .sidebar-opinion-head h4 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 800;
        font-family: 'Noto Serif Bengali', serif !important;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .sidebar-opinion-more {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--accent, #c90000);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        font-family: 'Noto Sans Bengali', sans-serif;
        transition: color 0.2s ease;
    }
    .sidebar-opinion-more:hover {
        color: #111827;
    }
    .sidebar-opinion-list {
        padding: 6px 16px 10px;
    }
    .sidebar-opinion-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: transform 0.2s ease;
    }
    .sidebar-opinion-item:last-child {
        border-bottom: none;
        padding-bottom: 4px;
    }
    .sidebar-opinion-item:hover {
        transform: translateX(3px);
    }
    .sidebar-opinion-avatar-box {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        border: 2px solid #fecaca;
        background: #f8fafc;
        box-shadow: 0 2px 5px rgba(0,0,0,0.06);
    }
    .sidebar-opinion-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .sidebar-opinion-avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        color: var(--accent, #c90000);
        font-size: 1.05rem;
    }
    .sidebar-opinion-content {
        flex-grow: 1;
        min-width: 0;
    }
    .sidebar-opinion-author {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 3px;
    }
    .sidebar-opinion-author .author-name {
        font-size: 0.8rem;
        font-weight: 700;
        color: #1e293b;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .sidebar-opinion-author .author-badge {
        font-size: 0.65rem;
        font-weight: 700;
        color: var(--accent, #c90000);
        background: #fef2f2;
        padding: 1px 6px;
        border-radius: 10px;
        border: 1px solid #fee2e2;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .sidebar-opinion-headline {
        font-family: 'Noto Serif Bengali', serif !important;
        font-size: 0.94rem;
        font-weight: 700;
        line-height: 1.44;
        color: #111827;
        margin: 0 0 4px 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .sidebar-opinion-headline a {
        color: #111827;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .sidebar-opinion-headline a:hover {
        color: var(--accent, #c90000);
    }
    .sidebar-opinion-meta {
        font-size: 0.72rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 4px;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .sidebar-opinion-footer {
        padding: 10px 16px 14px;
        background: #fafafa;
        border-top: 1px solid #f1f5f9;
    }
    .sidebar-opinion-cta-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 9px 12px;
        border-radius: 6px;
        background: #ffffff;
        border: 1px dashed #cbd5e1;
        color: var(--accent, #c90000);
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        font-family: 'Noto Sans Bengali', sans-serif;
        transition: all 0.2s ease;
    }
    .sidebar-opinion-cta-btn:hover {
        background: var(--accent, #c90000);
        color: #ffffff !important;
        border-color: var(--accent, #c90000);
        box-shadow: 0 3px 10px rgba(201, 0, 0, 0.2);
    }

    /* ── Bhola District Module in Sidebar (ভোলা জেলার সংবাদ) ── */
    .sidebar-district-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
        transition: box-shadow 0.25s ease;
    }
    .sidebar-district-card:hover {
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.07);
    }
    .sidebar-district-head {
        padding: 12px 16px;
        border-bottom: 2px solid #111827;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
        position: relative;
    }
    .sidebar-district-head::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 44px;
        height: 2px;
        background-color: var(--accent, #c90000);
    }
    .sidebar-district-head h4 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 800;
        font-family: 'Noto Serif Bengali', serif !important;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .sidebar-district-body {
        padding: 14px 16px;
    }
    .sidebar-district-select {
        border-radius: 6px;
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.86rem;
        font-weight: 600;
        border-color: #cbd5e1;
    }
    .sidebar-district-select:focus {
        border-color: var(--accent, #c90000);
        box-shadow: 0 0 0 3px rgba(201, 0, 0, 0.1);
    }
    .sidebar-district-search-btn {
        background: var(--accent, #c90000);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        padding: 7px 14px;
        font-size: 0.88rem;
        transition: background-color 0.2s ease;
    }
    .sidebar-district-search-btn:hover {
        background: #a80000;
    }
    .sidebar-district-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px dashed #e2e8f0;
    }
    .sidebar-district-pill {
        background-color: #f8fafc;
        color: #475569;
        padding: 4px 11px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        font-family: 'Noto Sans Bengali', sans-serif;
        transition: all 0.2s ease;
    }
    .sidebar-district-pill:hover {
        background-color: var(--accent, #c90000);
        color: #ffffff !important;
        border-color: var(--accent, #c90000);
        transform: translateY(-1px);
    }

    /* ── Online Poll Widget (অনলাইন জরিপ) ── */
    .sidebar-poll-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
        transition: box-shadow 0.25s ease;
    }
    .sidebar-poll-card:hover {
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.07);
    }
    .sidebar-poll-head {
        padding: 12px 16px;
        border-bottom: 2px solid #111827;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
        position: relative;
    }
    .sidebar-poll-head::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 44px;
        height: 2px;
        background-color: var(--accent, #c90000);
    }
    .sidebar-poll-head h4 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 800;
        font-family: 'Noto Serif Bengali', serif !important;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .sidebar-poll-body {
        padding: 16px;
    }
    .sidebar-poll-question {
        font-family: 'Noto Serif Bengali', serif !important;
        font-size: 0.94rem;
        font-weight: 700;
        line-height: 1.5;
        color: #1e293b;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #e2e8f0;
    }
    .poll-option-label {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 6px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-bottom: 8px;
        cursor: pointer;
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.88rem;
        font-weight: 600;
        color: #334155;
        transition: all 0.2s ease;
    }
    .poll-option-label:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    .poll-option-label input[type="radio"] {
        accent-color: var(--accent, #c90000);
        width: 16px;
        height: 16px;
    }
    .poll-action-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
        gap: 10px;
    }
    .poll-vote-btn {
        background: var(--accent, #c90000);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        padding: 8px 18px;
        font-size: 0.86rem;
        font-weight: 700;
        font-family: 'Noto Sans Bengali', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .poll-vote-btn:hover {
        background: #a80000;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(201, 0, 0, 0.25);
    }
    .poll-result-toggle-btn {
        background: none;
        border: none;
        color: #64748b;
        font-size: 0.82rem;
        font-weight: 600;
        font-family: 'Noto Sans Bengali', sans-serif;
        text-decoration: underline;
        cursor: pointer;
        padding: 0;
    }
    .poll-result-toggle-btn:hover {
        color: #111827;
    }

    /* Poll Results styling */
    .poll-result-item {
        margin-bottom: 12px;
    }
    .poll-result-info {
        display: flex;
        justify-content: space-between;
        font-size: 0.84rem;
        font-weight: 700;
        font-family: 'Noto Sans Bengali', sans-serif;
        color: #334155;
        margin-bottom: 5px;
    }
    .poll-progress-bg {
        height: 9px;
        border-radius: 20px;
        background: #e2e8f0;
        overflow: hidden;
    }
    .poll-progress-bar {
        height: 100%;
        border-radius: 20px;
        transition: width 0.7s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .poll-bar-yes { background: #16a34a; }
    .poll-bar-no { background: var(--accent, #c90000); }
    .poll-bar-neutral { background: #64748b; }
    .poll-total-votes {
        font-size: 0.78rem;
        color: #94a3b8;
        margin-top: 14px;
        padding-top: 10px;
        border-top: 1px dashed #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: 'Noto Sans Bengali', sans-serif;
    }

    /* ── Digital E-Paper Quick Box with Realistic Thumbnail ── */
    .epaper-sidebar-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
        transition: box-shadow 0.25s ease;
    }
    .epaper-sidebar-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07);
    }
    .epaper-sidebar-head {
        padding: 12px 16px;
        background: linear-gradient(135deg, #111827 0%, #1e293b 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .epaper-sidebar-head h4 {
        margin: 0;
        font-size: 0.96rem;
        font-weight: 800;
        font-family: 'Noto Serif Bengali', serif;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .epaper-sidebar-body {
        padding: 16px;
        text-align: center;
    }
    .epaper-thumb-preview {
        display: block;
        text-decoration: none;
        margin: 0 auto 14px;
        max-width: 210px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        padding: 8px 10px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08), 2px 2px 0 #f1f5f9;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
    }
    .epaper-thumb-preview:hover {
        transform: translateY(-4px) rotate(-0.5deg);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
    }
    .epaper-mock-masthead {
        border-bottom: 2px solid #111827;
        padding-bottom: 3px;
        margin-bottom: 4px;
    }
    .epaper-mock-logo {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 0.82rem;
        font-weight: 900;
        color: #111827;
        line-height: 1;
        margin: 0;
    }
    .epaper-mock-date {
        font-size: 0.52rem;
        color: #64748b;
        border-top: 1px solid #e2e8f0;
        padding-top: 2px;
        margin-top: 2px;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .epaper-mock-lead-img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 2px;
        background-color: #e2e8f0;
        margin-bottom: 4px;
        display: block;
    }
    .epaper-mock-headline {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 0.68rem;
        font-weight: 800;
        color: #111827;
        line-height: 1.25;
        margin: 0 0 4px 0;
        text-align: left;
    }
    .epaper-mock-columns {
        display: flex;
        gap: 4px;
    }
    .epaper-mock-col {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .epaper-mock-line {
        height: 2px;
        background: #e2e8f0;
        border-radius: 1px;
    }
    .epaper-read-overlay {
        position: absolute;
        inset: 0;
        background: rgba(17, 24, 39, 0.75);
        color: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 0.85rem;
        font-weight: 700;
        font-family: 'Noto Sans Bengali', sans-serif;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .epaper-thumb-preview:hover .epaper-read-overlay {
        opacity: 1;
    }

    /* ── Social Connect Widget ── */
    .social-connect-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 18px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
    }
    .social-connect-title {
        font-family: 'Noto Serif Bengali', serif !important;
        font-size: 1.05rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .social-connect-desc {
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 14px;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .social-bar-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        border-radius: 8px;
        text-decoration: none;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 0.88rem;
        margin-bottom: 10px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .social-bar-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .social-bar-fb {
        background: linear-gradient(135deg, #1877f2 0%, #0d65d9 100%);
    }
    .social-bar-yt {
        background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%);
    }
    .social-bar-pill {
        background: rgba(255, 255, 255, 0.22);
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.74rem;
        letter-spacing: 0.3px;
    }
    .social-mini-icons {
        display: flex;
        gap: 8px;
        justify-content: center;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }
    .social-mini-link {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #475569;
        text-decoration: none;
        font-size: 0.88rem;
        transition: all 0.2s ease;
    }
    .social-mini-link:hover {
        background: var(--accent, #c90000);
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* ── Square Ad (300x250) ── */
    .sidebar-ad-card {
        margin-bottom: 24px;
        text-align: center;
    }
    .sidebar-ad-label {
        font-size: 0.65rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: block;
        margin-bottom: 4px;
    }
    .sidebar-ad-box {
        width: 100%;
        height: 250px;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        padding: 16px;
        transition: border-color 0.2s ease;
    }
    .sidebar-ad-box:hover {
        border-color: #94a3b8;
    }
</style>

<div class="sidebar-sticky">

    <!-- 1. Daily Star Style Tabbed Live Feed Widget (সর্বশেষ ও জনপ্রিয়) -->
    <div class="sidebar-tabbed-card">
        <div class="sidebar-tab-header">
            <button class="sidebar-tab-nav-btn active" id="btnTabLatest" onclick="switchSidebarTab('latest')">
                <i class="fa-solid fa-bolt-lightning text-danger"></i>
                <span>সর্বশেষ</span>
            </button>
            <button class="sidebar-tab-nav-btn" id="btnTabPopular" onclick="switchSidebarTab('popular')">
                <i class="fa-solid fa-fire-flame-curved text-danger"></i>
                <span>জনপ্রিয়</span>
            </button>
        </div>

        <!-- Latest News Tab Pane (৮টি খবর উইথ ছবি) -->
        <div id="paneTabLatest" class="sidebar-tab-pane active">
            <ul class="sidebar-feed-list">
                @foreach($latestPosts->take(8) as $index => $post)
                    <li class="sidebar-feed-item">
                        <span class="sidebar-rank-badge sidebar-rank-badge-latest">
                            {{ $bnNumbers[$index + 1] ?? ($index + 1) }}
                        </span>
                        <div class="sidebar-feed-thumb-box">
                            <a href="{{ route('post', $post->slug) }}" class="d-block w-100 h-100">
                                <img src="{{ $post->featured_image_url }}" 
                                     alt="{{ $post->title }}" 
                                     class="sidebar-feed-thumb" 
                                     onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=200'" 
                                     loading="lazy">
                            </a>
                        </div>
                        <div class="sidebar-feed-content">
                            <h4 class="sidebar-feed-title">
                                <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                            </h4>
                            <div class="sidebar-feed-meta">
                                <i class="fa-regular fa-clock"></i>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Popular News Tab Pane (৮টি খবর উইথ ছবি ও প্রিমিয়াম র‍্যাঙ্ক ব্যাজ) -->
        <div id="paneTabPopular" class="sidebar-tab-pane">
            <ul class="sidebar-feed-list">
                @foreach($popularPosts->take(8) as $index => $post)
                    @php
                        $rankClass = 'sidebar-rank-other';
                        if ($index === 0) $rankClass = 'sidebar-rank-top-1';
                        elseif ($index === 1) $rankClass = 'sidebar-rank-top-2';
                        elseif ($index === 2) $rankClass = 'sidebar-rank-top-3';
                    @endphp
                    <li class="sidebar-feed-item">
                        <span class="sidebar-rank-badge {{ $rankClass }}">
                            {{ $bnNumbers[$index + 1] ?? ($index + 1) }}
                        </span>
                        <div class="sidebar-feed-thumb-box">
                            <a href="{{ route('post', $post->slug) }}" class="d-block w-100 h-100">
                                <img src="{{ $post->featured_image_url }}" 
                                     alt="{{ $post->title }}" 
                                     class="sidebar-feed-thumb" 
                                     onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=200'" 
                                     loading="lazy">
                            </a>
                        </div>
                        <div class="sidebar-feed-content">
                            <h4 class="sidebar-feed-title">
                                <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                            </h4>
                            <div class="sidebar-feed-meta">
                                <i class="fa-regular fa-eye"></i>
                                <span>{{ $post->views_count }} বার পঠিত</span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- 2. Dedicated Opinion & Column Showcase Card (মতামত ও কলামের বিশেষ ব্লক) -->
    <div class="sidebar-opinion-card">
        <div class="sidebar-opinion-head">
            <h4>
                <i class="fa-solid fa-pen-nib text-danger"></i>
                <span>মতামত ও কলাম</span>
            </h4>
            <a href="{{ route('category', 'opinion') }}" class="sidebar-opinion-more">
                <span>সব কলাম</span>
                <i class="fa-solid fa-angle-right ms-1"></i>
            </a>
        </div>
        <div class="sidebar-opinion-list">
            @forelse($opinionPosts->take(4) as $opPost)
                <article class="sidebar-opinion-item">
                    <div class="sidebar-opinion-avatar-box">
                        @if($opPost->featured_image_url)
                            <img src="{{ $opPost->featured_image_url }}" 
                                 alt="{{ $opPost->user ? $opPost->user->name : 'লেখক' }}" 
                                 class="sidebar-opinion-avatar"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="sidebar-opinion-avatar-placeholder" style="display: none;">
                                <i class="fa-solid fa-user-pen"></i>
                            </div>
                        @else
                            <div class="sidebar-opinion-avatar-placeholder">
                                <i class="fa-solid fa-user-pen"></i>
                            </div>
                        @endif
                    </div>
                    <div class="sidebar-opinion-content">
                        <div class="sidebar-opinion-author">
                            <span class="author-name">{{ $opPost->user ? $opPost->user->name : 'কলামিস্ট' }}</span>
                            <span class="author-badge">কলাম</span>
                        </div>
                        <h5 class="sidebar-opinion-headline">
                            <a href="{{ route('post', $opPost->slug) }}">{{ $opPost->title }}</a>
                        </h5>
                        <div class="sidebar-opinion-meta">
                            <i class="fa-regular fa-clock"></i>
                            <span>{{ $opPost->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-muted text-center py-3 m-0" style="font-size: 0.85rem;">কোন মতামত কলাম পাওয়া যায়নি।</p>
            @endforelse
        </div>
        <div class="sidebar-opinion-footer">
            <a href="{{ route('epaper') }}#submit" class="sidebar-opinion-cta-btn">
                <i class="fa-solid fa-feather-pointed me-2"></i>
                <span>আপনার মতামত বা লেখা পাঠান</span>
                <i class="fa-solid fa-arrow-right ms-2" style="font-size: 0.75rem;"></i>
            </a>
        </div>
    </div>

    <!-- 3. Bhola District Grassroots News Module (ভোলা জেলার সংবাদ - Moved to Sidebar) -->
    <div class="sidebar-district-card">
        <div class="sidebar-district-head">
            <h4>
                <i class="fa-solid fa-map-location-dot text-danger"></i>
                <span>ভোলা জেলার সংবাদ</span>
            </h4>
            <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.72rem; padding: 3px 8px;">৭টি উপজেলা</span>
        </div>
        <div class="sidebar-district-body">
            <div class="mb-2">
                <select class="form-select form-select-sm sidebar-district-select mb-2" id="sidebarUpazilaSelect" onchange="loadSidebarUnions()">
                    <option value="">উপজেলা নির্বাচন করুন</option>
                    <option value="ভোলা সদর">ভোলা সদর</option>
                    <option value="চরফ্যাশন">চরফ্যাশন</option>
                    <option value="লালমোহন">লালমোহন</option>
                    <option value="বোরহানউদ্দিন">বোরহানউদ্দিন</option>
                    <option value="তজুমদ্দিন">তজুমদ্দিন</option>
                    <option value="দৌলতখান">দৌলতখান</option>
                    <option value="মনপুরা">মনপুরা</option>
                </select>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm sidebar-district-select" id="sidebarUnionSelect" disabled>
                        <option value="">ইউনিয়ন নির্বাচন করুন</option>
                    </select>
                    <button class="sidebar-district-search-btn" onclick="searchSidebarBholaNews()" title="খুঁজুন">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
            <div class="sidebar-district-pills">
                <a href="{{ route('search') }}?query={{ urlencode('ভোলা সদর') }}" class="sidebar-district-pill">ভোলা সদর</a>
                <a href="{{ route('search') }}?query={{ urlencode('চরফ্যাশন') }}" class="sidebar-district-pill">চরফ্যাশন</a>
                <a href="{{ route('search') }}?query={{ urlencode('লালমোহন') }}" class="sidebar-district-pill">লালমোহন</a>
                <a href="{{ route('search') }}?query={{ urlencode('বোরহানউদ্দিন') }}" class="sidebar-district-pill">বোরহানউদ্দিন</a>
                <a href="{{ route('search') }}?query={{ urlencode('তজুমদ্দিন') }}" class="sidebar-district-pill">তজুমদ্দিন</a>
                <a href="{{ route('search') }}?query={{ urlencode('মনপুরা') }}" class="sidebar-district-pill">মনপুরা</a>
                <a href="{{ route('search') }}?query={{ urlencode('দৌলতখান') }}" class="sidebar-district-pill">দৌলতখান</a>
            </div>
        </div>
    </div>

    <!-- 4. Interactive Online Poll Widget (অনলাইন জরিপ) -->
    <div class="sidebar-poll-card">
        <div class="sidebar-poll-head">
            <h4>
                <i class="fa-solid fa-square-poll-vertical text-danger"></i>
                <span>অনলাইন জরিপ</span>
            </h4>
            <span class="badge bg-danger-subtle text-danger fw-bold" style="font-size: 0.72rem; padding: 3px 8px; border-radius: 4px;">চলমান</span>
        </div>
        <div class="sidebar-poll-body">
            <!-- Question -->
            <p class="sidebar-poll-question">
                ভোলা-বরিশাল সেতু নির্মাণ ও জেলায় গ্যাসভিত্তিক ভারী শিল্পায়ন দ্বীপবাসীর দীর্ঘদিনের প্রধান দাবি—আপনি কি এর সাথে একমত?
            </p>

            <!-- Poll Voting Form View -->
            <div id="pollVoteForm">
                <label class="poll-option-label">
                    <input type="radio" name="poll_vote_option" value="yes">
                    <span>হ্যাঁ</span>
                </label>
                <label class="poll-option-label">
                    <input type="radio" name="poll_vote_option" value="no">
                    <span>না</span>
                </label>
                <label class="poll-option-label">
                    <input type="radio" name="poll_vote_option" value="neutral">
                    <span>মন্তব্য নেই</span>
                </label>

                <div class="poll-action-bar">
                    <button type="button" class="poll-vote-btn" onclick="submitOnlinePoll()">
                        <i class="fa-solid fa-check"></i>
                        <span>ভোট দিন</span>
                    </button>
                    <button type="button" class="poll-result-toggle-btn" onclick="togglePollView('results')">
                        ফলাফল দেখুন
                    </button>
                </div>
            </div>

            <!-- Poll Results View -->
            <div id="pollResultsView" style="display: none;">
                <div class="poll-result-item">
                    <div class="poll-result-info">
                        <span>হ্যাঁ</span>
                        <span id="pollPctYes">৮২%</span>
                    </div>
                    <div class="poll-progress-bg">
                        <div class="poll-progress-bar poll-bar-yes" id="pollBarYes" style="width: 82%;"></div>
                    </div>
                </div>

                <div class="poll-result-item">
                    <div class="poll-result-info">
                        <span>না</span>
                        <span id="pollPctNo">১৩%</span>
                    </div>
                    <div class="poll-progress-bg">
                        <div class="poll-progress-bar poll-bar-no" id="pollBarNo" style="width: 13%;"></div>
                    </div>
                </div>

                <div class="poll-result-item">
                    <div class="poll-result-info">
                        <span>মন্তব্য নেই</span>
                        <span id="pollPctNeutral">৫%</span>
                    </div>
                    <div class="poll-progress-bg">
                        <div class="poll-progress-bar poll-bar-neutral" id="pollBarNeutral" style="width: 5%;"></div>
                    </div>
                </div>

                <div class="poll-total-votes">
                    <span><i class="fa-solid fa-users me-1 text-danger"></i>মোট ভোট: <strong id="pollTotalCount">১,৪৭৮</strong>টি</span>
                    <button type="button" class="poll-result-toggle-btn" onclick="togglePollView('form')">
                        ভোট ফর্ম
                    </button>
                </div>
                <div id="pollVotedNotice" class="text-success text-center mt-2 fw-bold" style="font-size: 0.76rem; display: none;">
                    <i class="fa-solid fa-circle-check me-1"></i>আপনার মতামত গ্রহণ করা হয়েছে। ধন্যবাদ!
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Square Advertisement (300x250) -->
    <div class="sidebar-ad-card">
        <span class="sidebar-ad-label">বিজ্ঞাপন</span>
        <div class="sidebar-ad-box">
            <i class="fa-solid fa-rectangle-ad mb-2" style="font-size: 2.2rem; color: #cbd5e1;"></i>
            <span style="font-size: 0.88rem; font-weight: 700; color: #475569;">বিজ্ঞাপন স্লট (300x250)</span>
            <small style="color: #94a3b8; margin-top: 4px;">বিজ্ঞাপনের জন্য যোগাযোগ: {{ $themeSettings['contact_phone'] ?? '01716-674375' }}</small>
        </div>
    </div>

    <!-- 6. Digital E-Paper Quick Box (আজকের প্রথম পাতার থাম্বনেইল প্রিভিউ) -->
    <div class="epaper-sidebar-card">
        <div class="epaper-sidebar-head">
            <h4><i class="fa-solid fa-newspaper text-danger"></i>ডিজিটাল ই-পেপার</h4>
            <span class="badge bg-danger-subtle text-danger fw-bold" style="font-size: 0.72rem; padding: 3px 8px; border-radius: 4px;">আজকের সংখ্যা</span>
        </div>
        <div class="epaper-sidebar-body">
            @php
                $firstPostForMockup = $latestPosts->first();
                $epaperDateDisplay = \App\Helpers\BanglaDateHelper::getFormattedEPaperDate(now());
            @endphp
            
            <!-- Miniature Broadsheet Newspaper Mockup -->
            <a href="{{ route('epaper') }}" class="epaper-thumb-preview" title="আজকের ই-পেপার পড়ুন">
                <div class="epaper-mock-masthead">
                    <div class="epaper-mock-logo">দৈনিক ভোলা জার্নাল</div>
                    <div class="epaper-mock-date">{{ Str::limit($epaperDateDisplay, 32) }}</div>
                </div>

                @if($firstPostForMockup && $firstPostForMockup->featured_image_url)
                    <img src="{{ $firstPostForMockup->featured_image_url }}" alt="ই-পেপার প্রচ্ছদ" class="epaper-mock-lead-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                @else
                    <div class="epaper-mock-lead-img"></div>
                @endif

                <h6 class="epaper-mock-headline">
                    {{ $firstPostForMockup ? Str::limit($firstPostForMockup->title, 42) : 'আজকের মুদ্রিত সংবাদপত্রের সকল পাতার ডিজিটাল রূপ' }}
                </h6>

                <div class="epaper-mock-columns">
                    <div class="epaper-mock-col">
                        <div class="epaper-mock-line" style="width: 100%;"></div>
                        <div class="epaper-mock-line" style="width: 80%;"></div>
                        <div class="epaper-mock-line" style="width: 90%;"></div>
                    </div>
                    <div class="epaper-mock-col">
                        <div class="epaper-mock-line" style="width: 95%;"></div>
                        <div class="epaper-mock-line" style="width: 85%;"></div>
                        <div class="epaper-mock-line" style="width: 70%;"></div>
                    </div>
                </div>

                <!-- Hover Eye Overlay -->
                <div class="epaper-read-overlay">
                    <i class="fa-solid fa-magnifying-glass-plus" style="font-size: 1.5rem;"></i>
                    <span>পাতা উল্টে পড়ুন</span>
                </div>
            </a>

            <p style="font-size: 0.82rem; color: #64748b; margin-bottom: 14px; font-family: 'Noto Sans Bengali', sans-serif;">
                আজকের ছাপা কাগজের প্রতিটি পাতা ডিজিটাল ব্রাউজারে পড়ুন।
            </p>

            <a href="{{ route('epaper') }}" class="btn btn-danger w-100 fw-bold d-flex align-items-center justify-content-center gap-2" style="background-color: var(--accent, #c90000); border-radius: 6px; padding: 10px; font-size: 0.92rem; font-family: 'Noto Sans Bengali', sans-serif;">
                <i class="fa-solid fa-book-open"></i>
                <span>আজকের ই-পেপার পড়ুন</span>
                <i class="fa-solid fa-arrow-right" style="font-size: 0.8rem;"></i>
            </a>
        </div>
    </div>

    <!-- 7. Social Connect Widget (Facebook & YouTube Follower Buttons) -->
    <div class="social-connect-card">
        <h4 class="social-connect-title">
            <i class="fa-solid fa-share-nodes text-danger"></i>
            <span>সামাজিক মাধ্যমে যুক্ত থাকুন</span>
        </h4>
        <div class="social-connect-desc">সব খবর সবার আগে পেতে আমাদের সোশ্যাল মিডিয়া অনুসরণ করুন</div>

        <!-- Facebook Follow Banner -->
        <a href="{{ $themeSettings['social_facebook'] ?? 'https://facebook.com' }}" target="_blank" class="social-bar-btn social-bar-fb" title="ফেসবুকে ফলো করুন">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-brands fa-facebook-f" style="font-size: 1.15rem;"></i>
                <span>ফেসবুক পেজ</span>
            </div>
            <span class="social-bar-pill">লাইক দিন</span>
        </a>

        <!-- YouTube Subscribe Banner -->
        <a href="{{ $themeSettings['social_youtube'] ?? 'https://youtube.com' }}" target="_blank" class="social-bar-btn social-bar-yt" title="ইউটিউব চ্যানেল সাবস্ক্রাইব করুন">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-brands fa-youtube" style="font-size: 1.15rem;"></i>
                <span>ইউটিউব চ্যানেল</span>
            </div>
            <span class="social-bar-pill">সাবস্ক্রাইব</span>
        </a>

        <!-- Secondary Socials (X and Instagram) -->
        <div class="social-mini-icons">
            <a href="{{ $themeSettings['social_twitter'] ?? '#' }}" target="_blank" class="social-mini-link" title="Twitter / X"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="{{ $themeSettings['social_instagram'] ?? '#' }}" target="_blank" class="social-mini-link" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
        </div>
    </div>

</div>

<script>
    // 1. Sidebar Tab Switching
    function switchSidebarTab(tabName) {
        const tabs = ['latest', 'popular'];
        tabs.forEach(t => {
            const cap = t.charAt(0).toUpperCase() + t.slice(1);
            const btn = document.getElementById('btnTab' + cap);
            const pane = document.getElementById('paneTab' + cap);
            if (btn && pane) {
                if (t === tabName) {
                    btn.classList.add('active');
                    pane.classList.add('active');
                } else {
                    btn.classList.remove('active');
                    pane.classList.remove('active');
                }
            }
        });
    }

    // 2. Bhola District Upazilas & Unions Mapping
    const sidebarUpazilaUnions = {
        "ভোলা সদর": ["পূর্ব ইলিশা", "পশ্চিম ইলিশা", "বাপ্তা", "ধনিয়া", "আলীনগর", "চরসামাইয়া", "ভেদুরিয়া", "চরশিবলি", "রাজাপুর", "উত্তর দিঘলদী", "দক্ষিণ দিঘলদী", "কাচিয়া", "শিবপুর"],
        "চরফ্যাশন": ["ওসমানগঞ্জ", "আসলামপুর", "জিন্নাহগড়", "আমিনাবাদ", "চরমাদ্রাজ", "চরকলমি", "হাজারীগঞ্জ", "এওয়াজপুর", "জাহানপুর", "নীলকমল", "নূরাবাদ", "কুকরী মুকরী", "ঢালচর", "মজিবনগর"],
        "লালমোহন": ["কালমা", "চরভূতা", "লর্ড হার্ডিঞ্জ", "ধলীগৌরনগর", "বদরপুর", "লালমোহন", "চর উমেদ"],
        "বোরহানউদ্দিন": ["গঙ্গাপুর", "সাচড়া", "দেউলা", "টবগী", "পক্ষিয়া", "বড় মানিকা", "কুতুবা", "কাচিয়া", "হাসাননগর"],
        "তজুমদ্দিন": ["বড় মলংচড়া", "সোনাপুর", "চাঁদপুর", "চাচড়া", "শম্ভুপুর"],
        "দৌলতখান": ["মদনপুর", "মেদুয়া", "চরপাতা", "উত্তর জয়নগর", "দক্ষিণ জয়নগর", "চরখলিফা", "সৈয়দপুর", "ভবানীপুর", "হাজিপুর"],
        "মনপুরা": ["মনপুরা", "হাজিরহাট", "উত্তর সাকুচিয়া", "দক্ষিণ সাকুচিয়া"]
    };

    function loadSidebarUnions() {
        const upazilaSelect = document.getElementById('sidebarUpazilaSelect');
        const unionSelect = document.getElementById('sidebarUnionSelect');
        if (!upazilaSelect || !unionSelect) return;
        const selectedUpazila = upazilaSelect.value;

        unionSelect.innerHTML = '<option value="">ইউনিয়ন নির্বাচন করুন</option>';

        if (selectedUpazila && sidebarUpazilaUnions[selectedUpazila]) {
            unionSelect.disabled = false;
            sidebarUpazilaUnions[selectedUpazila].forEach(union => {
                const option = document.createElement('option');
                option.value = union;
                option.textContent = union;
                unionSelect.appendChild(option);
            });
        } else {
            unionSelect.disabled = true;
        }
    }

    function searchSidebarBholaNews() {
        const unionSelect = document.getElementById('sidebarUnionSelect');
        const union = unionSelect ? unionSelect.value : '';
        if (union) {
            window.location.href = `{{ route('search') }}?query=${encodeURIComponent(union)}`;
        } else {
            const upazilaSelect = document.getElementById('sidebarUpazilaSelect');
            const upazila = upazilaSelect ? upazilaSelect.value : '';
            if (upazila) {
                window.location.href = `{{ route('search') }}?query=${encodeURIComponent(upazila)}`;
            } else {
                alert('অনুগ্রহ করে উপজেলা বা ইউনিয়ন নির্বাচন করুন।');
            }
        }
    }

    // 3. Online Poll Interactive Logic
    function togglePollView(viewName) {
        const formView = document.getElementById('pollVoteForm');
        const resultsView = document.getElementById('pollResultsView');
        if (!formView || !resultsView) return;

        if (viewName === 'results') {
            formView.style.display = 'none';
            resultsView.style.display = 'block';
        } else {
            resultsView.style.display = 'none';
            formView.style.display = 'block';
        }
    }

    function submitOnlinePoll() {
        const selectedRadio = document.querySelector('input[name="poll_vote_option"]:checked');
        if (!selectedRadio) {
            alert('অনুগ্রহ করে একটি মতামত নির্বাচন করুন।');
            return;
        }

        const choice = selectedRadio.value;
        // Save in localStorage to prevent duplicate submissions
        localStorage.setItem('dbj_poll_voted', choice);

        // Show thank you notice
        const notice = document.getElementById('pollVotedNotice');
        if (notice) notice.style.display = 'block';

        togglePollView('results');
    }

    // Check on load if already voted
    document.addEventListener('DOMContentLoaded', function() {
        const hasVoted = localStorage.getItem('dbj_poll_voted');
        if (hasVoted) {
            const formView = document.getElementById('pollVoteForm');
            const resultsView = document.getElementById('pollResultsView');
            const notice = document.getElementById('pollVotedNotice');
            if (formView && resultsView) {
                formView.style.display = 'none';
                resultsView.style.display = 'block';
                if (notice) notice.style.display = 'block';
            }
        }
    });
</script>
