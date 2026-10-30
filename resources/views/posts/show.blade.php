@extends('layouts.app')

@section('title', $post->title . ' | দৈনিক ভোলা জার্নাল')
@section('meta_description', mb_substr(strip_tags($post->excerpt ?: $post->content), 0, 160))
@section('meta_keywords', implode(', ', $post->tags->pluck('name')->toArray()) ?: 'দৈনিক ভোলা জার্নাল, ' . $post->title)
@section('og_title', $post->title)
@section('og_description', mb_substr(strip_tags($post->excerpt ?: $post->content), 0, 160))
@section('og_image', $post->featured_image_url)
@section('og_type', 'article')

@section('schema_json')
@php
    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'NewsArticle',
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => request()->url(),
        ],
        'headline' => $post->title,
        'description' => mb_substr(strip_tags($post->excerpt ?: $post->content), 0, 160),
        'image' => [
            $post->featured_image_url
        ],
        'datePublished' => ($post->created_at ?? now())->toIso8601String(),
        'dateModified' => ($post->updated_at ?? $post->created_at ?? now())->toIso8601String(),
        'author' => [
            '@type' => 'Person',
            'name' => $post->user ? $post->user->name : 'দৈনিক ভোলা জার্নাল ডেস্ক',
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'দৈনিক ভোলা জার্নাল',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset($themeSettings['logo_image'] ?? 'uploads/logo.png'),
            ]
        ],
        'articleSection' => $post->categories->first() ? $post->categories->first()->name : 'সংবাদ',
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('styles')
<style>
    /* Top Slim Reading Progress Bar */
    .reading-progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #ef4444, #dc2626);
        z-index: 9999;
        transition: width 0.1s ease;
    }

    /* Single News Main Stream & Sidebar Columns */
    @media (min-width: 992px) {
        .single-main-col {
            flex: 0 0 70% !important;
            max-width: 70% !important;
        }
        .single-sidebar-col {
            flex: 0 0 30% !important;
            max-width: 30% !important;
        }
    }

    /* Main Article Wrapper */
    .single-article-wrapper {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }
    @media (min-width: 768px) {
        .single-article-wrapper {
            padding: 36px 38px;
        }
    }

    /* Headline Typography */
    .single-article-headline {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 2.15rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.38;
        margin-bottom: 20px;
        letter-spacing: -0.3px;
    }
    @media (min-width: 768px) {
        .single-article-headline {
            font-size: 2.65rem;
        }
    }

    /* Meta Bar & Action Tools */
    .article-meta-bar {
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        padding: 14px 0;
        margin-bottom: 26px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    @media (min-width: 768px) {
        .article-meta-bar {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }
    .article-meta-left {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 14px 18px;
        font-size: 0.86rem;
        color: #475569;
    }
    .article-meta-left span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .article-meta-right {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    /* Font Resizer & Print Controls */
    .reader-tool-btn {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        color: #334155;
        font-size: 0.82rem;
        font-weight: 700;
        padding: 4px 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
    }
    .reader-tool-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Social Share Buttons */
    .share-pill-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #ffffff !important;
        font-size: 0.85rem;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        cursor: pointer;
    }
    .share-pill-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    .share-pill-btn.fb { background: #1877f2; }
    .share-pill-btn.wa { background: #25d366; }
    .share-pill-btn.tw { background: #000000; }
    .share-pill-btn.copy { background: #475569; position: relative; }

    .copy-tooltip {
        position: absolute;
        bottom: 42px;
        background-color: #0f172a;
        color: #ffffff;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
        transform: translateY(6px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .copy-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid transparent;
        border-top-color: #0f172a;
    }
    .copy-tooltip.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Featured Image Box */
    .article-featured-box {
        margin-bottom: 30px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #000;
    }
    .article-featured-img {
        width: 100%;
        height: auto;
        max-height: 520px;
        object-fit: cover;
        display: block;
    }
    .article-img-caption {
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        padding: 8px 14px;
        font-size: 0.80rem;
        color: #64748b;
        font-family: 'Noto Sans Bengali', sans-serif;
    }

    /* Main Article Content & Typography */
    .single-article-content {
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 1.22rem;
        line-height: 2.05;
        color: #1e293b;
        font-weight: 400;
        transition: font-size 0.2s ease;
    }
    .single-article-content p {
        margin-bottom: 22px;
        text-align: justify;
    }
    .single-article-content p:first-of-type::first-letter {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 3.4rem;
        font-weight: 800;
        float: left;
        line-height: 1;
        margin-right: 12px;
        margin-top: 4px;
        color: var(--accent, #c90000);
    }
    .single-article-content h2, 
    .single-article-content h3, 
    .single-article-content h4 {
        font-family: 'Noto Serif Bengali', serif;
        color: #0f172a;
        margin: 36px 0 16px 0;
        font-weight: 800;
        line-height: 1.4;
        position: relative;
        padding-left: 14px;
    }
    .single-article-content h2::before,
    .single-article-content h3::before {
        content: '';
        position: absolute;
        left: 0;
        top: 6px;
        bottom: 6px;
        width: 4px;
        background-color: var(--accent, #c90000);
        border-radius: 2px;
    }
    .single-article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 24px auto;
        display: block;
        border: 1px solid #e2e8f0;
    }
    .single-article-content blockquote {
        border-left: 4px solid var(--accent, #c90000);
        padding: 18px 24px;
        font-style: italic;
        color: #334155;
        margin: 30px 0;
        font-size: 1.20rem;
        background: #f8fafc;
        border-radius: 0 8px 8px 0;
        position: relative;
    }

    /* Tags Row */
    .article-tags-wrapper {
        margin-top: 36px;
        padding-top: 20px;
        border-top: 1px dashed #cbd5e1;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
    }
    .article-tag-pill {
        background-color: #f1f5f9;
        color: #475569;
        font-size: 0.84rem;
        padding: 4px 12px;
        border-radius: 20px;
        text-decoration: none;
        transition: all 0.2s ease;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .article-tag-pill:hover {
        background-color: var(--accent, #c90000);
        color: #ffffff;
    }

    /* Bottom Share Strip */
    .article-bottom-share-strip {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px 20px;
        margin-top: 28px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    /* Legal Disclaimer Box */
    .article-disclaimer-box {
        background-color: #fef2f2;
        border: 1px solid #fee2e2;
        border-left: 4px solid #ef4444;
        border-radius: 6px;
        padding: 14px 18px;
        margin-top: 24px;
        font-size: 0.85rem;
        color: #7f1d1d;
        line-height: 1.6;
        font-family: 'Noto Sans Bengali', sans-serif;
    }

    /* Facebook Comments Section */
    .article-comments-section {
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px dashed #cbd5e1;
    }
    .fb-comments, .fb-comments iframe[style], .fb-comments > span {
        width: 100% !important;
    }

    /* Related News Grid (4 Columns, 3-Line Headlines) */
    .related-news-section {
        margin-top: 48px;
    }
    .related-sec-head {
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 10px;
        margin-bottom: 20px;
        position: relative;
    }
    .related-sec-head::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 60px;
        height: 2px;
        background-color: var(--accent, #c90000);
    }
    .related-sec-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .related-news-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 18px;
    }
    @media (min-width: 576px) {
        .related-news-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (min-width: 992px) {
        .related-news-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    .related-card-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.25s ease;
        text-decoration: none;
    }
    .related-card-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        border-color: var(--accent, #c90000);
    }
    .related-thumb-box {
        position: relative;
        width: 100%;
        padding-top: 58%;
        background-color: #cbd5e1;
        overflow: hidden;
    }
    .related-thumb-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }
    .related-card-item:hover .related-thumb-img {
        transform: scale(1.06);
    }
    .related-content-box {
        padding: 12px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .related-card-title {
        font-size: 0.94rem;
        font-weight: 700;
        line-height: 1.45;
        color: #1e293b;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s ease;
    }
    .related-card-item:hover .related-card-title {
        color: var(--accent, #c90000);
    }

    /* Print Stylesheet */
    @media print {
        header, footer, .article-meta-right, 
        .article-bottom-share-strip, .article-nav-strip, .related-news-section, 
        .single-sidebar-col, .reading-progress-bar {
            display: none !important;
        }
        .single-main-col {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
        .single-article-wrapper {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }
        .single-article-content {
            font-size: 12pt !important;
            line-height: 1.8 !important;
            color: #000000 !important;
        }
        .single-article-headline {
            font-size: 20pt !important;
            color: #000000 !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- Slim Top Reading Progress Bar -->
    <div class="reading-progress-bar" id="readingProgressBar" style="width: 0%;"></div>

    <!-- Main Container: 70% Left Stream + 30% Right Sidebar -->
    <div class="row g-4 mt-1">
        <div class="col-lg-8 single-main-col">
            <article class="single-article-wrapper">
                <!-- Article Headline -->
                <h1 class="single-article-headline">{{ $post->title }}</h1>

                <!-- Featured Image -->
                @if($post->featured_image)
                    <figure class="article-featured-box">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="article-featured-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=900'" loading="eager">
                        <figcaption class="article-img-caption">
                            <i class="fa-solid fa-camera me-1"></i>ছবি: দৈনিক ভোলা জার্নাল
                        </figcaption>
                    </figure>
                @endif

                <!-- Metadata & Quick Action Tools Bar (Positioned Below Image) -->
                <div class="article-meta-bar">
                    <div class="article-meta-left">
                        <span>
                            <i class="fa-solid fa-user-pen text-danger"></i>
                            <strong>{{ $post->user ? $post->user->name : 'অনলাইন ডেস্ক' }}</strong>
                        </span>
                        <span>
                            <i class="fa-regular fa-clock text-danger"></i>
                            প্রকাশ: {{ $post->created_at->diffForHumans() }} ({{ $post->created_at->format('d/m/Y') }})
                        </span>
                        <span>
                            <i class="fa-regular fa-eye text-danger"></i>
                            {{ $post->views_count }} বার পঠিত
                        </span>
                    </div>

                    <div class="article-meta-right">
                        <!-- Font Size Controls -->
                        <div class="btn-group" role="group" aria-label="Font Controls">
                            <button type="button" class="reader-tool-btn" onclick="changeFontSize(-1)" title="ফন্ট ছোট করুন">অ-</button>
                            <button type="button" class="reader-tool-btn" onclick="resetFontSize()" title="স্বাভাবিক ফন্ট">অ</button>
                            <button type="button" class="reader-tool-btn" onclick="changeFontSize(1)" title="ফন্ট বড় করুন">অ+</button>
                        </div>

                        <!-- Print Button -->
                        <button type="button" class="reader-tool-btn" onclick="window.print()" title="প্রিন্ট করুন">
                            <i class="fa-solid fa-print"></i>
                        </button>

                        <!-- Share Pills -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="share-pill-btn fb" title="ফেসবুকে শেয়ার করুন">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}" target="_blank" class="share-pill-btn wa" title="হোয়াটসঅ্যাপে শেয়ার করুন">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" target="_blank" class="share-pill-btn tw" title="X / Twitter-এ শেয়ার করুন">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <button type="button" class="share-pill-btn copy" onclick="copyLinkUrl(this)" title="লিংক কপি করুন">
                            <i class="fa-solid fa-link"></i>
                            <span class="copy-tooltip" id="topCopyTooltip">কপি হয়েছে!</span>
                        </button>
                    </div>
                </div>

                <!-- Article Body Content -->
                <div class="single-article-content" id="articleBodyContent">
                    {!! $post->content !!}
                </div>

                <!-- Tags Section -->
                @if($post->tags && $post->tags->count() > 0)
                    <div class="article-tags-wrapper">
                        <span class="fw-bold text-dark me-2" style="font-size: 0.88rem;"><i class="fa-solid fa-tags text-danger me-1"></i>বিষয় / ট্যাগ:</span>
                        @foreach($post->tags as $tag)
                            <a href="{{ route('tag', $tag->slug) }}" class="article-tag-pill">#{{ $tag->name }}</a>
                        @endforeach
                    </div>
                @endif

                <!-- Bottom Social Share Bar -->
                <div class="article-bottom-share-strip">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-share-nodes text-danger fs-5"></i>
                        <span class="fw-bold text-dark" style="font-size: 0.95rem;">সংবাদটি আপনার পরিচিতদের সাথে শেয়ার করুন:</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="share-pill-btn fb" title="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}" target="_blank" class="share-pill-btn wa" title="WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" target="_blank" class="share-pill-btn tw" title="X / Twitter">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <button type="button" class="share-pill-btn copy" onclick="copyLinkUrl(this)" title="লিংক কপি">
                            <i class="fa-solid fa-link"></i>
                            <span class="copy-tooltip" id="bottomCopyTooltip">কপি হয়েছে!</span>
                        </button>
                    </div>
                </div>

                <!-- Legal Disclaimer Box -->
                <div class="article-disclaimer-box">
                    <i class="fa-solid fa-shield-halved me-1"></i>
                    <strong>আইনগত সতর্কতা:</strong> দৈনিক ভোলা জার্নাল-এ প্রকাশিত সংবাদের কোনো অংশ অনুমতি ছাড়া কপি, পুনর্মুদ্রণ বা যেকোনো ডিজিটাল মাধ্যমে প্রচার কপিরাইট আইনের আওতায় আইনত দণ্ডনীয় অপরাধ।
                </div>

                <!-- Facebook Comments Section -->
                <div class="article-comments-section">
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <h3 class="m-0 text-dark fw-bold" style="font-size: 1.25rem; font-family: 'Noto Serif Bengali', serif;">
                            <i class="fa-brands fa-facebook text-primary me-2"></i>মন্তব্যসমূহ (Facebook Comments)
                        </h3>
                        <a href="{{ route('comment.policy') }}" class="small text-muted text-decoration-none">
                            <i class="fa-solid fa-circle-info me-1"></i>মন্তব্য নীতিমালা
                        </a>
                    </div>
                    <div class="p-3 bg-light rounded border mb-3" style="font-size: 0.84rem; color: #64748b; line-height: 1.6;">
                        ফেসবুক অ্যাকাউন্টের মাধ্যমে আপনি সরাসরি মন্তব্য করতে পারেন। কোনো ধরনের আক্রমণাত্মক, আপত্তিকর বা বিভ্রান্তিকর বক্তব্য প্রকাশ আইনত নিষিদ্ধ ও দণ্ডনীয় অপরাধ।
                    </div>

                    <!-- Facebook Comments Plugin -->
                    <div id="fb-root"></div>
                    <div class="fb-comments-wrapper" style="min-height: 180px; width: 100%; overflow-x: auto;">
                        <div class="fb-comments" 
                             data-href="{{ request()->url() }}" 
                             data-width="100%" 
                             data-numposts="5" 
                             data-order-by="reverse_time">
                        </div>
                    </div>
                </div>
            </article>

            <!-- Related Posts Section (4-column grid, 3-line headlines) -->
            @if(isset($relatedPosts) && $relatedPosts->count() > 0)
                <section class="related-news-section" aria-label="সম্পর্কিত খবর">
                    <div class="related-sec-head d-flex justify-content-between align-items-center">
                        <h3 class="related-sec-title">
                            <i class="fa-solid fa-newspaper text-danger me-2"></i>সম্পর্কিত খবর
                        </h3>
                        @if($post->categories->first())
                            <a href="{{ route('category', $post->categories->first()->slug) }}" class="text-decoration-none fw-bold text-danger small">
                                আরও খবর <i class="fa-solid fa-angle-right ms-1"></i>
                            </a>
                        @endif
                    </div>

                    <div class="related-news-grid">
                        @foreach($relatedPosts->take(4) as $rPost)
                            <a href="{{ route('post', $rPost->slug) }}" class="related-card-item">
                                <div class="related-thumb-box">
                                    <img src="{{ $rPost->featured_image_url }}" alt="{{ $rPost->title }}" class="related-thumb-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'" loading="lazy">
                                </div>
                                <div class="related-content-box">
                                    <h4 class="related-card-title">{{ $rPost->title }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>

        <!-- Right Persistent Rail / Sidebar (30% Width) -->
        <div class="col-lg-4 single-sidebar-col">
            @include('layouts.partials.sidebar')
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // Copy Article Link to Clipboard with UI feedback tooltip
    function copyLinkUrl(button) {
        const link = window.location.href;
        navigator.clipboard.writeText(link).then(() => {
            const tooltip = button.querySelector('.copy-tooltip');
            if (tooltip) {
                tooltip.classList.add('show');
                const icon = button.querySelector('i');
                const originalClass = icon.className;
                icon.className = 'fa-solid fa-check';
                setTimeout(() => {
                    tooltip.classList.remove('show');
                    icon.className = originalClass;
                }, 2000);
            }
        }).catch(err => {
            const textArea = document.createElement("textarea");
            textArea.value = link;
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                const tooltip = button.querySelector('.copy-tooltip');
                if (tooltip) {
                    tooltip.classList.add('show');
                    setTimeout(() => tooltip.classList.remove('show'), 2000);
                }
            } catch (err2) {
                console.error('Copy fallback failed: ', err2);
            }
            document.body.removeChild(textArea);
        });
    }

    // Interactive Font Resizer for Reading Comfort
    let currentFontSizeRem = 1.22;
    const defaultFontSizeRem = 1.22;
    const articleBody = document.getElementById('articleBodyContent');

    function changeFontSize(step) {
        if (!articleBody) return;
        currentFontSizeRem += (step * 0.1);
        if (currentFontSizeRem < 1.0) currentFontSizeRem = 1.0;
        if (currentFontSizeRem > 1.6) currentFontSizeRem = 1.6;
        articleBody.style.fontSize = currentFontSizeRem + 'rem';
    }

    function resetFontSize() {
        if (!articleBody) return;
        currentFontSizeRem = defaultFontSizeRem;
        articleBody.style.fontSize = defaultFontSizeRem + 'rem';
    }

    // Slim Reading Progress Bar Indicator
    window.addEventListener('scroll', function() {
        const progressBar = document.getElementById('readingProgressBar');
        if (!progressBar) return;
        const totalHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        if (totalHeight <= 0) return;
        const scrolled = (window.scrollY / totalHeight) * 100;
        progressBar.style.width = Math.min(Math.max(scrolled, 0), 100) + '%';
    });

    // Recalibrate Facebook comments on window resize
    window.addEventListener('resize', function() {
        if (typeof FB !== 'undefined' && FB.XFBML) {
            FB.XFBML.parse();
        }
    });
</script>
<!-- Facebook Comments SDK -->
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/bn_IN/sdk.js#xfbml=1&version=v19.0"></script>
@endsection
