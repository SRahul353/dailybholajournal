@extends('layouts.app')

@section('title', (!empty($query) ? 'অনুসন্ধান ফলাফল: "' . $query . '"' : 'অনুসন্ধান') . ' | দৈনিক ভোলা জার্নাল')
@section('meta_description', (!empty($query) ? 'দৈনিক ভোলা জার্নাল-এ "' . $query . '" সম্পর্কিত খবর ও অনুসন্ধান ফলাফল।' : 'দৈনিক ভোলা জার্নাল-এর অনুসন্ধান পৃষ্ঠা।'))

@section('styles')
<style>
    /* ==========================================================================
       Search Page Layout Styles
       ========================================================================== */
    .archive-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
        margin-top: 10px;
        margin-bottom: 48px;
    }

    @media (min-width: 1024px) {
        .archive-container {
            grid-template-columns: 2.4fr 1fr;
        }
    }

    /* Breadcrumbs */
    .archive-breadcrumb {
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.88rem;
    }
    .archive-breadcrumb .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }
    .archive-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        content: "\f105";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        font-size: 0.72rem;
        color: #94a3b8;
        padding: 0 8px;
    }

    /* Interactive Search Header Box */
    .search-box-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-top: 4px solid var(--accent, #c90000);
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 28px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .search-form-row {
        position: relative;
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 2px solid #cbd5e1;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.2s ease;
    }
    .search-form-row:focus-within {
        border-color: var(--accent, #c90000);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(201, 0, 0, 0.12);
    }
    .search-icon-prefix {
        padding-left: 16px;
        padding-right: 8px;
        color: #94a3b8;
        font-size: 1.1rem;
    }
    .search-input-field {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        padding: 12px 8px;
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 1.05rem;
        color: #0f172a;
    }
    .search-input-field::placeholder {
        color: #94a3b8;
        font-size: 0.95rem;
    }
    .search-submit-btn {
        background: var(--accent, #c90000);
        color: #ffffff;
        border: none;
        padding: 0 24px;
        height: 52px;
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.96rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s ease;
    }
    .search-submit-btn:hover {
        background: #a80000;
    }
    .search-stats-strip {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
        font-size: 0.90rem;
    }
    .search-count-pill {
        background: #fef2f2;
        color: var(--accent, #c90000);
        border: 1px solid #fecaca;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.82rem;
    }

    /* 2-Column Archive Grid */
    .archive-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 22px;
        margin-bottom: 36px;
    }
    @media (min-width: 640px) {
        .archive-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    .archive-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }
    .archive-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        border-color: var(--accent, #c90000);
    }
    .archive-card-thumb {
        position: relative;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        background-color: #cbd5e1;
    }
    .archive-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }
    .archive-card:hover .archive-card-img {
        transform: scale(1.05);
    }
    .archive-card-category-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(15, 23, 42, 0.85);
        color: #ffffff;
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        backdrop-filter: blur(4px);
    }
    .archive-card-body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
    .archive-card-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.05rem;
        font-weight: 700;
        line-height: 1.45;
        color: #1e293b;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s ease;
    }
    .archive-card:hover .archive-card-title {
        color: var(--accent, #c90000);
    }
    .archive-card-excerpt {
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.86rem;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .archive-card-meta {
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.78rem;
        color: #94a3b8;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 10px;
        border-top: 1px solid #f8fafc;
        margin-top: auto;
    }

    /* Dynamic Pagination Styling */
    .pagination-wrapper {
        margin-top: 36px;
        display: flex;
        justify-content: center;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .pagination-wrapper .pagination {
        margin: 0;
        gap: 4px;
        flex-wrap: wrap;
    }
    .pagination-wrapper .page-item .page-link {
        color: #334155;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 8px 14px;
        font-size: 0.90rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .pagination-wrapper .page-item.active .page-link {
        background-color: var(--accent, #c90000);
        border-color: var(--accent, #c90000);
        color: #ffffff;
    }
    .pagination-wrapper .page-item .page-link:hover:not(.active) {
        background-color: #fee2e2;
        color: #b91c1c;
        border-color: #fca5a5;
    }

    /* Empty state */
    .archive-empty-state {
        background: #ffffff;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        padding: 48px 24px;
        text-align: center;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .search-tip-list {
        display: inline-block;
        text-align: left;
        color: #64748b;
        font-size: 0.90rem;
        margin-top: 12px;
    }
</style>
@endsection

@section('content')

    <div class="archive-container">
        <!-- Main Search Results Column -->
        <main>
            <!-- Breadcrumbs -->
            <div class="archive-breadcrumb-wrap mb-3">
                <nav class="archive-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                                <i class="fa-solid fa-house me-1"></i> প্রচ্ছদ
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-danger fw-bold" aria-current="page">
                            অনুসন্ধান ফলাফল
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Interactive Search Header Box -->
            <section class="search-box-card">
                <form action="{{ route('search') }}" method="GET">
                    <div class="search-form-row">
                        <i class="fa-solid fa-magnifying-glass search-icon-prefix"></i>
                        <input type="text" 
                               name="query" 
                               value="{{ $query }}" 
                               class="search-input-field" 
                               placeholder="খবর খুঁজতে শিরোনাম, কীওয়ার্ড বা বিষয় লিখুন..." 
                               autocomplete="off">
                        <button type="submit" class="search-submit-btn">
                            <span>অনুসন্ধান</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>

                @if(!empty($query))
                    <div class="search-stats-strip">
                        <div>
                            <span class="text-muted">অনুসন্ধানের শব্দ: </span>
                            <strong class="text-dark">"{{ $query }}"</strong>
                        </div>
                        <div class="search-count-pill">
                            মোট <strong>{{ $posts->total() }}</strong> টি সংবাদ পাওয়া গেছে
                        </div>
                    </div>
                @endif
            </section>

            <!-- Posts Grid -->
            @if($posts->count() > 0)
                <div class="archive-grid">
                    @foreach($posts as $post)
                        <article class="archive-card">
                            <div class="archive-card-thumb">
                                <a href="{{ route('post', $post->slug) }}">
                                    <img src="{{ $post->featured_image_url }}" 
                                         alt="{{ $post->title }}" 
                                         class="archive-card-img" 
                                         onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=500'">
                                </a>
                                @if($post->categories->count() > 0)
                                    <span class="archive-card-category-badge">
                                        {{ $post->categories->first()->name }}
                                    </span>
                                @endif
                            </div>
                            <div class="archive-card-body">
                                <div>
                                    <h3 class="archive-card-title">
                                        <a href="{{ route('post', $post->slug) }}" class="text-decoration-none text-dark">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    <p class="archive-card-excerpt">
                                        {{ Str::limit(strip_tags($post->content), 90) }}
                                    </p>
                                </div>
                                <div class="archive-card-meta">
                                    <span>
                                        <i class="fa-regular fa-clock text-danger me-1"></i>
                                        {{ $post->created_at->diffForHumans() }}
                                    </span>
                                    <span>
                                        <i class="fa-regular fa-eye text-danger me-1"></i>
                                        {{ $post->views_count }} বার পঠিত
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination (Preserves Query Parameter) -->
                <div class="pagination-wrapper">
                    {{ $posts->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="archive-empty-state">
                    <i class="fa-solid fa-circle-question text-muted mb-3" style="font-size: 3.2rem;"></i>
                    @if(!empty($query))
                        <h3 class="fw-bold text-dark mb-2" style="font-size: 1.25rem;">
                            দুঃখিত, "<strong>{{ $query }}</strong>" সম্পর্কিত কোনো সংবাদ পাওয়া যায়নি
                        </h3>
                        <p class="text-muted mb-3" style="font-size: 0.95rem;">অনুসন্ধান আরও ফলপ্রসূ করতে নিচের পরামর্শগুলো দেখতে পারেন:</p>
                        <ul class="search-tip-list">
                            <li>শব্দের বানান ঠিক আছে কিনা পুনরায় যাচাই করুন।</li>
                            <li>খুব বড় বাক্য না লিখে মূল শব্দ বা ছোট কীওয়ার্ড দিয়ে চেষ্টা করুন।</li>
                            <li>অন্য কোনো সমার্থক শব্দ বা বিষয় দিয়ে খুঁজুন।</li>
                        </ul>
                    @else
                        <h3 class="fw-bold text-dark mb-2" style="font-size: 1.25rem;">অনুসন্ধান করতে কীওয়ার্ড লিখুন</h3>
                        <p class="text-muted mb-4" style="font-size: 0.95rem;">উপরে সার্চ বক্সে আপনি যে বিষয়ে খবর খুঁজতে চান তা লিখে অনুসন্ধান বাটনে ক্লিক করুন।</p>
                    @endif
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-outline-danger px-4 py-2 fw-bold">
                            <i class="fa-solid fa-arrow-left me-1"></i> প্রচ্ছদে ফিরে যান
                        </a>
                    </div>
                </div>
            @endif
        </main>

        <!-- Sidebar Column -->
        <aside>
            @include('layouts.partials.sidebar')
        </aside>
    </div>

@endsection
