@extends('layouts.admin')

@section('title', 'এসইও ম্যানেজার | দৈনিক ভোলা জার্নাল অ্যাডমিন প্যানেল')
@section('header_title', 'এসইও ম্যানেজার (SEO Manager)')

@section('styles')
<style>
    /* SEO Manager Layout & Tabs */
    .seo-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
    }

    .seo-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }

    .seo-stat-box {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: var(--shadow);
    }

    .seo-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .seo-tabs-nav {
        display: flex;
        gap: 8px;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 24px;
        overflow-x: auto;
        padding-bottom: 2px;
        -webkit-overflow-scrolling: touch;
    }

    .seo-tab-btn {
        background: none;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 10px 18px;
        font-weight: 600;
        font-size: 0.92rem;
        color: var(--text-sub);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        border-radius: var(--radius-sm) var(--radius-sm) 0 0;
    }

    .seo-tab-btn:hover {
        color: var(--accent);
        background: #f8fafc;
    }

    .seo-tab-btn.active {
        color: var(--accent);
        border-bottom-color: var(--accent);
        background: #ffffff;
    }

    .seo-tab-content {
        display: none;
    }

    .seo-tab-content.active {
        display: block;
        animation: fadeInTab 0.25s ease;
    }

    @keyframes fadeInTab {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Live Google SERP Preview */
    .serp-preview-box {
        background: #ffffff;
        border: 1px solid #dfe1e5;
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 6px rgba(32, 33, 36, 0.08);
        max-width: 650px;
        font-family: Arial, sans-serif;
    }

    .serp-url-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.82rem;
        color: #202124;
        margin-bottom: 4px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .serp-favicon {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #c90000;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 700;
    }

    .serp-title {
        color: #1a0dab;
        font-size: 1.25rem;
        line-height: 1.35;
        margin-bottom: 4px;
        cursor: pointer;
        font-weight: 400;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .serp-title:hover {
        text-decoration: underline;
    }

    .serp-desc {
        color: #4d5156;
        font-size: 0.88rem;
        line-height: 1.58;
        margin-bottom: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    /* Social Share Card Preview */
    .social-card-preview {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        max-width: 520px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        margin-bottom: 20px;
    }

    .social-card-img-wrap {
        width: 100%;
        height: 220px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .social-card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .social-card-body {
        padding: 14px 16px;
        background: #ffffff;
    }

    .social-card-domain {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #64748b;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .social-card-title {
        font-size: 0.98rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.4;
        margin-bottom: 6px;
    }

    .social-card-desc {
        font-size: 0.85rem;
        color: #475569;
        line-height: 1.45;
        margin-bottom: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Code & Script editor textarea */
    .code-editor-area {
        font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
        font-size: 0.88rem;
        line-height: 1.5;
        background-color: #0f172a !important;
        color: #38bdf8 !important;
        border: 1px solid #1e293b !important;
        border-radius: var(--radius-sm);
        padding: 14px;
    }

    .code-editor-area:focus {
        border-color: #38bdf8 !important;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2) !important;
    }

    /* Character Counter Badges */
    .char-counter {
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--text-sub);
        float: right;
    }
    .char-counter.good { color: #16a34a; }
    .char-counter.warn { color: #d97706; }
    .char-counter.bad { color: #dc2626; }

    /* Sticky Save Footer on Mobile */
    @media (max-width: 768px) {
        .seo-sticky-save-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 10px 16px;
            z-index: 95;
            display: flex;
            gap: 10px;
            box-shadow: 0 -4px 12px rgba(0,0,0,0.08);
        }
        .admin-content {
            padding-bottom: 75px !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- Success & Error Alerts -->
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4" style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 18px; border-radius: var(--radius-sm);">
            <i class="fa-solid fa-circle-check text-success fs-5"></i>
            <span class="fw-semibold">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-4" style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: var(--radius-sm);">
            <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- SEO Dashboard Quick Overview Cards -->
    <div class="seo-stats-grid">
        <div class="seo-stat-box">
            <div class="seo-stat-icon" style="background: rgba(37, 99, 235, 0.12); color: #2563eb;">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <span style="font-size: 0.8rem; color: var(--text-sub); display: block;">প্রকাশিত সংবাদ (ইনডেক্সড)</span>
                <strong style="font-size: 1.4rem; color: var(--text-dark);">{{ number_format($stats['published_posts']) }}</strong>
            </div>
        </div>

        <div class="seo-stat-box">
            <div class="seo-stat-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                <i class="fa-solid fa-sitemap"></i>
            </div>
            <div>
                <span style="font-size: 0.8rem; color: var(--text-sub); display: block;">XML সাইটম্যাপ স্ট্যাটাস</span>
                <strong style="font-size: 0.95rem; color: #059669;">
                    <i class="fa-solid fa-circle-check"></i> সক্রিয় ও প্রস্তুত
                </strong>
            </div>
        </div>

        <div class="seo-stat-box">
            <div class="seo-stat-icon" style="background: rgba(245, 158, 11, 0.12); color: #f59e0b;">
                <i class="fa-solid fa-rss"></i>
            </div>
            <div>
                <span style="font-size: 0.8rem; color: var(--text-sub); display: block;">RSS / News Feed</span>
                <strong style="font-size: 0.95rem; color: var(--text-dark);">
                    <i class="fa-solid fa-check"></i> RSS 2.0 লাইভ
                </strong>
            </div>
        </div>

        <div class="seo-stat-box">
            <div class="seo-stat-icon" style="background: rgba(139, 92, 246, 0.12); color: #8b5cf6;">
                <i class="fa-solid fa-robot"></i>
            </div>
            <div>
                <span style="font-size: 0.8rem; color: var(--text-sub); display: block;">Robots.txt ফাইল</span>
                <strong style="font-size: 0.95rem; color: var(--text-dark);">
                    @if(!empty($settings['enable_custom_robots']))
                        <span class="text-warning"><i class="fa-solid fa-sliders"></i> কাস্টম মোড</span>
                    @else
                        <span class="text-success"><i class="fa-solid fa-check"></i> স্ট্যান্ডার্ড মোড</span>
                    @endif
                </strong>
            </div>
        </div>
    </div>

    <!-- Main SEO Settings Container -->
    <div class="admin-card">
        <div class="seo-card-header">
            <div>
                <h3 class="card-title mb-1">
                    <i class="fa-solid fa-magnifying-glass-chart text-danger me-2"></i>
                    <span>সার্চ ইঞ্জিন অপ্টিমাইজেশন (SEO) ম্যানেজার</span>
                </h3>
                <p class="mb-0 text-muted" style="font-size: 0.88rem;">গুগল, বিং ও সোশ্যাল মিডিয়ায় পত্রিকার দৃশ্যমানতা ও ট্রাফিক বৃদ্ধির সর্বাধুনিক কনফিগারেশন</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ $stats['sitemap_url'] }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="এক্সএমএল সাইটম্যাপ ব্রাউজ করুন">
                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> সitemap.xml
                </a>
                <a href="{{ $stats['rss_url'] }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="আরএসএস ফিড দেখুন">
                    <i class="fa-solid fa-rss me-1 text-warning"></i> RSS ফিড
                </a>
                <button type="submit" form="seo-manager-form" class="btn btn-primary d-none d-md-inline-flex align-items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>পরিবর্তন সংরক্ষণ করুন</span>
                </button>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="seo-tabs-nav" id="seoTabsNav">
            <button type="button" class="seo-tab-btn active" onclick="switchSeoTab('general')">
                <i class="fa-solid fa-globe"></i> সাধারণ ও মেটা
            </button>
            <button type="button" class="seo-tab-btn" onclick="switchSeoTab('social')">
                <i class="fa-solid fa-share-nodes"></i> সোশ্যাল ও ওপেন গ্রাফ
            </button>
            <button type="button" class="seo-tab-btn" onclick="switchSeoTab('webmaster')">
                <i class="fa-solid fa-chart-line"></i> ওয়েবমাস্টার ও অ্যানালিটিক্স
            </button>
            <button type="button" class="seo-tab-btn" onclick="switchSeoTab('sitemap')">
                <i class="fa-solid fa-sitemap"></i> সাইটম্যাপ ও পিং
            </button>
            <button type="button" class="seo-tab-btn" onclick="switchSeoTab('robots')">
                <i class="fa-solid fa-robot"></i> Robots.txt এডিটর
            </button>
            <button type="button" class="seo-tab-btn" onclick="switchSeoTab('scripts')">
                <i class="fa-solid fa-code"></i> কাস্টম স্ক্রিপ্টস
            </button>
            <button type="button" class="seo-tab-btn" onclick="switchSeoTab('schema')">
                <i class="fa-solid fa-diagram-project"></i> নলেজ গ্রাফ (Schema)
            </button>
        </div>

        <!-- Form for All SEO Settings -->
        <form id="seo-manager-form" action="{{ route('admin.seo.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- ================= TAB 1: GENERAL & META ================= -->
            <div id="tab-general" class="seo-tab-content active">
                <div class="row">
                    <!-- Form Controls -->
                    <div class="col-lg-7">
                        <h5 class="fw-bold text-dark pb-2 mb-3 border-bottom" style="font-size: 1rem;">
                            <i class="fa-solid fa-tag text-danger me-2"></i>প্রাথমিক মেটা তথ্য
                        </h5>

                        <div class="row">
                            <div class="col-md-7 form-group">
                                <label class="form-label" for="site_name">সাইটের প্রাতিষ্ঠানিক নাম <span class="text-danger">*</span></label>
                                <input type="text" name="site_name" id="site_name" class="form-control" value="{{ old('site_name', $settings['site_name']) }}" required placeholder="যেমন: দৈনিক ভোলা জার্নাল">
                            </div>
                            <div class="col-md-5 form-group">
                                <label class="form-label" for="title_separator">টাইটেল বিভাজক (Separator)</label>
                                <input type="text" name="title_separator" id="title_separator" class="form-control text-center" value="{{ old('title_separator', $settings['title_separator']) }}" placeholder="| বা -">
                                <span class="form-text">যেমন: খবর শিরোনাম | দৈনিক ভোলা জার্নাল</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="site_title">
                                ডিফল্ট হোমপেজ মেটা টাইটেল <span class="text-danger">*</span>
                                <span id="titleCounter" class="char-counter">0 / 60</span>
                            </label>
                            <input type="text" name="site_title" id="site_title" class="form-control" value="{{ old('site_title', $settings['site_title']) }}" required placeholder="সার্চ রেজাল্টে প্রদর্শিত টাইটেল">
                            <span class="form-text">গুগলে ৫০-৬০ অক্ষরের টাইটেল সবচেয়ে কার্যকরভাবে প্রদর্শিত হয়।</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="meta_tagline">সাইট ট্যাগলাইন (Tagline / স্লোগান)</label>
                            <input type="text" name="meta_tagline" id="meta_tagline" class="form-control" value="{{ old('meta_tagline', $settings['meta_tagline']) }}" placeholder="যেমন: সত্য ও তথ্যের সমন্বয়ে উপকূলের দিনলিপি">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="meta_description">
                                ডিফল্ট মেটা ডেসক্রিপশন (Meta Description)
                                <span id="descCounter" class="char-counter">0 / 160</span>
                            </label>
                            <textarea name="meta_description" id="meta_description" rows="4" class="form-control" placeholder="পত্রিকা বা ওয়েবসাইটের সংক্ষিপ্ত আকর্ষণীয় পরিচিতি..." style="line-height: 1.6;">{{ old('meta_description', $settings['meta_description']) }}</textarea>
                            <span class="form-text">সার্চ ইঞ্জিনে ১২০ থেকে ১৬০ অক্ষরের বিবরণ সেরা রেটিং পায়।</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="meta_keywords">ডিফল্ট মেটা কীওয়ার্ডস (Meta Keywords)</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords', $settings['meta_keywords']) }}" placeholder="কমা দিয়ে আলাদা করুন, যেমন: দৈনিক ভোলা জার্নাল, ভোলা নিউজ">
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="meta_author">মেটা অথর / প্রকাশক (Author)</label>
                                <input type="text" name="meta_author" id="meta_author" class="form-control" value="{{ old('meta_author', $settings['meta_author']) }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="robots_indexing">সার্চ ইঞ্জিন ইনডেক্সিং (Robots)</label>
                                <select name="robots_indexing" id="robots_indexing" class="form-control">
                                    <option value="index, follow" {{ $settings['robots_indexing'] === 'index, follow' ? 'selected' : '' }}>সক্রিয় (index, follow - রিকমেন্ডেড)</option>
                                    <option value="noindex, nofollow" {{ $settings['robots_indexing'] === 'noindex, nofollow' ? 'selected' : '' }}>নিষ্ক্রিয় (noindex, nofollow - সতর্ক থাকুন)</option>
                                    <option value="index, nofollow" {{ $settings['robots_indexing'] === 'index, nofollow' ? 'selected' : '' }}>ইনডেক্স করুন কিন্তু লিঙ্ক ফলো করবেন না (index, nofollow)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="canonical_url">ক্যানোনিকাল বেস ইউআরএল (ঐচ্ছিক)</label>
                            <input type="text" name="canonical_url" id="canonical_url" class="form-control" value="{{ old('canonical_url', $settings['canonical_url']) }}" placeholder="{{ url('/') }}">
                            <span class="form-text">ফাঁকা রাখলে বর্তমান ডোমেইনের পূর্ণাঙ্গ লিঙ্ক স্বয়ংক্রিয়ভাবে ব্যবহৃত হবে।</span>
                        </div>
                    </div>

                    <!-- Live Google Search Result Preview -->
                    <div class="col-lg-5">
                        <div class="p-3 bg-light rounded border sticky-top" style="top: 85px;">
                            <h6 class="fw-bold text-dark mb-2">
                                <i class="fa-brands fa-google text-danger me-1"></i> গুগল সার্চ প্রিভিউ (Live SERP Preview)
                            </h6>
                            <p class="text-muted" style="font-size: 0.8rem; margin-bottom: 12px;">গুগল সার্চ ফলাফলে আপনার ওয়েবসাইট ঠিক কেমন দেখাবে তার রিয়েল-টাইম প্রিভিউ:</p>

                            <div class="serp-preview-box">
                                <div class="serp-url-row">
                                    <span class="serp-favicon"><i class="fa-solid fa-newspaper"></i></span>
                                    <span id="previewSerpUrl">{{ url('/') }}</span>
                                </div>
                                <h3 class="serp-title" id="previewSerpTitle">{{ $settings['site_title'] }}</h3>
                                <p class="serp-desc" id="previewSerpDesc">{{ $settings['meta_description'] }}</p>
                            </div>

                            <div class="small text-muted p-2 bg-white rounded border">
                                <i class="fa-solid fa-lightbulb text-warning me-1"></i>
                                <strong>প্রো-টিপ:</strong> সংবাদের প্রতিটি পোস্ট তার শিরোনাম ও বিবরণ নিজস্বভাবে প্রদর্শন করবে। এই ডিফল্ট সেটিংস হোমপেজ ও সাধারণ পেজের জন্য প্রযোজ্য।
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= TAB 2: SOCIAL & OPEN GRAPH ================= -->
            <div id="tab-social" class="seo-tab-content">
                <div class="row">
                    <div class="col-lg-7">
                        <h5 class="fw-bold text-dark pb-2 mb-3 border-bottom" style="font-size: 1rem;">
                            <i class="fa-solid fa-share-nodes text-danger me-2"></i>সোশ্যাল মিডিয়া মেটা ও ওপেন গ্রাফ (OG)
                        </h5>

                        <!-- Default OG Image Upload -->
                        <div class="form-group">
                            <label class="form-label" for="og_image_file">ডিফল্ট সোশ্যাল শেয়ার ইমেজ (Social Share Card Image)</label>
                            <input type="file" name="og_image_file" id="og_image_file" class="form-control" accept="image/*" onchange="previewOgImage(this)">
                            <span class="form-text">ফেসবুক বা টুইটারে হোমপেজ বা যেসব পোস্টে ফিচার্ড ছবি নেই তা শেয়ার করলে এই ছবিটি প্রদর্শিত হবে। রিকমেন্ডেড রেজোলিউশন: <strong>১২০০x৬৩০ পিক্সেল</strong>।</span>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="og_type">ওপেন গ্রাফ টাইপ (OG Type)</label>
                                <select name="og_type" id="og_type" class="form-control">
                                    <option value="website" {{ $settings['og_type'] === 'website' ? 'selected' : '' }}>Website</option>
                                    <option value="article" {{ $settings['og_type'] === 'article' ? 'selected' : '' }}>Article</option>
                                    <option value="news" {{ $settings['og_type'] === 'news' ? 'selected' : '' }}>News</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="og_locale">ওপেন গ্রাফ লোকাল (OG Locale)</label>
                                <input type="text" name="og_locale" id="og_locale" class="form-control" value="{{ old('og_locale', $settings['og_locale']) }}" placeholder="bn_BD">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="facebook_app_id">ফেসবুক অ্যাপ আইডি (Facebook App ID - ঐচ্ছিক)</label>
                                <input type="text" name="facebook_app_id" id="facebook_app_id" class="form-control" value="{{ old('facebook_app_id', $settings['facebook_app_id']) }}" placeholder="যেমন: 123456789012345">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="facebook_page_url">অফিসিয়াল ফেসবুক পেজ লিংক</label>
                                <input type="text" name="facebook_page_url" id="facebook_page_url" class="form-control" value="{{ old('facebook_page_url', $settings['facebook_page_url']) }}" placeholder="https://facebook.com/dailybholajournal">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="twitter_site">টুইটার / এক্স হ্যান্ডেল (Twitter Site @)</label>
                                <input type="text" name="twitter_site" id="twitter_site" class="form-control" value="{{ old('twitter_site', $settings['twitter_site']) }}" placeholder="@dailybholajournal">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="twitter_card">টুইটার কার্ড টাইপ</label>
                                <select name="twitter_card" id="twitter_card" class="form-control">
                                    <option value="summary_large_image" {{ $settings['twitter_card'] === 'summary_large_image' ? 'selected' : '' }}>Summary Large Image (বড় ছবি সহ - রিকমেন্ডেড)</option>
                                    <option value="summary" {{ $settings['twitter_card'] === 'summary' ? 'selected' : '' }}>Summary (ছোট থাম্বনেইল)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Live Social Card Preview -->
                    <div class="col-lg-5">
                        <div class="p-3 bg-light rounded border sticky-top" style="top: 85px;">
                            <h6 class="fw-bold text-dark mb-2">
                                <i class="fa-brands fa-facebook text-primary me-1"></i> ফেসবুক / সোশ্যাল শেয়ার প্রিভিউ
                            </h6>
                            <p class="text-muted" style="font-size: 0.8rem; margin-bottom: 12px;">ফেসবুক বা লিংকডইনে শেয়ার করলে কার্ডটি ঠিক যেভাবে দেখাবে:</p>

                            <div class="social-card-preview">
                                <div class="social-card-img-wrap">
                                    @php
                                        $previewImgSrc = !empty($settings['og_image']) ? asset($settings['og_image']) : asset('BJ_Content/Profile Pic b.png');
                                    @endphp
                                    <img id="previewOgImg" src="{{ $previewImgSrc }}" alt="OG Preview">
                                </div>
                                <div class="social-card-body">
                                    <div class="social-card-domain" id="previewSocialDomain">{{ request()->getHost() }}</div>
                                    <div class="social-card-title" id="previewSocialTitle">{{ $settings['site_title'] }}</div>
                                    <p class="social-card-desc" id="previewSocialDesc">{{ $settings['meta_description'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= TAB 3: WEBMASTER & ANALYTICS ================= -->
            <div id="tab-webmaster" class="seo-tab-content">
                <h5 class="fw-bold text-dark pb-2 mb-3 border-bottom" style="font-size: 1rem;">
                    <i class="fa-solid fa-chart-line text-danger me-2"></i>সার্চ কনসোল ভেরিফিকেশন ও ট্র্যাকিং কোড
                </h5>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="google_site_verification">
                            <i class="fa-brands fa-google text-danger me-1"></i> গুগল সার্চ কনসোল ভেরিফিকেশন কোড
                        </label>
                        <input type="text" name="google_site_verification" id="google_site_verification" class="form-control" value="{{ old('google_site_verification', $settings['google_site_verification']) }}" placeholder="google-site-verification টোকেন বা কোড">
                        <span class="form-text">HTML tag ভেরিফিকেশন অপশনের <code>content="..."</code> এর ভেতরের মানটি এখানে দিন।</span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="form-label" for="bing_site_verification">
                            <i class="fa-brands fa-microsoft text-primary me-1"></i> বিং ওয়েবমাস্টার ভেরিফিকেশন কোড (Bing / Yahoo)
                        </label>
                        <input type="text" name="bing_site_verification" id="bing_site_verification" class="form-control" value="{{ old('bing_site_verification', $settings['bing_site_verification']) }}" placeholder="msvalidate.01 কোড">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="yandex_verification">
                            <i class="fa-brands fa-yandex text-danger me-1"></i> ইয়ানডেক্স ভেরিফিকেশন কোড (Yandex Verification)
                        </label>
                        <input type="text" name="yandex_verification" id="yandex_verification" class="form-control" value="{{ old('yandex_verification', $settings['yandex_verification']) }}" placeholder="yandex-verification কোড">
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="form-label" for="google_analytics_id">
                            <i class="fa-solid fa-chart-simple text-warning me-1"></i> গুগল অ্যানালিটিক্স ৪ (GA4 Measurement ID)
                        </label>
                        <input type="text" name="google_analytics_id" id="google_analytics_id" class="form-control" value="{{ old('google_analytics_id', $settings['google_analytics_id']) }}" placeholder="যেমন: G-XXXXXXXXXX">
                        <span class="form-text">এখানে আইডিটি দিলে গুগলের অফিসিয়াল gtag.js ট্র্যাকিং কোড স্বয়ংক্রিয়ভাবে সমগ্র সাইটে লোড হবে।</span>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="google_tag_manager_id">
                            <i class="fa-solid fa-tags text-primary me-1"></i> গুগল ট্যাগ ম্যানেজার আইডি (GTM Container ID)
                        </label>
                        <input type="text" name="google_tag_manager_id" id="google_tag_manager_id" class="form-control" value="{{ old('google_tag_manager_id', $settings['google_tag_manager_id']) }}" placeholder="যেমন: GTM-XXXXXXX">
                        <span class="form-text">GTM ব্যবহার করলে হেড এবং বডি কোড স্বয়ংক্রিয়ভাবে ইনজেক্ট হবে।</span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="form-label" for="facebook_pixel_id">
                            <i class="fa-brands fa-facebook text-primary me-1"></i> ফেসবুক পিক্সেল আইডি (Meta Pixel ID)
                        </label>
                        <input type="text" name="facebook_pixel_id" id="facebook_pixel_id" class="form-control" value="{{ old('facebook_pixel_id', $settings['facebook_pixel_id']) }}" placeholder="যেমন: 1234567890123456">
                    </div>
                </div>
            </div>

            <!-- ================= TAB 4: SITEMAP & PING ================= -->
            <div id="tab-sitemap" class="seo-tab-content">
                <h5 class="fw-bold text-dark pb-2 mb-3 border-bottom" style="font-size: 1rem;">
                    <i class="fa-solid fa-sitemap text-danger me-2"></i>সাইটম্যাপ ম্যানেজমেন্ট ও সার্চ ইঞ্জিন পিং
                </h5>

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="p-3 border rounded bg-white">
                            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-link text-primary me-2"></i>জরুরি ফিড ও সাইটম্যাপ লিংকসমূহ</h6>
                            
                            <div class="list-group">
                                <a href="{{ $stats['sitemap_url'] }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fa-solid fa-sitemap text-success me-2"></i>
                                        <strong>XML সাইটম্যাপ (Google & Bing)</strong>
                                        <div class="text-muted small">{{ $stats['sitemap_url'] }}</div>
                                    </div>
                                    <span class="badge bg-success">সক্রিয়</span>
                                </a>

                                <a href="{{ $stats['rss_url'] }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fa-solid fa-rss text-warning me-2"></i>
                                        <strong>RSS 2.0 ফিড (Google News & Readers)</strong>
                                        <div class="text-muted small">{{ $stats['rss_url'] }}</div>
                                    </div>
                                    <span class="badge bg-primary">লাইভ</span>
                                </a>

                                <a href="{{ $stats['robots_url'] }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fa-solid fa-robot text-secondary me-2"></i>
                                        <strong>Robots.txt ফাইল</strong>
                                        <div class="text-muted small">{{ $stats['robots_url'] }}</div>
                                    </div>
                                    <span class="badge bg-secondary">স্বয়ংক্রিয়</span>
                                </a>
                            </div>

                            <div class="mt-3 p-2 bg-light rounded small text-muted">
                                <i class="fa-solid fa-circle-info text-info me-1"></i>
                                সাইটম্যাপটি ডায়নামিক এবং এতে স্বয়ংক্রিয়ভাবে শেষ ৪৮ ঘণ্টার খবরে <code>&lt;news:news&gt;</code> ট্যাগ যুক্ত হয়, যা গুগল নিউজে দ্রুত ইন্ডেক্সিং নিশ্চিত করে।
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="p-3 border rounded bg-white">
                            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-bullhorn text-danger me-2"></i>এক ক্লিকে সার্চ ইঞ্জিন পিং (Instant Ping)</h6>
                            <p class="text-muted small">সাইটম্যাপে নতুন সংবাদ বা পরিবর্তন আসলে বিং সার্চ ইঞ্জিনকে অবিলম্বে সাইট রি-ইনডেক্স করার জন্য পিং রিকোয়েস্ট পাঠান:</p>

                            <button type="button" id="btnPingSearchEngines" onclick="pingSearchEngines()" class="btn btn-outline-primary w-100 py-2 fw-semibold">
                                <i class="fa-solid fa-paper-plane me-2"></i> সার্চ ইঞ্জিনগুলোতে সাইটম্যাপ পিং পাঠান
                            </button>

                            <div id="pingResultBox" class="mt-3 p-3 rounded" style="display: none; font-size: 0.88rem;"></div>

                            <div class="mt-4 pt-3 border-top">
                                <h6 class="fw-bold text-dark mb-2"><i class="fa-brands fa-google text-danger me-1"></i> গুগল সার্চ কনসোল সরাসরি সাবমিট:</h6>
                                <p class="text-muted small mb-2">গুগল নতুন নিয়মে সার্চ কনসোল ড্যাশবোর্ড থেকে সাইটম্যাপ জমা নেওয়ার পরামর্শ দেয়।</p>
                                <a href="https://search.google.com/search-console/sitemaps" target="_blank" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Google Search Console এ যান
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= TAB 5: ROBOTS.TXT ================= -->
            <div id="tab-robots" class="seo-tab-content">
                <h5 class="fw-bold text-dark pb-2 mb-3 border-bottom" style="font-size: 1rem;">
                    <i class="fa-solid fa-robot text-danger me-2"></i>Robots.txt ফাইল কনফিগারেশন
                </h5>

                <div class="p-3 mb-3 bg-light border rounded">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="enable_custom_robots" id="enable_custom_robots" value="1" {{ !empty($settings['enable_custom_robots']) ? 'checked' : '' }} onchange="toggleRobotsEditor()">
                        <label class="form-check-label fw-bold text-dark" for="enable_custom_robots">
                            কাস্টম Robots.txt সক্রিয় করুন (Enable Custom Robots.txt)
                        </label>
                    </div>
                    <p class="text-muted small mb-0">ডিফল্টভাবে এটি অ্যাডমিন ডিরেক্টরি সুরক্ষিত রাখে এবং সাইটম্যাপ লিংক সরবরাহ করে। কাস্টম রুলস যোগ করতে চাইলে এটি সক্রিয় করুন।</p>
                </div>

                <div class="form-group" id="robotsEditorWrapper" style="{{ empty($settings['enable_custom_robots']) ? 'opacity: 0.6; pointer-events: none;' : '' }}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0" for="custom_robots_txt">Robots.txt কন্টেন্ট এডিটর</label>
                        <button type="button" class="btn btn-sm btn-link text-decoration-none" onclick="resetRobotsDefault()">
                            <i class="fa-solid fa-rotate-left me-1"></i> ডিফল্ট রুলস লোড করুন
                        </button>
                    </div>
                    <textarea name="custom_robots_txt" id="custom_robots_txt" rows="10" class="form-control code-editor-area" placeholder="User-agent: *&#10;Disallow: /admin/">{{ old('custom_robots_txt', $settings['custom_robots_txt'] ?: $robotsContent) }}</textarea>
                </div>
            </div>

            <!-- ================= TAB 6: CUSTOM SCRIPTS ================= -->
            <div id="tab-scripts" class="seo-tab-content">
                <h5 class="fw-bold text-dark pb-2 mb-3 border-bottom" style="font-size: 1rem;">
                    <i class="fa-solid fa-code text-danger me-2"></i>কাস্টম হেডার ও ফুটার কোড ইনজেকশন
                </h5>
                <p class="text-muted small mb-4">যেকোনো থার্ড-পার্টি ট্র্যাকিং স্ক্রিপ্ট, মেটা ট্যাগ বা ভেরিফিকেশন কোড কোডিং ছাড়াই সরাসরি সাইটে যোগ করুন:</p>

                <div class="form-group mb-4">
                    <label class="form-label" for="header_scripts">
                        <i class="fa-solid fa-arrow-up-right-dots me-1 text-primary"></i> হেডার স্ক্রিপ্টস (Header Scripts - <code>&lt;head&gt;...&lt;/head&gt;</code> এর ভেতর)
                    </label>
                    <textarea name="header_scripts" id="header_scripts" rows="6" class="form-control code-editor-area" placeholder="<!-- আপনার কাস্টম মেটা বা স্ক্রিপ্ট এখানে পেস্ট করুন -->">{{ old('header_scripts', $settings['header_scripts']) }}</textarea>
                    <span class="form-text">এই কোডটি প্রতিটি পেজের হেড সেকশনের একদম শেষে রান হবে।</span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="footer_scripts">
                        <i class="fa-solid fa-arrow-down-wide-short me-1 text-success"></i> ফুটার স্ক্রিপ্টস (Footer Scripts - <code>&lt;/body&gt;</code> এর ঠিক পূর্বে)
                    </label>
                    <textarea name="footer_scripts" id="footer_scripts" rows="6" class="form-control code-editor-area" placeholder="<!-- কাস্টম জাভাস্ক্রিপ্ট কোড এখানে পেস্ট করুন -->">{{ old('footer_scripts', $settings['footer_scripts']) }}</textarea>
                    <span class="form-text">এই কোডটি পেজ লোডের গতি ব্যাহত না করে একদম শেষে রান হবে (যেমন: লাইভ চ্যাট উইজেট, কাস্টম অ্যানালিটিক্স)।</span>
                </div>
            </div>

            <!-- ================= TAB 7: SCHEMA & KNOWLEDGE GRAPH ================= -->
            <div id="tab-schema" class="seo-tab-content">
                <h5 class="fw-bold text-dark pb-2 mb-3 border-bottom" style="font-size: 1rem;">
                    <i class="fa-solid fa-diagram-project text-danger me-2"></i>Schema.org স্ট্রাকচার্ড ডেটা ও নলেজ গ্রাফ
                </h5>
                <p class="text-muted small mb-4">গুগল নিউজ ও নলেজ প্যানেলের জন্য স্ট্রাকচার্ড ডেটা কনফিগার করুন:</p>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="schema_org_type">প্রতিষ্ঠানের ধরন (Organization Type)</label>
                        <select name="schema_org_type" id="schema_org_type" class="form-control">
                            <option value="NewsMediaOrganization" {{ $settings['schema_org_type'] === 'NewsMediaOrganization' ? 'selected' : '' }}>সংবাদ মাধ্যম প্রতিষ্ঠান (NewsMediaOrganization - রিকমেন্ডেড)</option>
                            <option value="Organization" {{ $settings['schema_org_type'] === 'Organization' ? 'selected' : '' }}>সাধারণ প্রতিষ্ঠান (Organization)</option>
                            <option value="Periodical" {{ $settings['schema_org_type'] === 'Periodical' ? 'selected' : '' }}>সাময়িকী বা পত্রিকা (Periodical)</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="schema_org_name">প্রতিষ্ঠানের নাম</label>
                        <input type="text" name="schema_org_name" id="schema_org_name" class="form-control" value="{{ old('schema_org_name', $settings['schema_org_name']) }}" placeholder="যেমন: দৈনিক ভোলা জার্নাল">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="schema_org_url">অফিসিয়াল ওয়েবসাইট ইউআরএল</label>
                        <input type="text" name="schema_org_url" id="schema_org_url" class="form-control" value="{{ old('schema_org_url', $settings['schema_org_url']) }}" placeholder="{{ url('/') }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="schema_org_logo">লোগো ইউআরএল (Logo URL)</label>
                        <input type="text" name="schema_org_logo" id="schema_org_logo" class="form-control" value="{{ old('schema_org_logo', $settings['schema_org_logo']) }}" placeholder="{{ asset('BJ_Content/Profile Pic b.png') }}">
                    </div>
                </div>

                <div class="form-group mt-2">
                    <label class="form-label" for="social_profiles">সোশ্যাল প্রোফাইল লিঙ্কসমূহ (SameAs Profiles - প্রতি লাইনে একটি)</label>
                    <textarea name="social_profiles" id="social_profiles" rows="4" class="form-control" placeholder="https://www.facebook.com/dailybholajournal&#10;https://twitter.com/dailybholajournal&#10;https://www.youtube.com/@dailybholajournal">{{ old('social_profiles', $settings['social_profiles']) }}</textarea>
                    <span class="form-text">গুগল নলেজ গ্রাফ এই লিঙ্কগুলো ব্যবহার করে আপনার ব্র্যান্ড ভেরিফাই করে।</span>
                </div>
            </div>

            <!-- Desktop Bottom Submit Row -->
            <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="fa-solid fa-shield-halved text-success me-1"></i> পরিবর্তন সংরক্ষণ করার পর অবিলম্বে কার্যকর হবে।
                </span>
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>পরিবর্তন সংরক্ষণ করুন</span>
                </button>
            </div>

            <!-- Mobile Sticky Bottom Bar -->
            <div class="seo-sticky-save-bar d-md-none">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="fa-solid fa-floppy-disk me-1"></i> পরিবর্তন সংরক্ষণ করুন
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    বাতিল
                </a>
            </div>

        </form>
    </div>

@endsection

@section('scripts')
<script>
    // Tab Switching Function
    function switchSeoTab(tabKey) {
        // Update tab buttons
        document.querySelectorAll('.seo-tab-btn').forEach(btn => btn.classList.remove('active'));
        const activeBtn = Array.from(document.querySelectorAll('.seo-tab-btn')).find(b => b.getAttribute('onclick')?.includes(tabKey));
        if (activeBtn) activeBtn.classList.add('active');

        // Update tab contents
        document.querySelectorAll('.seo-tab-content').forEach(content => content.classList.remove('active'));
        const targetContent = document.getElementById('tab-' + tabKey);
        if (targetContent) targetContent.classList.add('active');

        // Save active tab to session/hash
        window.location.hash = tabKey;
    }

    // Initialize Hash-based Tab on Load
    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash) {
            const cleanHash = window.location.hash.replace('#', '');
            if (document.getElementById('tab-' + cleanHash)) {
                switchSeoTab(cleanHash);
            }
        }

        // Realtime Character Counters and SERP Live Sync
        const titleInput = document.getElementById('site_title');
        const descInput = document.getElementById('meta_description');
        const titleCounter = document.getElementById('titleCounter');
        const descCounter = document.getElementById('descCounter');

        const serpTitle = document.getElementById('previewSerpTitle');
        const serpDesc = document.getElementById('previewSerpDesc');
        const socialTitle = document.getElementById('previewSocialTitle');
        const socialDesc = document.getElementById('previewSocialDesc');

        function updateTitle() {
            const val = titleInput ? titleInput.value : '';
            if (titleCounter) {
                titleCounter.innerText = val.length + ' / 60';
                titleCounter.className = 'char-counter ' + (val.length > 60 ? 'warn' : 'good');
            }
            if (serpTitle) serpTitle.innerText = val || 'দৈনিক ভোলা জার্নাল | সত্য ও ন্যায়ের সন্ধানে সার্বক্ষণিক';
            if (socialTitle) socialTitle.innerText = val || 'দৈনিক ভোলা জার্নাল | সত্য ও ন্যায়ের সন্ধানে সার্বক্ষণিক';
        }

        function updateDesc() {
            const val = descInput ? descInput.value : '';
            if (descCounter) {
                descCounter.innerText = val.length + ' / 160';
                descCounter.className = 'char-counter ' + (val.length > 160 ? 'bad' : (val.length >= 120 ? 'good' : 'warn'));
            }
            if (serpDesc) serpDesc.innerText = val || 'দৈনিক ভোলা জার্নাল - ভোলা জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র।';
            if (socialDesc) socialDesc.innerText = val || 'দৈনিক ভোলা জার্নাল - ভোলা জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র।';
        }

        if (titleInput) {
            titleInput.addEventListener('input', updateTitle);
            updateTitle();
        }

        if (descInput) {
            descInput.addEventListener('input', updateDesc);
            updateDesc();
        }
    });

    // Preview Social OG image
    function previewOgImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgEl = document.getElementById('previewOgImg');
                if (imgEl) imgEl.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Toggle Robots Editor
    function toggleRobotsEditor() {
        const checkbox = document.getElementById('enable_custom_robots');
        const wrapper = document.getElementById('robotsEditorWrapper');
        if (wrapper && checkbox) {
            if (checkbox.checked) {
                wrapper.style.opacity = '1';
                wrapper.style.pointerEvents = 'auto';
            } else {
                wrapper.style.opacity = '0.6';
                wrapper.style.pointerEvents = 'none';
            }
        }
    }

    // Reset Robots Default Template
    function resetRobotsDefault() {
        const sitemapUrl = "{{ route('seo.sitemap') }}";
        const defaultTxt = "User-agent: *\nDisallow: /admin/\nDisallow: /epaper/clear-cache\nDisallow: /epaper/migrate\nAllow: /\n\nSitemap: " + sitemapUrl;
        const textarea = document.getElementById('custom_robots_txt');
        if (textarea && confirm('আপনি কি ডিফল্ট Robots.txt টেমপ্লেট পুনরুদ্ধার করতে চান?')) {
            textarea.value = defaultTxt;
        }
    }

    // Instant AJAX Ping to Search Engines
    function pingSearchEngines() {
        const btn = document.getElementById('btnPingSearchEngines');
        const resultBox = document.getElementById('pingResultBox');
        if (!btn || !resultBox) return;

        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-arrows-rotate fa-spin me-2"></i> সার্চ ইঞ্জিনগুলোতে পিং পাঠানো হচ্ছে...';
        btn.disabled = true;

        fetch("{{ route('admin.seo.ping') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;

            resultBox.style.display = 'block';
            resultBox.style.background = '#f0fdf4';
            resultBox.style.border = '1px solid #bbf7d0';
            resultBox.style.color = '#166534';

            let msg = '<div class="fw-bold mb-1"><i class="fa-solid fa-circle-check text-success me-1"></i> পিং সফলভাবে সম্পন্ন হয়েছে!</div>';
            if (data.results) {
                if (data.results.bing) {
                    msg += `<div class="small">• Bing: ${data.results.bing.message}</div>`;
                }
                if (data.results.google) {
                    msg += `<div class="small">• Google: ${data.results.google.message}</div>`;
                }
            }
            resultBox.innerHTML = msg;
        })
        .catch(err => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;

            resultBox.style.display = 'block';
            resultBox.style.background = '#fef2f2';
            resultBox.style.border = '1px solid #fecaca';
            resultBox.style.color = '#991b1b';
            resultBox.innerHTML = '<i class="fa-solid fa-circle-exclamation me-1"></i> পিং পাঠাতে ত্রুটি হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।';
        });
    }
</script>
@endsection
