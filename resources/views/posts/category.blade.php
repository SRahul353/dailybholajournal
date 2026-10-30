@extends('layouts.app')

@section('title', $category->name . ' | ক্যাটাগরি | দৈনিক ভোলা জার্নাল')
@section('meta_description', $category->description ?: $category->name . ' ক্যাটাগরির সকল খবর ও সর্বশেষ আপডেট জানুন দৈনিক ভোলা জার্নাল-এ।')
@section('og_title', $category->name . ' - দৈনিক ভোলা জার্নাল')

@section('styles')
<style>
    /* ==========================================================================
       Archive / Category Page Layout Styles
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

    /* Category Header Banner */
    .archive-header-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-left: 5px solid var(--accent, #c90000);
        border-radius: 8px;
        padding: 22px 26px;
        margin-bottom: 28px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        position: relative;
    }
    .archive-header-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.3;
    }
    .archive-count-badge {
        background: #fef2f2;
        color: var(--accent, #c90000);
        border: 1px solid #fecaca;
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.84rem;
        font-weight: 700;
        padding: 5px 14px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .archive-header-desc {
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.95rem;
        color: #475569;
        line-height: 1.6;
        margin-top: 8px;
        margin-bottom: 0;
    }

    /* Lead Hero Card (Page 1 Top Story) */
    .archive-lead-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 28px;
        transition: all 0.25s ease;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }
    @media (min-width: 768px) {
        .archive-lead-card {
            flex-direction: row;
        }
        .archive-lead-thumb {
            width: 48%;
            flex-shrink: 0;
        }
        .archive-lead-body {
            width: 52%;
        }
    }
    .archive-lead-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border-color: var(--accent, #c90000);
    }
    .archive-lead-thumb {
        position: relative;
        overflow: hidden;
        background-color: #cbd5e1;
        aspect-ratio: 16 / 10;
    }
    .archive-lead-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .archive-lead-card:hover .archive-lead-img {
        transform: scale(1.05);
    }
    .archive-lead-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .archive-lead-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.45rem;
        font-weight: 800;
        line-height: 1.45;
        color: #0f172a;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s ease;
    }
    .archive-lead-card:hover .archive-lead-title {
        color: var(--accent, #c90000);
    }
    .archive-lead-excerpt {
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.92rem;
        color: #475569;
        line-height: 1.6;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .archive-lead-meta {
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.82rem;
        color: #64748b;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
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
        padding: 56px 24px;
        text-align: center;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
</style>
@endsection

@section('content')

    <div class="archive-container">
        <!-- Main Archives Column -->
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
                            {{ $category->name }}
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Category Header Box -->
            <header class="archive-header-card">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h1 class="archive-header-title mb-0">{{ $category->name }}</h1>
                    <div class="archive-count-badge">
                        <i class="fa-solid fa-newspaper text-danger"></i>
                        <span>মোট <strong>{{ $posts->total() }}</strong> টি সংবাদ</span>
                    </div>
                </div>
                @if($category->description)
                    <p class="archive-header-desc">{{ $category->description }}</p>
                @endif
            </header>

            <!-- Posts Listing -->
            @if($posts->count() > 0)
                @php
                    $isFirstPage = ($posts->currentPage() == 1);
                    $leadPost = $isFirstPage ? $posts->first() : null;
                    $gridPosts = $isFirstPage ? $posts->slice(1) : $posts;
                @endphp

                {{-- Page 1: Hero / Lead Story Showcase --}}
                @if($leadPost)
                    <article class="archive-lead-card">
                        <div class="archive-lead-thumb">
                            <img src="{{ $leadPost->featured_image_url }}" 
                                 alt="{{ $leadPost->title }}" 
                                 class="archive-lead-img" 
                                 onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=800'">
                        </div>
                        <div class="archive-lead-body">
                            <div>
                                <span class="badge bg-danger-subtle text-danger px-2 py-1 mb-2 fw-bold" style="font-size: 0.78rem;">
                                    শীর্ষ সংবাদ
                                </span>
                                <h2 class="archive-lead-title">
                                    <a href="{{ route('post', $leadPost->slug) }}" class="text-decoration-none text-dark">
                                        {{ $leadPost->title }}
                                    </a>
                                </h2>
                                <p class="archive-lead-excerpt">
                                    {{ Str::limit(strip_tags($leadPost->content), 170) }}
                                </p>
                            </div>
                            <div class="archive-lead-meta">
                                <span>
                                    <i class="fa-solid fa-user-pen text-danger me-1"></i>
                                    {{ $leadPost->user ? $leadPost->user->name : 'অনলাইন ডেস্ক' }}
                                </span>
                                <span>
                                    <i class="fa-regular fa-clock text-danger me-1"></i>
                                    {{ $leadPost->created_at->diffForHumans() }}
                                </span>
                                <span>
                                    <i class="fa-regular fa-eye text-danger me-1"></i>
                                    {{ $leadPost->views_count }} বার পঠিত
                                </span>
                            </div>
                        </div>
                    </article>
                @endif

                {{-- Remaining News Grid --}}
                @if($gridPosts->count() > 0)
                    <div class="archive-grid">
                        @foreach($gridPosts as $post)
                            <article class="archive-card">
                                <div class="archive-card-thumb">
                                    <a href="{{ route('post', $post->slug) }}">
                                        <img src="{{ $post->featured_image_url }}" 
                                             alt="{{ $post->title }}" 
                                             class="archive-card-img" 
                                             onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=500'">
                                    </a>
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
                @endif

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $posts->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="archive-empty-state">
                    <i class="fa-solid fa-folder-open text-muted mb-3" style="font-size: 3.2rem;"></i>
                    <h3 class="fw-bold text-dark mb-2" style="font-size: 1.25rem;">এই ক্যাটাগরিতে এখনো কোনো সংবাদ পাওয়া যায়নি</h3>
                    <p class="text-muted mb-4" style="font-size: 0.95rem;">অনুগ্রহ করে পরবর্তীতে আবার ভিজিট করুন অথবা প্রচ্ছদ ঘুরে আসুন।</p>
                    <a href="{{ route('home') }}" class="btn btn-outline-danger px-4 py-2 fw-bold">
                        <i class="fa-solid fa-arrow-left me-1"></i> প্রচ্ছদে ফিরে যান
                    </a>
                </div>
            @endif
        </main>

        <!-- Sidebar Column -->
        <aside>
            @include('layouts.partials.sidebar')
        </aside>
    </div>

@endsection
