@extends('layouts.admin')

@section('title', 'ড্যাশবোর্ড | অ্যাডমিন প্যানেল | দৈনিক ভোলা জার্নাল')
@section('header_title', 'কন্ট্রোল প্যানেল ড্যাশবোর্ড')

@section('styles')
<style>
    /* ========================================================
       Dashboard Modern UI Styles
       ======================================================== */

    /* Quick Action Shortcuts Hub */
    .quick-actions-bar {
        background: var(--content-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: var(--shadow);
    }

    .quick-actions-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    @media (min-width: 640px) {
        .quick-actions-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (min-width: 1024px) {
        .quick-actions-grid {
            grid-template-columns: repeat(6, 1fr);
        }
    }

    .quick-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 10px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-color);
        background: #f8fafc;
        color: var(--text-main);
        font-size: 0.84rem;
        font-weight: 600;
        text-align: center;
        transition: var(--transition);
        text-decoration: none;
    }

    .quick-action-btn i {
        font-size: 1.35rem;
        transition: transform 0.2s ease;
    }

    .quick-action-btn:hover {
        background: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px -2px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
        color: var(--text-dark);
    }

    .quick-action-btn:hover i {
        transform: scale(1.12);
    }

    .qa-new-post { color: #dc2626; border-color: rgba(220, 38, 38, 0.2); background: rgba(220, 38, 38, 0.03); }
    .qa-new-post:hover { border-color: #dc2626; background: rgba(220, 38, 38, 0.08); color: #dc2626; }
    .qa-social-card { color: #8b5cf6; border-color: rgba(139, 92, 246, 0.2); background: rgba(139, 92, 246, 0.03); }
    .qa-social-card:hover { border-color: #8b5cf6; background: rgba(139, 92, 246, 0.08); color: #8b5cf6; }
    .qa-video { color: #ea580c; border-color: rgba(234, 88, 12, 0.2); background: rgba(234, 88, 12, 0.03); }
    .qa-video:hover { border-color: #ea580c; background: rgba(234, 88, 12, 0.08); color: #ea580c; }
    .qa-seo { color: #059669; border-color: rgba(5, 150, 105, 0.2); background: rgba(5, 150, 105, 0.03); }
    .qa-seo:hover { border-color: #059669; background: rgba(5, 150, 105, 0.08); color: #059669; }
    .qa-epaper { color: #0284c7; border-color: rgba(2, 132, 199, 0.2); background: rgba(2, 132, 199, 0.03); }
    .qa-epaper:hover { border-color: #0284c7; background: rgba(2, 132, 199, 0.08); color: #0284c7; }
    .qa-poll { color: #d97706; border-color: rgba(217, 119, 6, 0.2); background: rgba(217, 119, 6, 0.03); }
    .qa-poll:hover { border-color: #d97706; background: rgba(217, 119, 6, 0.08); color: #d97706; }

    /* Stats Grid Layout - 8 Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    @media (min-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
    }

    .stat-card {
        background-color: var(--content-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: var(--shadow);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        text-decoration: none;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        border-color: #cbd5e1;
        box-shadow: 0 12px 20px -3px rgba(15, 23, 42, 0.08);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.35rem;
    }

    /* Icon theme variants */
    .stat-icon-posts     { background-color: rgba(220, 38, 38, 0.12); color: #dc2626; }
    .stat-icon-today     { background-color: rgba(16, 185, 129, 0.12); color: #10b981; }
    .stat-icon-drafts    { background-color: rgba(100, 116, 139, 0.14); color: #64748b; }
    .stat-icon-views     { background-color: rgba(14, 165, 233, 0.12); color: #0284c7; }
    .stat-icon-cats      { background-color: rgba(245, 158, 11, 0.12); color: #d97706; }
    .stat-icon-users     { background-color: rgba(139, 92, 246, 0.12); color: #7c3aed; }
    .stat-icon-subs      { background-color: rgba(236, 72, 153, 0.12); color: #db2777; }
    .stat-icon-poll      { background-color: rgba(20, 184, 166, 0.12); color: #0d9488; }

    .stat-info {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    /* CRITICAL FIX: Ensure stat-value is dark slate-900 high contrast, NEVER white */
    .stat-value {
        font-family: 'Outfit', 'Noto Sans Bengali', sans-serif;
        font-size: 1.65rem;
        font-weight: 700;
        color: #0f172a !important; /* Fixed invisible text bug */
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.84rem;
        color: var(--text-sub);
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat-subtext {
        font-size: 0.73rem;
        color: #94a3b8;
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Layout Splits (Grid Rows) */
    .dashboard-splits {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        margin-bottom: 28px;
    }

    @media (min-width: 1024px) {
        .dashboard-splits.split-8-4 {
            grid-template-columns: 2fr 1fr;
        }
        .dashboard-splits.split-6-6 {
            grid-template-columns: 1fr 1fr;
        }
    }

    /* Admin Cards */
    .admin-card {
        background-color: var(--content-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .card-header-wrapper {
        padding: 18px 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
    }

    .card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title i {
        color: var(--accent);
    }

    .card-body-padded {
        padding: 20px;
    }

    /* Category Breakdown styling */
    .breakdown-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .breakdown-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .breakdown-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.88rem;
    }

    .breakdown-name {
        font-weight: 600;
        color: var(--text-dark);
    }

    .breakdown-count {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 0.82rem;
        color: var(--text-sub);
    }

    .breakdown-bar-bg {
        width: 100%;
        height: 7px;
        background-color: #f1f5f9;
        border-radius: 999px;
        overflow: hidden;
    }

    .breakdown-bar-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #dc2626 0%, #f97316 100%);
        transition: width 0.6s ease;
    }

    /* Top Viewed Posts List */
    .top-viewed-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .top-viewed-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border-color);
    }

    .top-viewed-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .rank-badge {
        width: 26px;
        height: 26px;
        min-width: 26px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        font-size: 0.85rem;
    }

    .rank-1 { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .rank-2 { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .rank-3 { background: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; }
    .rank-other { background: #f8fafc; color: #94a3b8; border: 1px solid #e2e8f0; }

    .top-post-details {
        flex: 1;
        min-width: 0;
    }

    .top-post-title {
        font-weight: 600;
        font-size: 0.88rem;
        line-height: 1.35;
        color: var(--text-dark);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-decoration: none;
    }

    .top-post-title:hover {
        color: var(--accent);
    }

    .top-post-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.76rem;
        color: var(--text-sub);
        margin-top: 4px;
    }

    /* Enhanced Post Table Styles */
    .post-thumb-sm {
        width: 44px;
        height: 34px;
        min-width: 44px;
        border-radius: 4px;
        object-fit: cover;
        background-color: #f1f5f9;
        border: 1px solid var(--border-color);
    }

    .post-title-link {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.92rem;
        text-decoration: none;
        display: inline-block;
        max-width: 280px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: middle;
    }

    .post-title-link:hover {
        color: var(--accent);
    }

    .post-reporter-tag {
        font-size: 0.78rem;
        color: var(--text-sub);
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
    }

    .badge-status-publish {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 999px;
    }

    .badge-status-draft {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 999px;
    }

    .badge-cat-tag {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 6px;
        white-space: nowrap;
    }

    .action-social-btn {
        background-color: #f5f3ff;
        color: #7c3aed;
        border: 1px solid #ddd6fe;
        padding: 5px 8px;
        border-radius: 6px;
        font-size: 0.8rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .action-social-btn:hover {
        background-color: #7c3aed;
        color: #ffffff;
    }

    /* Compact lists for opinions & messages */
    .hub-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    .hub-list-item {
        padding: 14px 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        transition: background 0.15s ease;
    }

    .hub-list-item:hover {
        background: #f8fafc;
    }

    .hub-list-item:last-child {
        border-bottom: none;
    }

    .hub-item-left {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .hub-item-avatar {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 700;
    }

    .hub-item-title {
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--text-dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 300px;
    }

    .hub-item-sub {
        font-size: 0.77rem;
        color: var(--text-sub);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 2px;
    }

    /* Chart Container */
    .chart-container-wrapper {
        position: relative;
        height: 290px;
        width: 100%;
    }

    /* Mobile specific adjustments */
    @media (max-width: 639px) {
        .stat-value {
            font-size: 1.4rem;
        }
        .stat-card {
            padding: 14px;
            gap: 12px;
        }
        .stat-icon {
            width: 42px;
            height: 42px;
            min-width: 42px;
            font-size: 1.15rem;
        }
        .card-header-wrapper {
            padding: 14px 16px;
        }
        .card-body-padded {
            padding: 16px;
        }
        .chart-container-wrapper {
            height: 240px;
        }
    }
</style>
@endsection

@section('content')

    <!-- 1. Pending Alerts Banners -->
    @if(isset($pendingOpinionsCount) && $pendingOpinionsCount > 0)
        <div style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border: 1px solid #fecaca; border-radius: 10px; padding: 14px 20px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.08);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 38px; height: 38px; min-width: 38px; border-radius: 50%; background: #dc2626; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.05rem;">
                    <i class="fa-solid fa-pen-nib"></i>
                </div>
                <div>
                    <strong style="color: #991b1b; font-size: 0.96rem;">নতুন মতামত ও কলাম জমা হয়েছে!</strong>
                    <div style="font-size: 0.83rem; color: #7f1d1d;">মোট <strong>{{ $pendingOpinionsCount }}</strong> টি মতামত প্রকাশের জন্য অনুমোদনের অপেক্ষায় রয়েছে।</div>
                </div>
            </div>
            <a href="{{ route('admin.opinions.index', ['status' => 'pending']) }}" class="btn btn-primary" style="background-color: #dc2626; border-color: #dc2626; font-size: 0.84rem; padding: 6px 14px; border-radius: 6px;">
                <span>পর্যালোচনা করুন</span>
                <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
    @endif

    @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
        <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe; border-radius: 10px; padding: 14px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.08);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 38px; height: 38px; min-width: 38px; border-radius: 50%; background: #2563eb; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.05rem;">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div>
                    <strong style="color: #1e40af; font-size: 0.96rem;">পাঠকদের পাঠানো অপঠিত বার্তা রয়েছে!</strong>
                    <div style="font-size: 0.83rem; color: #1e3a8a;">যোগাযোগ পেজ থেকে <strong>{{ $unreadMessagesCount }}</strong> টি নতুন বার্তা ইনবক্সে অপঠিত রয়েছে।</div>
                </div>
            </div>
            <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="btn btn-primary" style="background-color: #2563eb; border-color: #2563eb; font-size: 0.84rem; padding: 6px 14px; border-radius: 6px;">
                <span>ইনবক্স দেখুন</span>
                <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
    @endif

    <!-- 2. Quick Actions Shortcuts Hub -->
    <div class="quick-actions-bar">
        <div class="quick-actions-title">
            <i class="fa-solid fa-bolt text-warning"></i>
            <span>দ্রুত নেভিগেশন ও কার্যসম্পাদন শর্টকাট (Quick Actions)</span>
        </div>
        <div class="quick-actions-grid">
            <a href="{{ route('admin.posts.create') }}" class="quick-action-btn qa-new-post">
                <i class="fa-solid fa-plus-circle"></i>
                <span>নতুন সংবাদ লিখুন</span>
            </a>
            <a href="{{ route('admin.social-card') }}" class="quick-action-btn qa-social-card">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                <span>সোশ্যাল কার্ড</span>
            </a>
            <a href="{{ route('admin.videos.index') }}" class="quick-action-btn qa-video">
                <i class="fa-brands fa-youtube"></i>
                <span>ভিডিও গ্যালারি</span>
            </a>
            <a href="{{ route('admin.seo.index') }}" class="quick-action-btn qa-seo">
                <i class="fa-solid fa-magnifying-glass-chart"></i>
                <span>এসইও ম্যানেজার</span>
            </a>
            <a href="{{ route('admin.epaper.index') }}" class="quick-action-btn qa-epaper">
                <i class="fa-regular fa-newspaper"></i>
                <span>ই-পেপার বিল্ডার</span>
            </a>
            <a href="{{ route('admin.polls.index') }}" class="quick-action-btn qa-poll">
                <i class="fa-solid fa-square-poll-vertical"></i>
                <span>অনলাইন জরিপ</span>
            </a>
        </div>
    </div>

    <!-- 3. Metrics Statistics Grid (8 Metrics Cards) -->
    <div class="stats-grid">
        <!-- 1. Published Posts -->
        <a href="{{ route('admin.posts.index') }}" class="stat-card">
            <div class="stat-icon stat-icon-posts"><i class="fa-solid fa-newspaper"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalPosts) }}</span>
                <span class="stat-label">প্রকাশিত সংবাদ</span>
                <span class="stat-subtext">সর্বমোট লাইভ পোস্ট</span>
            </div>
        </a>

        <!-- 2. Today's Posts -->
        <a href="{{ route('admin.posts.index') }}" class="stat-card">
            <div class="stat-icon stat-icon-today"><i class="fa-solid fa-calendar-day"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($todayPosts) }}</span>
                <span class="stat-label">আজকের সংবাদ</span>
                <span class="stat-subtext">আজ প্রকাশিত হয়েছে</span>
            </div>
        </a>

        <!-- 3. Draft Posts -->
        <a href="{{ route('admin.posts.index') }}" class="stat-card">
            <div class="stat-icon stat-icon-drafts"><i class="fa-solid fa-file-pen"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($draftPosts) }}</span>
                <span class="stat-label">ড্রাফট / খসড়া</span>
                <span class="stat-subtext">অপ্রকাশিত সংরক্ষিত</span>
            </div>
        </a>

        <!-- 4. Total Views -->
        <div class="stat-card" style="cursor: default;">
            <div class="stat-icon stat-icon-views"><i class="fa-solid fa-eye"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalViews) }}</span>
                <span class="stat-label">মোট পাঠক ভিউ</span>
                <span class="stat-subtext">সর্বমোট নিউজ রিড</span>
            </div>
        </div>

        <!-- 5. Categories & Tags -->
        <a href="{{ route('admin.categories.index') }}" class="stat-card">
            <div class="stat-icon stat-icon-cats"><i class="fa-solid fa-folder-tree"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalCategories) }} / {{ number_format($totalTags) }}</span>
                <span class="stat-label">ক্যাটাগরি ও ট্যাগ</span>
                <span class="stat-subtext">{{ $totalCategories }} ক্যাটাগরি, {{ $totalTags }} ট্যাগ</span>
            </div>
        </a>

        <!-- 6. Registered Users/Reporters -->
        <a href="{{ route('admin.users.index') }}" class="stat-card">
            <div class="stat-icon stat-icon-users"><i class="fa-solid fa-users"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalUsers) }}</span>
                <span class="stat-label">ইউজার ও সাংবাদিক</span>
                <span class="stat-subtext">নিবন্ধিত অ্যাকাউন্ট</span>
            </div>
        </a>

        <!-- 7. Subscribers -->
        <a href="{{ route('admin.subscribers.index') }}" class="stat-card">
            <div class="stat-icon stat-icon-subs"><i class="fa-solid fa-bell"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalSubscribers) }}</span>
                <span class="stat-label">সাবস্ক্রাইবার</span>
                <span class="stat-subtext">ইমেইল গ্রাহক সংখ্যা</span>
            </div>
        </a>

        <!-- 8. Active Poll & Votes -->
        <a href="{{ route('admin.polls.index') }}" class="stat-card">
            <div class="stat-icon stat-icon-poll"><i class="fa-solid fa-square-poll-vertical"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $activePoll ? number_format($activePoll->total_votes) : '০' }}</span>
                <span class="stat-label">চলমান জরিপে ভোট</span>
                <span class="stat-subtext">{{ $activePoll ? 'সক্রিয় জরিপ চলমান' : 'কোনো জরিপ নেই' }}</span>
            </div>
        </a>
    </div>

    <!-- 4. Middle Split (7-Day Trend Chart & Category Breakdown) -->
    <div class="dashboard-splits split-8-4">
        <!-- 7-Day Trend Area Chart -->
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>গত ৭ দিনের সংবাদ প্রকাশনার ট্রেন্ড</span>
                </h3>
                <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.78rem;">
                    সর্বশেষ ৭ দিন
                </span>
            </div>
            <div class="card-body-padded">
                <div class="chart-container-wrapper">
                    <canvas id="publishTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>শীর্ষ ক্যাটাগরিসমূহ</span>
                </h3>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm" style="font-size: 0.8rem; padding: 4px 10px;">সব দেখুন</a>
            </div>
            <div class="card-body-padded">
                <ul class="breakdown-list">
                    @forelse($categoriesBreakdown as $cat)
                        @php
                            $percentage = $maxCategoryPosts > 0 ? round(($cat->posts_count / $maxCategoryPosts) * 100) : 0;
                        @endphp
                        <li class="breakdown-item">
                            <div class="breakdown-header">
                                <span class="breakdown-name">{{ $cat->name }}</span>
                                <span class="breakdown-count">{{ number_format($cat->posts_count) }} টি পোস্ট</span>
                            </div>
                            <div class="breakdown-bar-bg">
                                <div class="breakdown-bar-fill" style="width: {{ $percentage }}%;"></div>
                            </div>
                        </li>
                    @empty
                        <li style="color: var(--text-sub); text-align: center; padding: 24px 0;">কোনো ক্যাটাগরির তথ্য পাওয়া যায়নি।</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- 5. Lower Split (Recent Posts & Most Viewed Posts) -->
    <div class="dashboard-splits split-8-4">
        <!-- Recent Posts Section -->
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>সাম্প্রতিক প্রকাশিত সংবাদ</span>
                </h3>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm" style="background-color: var(--accent); border-color: var(--accent); font-size: 0.82rem;">
                        <i class="fa-solid fa-plus me-1"></i> নতুন পোস্ট
                    </a>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm" style="font-size: 0.82rem;">সব দেখুন</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ছবি</th>
                            <th>সংবাদের শিরোনাম ও প্রতিবেদক</th>
                            <th>ক্যাটাগরি</th>
                            <th>তারিখ</th>
                            <th>ভিউস</th>
                            <th>স্ট্যাটাস</th>
                            <th style="text-align: right;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPosts as $post)
                            <tr>
                                <td>
                                    <img src="{{ $post->featured_image_url }}" alt="thumb" class="post-thumb-sm" onerror="this.src='{{ asset('images/default-news.jpg') }}'">
                                </td>
                                <td>
                                    <div>
                                        <a href="{{ route('post', $post->slug) }}" target="_blank" class="post-title-link" title="{{ $post->title }}">
                                            {{ $post->title }}
                                        </a>
                                        <div class="post-reporter-tag">
                                            <i class="fa-regular fa-user"></i>
                                            <span>{{ $post->author_name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($post->categories->first())
                                        <span class="badge-cat-tag">{{ $post->categories->first()->name }}</span>
                                    @else
                                        <span class="badge badge-secondary" style="font-size: 0.72rem;">অনির্ধারিত</span>
                                    @endif
                                </td>
                                <td style="font-size: 0.82rem; color: var(--text-sub); white-space: nowrap;">
                                    {{ $post->created_at->format('d M, Y') }}
                                </td>
                                <td style="font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 0.88rem; color: var(--text-dark);">
                                    <i class="fa-regular fa-eye text-muted me-1" style="font-size: 0.78rem;"></i>{{ number_format($post->views_count) }}
                                </td>
                                <td>
                                    @if($post->status === 'publish')
                                        <span class="badge-status-publish"><i class="fa-solid fa-circle-check me-1"></i>প্রকাশিত</span>
                                    @else
                                        <span class="badge-status-draft"><i class="fa-solid fa-clock me-1"></i>ড্রাফট</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <div class="action-flex" style="justify-content: flex-end;">
                                        <a href="{{ route('post', $post->slug) }}" target="_blank" class="action-btn action-view" title="অনলাইনে দেখুন">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                        <a href="{{ route('admin.posts.social-card', $post->id) }}" class="action-social-btn" title="সোশ্যাল কার্ড তৈরি করুন">
                                            <i class="fa-solid fa-share-nodes"></i>
                                        </a>
                                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="action-btn action-edit" title="সম্পাদনা">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 36px; color: var(--text-sub);">
                                    <i class="fa-regular fa-newspaper fa-2x mb-2 d-block text-muted"></i>
                                    কোনো সংবাদ পাওয়া যায়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top 5 Most Viewed News -->
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-fire text-danger"></i>
                    <span>সর্বাধিক পঠিত সংবাদ</span>
                </h3>
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" style="font-size: 0.78rem;">
                    টপ ৫ ভিউ
                </span>
            </div>
            <div class="card-body-padded">
                <ul class="top-viewed-list">
                    @forelse($topViewedPosts as $index => $topPost)
                        <li class="top-viewed-item">
                            <span class="rank-badge {{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : ($index == 2 ? 'rank-3' : 'rank-other')) }}">
                                {{ $index + 1 }}
                            </span>
                            <div class="top-post-details">
                                <a href="{{ route('post', $topPost->slug) }}" target="_blank" class="top-post-title" title="{{ $topPost->title }}">
                                    {{ $topPost->title }}
                                </a>
                                <div class="top-post-meta">
                                    <span><i class="fa-regular fa-eye me-1"></i>{{ number_format($topPost->views_count) }} বার</span>
                                    <span>•</span>
                                    <span>{{ $topPost->author_name }}</span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li style="color: var(--text-sub); text-align: center; padding: 24px 0;">কোনো সংবাদ পাওয়া যায়নি।</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- 6. Bottom Split (Opinions & Contact Messages Hubs) -->
    <div class="dashboard-splits split-6-6">
        <!-- Recent Opinions Activity -->
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-feather-pointed text-primary"></i>
                    <span>সাম্প্রতিক মতামত ও কলাম</span>
                </h3>
                <a href="{{ route('admin.opinions.index') }}" class="btn btn-outline-secondary btn-sm" style="font-size: 0.8rem; padding: 4px 10px;">সব দেখুন</a>
            </div>
            <ul class="hub-list">
                @forelse($recentOpinions as $opinion)
                    <li class="hub-list-item">
                        <div class="hub-item-left">
                            <div class="hub-item-avatar">
                                <i class="fa-solid fa-pen-nib"></i>
                            </div>
                            <div>
                                <div class="hub-item-title">{{ $opinion->title }}</div>
                                <div class="hub-item-sub">
                                    <span><strong>{{ $opinion->author_name }}</strong></span>
                                    <span>•</span>
                                    <span>{{ $opinion->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            @if($opinion->status === 'approved')
                                <span class="badge bg-success" style="font-size: 0.72rem;">অনুমোদিত</span>
                            @elseif($opinion->status === 'rejected')
                                <span class="badge bg-danger" style="font-size: 0.72rem;">বাতিল</span>
                            @else
                                <a href="{{ route('admin.opinions.show', $opinion->id) }}" class="btn btn-sm btn-outline-danger" style="font-size: 0.74rem; padding: 3px 8px;">
                                    রিভিউ
                                </a>
                            @endif
                        </div>
                    </li>
                @empty
                    <li style="padding: 32px 20px; text-align: center; color: var(--text-sub);">
                        <i class="fa-regular fa-comment-dots fa-2x mb-2 d-block text-muted"></i>
                        কোনো মতামত জমা হয়নি।
                    </li>
                @endforelse
            </ul>
        </div>

        <!-- Recent Contact Messages -->
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-inbox text-info"></i>
                    <span>যোগাযোগ ইনবক্সের বার্তা</span>
                </h3>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary btn-sm" style="font-size: 0.8rem; padding: 4px 10px;">ইনবক্স দেখুন</a>
            </div>
            <ul class="hub-list">
                @forelse($recentMessages as $msg)
                    <li class="hub-list-item">
                        <div class="hub-item-left">
                            <div class="hub-item-avatar" style="background: {{ $msg->is_read ? '#f1f5f9' : '#e0e7ff' }}; color: {{ $msg->is_read ? '#64748b' : '#3730a3' }};">
                                <i class="fa-regular {{ $msg->is_read ? 'fa-envelope-open' : 'fa-envelope' }}"></i>
                            </div>
                            <div>
                                <div class="hub-item-title">{{ $msg->subject ?: 'বিষয় উল্লেখ নেই' }}</div>
                                <div class="hub-item-sub">
                                    <span><strong>{{ $msg->name }}</strong></span>
                                    <span>•</span>
                                    <span>{{ $msg->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            @if(!$msg->is_read)
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="badge bg-primary" style="font-size: 0.72rem; text-decoration: none; padding: 5px 8px;">
                                    নতুন বার্তা
                                </a>
                            @else
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="action-btn action-view" title="বার্তা পড়ুন">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            @endif
                        </div>
                    </li>
                @empty
                    <li style="padding: 32px 20px; text-align: center; color: var(--text-sub);">
                        <i class="fa-regular fa-paper-plane fa-2x mb-2 d-block text-muted"></i>
                        ইনবক্সে কোনো বার্তা নেই।
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

@endsection

@section('scripts')
<!-- Chart.js 4.4 CDN for 7-Day Trend Line/Area Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('publishTrendChart');
        if (!ctx) return;

        const labels = @json($chartLabels);
        const dataValues = @json($chartPostCounts);

        const chartContext = ctx.getContext('2d');
        
        // Gradient fill for area under the line
        const gradient = chartContext.createLinearGradient(0, 0, 0, 260);
        gradient.addColorStop(0, 'rgba(220, 38, 38, 0.28)');
        gradient.addColorStop(1, 'rgba(220, 38, 38, 0.01)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'প্রকাশিত সংবাদ',
                    data: dataValues,
                    borderColor: '#dc2626',
                    backgroundColor: gradient,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#dc2626',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#dc2626',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: {
                            family: 'Noto Sans Bengali, sans-serif',
                            size: 13
                        },
                        bodyFont: {
                            family: 'Noto Sans Bengali, Outfit, sans-serif',
                            size: 13,
                            weight: 'bold'
                        },
                        padding: 10,
                        cornerRadius: 6,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' টি সংবাদ প্রকাশিত';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'Noto Sans Bengali, sans-serif',
                                size: 12
                            },
                            color: '#64748b'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: Math.max(...dataValues, 5) + 1,
                        ticks: {
                            stepSize: 1,
                            font: {
                                family: 'Outfit, sans-serif',
                                size: 12
                            },
                            color: '#64748b'
                        },
                        grid: {
                            color: '#f1f5f9'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
