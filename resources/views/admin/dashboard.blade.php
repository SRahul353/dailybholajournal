@extends('layouts.admin')

@section('title', 'ড্যাশবোর্ড ও ভিজিটর অ্যানালিটিক্স | দৈনিক ভোলা জার্নাল')
@section('header_title', 'কন্ট্রোল প্যানেল ও ভিজিটর অ্যানালিটিক্স')

@section('styles')
<style>
    /* ========================================================
       Dashboard Redesign — Clean, Zoned Layout
       ======================================================== */

    /* ── Greeting Card ─────────────────────────────────────── */
    .page-greeting-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #dc2626 200%);
        border-radius: var(--radius-md);
        padding: 20px 24px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        box-shadow: 0 4px 16px rgba(15,23,42,0.18);
    }

    .greeting-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .greeting-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: #fff;
        flex-shrink: 0;
    }

    .greeting-title {
        font-size: 1.08rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.3;
    }

    .greeting-sub {
        font-size: 0.82rem;
        color: rgba(255,255,255,0.65);
        margin-top: 2px;
    }

    .greeting-badges {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .greeting-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 14px;
        border-radius: 8px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.18);
        color: #fff;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s;
    }

    .greeting-badge:hover {
        background: rgba(255,255,255,0.22);
        color: #fff;
    }

    .greeting-badge .badge-num {
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        font-size: 1rem;
    }

    /* ── Alert Banners ─────────────────────────────────────── */
    .alert-banner {
        border-radius: 10px;
        padding: 14px 20px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.06);
    }

    .alert-banner-opinions {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border: 1px solid #fecaca;
    }

    .alert-banner-messages {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #bfdbfe;
    }

    .alert-banner-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 50%;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
    }

    .alert-icon-red  { background: #dc2626; }
    .alert-icon-blue { background: #2563eb; }

    .alert-banner-title   { font-weight: 700; font-size: 0.95rem; }
    .alert-banner-sub     { font-size: 0.83rem; }
    .alert-title-red      { color: #991b1b; }
    .alert-title-blue     { color: #1e40af; }
    .alert-sub-red        { color: #7f1d1d; }
    .alert-sub-blue       { color: #1e3a8a; }

    /* ── Zone Section Headers ──────────────────────────────── */
    .dashboard-zone-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--border-color);
    }

    .zone-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1rem;
        font-weight: 800;
        color: var(--text-dark);
    }

    .zone-title-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
    }

    .zone-icon-analytics { background: rgba(16,185,129,0.12); color: #059669; }
    .zone-icon-editorial { background: rgba(245,158,11,0.12); color: #d97706; }

    /* Range Filter (inside zone header) */
    .range-btn-group {
        display: flex;
        align-items: center;
        gap: 4px;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 8px;
    }

    .range-btn {
        padding: 5px 13px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-sub);
        text-decoration: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .range-btn:hover { color: var(--text-dark); background: rgba(255,255,255,0.7); }
    .range-btn.active { background: #dc2626; color: #fff !important; box-shadow: 0 2px 4px rgba(220,38,38,0.25); }

    /* ── Stats Grid ────────────────────────────────────────── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    @media (min-width: 768px) {
        .stats-grid { grid-template-columns: repeat(4, 1fr); gap: 18px; }
    }

    .stat-card {
        background-color: var(--content-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: var(--shadow);
        transition: var(--transition);
        text-decoration: none;
        overflow: hidden;
    }

    .stat-card:hover { transform: translateY(-3px); border-color: #cbd5e1; box-shadow: 0 10px 20px -4px rgba(15,23,42,0.08); }

    .stat-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.3rem;
    }

    .stat-icon-visitors { background: rgba(16,185,129,0.12); color: #059669; }
    .stat-icon-views    { background: rgba(220,38,38,0.12);  color: #dc2626; }
    .stat-icon-traffic  { background: rgba(14,165,233,0.12); color: #0284c7; }
    .stat-icon-allviews { background: rgba(99,102,241,0.12); color: #4f46e5; }
    .stat-icon-posts    { background: rgba(245,158,11,0.12); color: #d97706; }
    .stat-icon-cats     { background: rgba(100,116,139,0.14);color: #475569; }
    .stat-icon-users    { background: rgba(139,92,246,0.12); color: #7c3aed; }
    .stat-icon-poll     { background: rgba(20,184,166,0.12); color: #0d9488; }

    .stat-info { display: flex; flex-direction: column; overflow: hidden; }

    .stat-value {
        font-family: 'Outfit', 'Noto Sans Bengali', sans-serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: #0f172a !important;
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.83rem;
        color: var(--text-sub);
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat-subtext {
        font-size: 0.72rem;
        color: #94a3b8;
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ── Dashboard Splits ──────────────────────────────────── */
    .dashboard-splits {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    @media (min-width: 1024px) {
        .dashboard-splits.split-8-4 { grid-template-columns: 2fr 1fr; }
        .dashboard-splits.split-6-6 { grid-template-columns: 1fr 1fr; }
    }

    /* ── Admin Cards ───────────────────────────────────────── */
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
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fff;
        flex-wrap: wrap;
        gap: 8px;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .card-body-padded { padding: 18px 20px; }

    /* ── Chart ─────────────────────────────────────────────── */
    .chart-container-wrapper {
        position: relative;
        height: 280px;
        width: 100%;
    }

    .chart-legend-row {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .chart-legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        color: var(--text-sub);
    }

    .chart-legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }

    /* ── Device & Source Panel ─────────────────────────────── */
    .tech-group-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 10px;
        margin-top: 16px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .tech-group-title:first-child { margin-top: 0; }

    .device-progress-item { margin-bottom: 12px; }
    .device-progress-item:last-child { margin-bottom: 0; }

    .device-progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.82rem;
        margin-bottom: 5px;
    }

    .device-bar-bg { width: 100%; height: 7px; background: #f1f5f9; border-radius: 999px; overflow: hidden; }
    .device-bar-fill { height: 100%; border-radius: 999px; transition: width 0.6s ease; }
    .bar-mobile  { background: linear-gradient(90deg, #10b981 0%, #059669 100%); }
    .bar-desktop { background: linear-gradient(90deg, #3b82f6 0%, #1d4ed8 100%); }
    .bar-tablet  { background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); }

    .source-pills-list { display: flex; flex-wrap: wrap; gap: 7px; margin-top: 6px; }

    .source-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 9px;
        border-radius: 6px;
        font-size: 0.76rem;
        font-weight: 600;
        background: #f8fafc;
        border: 1px solid var(--border-color);
        color: var(--text-dark);
    }

    .source-fb   { color: #1877f2; border-color: #dbeafe; background: #eff6ff; }
    .source-goog { color: #ea4335; border-color: #fee2e2; background: #fef2f2; }
    .source-dir  { color: #059669; border-color: #d1fae5; background: #ecfdf5; }
    .source-tw   { color: #0ea5e9; border-color: #e0f2fe; background: #f0f9ff; }
    .source-wa   { color: #16a34a; border-color: #dcfce7; background: #f0fdf4; }

    /* ── Live Visitor Table ────────────────────────────────── */
    .device-icon-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-dark);
        white-space: nowrap;
    }

    /* ── Top Viewed Posts ──────────────────────────────────── */
    .top-viewed-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px; }

    .top-viewed-item {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border-color);
    }

    .top-viewed-item:last-child { border-bottom: none; padding-bottom: 0; }

    .rank-badge {
        width: 24px;
        height: 24px;
        min-width: 24px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        font-size: 0.82rem;
    }

    .rank-1     { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .rank-2     { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .rank-3     { background: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; }
    .rank-other { background: #f8fafc; color: #94a3b8; border: 1px solid #e2e8f0; }

    .top-post-details { flex: 1; min-width: 0; }

    .top-post-title {
        font-weight: 600;
        font-size: 0.86rem;
        line-height: 1.35;
        color: var(--text-dark);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-decoration: none;
    }

    .top-post-title:hover { color: var(--accent); }

    .top-post-meta {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 0.74rem;
        color: var(--text-sub);
        margin-top: 4px;
    }

    /* ── Post Table ────────────────────────────────────────── */
    .post-thumb-sm {
        width: 44px;
        height: 34px;
        min-width: 44px;
        border-radius: 4px;
        object-fit: cover;
        background: #f1f5f9;
        border: 1px solid var(--border-color);
    }

    .post-title-link {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-block;
        max-width: 240px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: middle;
    }

    .post-title-link:hover { color: var(--accent); }

    .post-reporter-tag {
        font-size: 0.76rem;
        color: var(--text-sub);
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
    }

    .badge-status-publish {
        background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;
        font-size: 0.72rem; font-weight: 700; padding: 2px 7px; border-radius: 999px;
    }

    .badge-status-draft {
        background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;
        font-size: 0.72rem; font-weight: 700; padding: 2px 7px; border-radius: 999px;
    }

    .badge-cat-tag {
        background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;
        font-size: 0.74rem; font-weight: 600; padding: 2px 7px; border-radius: 6px; white-space: nowrap;
    }

    .action-social-btn {
        background: #f5f3ff; color: #7c3aed; border: 1px solid #ddd6fe;
        padding: 5px 8px; border-radius: 6px; font-size: 0.8rem;
        transition: var(--transition); display: inline-flex; align-items: center;
        justify-content: center; text-decoration: none;
    }

    .action-social-btn:hover { background: #7c3aed; color: #fff; }

    /* ── Category Breakdown ────────────────────────────────── */
    .breakdown-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 13px; }

    .breakdown-item { display: flex; flex-direction: column; gap: 5px; }

    .breakdown-header { display: flex; justify-content: space-between; align-items: center; font-size: 0.86rem; }
    .breakdown-name { font-weight: 600; color: var(--text-dark); }
    .breakdown-count { font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 0.8rem; color: var(--text-sub); }

    .breakdown-bar-bg { width: 100%; height: 6px; background: #f1f5f9; border-radius: 999px; overflow: hidden; }
    .breakdown-bar-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #dc2626 0%, #f97316 100%); transition: width 0.6s ease; }

    /* ── Hub List (Opinions & Messages) ────────────────────── */
    .hub-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; }

    .hub-list-item {
        padding: 13px 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        transition: background 0.15s;
    }

    .hub-list-item:hover { background: #f8fafc; }
    .hub-list-item:last-child { border-bottom: none; }

    .hub-item-left { display: flex; align-items: center; gap: 11px; min-width: 0; }

    .hub-item-avatar {
        width: 36px; height: 36px; min-width: 36px;
        border-radius: 50%; background: #f1f5f9; color: #64748b;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.95rem;
    }

    .hub-item-title {
        font-weight: 600; font-size: 0.87rem; color: var(--text-dark);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 280px;
    }

    .hub-item-sub { font-size: 0.75rem; color: var(--text-sub); display: flex; align-items: center; gap: 7px; margin-top: 2px; }

    /* ── Zone Separator ────────────────────────────────────── */
    .zone-separator { margin: 28px 0 20px; }

    /* ── Mobile Adjustments ────────────────────────────────── */
    @media (max-width: 639px) {
        .stat-value { font-size: 1.35rem; }
        .stat-card  { padding: 14px; gap: 12px; }
        .stat-icon  { width: 42px; height: 42px; min-width: 42px; font-size: 1.1rem; }
        .card-header-wrapper { padding: 13px 15px; }
        .card-body-padded { padding: 14px 15px; }
        .chart-container-wrapper { height: 230px; }
        .greeting-title { font-size: 0.95rem; }
        .page-greeting-card { padding: 16px 18px; }
    }
</style>
@endsection

@section('content')

    {{-- ══════════════════════════════════════════════════════
         1. PAGE GREETING CARD
    ══════════════════════════════════════════════════════ --}}
    <div class="page-greeting-card">
        <div class="greeting-left">
            <div class="greeting-avatar">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div>
                <div class="greeting-title">
                    স্বাগতম, {{ $userName }}!
                </div>
                <div class="greeting-sub">
                    <i class="fa-regular fa-calendar me-1"></i>
                    {{ now()->locale('bn')->translatedFormat('l, d F Y') }} — কন্ট্রোল প্যানেল ওভারভিউ
                </div>
            </div>
        </div>
        <div class="greeting-badges">
            <div class="greeting-badge">
                <i class="fa-solid fa-users"></i>
                <span>আজকের ভিজিটর</span>
                <span class="badge-num">{{ number_format(\App\Models\VisitorLog::whereDate('created_at', today())->distinct('ip_address')->count('ip_address')) }}</span>
            </div>
            @if($unreadMessagesCount > 0)
            <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="greeting-badge">
                <i class="fa-solid fa-envelope"></i>
                <span>অপঠিত বার্তা</span>
                <span class="badge-num">{{ $unreadMessagesCount }}</span>
            </a>
            @endif
            @if($pendingOpinionsCount > 0)
            <a href="{{ route('admin.opinions.index', ['status' => 'pending']) }}" class="greeting-badge">
                <i class="fa-solid fa-pen-nib"></i>
                <span>পেন্ডিং মতামত</span>
                <span class="badge-num">{{ $pendingOpinionsCount }}</span>
            </a>
            @endif
            <div class="greeting-badge">
                <i class="fa-solid fa-newspaper"></i>
                <span>মোট সংবাদ</span>
                <span class="badge-num">{{ number_format($totalPosts) }}</span>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════
         2. ALERT BANNERS (conditional)
    ══════════════════════════════════════════════════════ --}}
    @if(isset($pendingOpinionsCount) && $pendingOpinionsCount > 0)
        <div class="alert-banner alert-banner-opinions">
            <div class="d-flex align-items-center gap-3">
                <div class="alert-banner-icon alert-icon-red">
                    <i class="fa-solid fa-pen-nib"></i>
                </div>
                <div>
                    <div class="alert-banner-title alert-title-red">নতুন মতামত ও কলাম জমা হয়েছে!</div>
                    <div class="alert-banner-sub alert-sub-red">মোট <strong>{{ $pendingOpinionsCount }}</strong> টি মতামত প্রকাশের জন্য অনুমোদনের অপেক্ষায় রয়েছে।</div>
                </div>
            </div>
            <a href="{{ route('admin.opinions.index', ['status' => 'pending']) }}" class="btn btn-sm" style="background:#dc2626;color:#fff;border-color:#dc2626;font-size:0.84rem;">
                পর্যালোচনা করুন <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
    @endif

    @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
        <div class="alert-banner alert-banner-messages">
            <div class="d-flex align-items-center gap-3">
                <div class="alert-banner-icon alert-icon-blue">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div>
                    <div class="alert-banner-title alert-title-blue">পাঠকদের পাঠানো অপঠিত বার্তা রয়েছে!</div>
                    <div class="alert-banner-sub alert-sub-blue">যোগাযোগ পেজ থেকে <strong>{{ $unreadMessagesCount }}</strong> টি নতুন বার্তা ইনবক্সে অপঠিত রয়েছে।</div>
                </div>
            </div>
            <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="btn btn-sm" style="background:#2563eb;color:#fff;border-color:#2563eb;font-size:0.84rem;">
                ইনবক্স দেখুন <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════
         3. ANALYTICS ZONE HEADER + RANGE FILTER
    ══════════════════════════════════════════════════════ --}}
    <div class="dashboard-zone-header zone-separator">
        <div class="zone-title">
            <div class="zone-title-icon zone-icon-analytics">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <span>ভিজিটর অ্যানালিটিক্স</span>
            <span style="font-size:0.8rem;font-weight:500;color:var(--text-sub);">— {{ $rangeLabelBn }} এর তথ্য দেখাচ্ছে</span>
        </div>
        <div class="range-btn-group">
            <a href="{{ route('admin.dashboard', ['range' => 'today']) }}" class="range-btn {{ $range === 'today' ? 'active' : '' }}">
                <i class="fa-regular fa-sun"></i>আজকে
            </a>
            <a href="{{ route('admin.dashboard', ['range' => '7days']) }}" class="range-btn {{ $range === '7days' ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-week"></i>৭ দিন
            </a>
            <a href="{{ route('admin.dashboard', ['range' => '30days']) }}" class="range-btn {{ $range === '30days' ? 'active' : '' }}">
                <i class="fa-regular fa-calendar"></i>৩০ দিন
            </a>
            <a href="{{ route('admin.dashboard', ['range' => '90days']) }}" class="range-btn {{ $range === '90days' ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i>৯০ দিন
            </a>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════
         4. ANALYTICS STAT CARDS (4 — Range Sensitive)
    ══════════════════════════════════════════════════════ --}}
    <div class="stats-grid">
        <div class="stat-card" style="border-left:4px solid #10b981;">
            <div class="stat-icon stat-icon-visitors"><i class="fa-solid fa-users"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($rangeVisitorsCount) }}</span>
                <span class="stat-label">{{ $rangeLabelBn }}র ইউনিক ভিজিটর</span>
                <span class="stat-subtext">নির্বাচিত সময়সীমায় পাঠক</span>
            </div>
        </div>

        <div class="stat-card" style="border-left:4px solid #dc2626;">
            <div class="stat-icon stat-icon-views"><i class="fa-solid fa-chart-line"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($rangeViewsCount) }}</span>
                <span class="stat-label">{{ $rangeLabelBn }}র পেজ ভিউ</span>
                <span class="stat-subtext">নির্বাচিত সময়সীমায় পঠিত</span>
            </div>
        </div>

        <div class="stat-card" style="border-left:4px solid #0284c7;">
            <div class="stat-icon stat-icon-traffic"><i class="fa-solid fa-newspaper"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($rangePostsCount) }}</span>
                <span class="stat-label">{{ $rangeLabelBn }}র সংবাদ</span>
                <span class="stat-subtext">সময়সীমায় প্রকাশিত পোস্ট</span>
            </div>
        </div>

        <div class="stat-card" style="border-left:4px solid #4f46e5;">
            <div class="stat-icon stat-icon-allviews"><i class="fa-solid fa-eye"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalViews) }}</span>
                <span class="stat-label">সর্বমোট পাঠক ভিউ</span>
                <span class="stat-subtext">সকল সংবাদের মোট রিড</span>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════
         5. CHART (col-8) + DEVICE/SOURCE PANEL (col-4)
    ══════════════════════════════════════════════════════ --}}
    <div class="dashboard-splits split-8-4">
        {{-- Visitor Traffic Trend Chart --}}
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-chart-area text-success"></i>
                    <span>ভিজিটর ট্রাফিক ট্রেন্ড ({{ $rangeLabelBn }})</span>
                </h3>
                <div class="chart-legend-row">
                    <span class="chart-legend-item">
                        <span class="chart-legend-dot" style="background:#10b981;"></span>
                        ইউনিক ভিজিটর
                    </span>
                    <span class="chart-legend-item">
                        <span class="chart-legend-dot" style="background:#dc2626;"></span>
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

        {{-- Device & Source Breakdown Panel --}}
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-mobile-screen-button text-primary"></i>
                    <span>ডিভাইস ও ট্রাফিক উৎস</span>
                </h3>
                <span class="badge bg-light text-secondary border px-2 py-1" style="font-size:0.74rem;">{{ $rangeLabelBn }}</span>
            </div>
            <div class="card-body-padded">
                {{-- Device Breakdown --}}
                <div class="tech-group-title">
                    <i class="fa-solid fa-laptop-file text-muted"></i>
                    <span>ডিভাইস বিভাজন:</span>
                </div>
                @forelse($deviceStats as $device)
                    @php
                        $barClass  = $device->device === 'Mobile' ? 'bar-mobile' : ($device->device === 'Desktop' ? 'bar-desktop' : 'bar-tablet');
                        $iconClass = $device->device === 'Mobile' ? 'fa-mobile-screen' : ($device->device === 'Desktop' ? 'fa-desktop' : 'fa-tablet-screen-button');
                        $labelBn   = $device->device === 'Mobile' ? 'মোবাইল' : ($device->device === 'Desktop' ? 'ডেস্কটপ' : 'ট্যাবলেট');
                    @endphp
                    <div class="device-progress-item">
                        <div class="device-progress-header">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fa-solid {{ $iconClass }} text-muted"></i>
                                <strong>{{ $labelBn }}</strong>
                            </span>
                            <span style="font-family:'Outfit',sans-serif;font-weight:700;font-size:0.82rem;">{{ $device->percent }}% ({{ number_format($device->count) }})</span>
                        </div>
                        <div class="device-bar-bg">
                            <div class="device-bar-fill {{ $barClass }}" style="width:{{ $device->percent }}%;"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-muted small">তথ্য পাওয়া যায়নি।</div>
                @endforelse

                {{-- Top Browsers --}}
                <div class="tech-group-title">
                    <i class="fa-brands fa-chrome text-muted"></i>
                    <span>শীর্ষ ব্রাউজার:</span>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($browserStats as $browser)
                        <span class="badge bg-light text-dark border px-2 py-1" style="font-size:0.76rem;">
                            <i class="fa-solid fa-globe text-secondary me-1"></i>
                            {{ $browser->browser }}: <strong style="font-family:'Outfit',sans-serif;">{{ $browser->percent }}%</strong>
                        </span>
                    @endforeach
                </div>

                {{-- Traffic Sources --}}
                <div class="tech-group-title">
                    <i class="fa-solid fa-share-nodes text-muted"></i>
                    <span>ট্রাফিক উৎস:</span>
                </div>
                <div class="source-pills-list">
                    @foreach($sourceStats as $source)
                        @php
                            $pillClass = 'source-dir'; $icon = 'fa-solid fa-link';
                            if (stripos($source->referer_source, 'Facebook') !== false)       { $pillClass = 'source-fb';   $icon = 'fa-brands fa-facebook'; }
                            elseif (stripos($source->referer_source, 'Google') !== false)     { $pillClass = 'source-goog'; $icon = 'fa-brands fa-google'; }
                            elseif (stripos($source->referer_source, 'Twitter') !== false)    { $pillClass = 'source-tw';   $icon = 'fa-brands fa-x-twitter'; }
                            elseif (stripos($source->referer_source, 'WhatsApp') !== false)   { $pillClass = 'source-wa';   $icon = 'fa-brands fa-whatsapp'; }
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

    {{-- ══════════════════════════════════════════════════════
         6. LIVE VISITOR FEED — Full Width (5 columns, no IP)
    ══════════════════════════════════════════════════════ --}}
    <div class="admin-card" style="margin-bottom:20px;">
        <div class="card-header-wrapper">
            <h3 class="card-title">
                <i class="fa-solid fa-satellite-dish text-primary"></i>
                <span>সাম্প্রতিক ভিজিটর লাইভ লগ</span>
            </h3>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size:0.74rem;">
                <i class="fa-solid fa-circle-dot me-1"></i>রিয়েলটাইম
            </span>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ডিভাইস ও ওএস</th>
                        <th>ব্রাউজার</th>
                        <th>পরিদর্শিত পেজ / সংবাদ</th>
                        <th>ট্রাফিক উৎস</th>
                        <th style="text-align:right;">সময়</th>
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
                                <span class="badge bg-light text-secondary border" style="font-size:0.74rem;">
                                    {{ $visitor->browser }}
                                </span>
                            </td>
                            <td>
                                @if($visitor->post)
                                    <a href="{{ route('post', $visitor->post->slug) }}" target="_blank" class="post-title-link" title="{{ $visitor->post->title }}">
                                        <i class="fa-solid fa-newspaper text-muted me-1" style="font-size:0.76rem;"></i>
                                        {{ $visitor->post->title }}
                                    </a>
                                @elseif($visitor->page_title)
                                    <span style="font-size:0.84rem;font-weight:600;color:var(--text-dark);">{{ $visitor->page_title }}</span>
                                @else
                                    <span style="font-size:0.82rem;color:var(--text-sub);">হোমপেজ / মূল পাতা</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $src = $visitor->referer_source ?: 'Direct';
                                    $pc  = 'source-dir';
                                    if (stripos($src,'Facebook') !== false)  $pc = 'source-fb';
                                    elseif (stripos($src,'Google') !== false)   $pc = 'source-goog';
                                    elseif (stripos($src,'WhatsApp') !== false) $pc = 'source-wa';
                                    elseif (stripos($src,'Twitter') !== false)  $pc = 'source-tw';
                                @endphp
                                <span class="source-pill {{ $pc }}" style="padding:2px 7px;font-size:0.74rem;">{{ $src }}</span>
                            </td>
                            <td style="text-align:right;font-size:0.76rem;color:var(--text-sub);white-space:nowrap;">
                                {{ $visitor->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:28px;color:var(--text-sub);">কোনো ভিজিটর লগ পাওয়া যায়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════
         7. EDITORIAL ZONE HEADER
    ══════════════════════════════════════════════════════ --}}
    <div class="dashboard-zone-header">
        <div class="zone-title">
            <div class="zone-title-icon zone-icon-editorial">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <span>সম্পাদকীয় পরিসংখ্যান</span>
            <span style="font-size:0.8rem;font-weight:500;color:var(--text-sub);">— সকল সময়ের ডেটা</span>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════
         8. EDITORIAL STAT CARDS (4 — All-time)
    ══════════════════════════════════════════════════════ --}}
    <div class="stats-grid">
        <a href="{{ route('admin.posts.index') }}" class="stat-card" style="border-left:4px solid #d97706;">
            <div class="stat-icon stat-icon-posts"><i class="fa-solid fa-file-lines"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalPosts) }}</span>
                <span class="stat-label">মোট প্রকাশিত সংবাদ</span>
                <span class="stat-subtext">আজ {{ $todayPosts }}টি, ড্রাফট {{ $draftPosts }}টি</span>
            </div>
        </a>

        <a href="{{ route('admin.categories.index') }}" class="stat-card" style="border-left:4px solid #475569;">
            <div class="stat-icon stat-icon-cats"><i class="fa-solid fa-folder-tree"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalCategories) }} / {{ number_format($totalTags) }}</span>
                <span class="stat-label">ক্যাটাগরি ও ট্যাগ</span>
                <span class="stat-subtext">{{ $totalCategories }} ক্যাটাগরি, {{ $totalTags }} ট্যাগ</span>
            </div>
        </a>

        <a href="{{ route('admin.users.index') }}" class="stat-card" style="border-left:4px solid #7c3aed;">
            <div class="stat-icon stat-icon-users"><i class="fa-solid fa-user-shield"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalUsers) }}</span>
                <span class="stat-label">সাংবাদিক ও স্টাফ</span>
                <span class="stat-subtext">নিবন্ধিত অ্যাকাউন্ট</span>
            </div>
        </a>

        <a href="{{ route('admin.polls.index') }}" class="stat-card" style="border-left:4px solid #0d9488;">
            <div class="stat-icon stat-icon-poll"><i class="fa-solid fa-square-poll-vertical"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $activePoll ? number_format($activePoll->total_votes) : '০' }}</span>
                <span class="stat-label">চলমান জরিপে ভোট</span>
                <span class="stat-subtext">{{ $activePoll ? 'সক্রিয় জরিপ চলমান' : 'কোনো জরিপ নেই' }}</span>
            </div>
        </a>
    </div>

    {{-- ══════════════════════════════════════════════════════
         9. RECENT POSTS (col-8) + TOP VIEWED & CATEGORIES (col-4)
    ══════════════════════════════════════════════════════ --}}
    <div class="dashboard-splits split-8-4">
        {{-- Recent Published Posts --}}
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>সাম্প্রতিক প্রকাশিত সংবাদ</span>
                </h3>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm" style="background:var(--accent);border-color:var(--accent);font-size:0.8rem;">
                        <i class="fa-solid fa-plus me-1"></i>নতুন পোস্ট
                    </a>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm" style="font-size:0.8rem;">সব দেখুন</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width:50px;">ছবি</th>
                            <th>শিরোনাম ও প্রতিবেদক</th>
                            <th>ক্যাটাগরি</th>
                            <th>তারিখ</th>
                            <th>ভিউ</th>
                            <th>স্ট্যাটাস</th>
                            <th style="text-align:right;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPosts as $post)
                            <tr>
                                <td>
                                    <img src="{{ $post->featured_image_url }}" alt="thumb" class="post-thumb-sm" onerror="this.src='{{ asset('images/default-news.jpg') }}'">
                                </td>
                                <td>
                                    <a href="{{ route('post', $post->slug) }}" target="_blank" class="post-title-link" title="{{ $post->title }}">{{ $post->title }}</a>
                                    <div class="post-reporter-tag">
                                        <i class="fa-regular fa-user"></i>
                                        <span>{{ $post->author_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($post->categories->first())
                                        <span class="badge-cat-tag">{{ $post->categories->first()->name }}</span>
                                    @else
                                        <span class="badge badge-secondary" style="font-size:0.72rem;">অনির্ধারিত</span>
                                    @endif
                                </td>
                                <td style="font-size:0.8rem;color:var(--text-sub);white-space:nowrap;">
                                    {{ $post->created_at->format('d M, Y') }}
                                </td>
                                <td style="font-family:'Outfit',sans-serif;font-weight:700;font-size:0.86rem;color:var(--text-dark);">
                                    <i class="fa-regular fa-eye text-muted me-1" style="font-size:0.76rem;"></i>{{ number_format($post->views_count) }}
                                </td>
                                <td>
                                    @if($post->status === 'publish')
                                        <span class="badge-status-publish"><i class="fa-solid fa-circle-check me-1"></i>প্রকাশিত</span>
                                    @else
                                        <span class="badge-status-draft"><i class="fa-solid fa-clock me-1"></i>ড্রাফট</span>
                                    @endif
                                </td>
                                <td style="text-align:right;">
                                    <div class="action-flex" style="justify-content:flex-end;">
                                        <a href="{{ route('post', $post->slug) }}" target="_blank" class="action-btn action-view" title="অনলাইনে দেখুন">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                        <a href="{{ route('admin.posts.social-card', $post->id) }}" class="action-social-btn" title="সোশ্যাল কার্ড">
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
                                <td colspan="7" style="text-align:center;padding:36px;color:var(--text-sub);">
                                    <i class="fa-regular fa-newspaper fa-2x mb-2 d-block text-muted"></i>
                                    কোনো সংবাদ পাওয়া যায়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right Column: Top Viewed + Category Breakdown --}}
        <div style="display:flex;flex-direction:column;gap:20px;">
            {{-- Top 5 Most Viewed --}}
            <div class="admin-card">
                <div class="card-header-wrapper">
                    <h3 class="card-title">
                        <i class="fa-solid fa-fire text-danger"></i>
                        <span>সর্বাধিক পঠিত সংবাদ</span>
                    </h3>
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" style="font-size:0.74rem;">টপ ৫</span>
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
                            <li style="color:var(--text-sub);text-align:center;padding:24px 0;">কোনো সংবাদ পাওয়া যায়নি।</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- Category Breakdown --}}
            <div class="admin-card">
                <div class="card-header-wrapper">
                    <h3 class="card-title">
                        <i class="fa-solid fa-layer-group"></i>
                        <span>শীর্ষ ক্যাটাগরি</span>
                    </h3>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm" style="font-size:0.78rem;padding:3px 9px;">সব দেখুন</a>
                </div>
                <div class="card-body-padded">
                    <ul class="breakdown-list">
                        @forelse($categoriesBreakdown as $cat)
                            @php
                                $pct = $maxCategoryPosts > 0 ? round(($cat->posts_count / $maxCategoryPosts) * 100) : 0;
                            @endphp
                            <li class="breakdown-item">
                                <div class="breakdown-header">
                                    <span class="breakdown-name">{{ $cat->name }}</span>
                                    <span class="breakdown-count">{{ number_format($cat->posts_count) }} টি</span>
                                </div>
                                <div class="breakdown-bar-bg">
                                    <div class="breakdown-bar-fill" style="width:{{ $pct }}%;"></div>
                                </div>
                            </li>
                        @empty
                            <li style="color:var(--text-sub);text-align:center;padding:24px 0;">কোনো ক্যাটাগরির তথ্য পাওয়া যায়নি।</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════
         10. OPINIONS + CONTACT MESSAGES (Split 6-6)
    ══════════════════════════════════════════════════════ --}}
    <div class="dashboard-splits split-6-6">
        {{-- Recent Opinions --}}
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-feather-pointed text-primary"></i>
                    <span>সাম্প্রতিক মতামত ও কলাম</span>
                </h3>
                <a href="{{ route('admin.opinions.index') }}" class="btn btn-outline-secondary btn-sm" style="font-size:0.78rem;padding:3px 9px;">সব দেখুন</a>
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
                                <span class="badge bg-success" style="font-size:0.72rem;">অনুমোদিত</span>
                            @elseif($opinion->status === 'rejected')
                                <span class="badge bg-danger" style="font-size:0.72rem;">বাতিল</span>
                            @else
                                <a href="{{ route('admin.opinions.show', $opinion->id) }}" class="btn btn-sm btn-outline-danger" style="font-size:0.74rem;padding:3px 8px;">রিভিউ</a>
                            @endif
                        </div>
                    </li>
                @empty
                    <li style="padding:32px 20px;text-align:center;color:var(--text-sub);">
                        <i class="fa-regular fa-comment-dots fa-2x mb-2 d-block text-muted"></i>
                        কোনো মতামত জমা হয়নি।
                    </li>
                @endforelse
            </ul>
        </div>

        {{-- Recent Contact Messages --}}
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-inbox text-info"></i>
                    <span>যোগাযোগ ইনবক্সের বার্তা</span>
                </h3>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary btn-sm" style="font-size:0.78rem;padding:3px 9px;">ইনবক্স দেখুন</a>
            </div>
            <ul class="hub-list">
                @forelse($recentMessages as $msg)
                    <li class="hub-list-item">
                        <div class="hub-item-left">
                            <div class="hub-item-avatar" style="background:{{ $msg->is_read ? '#f1f5f9' : '#e0e7ff' }};color:{{ $msg->is_read ? '#64748b' : '#3730a3' }};">
                                <i class="fa-regular {{ $msg->is_read ? 'fa-envelope-open' : 'fa-envelope' }}"></i>
                            </div>
                            <div>
                                <div class="hub-item-title">{{ $msg->subject ?: 'বিষয় উল্লেখ নেই' }}</div>
                                <div class="hub-item-sub">
                                    <span><strong>{{ $msg->name }}</strong></span>
                                    <span>•</span>
                                    <span>{{ $msg->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            @if(!$msg->is_read)
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="badge bg-primary" style="font-size:0.72rem;text-decoration:none;padding:5px 8px;">নতুন বার্তা</a>
                            @else
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="action-btn action-view" title="বার্তা পড়ুন">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            @endif
                        </div>
                    </li>
                @empty
                    <li style="padding:32px 20px;text-align:center;color:var(--text-sub);">
                        <i class="fa-regular fa-paper-plane fa-2x mb-2 d-block text-muted"></i>
                        ইনবক্সে কোনো বার্তা নেই।
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('visitorTrendChart');
        if (!ctx) return;

        const labels       = @json($chartLabels);
        const visitorsData = @json($chartVisitors);
        const viewsData    = @json($chartViews);

        const chartCtx = ctx.getContext('2d');

        const gradVisitors = chartCtx.createLinearGradient(0, 0, 0, 260);
        gradVisitors.addColorStop(0, 'rgba(16, 185, 129, 0.28)');
        gradVisitors.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

        const gradViews = chartCtx.createLinearGradient(0, 0, 0, 260);
        gradViews.addColorStop(0, 'rgba(220, 38, 38, 0.20)');
        gradViews.addColorStop(1, 'rgba(220, 38, 38, 0.01)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'ইউনিক ভিজিটর',
                        data: visitorsData,
                        borderColor: '#10b981',
                        backgroundColor: gradVisitors,
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#10b981',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2
                    },
                    {
                        label: 'পেজ ভিউজ',
                        data: viewsData,
                        borderColor: '#dc2626',
                        backgroundColor: gradViews,
                        borderWidth: 2,
                        borderDash: [4, 4],
                        fill: false,
                        tension: 0.35,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#dc2626',
                        pointBorderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#dc2626',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { family: 'Noto Sans Bengali, sans-serif', size: 13 },
                        bodyFont: { family: 'Noto Sans Bengali, Outfit, sans-serif', size: 13 },
                        padding: 10,
                        cornerRadius: 6,
                        callbacks: {
                            label: function(c) {
                                return c.dataset.label + ': ' + c.parsed.y + ' জন';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Noto Sans Bengali, sans-serif', size: 12 }, color: '#64748b' }
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: Math.max(...viewsData, ...visitorsData, 10) + 5,
                        ticks: { precision: 0, font: { family: 'Outfit, sans-serif', size: 12 }, color: '#64748b' },
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });
    });
</script>
@endsection
