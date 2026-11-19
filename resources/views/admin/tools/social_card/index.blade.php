@extends('layouts.admin')

@section('title', 'সোশ্যাল মিডিয়া কার্ড জেনারেটর | ' . $post->title)
@section('header_title', 'সোশ্যাল মিডিয়া কার্ড জেনারেটর')

@section('styles')
    {{-- 1. Base Studio Styles & Typography --}}
    @include('admin.tools.social_card.partials.styles')

    {{-- 2. Four Modular Card Style Templates --}}
    @include('admin.tools.social_card.templates.classic')
    @include('admin.tools.social_card.templates.poster')
    @include('admin.tools.social_card.templates.quote')
    @include('admin.tools.social_card.templates.breaking')
@endsection

@section('content')
    {{-- 1. Mobile-only Quick Action Top Bar --}}
    @include('admin.tools.social_card.partials.mobile_topbar')

    <div class="studio-container">
        {{-- 2. Left Side Menu (Inspector Panel) --}}
        @include('admin.tools.social_card.partials.side_menu')

        {{-- 3. Right Canvas Workspace (1080x1080 Live Preview) --}}
        @include('admin.tools.social_card.partials.canvas')
    </div>

    {{-- 4. Master Card Settings Modal (Logo, Footer/Ads, Theme, Typography, Layout) --}}
    @include('admin.tools.social_card.partials.settings')

    {{-- 5. Floating Success Toast Notification --}}
    @include('admin.tools.social_card.partials.toast')
@endsection

@section('scripts')
    {{-- Studio JavaScript Engine --}}
    @include('admin.tools.social_card.partials.scripts')
@endsection