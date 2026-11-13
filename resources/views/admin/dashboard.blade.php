@extends('layouts.admin')

@section('title', 'ড্যাশবোর্ড ও ভিজিটর অ্যানালিটিক্স | দৈনিক ভোলা জার্নাল')
@section('header_title', 'কন্ট্রোল প্যানেল ও ভিজিটর অ্যানালিটিক্স')

@section('styles')
<style>
    /* ========================================================
       Dashboard & Visitor Analytics Modern UI Styles
       ======================================================== */

    /* Range Filter Bar */
    .range-filter-bar {
        background: var(--content-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 12px 18px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        box-shadow: var(--shadow);
    }

    .range-filter-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .range-btn-group {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 8px;
    }

    .range-btn {
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--text-sub);
        text-decoration: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
    }

    .range-btn:hover {
        color: var(--text-dark);
        background: rgba(255, 255, 255, 0.7);
    }

    .range-btn.active {
        background: #dc2626;
        color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(220, 38, 38, 0.25);
    }

    /* Stats Grid Layout - 8 Metrics Cards */
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
    .stat-icon-visitors  { background-color: rgba(16, 185, 129, 0.12); color: #059669; }
    .stat-icon-views     { background-color: rgba(220, 38, 38, 0.12); color: #dc2626; }
    .stat-icon-traffic   { background-color: rgba(14, 165, 233, 0.12); color: #0284c7; }
    .stat-icon-allviews  { background-color: rgba(99, 102, 241, 0.12); color: #4f46e5; }
    .stat-icon-posts     { background-color: rgba(245, 158, 11, 0.12); color: #d97706; }
    .stat-icon-cats      { background-color: rgba(100, 116, 139, 0.14); color: #475569; }
    .stat-icon-users     { background-color: rgba(139, 92, 246, 0.12); color: #7c3aed; }
    .stat-icon-poll      { background-color: rgba(20, 184, 166, 0.12); color: #0d9488; }

    .stat-info {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .stat-value {
        font-family: 'Outfit', 'Noto Sans Bengali', sans-serif;
        font-size: 1.65rem;
        font-weight: 700;
        color: #0f172a !important;
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
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
    }

    .card-title {
        font-size: 1.02rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-body-padded {
        padding: 20px;
    }

    /* Chart Container */
    .chart-container-wrapper {
        position: relative;
        height: 290px;
        width: 100%;
    }

    /* Visitor Tech & Device Breakdown */
    .tech-group-title {
        font-size: 0.84rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .device-progress-item {
        margin-bottom: 14px;
    }

    .device-progress-item:last-child {
        margin-bottom: 0;
    }

    .device-progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.84rem;
        margin-bottom: 5px;
    }

    .device-bar-bg {
        width: 100%;
        height: 7px;
        background-color: #f1f5f9;
        border-radius: 999px;
        overflow: hidden;
    }

    .device-bar-fill {
        height: 100%;
        border-radius: 999px;
        transition: width 0.6s ease;
    }

    .bar-mobile  { background: linear-gradient(90deg, #10b981 0%, #059669 100%); }
    .bar-desktop { background: linear-gradient(90deg, #3b82f6 0%, #1d4ed8 100%); }
    .bar-tablet  { background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); }

    /* Source Pills */
    .source-pills-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .source-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 600;
        background: #f8fafc;
        border: 1px solid var(--border-color);
        color: var(--text-dark);
    }

    .source-pill i {
        font-size: 0.85rem;
    }

    .source-fb    { color: #1877f2; border-color: #dbeafe; background: #eff6ff; }
    .source-goog  { color: #ea4335; border-color: #fee2e2; background: #fef2f2; }
    .source-dir   { color: #059669; border-color: #d1fae5; background: #ecfdf5; }
    .source-tw    { color: #0ea5e9; border-color: #e0f2fe; background: #f0f9ff; }
    .source-wa    { color: #16a34a; border-color: #dcfce7; background: #f0fdf4; }

    /* Live Visitors Table */
    .visitor-ip-badge {
        font-family: 'Outfit', monospace;
        font-size: 0.78rem;
        font-weight: 600;
        color: #475569;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 2px 7px;
        border-radius: 4px;
        white-space: nowrap;
    }

    .device-icon-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--text-dark);
        white-space: nowrap;
    }

    /* Category breakdown styling */
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
        max-width: 260px;
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

    /* Hub list styles for opinions & messages */
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

    <!-- 2. Date Range Filter Bar (আজকে, ৭ দিন, ৩০ দিন, ৯০ দিন) -->
    <div class="range-filter-bar">
        <div class="range-filter-title">
            <i class="fa-solid fa-clock-rotate-left text-danger"></i>
            <span>অ্যানালিটিক্স সময়সীমা ফিল্টার (Date Range):</span>
        </div>
        <div class="range-btn-group">
            <a href="{{ route('admin.dashboard', ['range' => 'today']) }}" class="range-btn {{ $range === 'today' ? 'active' : '' }}">
                <i class="fa-regular fa-sun me-1"></i>আজকে
            </a>
            <a href="{{ route('admin.dashboard', ['range' => '7days']) }}" class="range-btn {{ $range === '7days' ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-week me-1"></i>৭ দিন
            </a>
            <a href="{{ route('admin.dashboard', ['range' => '30days']) }}" class="range-btn {{ $range === '30days' ? 'active' : '' }}">
                <i class="fa-regular fa-calendar me-1"></i>৩০ দিন
            </a>
            <a href="{{ route('admin.dashboard', ['range' => '90days']) }}" class="range-btn {{ $range === '90days' ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days me-1"></i>৯০ দিন
            </a>
        </div>
    </div>

    <!-- 3. Metrics Statistics Grid (8 Cards: Range Analytics & Editorial) -->
    <div class="stats-grid">
        <!-- 1. Unique Visitors in Selected Range -->
        <div class="stat-card" style="border-left: 4px solid #10b981;">
            <div class="stat-icon stat-icon-visitors"><i class="fa-solid fa-users"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($rangeVisitorsCount) }}</span>
                <span class="stat-label">{{ $rangeLabelBn }}র ইউনিক ভিজিটর</span>
                <span class="stat-subtext">নির্বাচিত সময়সীমায় পাঠক</span>
            </div>
        </div>

        <!-- 2. Page Views in Selected Range -->
        <div class="stat-card" style="border-left: 4px solid #dc2626;">
            <div class="stat-icon stat-icon-views"><i class="fa-solid fa-chart-line"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($rangeViewsCount) }}</span>
                <span class="stat-label">{{ $rangeLabelBn }}র পেজ ভিউ</span>
                <span class="stat-subtext">নির্বাচিত সময়সীমায় পঠিত</span>
            </div>
        </div>

        <!-- 3. Published News in Selected Range -->
        <div class="stat-card" style="border-left: 4px solid #0284c7;">
            <div class="stat-icon stat-icon-traffic"><i class="fa-solid fa-newspaper"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($rangePostsCount) }}</span>
                <span class="stat-label">{{ $rangeLabelBn }}র সংবাদ</span>
                <span class="stat-subtext">সময়সীমায় প্রকাশিত পোস্ট</span>
            </div>
        </div>

        <!-- 4. Total Views Across News -->
        <div class="stat-card" style="border-left: 4px solid #4f46e5;">
            <div class="stat-icon stat-icon-allviews"><i class="fa-solid fa-eye"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalViews) }}</span>
                <span class="stat-label">সর্বমোট পাঠক ভিউ</span>
                <span class="stat-subtext">সকল সংবাদের মোট রিড</span>
            </div>
        </div>

        <!-- 5. Published News Posts -->
        <a href="{{ route('admin.posts.index') }}" class="stat-card">
            <div class="stat-icon stat-icon-posts"><i class="fa-solid fa-file-lines"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalPosts) }}</span>
                <span class="stat-label">মোট প্রকাশিত সংবাদ</span>
                <span class="stat-subtext">আজ {{ $todayPosts }}টি, ড্রাফট {{ $draftPosts }}টি</span>
            </div>
        </a>

        <!-- 6. Categories & Tags -->
        <a href="{{ route('admin.categories.index') }}" class="stat-card">
            <div class="stat-icon stat-icon-cats"><i class="fa-solid fa-folder-tree"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalCategories) }} / {{ number_format($totalTags) }}</span>
                <span class="stat-label">ক্যাটাগরি ও ট্যাগ</span>
                <span class="stat-subtext">{{ $totalCategories }} ক্যাটাগরি, {{ $totalTags }} ট্যাগ</span>
            </div>
        </a>

        <!-- 7. Registered Users/Reporters -->
        <a href="{{ route('admin.users.index') }}" class="stat-card">
            <div class="stat-icon stat-icon-users"><i class="fa-solid fa-user-shield"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalUsers) }}</span>
                <span class="stat-label">সাংবাদিক ও স্টাফ</span>
                <span class="stat-subtext">নিবন্ধিত অ্যাকাউন্ট</span>
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

    <!-- 4. Visitor Traffic Trend & Device Intelligence (Split 8-4) -->
    <div class="dashboard-splits split-8-4">
        <!-- Visitor Traffic Chart -->
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-chart-line text-success"></i>
                    <span>ভিজিটর ট্রাফিক ও পেজ ভিউ ট্রেন্ড ({{ $rangeLabelBn }})</span>
                </h3>
                <div class="d-flex align-items-center gap-3">
                    <span style="font-size: 0.78rem; display: flex; align-items: center; gap: 6px;">
                        <span style="width: 10px; height: 10px; background: #10b981; border-radius: 50%; display: inline-block;"></span>
                        ইউনিক ভিজিটর
                    </span>
                    <span style="font-size: 0.78rem; display: flex; align-items: center; gap: 6px;">
                        <span style="width: 10px; height: 10px; background: #dc2626; border-radius: 50%; display: inline-block;"></span>
                        পেজ ভিউজ
                    </span>
                </div>
            </div>
            <div class="card-body-padded">
                <div class="chart-container-wrapper">
                    <canvas id="visitorTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Visitor Tech & Device Breakdown -->
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-mobile-screen-button text-primary"></i>
                    <span>ভিজিটর ডিভাইস ও প্রযুক্তি বিশ্লেষণ ({{ $rangeLabelBn }})</span>
                </h3>
                <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.76rem;">
                    ডিভাইস অ্যানালিটিক্স
                </span>
            </div>
            <div class="card-body-padded">
                <!-- Device Breakdown -->
                <div class="tech-group-title">
                    <i class="fa-solid fa-laptop-file text-muted"></i>
                    <span>ডিভাইস ডিস্ট্রিবিউশন:</span>
                </div>
                <div style="margin-bottom: 20px;">
                    @forelse($deviceStats as $device)
                        @php
                            $barClass = $device->device === 'Mobile' ? 'bar-mobile' : ($device->device === 'Desktop' ? 'bar-desktop' : 'bar-tablet');
                            $iconClass = $device->device === 'Mobile' ? 'fa-mobile-screen' : ($device->device === 'Desktop' ? 'fa-desktop' : 'fa-tablet-screen-button');
                        @endphp
                        <div class="device-progress-item">
                            <div class="device-progress-header">
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fa-solid {{ $iconClass }} text-muted"></i>
                                    <strong>{{ $device->device === 'Mobile' ? 'মোবাইল (Mobile)' : ($device->device === 'Desktop' ? 'ডেস্কটপ (Desktop)' : 'ট্যাবলেট (Tablet)') }}</strong>
                                </span>
                                <span style="font-family: 'Outfit', sans-serif; font-weight: 700;">{{ $device->percent }}% ({{ number_format($device->count) }})</span>
                            </div>
                            <div class="device-bar-bg">
                                <div class="device-bar-fill {{ $barClass }}" style="width: {{ $device->percent }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted small">তথ্য পাওয়া যায়নি।</div>
                    @endforelse
                </div>

                <!-- Top Browsers -->
                <div class="tech-group-title">
                    <i class="fa-brands fa-chrome text-muted"></i>
                    <span>শীর্ষ ব্যবহৃত ব্রাউজার:</span>
                </div>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    @foreach($browserStats as $browser)
                        <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.78rem;">
                            <i class="fa-solid fa-globe text-secondary me-1"></i>
                            {{ $browser->browser }}: <strong style="font-family: 'Outfit', sans-serif;">{{ $browser->percent }}%</strong>
                        </span>
                    @endforeach
                </div>

                <!-- Traffic Sources -->
                <div class="tech-group-title">
                    <i class="fa-solid fa-share-nodes text-muted"></i>
                    <span>প্রধান ট্রাফিক উৎস (Traffic Sources):</span>
                </div>
                <div class="source-pills-list">
                    @foreach($sourceStats as $source)
                        @php
                            $pillClass = 'source-dir';
                            $icon = 'fa-solid fa-link';
                            if (stripos($source->referer_source, 'Facebook') !== false) {
                                $pillClass = 'source-fb';
                                $icon = 'fa-brands fa-facebook';
                            } elseif (stripos($source->referer_source, 'Google') !== false) {
                                $pillClass = 'source-goog';
                                $icon = 'fa-brands fa-google';
                            } elseif (stripos($source->referer_source, 'Twitter') !== false) {
                                $pillClass = 'source-tw';
                                $icon = 'fa-brands fa-x-twitter';
                            } elseif (stripos($source->referer_source, 'WhatsApp') !== false) {
                                $pillClass = 'source-wa';
                                $icon = 'fa-brands fa-whatsapp';
                            }
                        @endphp
                        <span class="source-pill {{ $pillClass }}">
                            <i class="{{ $icon }}"></i>
                            <span>{{ $source->referer_source }} ({{ $source->percent }}%)</span>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Recent Live Visitors Feed & Top Viewed News (Split 8-4) -->
    <div class="dashboard-splits split-8-4">
        <!-- Recent Live Visitors Table -->
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-satellite-dish text-primary"></i>
                    <span>সাম্প্রতিক ভিজিটর লাইভ লগ (Recent Live Visitors)</span>
                </h3>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 0.76rem;">
                    <i class="fa-solid fa-circle-dot me-1"></i>রিয়েলটাইম লগ
                </span>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ডিভাইস ও ওএস</th>
                            <th>ব্রাউজার</th>
                            <th>পরিদর্শিত পেজ / পঠিত সংবাদ</th>
                            <th>উৎস (Referer)</th>
                            <th>আইপি অ্যাড্রেস</th>
                            <th style="text-align: right;">সময়</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentVisitors as $visitor)
                            <tr>
                                <td>
                                    <span class="device-icon-badge">
                                        @if($visitor->device === 'Mobile')
                                            <i class="fa-solid fa-mobile-screen text-success"></i>
                                        @elseif($visitor->device === 'Tablet')
                                            <i class="fa-solid fa-tablet-screen-button text-warning"></i>
                                        @else
                                            <i class="fa-solid fa-desktop text-primary"></i>
                                        @endif
                                        <span>{{ $visitor->os }}</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-secondary border" style="font-size: 0.74rem;">
                                        {{ $visitor->browser }}
                                    </span>
                                </td>
                                <td>
                                    @if($visitor->post)
                                        <a href="{{ route('post', $visitor->post->slug) }}" target="_blank" class="post-title-link" title="{{ $visitor->post->title }}">
                                            <i class="fa-solid fa-newspaper text-muted me-1" style="font-size: 0.78rem;"></i>
                                            {{ $visitor->post->title }}
                                        </a>
                                    @elseif($visitor->page_title)
                                        <span style="font-size: 0.84rem; font-weight: 600; color: var(--text-dark);">
                                            {{ $visitor->page_title }}
                                        </span>
                                    @else
                                        <span style="font-size: 0.82rem; color: var(--text-sub);">হোমপেজ / মূল পাতা</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $source = $visitor->referer_source ?: 'Direct';
                                        $pillClass = 'source-dir';
                                        if (stripos($source, 'Facebook') !== false) $pillClass = 'source-fb';
                                        elseif (stripos($source, 'Google') !== false) $pillClass = 'source-goog';
                                        elseif (stripos($source, 'WhatsApp') !== false) $pillClass = 'source-wa';
                                        elseif (stripos($source, 'Twitter') !== false) $pillClass = 'source-tw';
                                    @endphp
                                    <span class="source-pill {{ $pillClass }}" style="padding: 2px 7px; font-size: 0.74rem;">
                                        {{ $source }}
                                    </span>
                                </td>
                                <td>
                                    <span class="visitor-ip-badge">{{ $visitor->ip_address }}</span>
                                </td>
                                <td style="text-align: right; font-size: 0.78rem; color: var(--text-sub); white-space: nowrap;">
                                    {{ $visitor->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 28px; color: var(--text-sub);">
                                    কোনো ভিজিটর লগ পাওয়া যায়নি।
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

    <!-- 5. Recent News & Category Breakdown (Split 8-4) -->
    <div class="dashboard-splits split-8-4">
        <!-- Recent Published Posts Section -->
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
                            <th>শিরোনাম ও প্রতিবেদক</th>
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
<!-- Chart.js 4.4 CDN for 7-Day Visitor & Traffic Trend Dual Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('visitorTrendChart');
        if (!ctx) return;

        const labels = @json($chartLabels);
        const visitorsData = @json($chartVisitors);
        const viewsData = @json($chartViews);

        const chartContext = ctx.getContext('2d');
        
        // Gradient for Unique Visitors (Emerald Green)
        const gradientVisitors = chartContext.createLinearGradient(0, 0, 0, 260);
        gradientVisitors.addColorStop(0, 'rgba(16, 185, 129, 0.28)');
        gradientVisitors.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

        // Gradient for Page Views (Crimson Red)
        const gradientViews = chartContext.createLinearGradient(0, 0, 0, 260);
        gradientViews.addColorStop(0, 'rgba(220, 38, 38, 0.22)');
        gradientViews.addColorStop(1, 'rgba(220, 38, 38, 0.01)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'ইউনিক ভিজিটর',
                        data: visitorsData,
                        borderColor: '#10b981',
                        backgroundColor: gradientVisitors,
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#10b981',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 2
                    },
                    {
                        label: 'পেজ ভিউজ',
                        data: viewsData,
                        borderColor: '#dc2626',
                        backgroundColor: gradientViews,
                        borderWidth: 2,
                        borderDash: [4, 4],
                        fill: false,
                        tension: 0.35,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#dc2626',
                        pointBorderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#dc2626',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
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
                            size: 13
                        },
                        padding: 10,
                        cornerRadius: 6,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' জন';
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
                        suggestedMax: Math.max(...viewsData, ...visitorsData, 10) + 5,
                        ticks: {
                            precision: 0,
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
