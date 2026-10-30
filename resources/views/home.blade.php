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

    /* ==========================================================================
       Hero Lead & Featured Section (Signature Broadsheet Layout)
       ========================================================================== */

    /* Top Lead Section Grid (Asymmetrical 2-Column Grid) */
    .top-lead-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-bottom: 28px;
    }
    @media (min-width: 992px) {
        .top-lead-grid {
            grid-template-columns: 1.48fr 1fr;
        }
    }

    /* Big Lead Article Card (বামে প্রধান বড় খবর) */
    .main-lead-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        position: relative;
    }
    .main-lead-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }
    .main-lead-img-box {
        position: relative;
        width: 100%;
        height: 250px;
        overflow: hidden;
        background-color: #e2e8f0;
    }
    @media (min-width: 768px) {
        .main-lead-img-box {
            height: 360px;
        }
    }
    .main-lead-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .main-lead-card:hover .main-lead-img {
        transform: scale(1.04);
    }
    .main-lead-img-box::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 80px;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.35), transparent);
        pointer-events: none;
    }
    .main-lead-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background-color: var(--accent, #c90000);
        color: #ffffff !important;
        padding: 5px 14px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.82rem;
        z-index: 10;
        box-shadow: 0 4px 12px rgba(201, 0, 0, 0.35);
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }
    .main-lead-badge:hover {
        background-color: #a80000;
        color: #ffffff !important;
        transform: translateY(-1px);
    }
    .main-lead-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
    .main-lead-headline {
        font-family: 'Noto Serif Bengali', serif !important;
        font-size: 1.55rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 14px;
        line-height: 1.34;
        letter-spacing: -0.5px;
    }
    @media (min-width: 768px) {
        .main-lead-headline {
            font-size: 2.1rem;
        }
    }
    .main-lead-headline a {
        color: #111827;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .main-lead-headline a:hover {
        color: var(--accent, #c90000);
    }
    .main-lead-excerpt {
        color: #374151;
        font-size: 1.02rem;
        margin-bottom: 18px;
        line-height: 1.7;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .main-lead-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 16px 20px;
        font-size: 0.82rem;
        color: #64748b;
        border-top: 1px solid #f1f5f9;
        padding-top: 14px;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .main-lead-meta .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .main-lead-meta i {
        color: var(--accent, #c90000);
        font-size: 0.88rem;
    }

    /* Sub-Leads List (ডানে ৩-৪টি ট্রেন্ডিং সংবাদ) */
    .sub-leads-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }
    .sub-leads-header {
        border-bottom: 2px solid #111827;
        padding-bottom: 10px;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }
    .sub-leads-header h3 {
        font-family: 'Noto Serif Bengali', serif !important;
        font-size: 1.25rem;
        font-weight: 800;
        margin: 0;
        color: #111827;
        display: flex;
        align-items: center;
    }
    .sub-leads-header::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 44px;
        height: 2px;
        background-color: var(--accent, #c90000);
    }
    .sub-lead-live-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.74rem;
        font-weight: 700;
        color: var(--accent, #c90000);
        background: #fef2f2;
        border: 1px solid #fee2e2;
        padding: 3px 10px;
        border-radius: 20px;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .sub-lead-pulse-dot {
        width: 7px;
        height: 7px;
        background-color: var(--accent, #c90000);
        border-radius: 50%;
        display: inline-block;
        animation: pulseSubLead 1.8s infinite;
    }
    @keyframes pulseSubLead {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(201, 0, 0, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 5px rgba(201, 0, 0, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(201, 0, 0, 0); }
    }
    .sub-leads-list {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
    .sub-lead-item {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        padding: 13px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: transform 0.22s ease;
    }
    .sub-lead-item:last-child {
        border-bottom: none;
        padding-bottom: 4px;
    }
    .sub-lead-item:hover {
        transform: translateX(4px);
    }
    .sub-lead-thumb-box {
        width: 110px;
        height: 76px;
        border-radius: 7px;
        overflow: hidden;
        flex-shrink: 0;
        background-color: #f1f5f9;
        position: relative;
    }
    .sub-lead-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.35s ease;
    }
    .sub-lead-item:hover .sub-lead-thumb {
        transform: scale(1.08);
    }
    .sub-lead-info {
        flex-grow: 1;
        min-width: 0;
    }
    .sub-lead-cat {
        font-size: 0.74rem;
        font-weight: 700;
        color: var(--accent, #c90000);
        text-decoration: none;
        display: inline-block;
        margin-bottom: 3px;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .sub-lead-cat:hover {
        text-decoration: underline;
    }
    .sub-lead-title {
        font-family: 'Noto Serif Bengali', serif !important;
        font-size: 0.98rem;
        font-weight: 700;
        line-height: 1.45;
        color: #111827;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .sub-lead-title a {
        color: #111827;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .sub-lead-title a:hover {
        color: var(--accent, #c90000);
    }
    .sub-lead-time {
        font-size: 0.76rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 4px;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .sub-lead-time i {
        color: var(--accent, #c90000);
        font-size: 0.74rem;
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
        align-items: flex-start;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }
    .cat-side-card:hover {
        transform: translateX(3px);
        border-color: var(--accent, #c90000);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .cat-side-thumb-box {
        width: 100px;
        height: 76px;
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
        margin-bottom: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
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
        margin-bottom: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cat-grid-title a:hover {
        color: var(--accent, #c90000);
    }

    /* Layout Type 3: 2 Large Featured Cards + 3 Compact Headlines Strip */
    .cat-layout-c {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .cat-style-c-top {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }
    @media (min-width: 576px) {
        .cat-style-c-top {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    .cat-card-c-featured {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .cat-card-c-featured:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.08);
        border-color: var(--accent, #c90000);
    }
    .cat-card-c-img-box {
        position: relative;
        height: 180px;
        overflow: hidden;
        background-color: #f1f5f9;
    }
    .cat-card-c-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .cat-card-c-featured:hover .cat-card-c-img {
        transform: scale(1.05);
    }
    .cat-card-c-body {
        padding: 14px 16px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .cat-card-c-title {
        font-size: 1.05rem;
        font-weight: 700;
        line-height: 1.4;
        color: #111827;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cat-card-c-title a:hover {
        color: var(--accent, #c90000);
    }
    .cat-card-c-excerpt {
        font-size: 0.88rem;
        color: #4b5563;
        line-height: 1.55;
        margin-bottom: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cat-style-c-bottom {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }
    @media (min-width: 768px) {
        .cat-style-c-bottom {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    .cat-strip-item-c {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-left: 3px solid var(--accent, #c90000);
        border-radius: 6px;
        padding: 10px 14px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }
    .cat-strip-item-c:hover {
        transform: translateX(2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        background-color: #fafafa;
    }
    .cat-strip-title-c {
        font-size: 0.90rem;
        font-weight: 600;
        line-height: 1.45;
        color: #1f2937;
        margin-bottom: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cat-strip-title-c a:hover {
        color: var(--accent, #c90000);
    }

    /* YouTube Video Gallery Strip - Modern & Premium */
    .video-gallery-strip {
        background: #0f172a;
        border-radius: 12px;
        padding: 28px;
        margin: 36px 0 16px 0;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }
    .video-gallery-header {
        border-bottom: 2px solid rgba(255, 255, 255, 0.12);
        padding-bottom: 12px;
        position: relative;
    }
    .video-gallery-header::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 60px;
        height: 2px;
        background-color: #ef4444;
    }
    .video-badge-pill {
        background-color: #ef4444;
        color: #ffffff;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.3px;
    }
    .video-gallery-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.45rem;
        font-weight: 800;
        color: #ffffff;
    }
    .video-channel-link {
        color: #94a3b8;
        font-size: 0.88rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: color 0.2s ease;
    }
    .video-channel-link:hover {
        color: #ef4444;
    }
    .video-gallery-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    @media (min-width: 640px) {
        .video-gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (min-width: 1024px) {
        .video-gallery-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    .video-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .video-card:hover {
        transform: translateY(-4px);
        background: rgba(255, 255, 255, 0.08);
        border-color: #ef4444;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.4);
    }
    .video-thumb-wrapper {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        background: #000;
        overflow: hidden;
    }
    .video-thumb-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.88;
        transition: transform 0.35s ease, opacity 0.35s ease;
    }
    .video-card:hover .video-thumb-img {
        transform: scale(1.06);
        opacity: 1;
    }
    .video-play-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 48px;
        height: 48px;
        background: rgba(239, 68, 68, 0.95);
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        box-shadow: 0 4px 14px rgba(239, 68, 68, 0.5);
        padding-left: 3px;
        transition: all 0.25s ease;
        z-index: 2;
    }
    .video-card:hover .video-play-btn {
        transform: translate(-50%, -50%) scale(1.15);
        background: #ffffff;
        color: #dc2626;
        box-shadow: 0 6px 18px rgba(255, 255, 255, 0.4);
    }
    .video-tag-badge {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-size: 0.72rem;
        padding: 2px 7px;
        border-radius: 4px;
        font-weight: 600;
        z-index: 2;
    }
    .video-card-body {
        padding: 14px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
    .video-card-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #f1f5f9;
        line-height: 1.45;
        margin: 0 0 10px 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s ease;
    }
    .video-card:hover .video-card-title {
        color: #ef4444;
    }
    .video-card-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.78rem;
        color: #94a3b8;
        padding-top: 8px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Proportional Main Stream & Sidebar Columns (Expanded Content & Compact Sidebar) */
    @media (min-width: 992px) {
        .main-stream-col {
            flex: 0 0 70% !important;
            max-width: 70% !important;
        }
        .sidebar-rail-col {
            flex: 0 0 30% !important;
            max-width: 30% !important;
        }
    }
    @media (min-width: 1200px) {
        .main-stream-col {
            flex: 0 0 71.5% !important;
            max-width: 71.5% !important;
        }
        .sidebar-rail-col {
            flex: 0 0 28.5% !important;
            max-width: 28.5% !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- ==========================================================================
         The Daily Star Signature Main Broadsheet Stream with Persistent Right Rail
         ========================================================================== -->
    <div class="row g-4">
        <!-- Main Content Area (Expanded to ~71.5% for rich presentation) -->
        <div class="col-lg-8 col-xl-8 main-stream-col">
            
            <!-- 1. The Daily Star Signature Top Fold (Lead Story + Sub-Leads) -->
            <div class="top-lead-grid">
                <!-- Main Lead Story (বামে প্রধান বড় খবর) -->
                <div>
                    @if($leadPost)
                        <article class="main-lead-card">
                            <div class="main-lead-img-box">
                                <a href="{{ route('post', $leadPost->slug) }}" class="d-block w-100 h-100">
                                    <img src="{{ $leadPost->featured_image_url }}" 
                                         alt="{{ $leadPost->title }}" 
                                         class="main-lead-img" 
                                         onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=800'"
                                         loading="eager">
                                </a>
                            </div>
                            <div class="main-lead-body">
                                <div>
                                    <h2 class="main-lead-headline">
                                        <a href="{{ route('post', $leadPost->slug) }}">{{ $leadPost->title }}</a>
                                    </h2>
                                    <p class="main-lead-excerpt">
                                        {!! Str::limit(strip_tags($leadPost->content), 200) !!}
                                    </p>
                                </div>
                                <div class="main-lead-meta">
                                    <span class="meta-item">
                                        <i class="fa-solid fa-user-pen"></i>
                                        {{ $leadPost->user ? $leadPost->user->name : 'ভোলা জার্নাল ডেস্ক' }}
                                    </span>
                                    <span class="meta-item">
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $leadPost->created_at->diffForHumans() }}
                                    </span>
                                    <span class="meta-item">
                                        <i class="fa-regular fa-eye"></i>
                                        {{ $leadPost->views_count }} বার পঠিত
                                    </span>
                                </div>
                            </div>
                        </article>
                    @else
                        <div class="p-4 text-center border rounded bg-white">
                            <p class="text-muted m-0">কোন সংবাদ পাওয়া যায়নি।</p>
                        </div>
                    @endif
                </div>

                <!-- Sub-Leads List (ডানে ৩-৪টি ট্রেন্ডিং সংবাদ) -->
                <div>
                    <div class="sub-leads-card">
                        <div class="sub-leads-header">
                            <h3><i class="fa-solid fa-bolt-lightning text-danger me-2"></i>শীর্ষ খবর</h3>
                        </div>
                        <div class="sub-leads-list">
                            @forelse($subLeadPosts as $post)
                                <article class="sub-lead-item">
                                    <div class="sub-lead-thumb-box">
                                        <a href="{{ route('post', $post->slug) }}" class="d-block w-100 h-100">
                                            <img src="{{ $post->featured_image_url }}" 
                                                 alt="{{ $post->title }}" 
                                                 class="sub-lead-thumb" 
                                                 onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=250'" 
                                                 loading="lazy">
                                        </a>
                                    </div>
                                    <div class="sub-lead-info">
                                        <h4 class="sub-lead-title">
                                            <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                        </h4>
                                    </div>
                                </article>
                            @empty
                                <p class="text-muted py-4 m-0 text-center">শীর্ষ খবর পাওয়া যায়নি।</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mid-Leaderboard Ad Slot (728x90) -->
            <div class="my-4 text-center">
                <span style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 4px;">বিজ্ঞাপন</span>
                <div style="width: 100%; height: 90px; background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 6px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8; font-size: 0.85rem;">
                    <span class="fw-bold">বিজ্ঞাপনের জন্য স্থান নির্ধারিত (728x90)</span>
                    <small style="color: #cbd5e1;">দৈনিক ভোলা জার্নাল ডিজিটাল বিজ্ঞাপন</small>
                </div>
            </div>

            <!-- 4. Thematic Category Streams (Custom Layouts from Admin Settings) -->
            @foreach($categoriesWithPosts as $cat)
                @if($cat->posts->count() > 0)
                    @php 
                        $layout = $cat->layout ?? 'style_a';
                    @endphp
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

                        @if($layout === 'style_b')
                            <!-- Layout Style B: 4-Column Card Grid -->
                            <div class="cat-grid-4">
                                @foreach($cat->posts->take(4) as $post)
                                    <article class="cat-grid-card">
                                        <div class="cat-grid-img-box">
                                            <a href="{{ route('post', $post->slug) }}" class="d-block w-100 h-100">
                                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="cat-grid-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'" loading="lazy">
                                            </a>
                                        </div>
                                        <div class="cat-grid-content">
                                            <h4 class="cat-grid-title">
                                                <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                            </h4>
                                        </div>
                                    </article>
                                @endforeach
                            </div>

                        @elseif($layout === 'style_c')
                            <!-- Layout Style C: 2 Large Featured Cards + 3 Compact Headlines Strip -->
                            <div class="cat-layout-c">
                                <div class="cat-style-c-top">
                                    @foreach($cat->posts->take(2) as $post)
                                        <article class="cat-card-c-featured">
                                            <div class="cat-card-c-img-box">
                                                <a href="{{ route('post', $post->slug) }}" class="d-block w-100 h-100">
                                                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="cat-card-c-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=500'" loading="lazy">
                                                </a>
                                            </div>
                                            <div class="cat-card-c-body">
                                                <h4 class="cat-card-c-title">
                                                    <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                                </h4>
                                                <p class="cat-card-c-excerpt m-0">
                                                    {!! Str::limit(strip_tags($post->content), 120) !!}
                                                </p>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>

                                @if($cat->posts->count() > 2)
                                    <div class="cat-style-c-bottom">
                                        @foreach($cat->posts->skip(2)->take(3) as $post)
                                            <article class="cat-strip-item-c">
                                                <h4 class="cat-strip-title-c">
                                                    <a href="{{ route('post', $post->slug) }}">
                                                        <i class="fa-solid fa-caret-right text-danger me-1"></i>{{ $post->title }}
                                                    </a>
                                                </h4>
                                            </article>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                        @else
                            <!-- Default Layout Style A: 1 Lead + 3 Horizontal Cards -->
                            <div class="cat-split-grid">
                                <div class="cat-split-left d-flex flex-column">
                                    @php $firstPost = $cat->posts->first(); @endphp
                                    @if($firstPost)
                                        <article class="cat-lead-card">
                                            <div class="cat-lead-img-box">
                                                <a href="{{ route('post', $firstPost->slug) }}" class="d-block w-100 h-100">
                                                    <img src="{{ $firstPost->featured_image_url }}" alt="{{ $firstPost->title }}" class="cat-lead-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=500'" loading="lazy">
                                                </a>
                                            </div>
                                            <div class="cat-lead-content">
                                                <h4 class="cat-lead-title">
                                                    <a href="{{ route('post', $firstPost->slug) }}">{{ $firstPost->title }}</a>
                                                </h4>
                                                <p class="cat-lead-excerpt m-0">
                                                    {!! Str::limit(strip_tags($firstPost->content), 140) !!}
                                                </p>
                                            </div>
                                        </article>
                                    @endif
                                </div>

                                <div class="cat-side-list">
                                    @foreach($cat->posts->skip(1)->take(3) as $post)
                                        <article class="cat-side-card">
                                            <div class="cat-side-thumb-box">
                                                <a href="{{ route('post', $post->slug) }}" class="d-block w-100 h-100">
                                                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="cat-side-thumb" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=200'" loading="lazy">
                                                </a>
                                            </div>
                                            <div class="cat-side-content">
                                                <h4 class="cat-side-title">
                                                    <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                                </h4>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </section>
                @endif
            @endforeach

        </div>

        <!-- Right Persistent Rail / Sidebar (Refined Compact Width ~28.5%) -->
        <div class="col-lg-4 col-xl-4 sidebar-rail-col">
            @include('layouts.partials.sidebar')
        </div>
    </div>

    <!-- ==========================================================================
         YouTube Video Gallery Strip (Interactive Video Player Modal)
         ========================================================================== -->
    <section class="video-gallery-strip" aria-label="ভিডিও গ্যালারি">
        <div class="video-gallery-header d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <span class="video-badge-pill"><i class="fa-brands fa-youtube"></i> ভিডিও</span>
                <h3 class="video-gallery-title m-0">ভিডিও গ্যালারি</h3>
            </div>
            <a href="{{ $themeSettings['social_youtube'] ?? 'https://www.youtube.com' }}" target="_blank" class="video-channel-link">
                <span>ভোলা জার্নাল ইউটিউব চ্যানেল</span>
                <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
            </a>
        </div>

        <div class="video-gallery-grid">
            @forelse($videoGallery as $vIndex => $vid)
                @php
                    $vId = $vid['video_id'] ?? '';
                    if (empty($vId) && !empty($vid['youtube_url'])) {
                        preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $vid['youtube_url'], $matches);
                        $vId = $matches[1] ?? '';
                    }
                    $thumb = $vid['thumbnail'] ?? (!empty($vId) ? "https://img.youtube.com/vi/{$vId}/hqdefault.jpg" : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400');
                    $title = $vid['title'] ?? 'ভিডিও সংবাদ';
                @endphp
                <div class="video-card" onclick="playYouTubeVideo('{{ $vId }}', '{{ addslashes($title) }}')">
                    <div class="video-thumb-wrapper">
                        <img src="{{ $thumb }}" alt="{{ $title }}" class="video-thumb-img" loading="lazy">
                        <div class="video-play-btn">
                            <i class="fa-solid fa-play"></i>
                        </div>
                        <span class="video-tag-badge"><i class="fa-brands fa-youtube text-danger me-1"></i>ভিডিও</span>
                    </div>
                    <div class="video-card-body">
                        <h4 class="video-card-title">{{ $title }}</h4>
                        <div class="video-card-meta">
                            <span><i class="fa-solid fa-circle-play me-1 text-danger"></i>ভিডিও দেখুন</span>
                            <span class="text-danger fw-bold"><i class="fa-solid fa-play me-1" style="font-size: 0.65rem;"></i>প্লে</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-white-50 py-4">
                    <p class="m-0">বর্তমানে কোনো ভিডিও যুক্ত করা নেই।</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Modal for YouTube Video Player -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-secondary shadow-lg">
                <div class="modal-header border-secondary py-2 px-3">
                    <h5 class="modal-title fs-6 text-truncate" id="videoModalLabel">
                        <i class="fa-brands fa-youtube text-danger me-2"></i>ভিডিও প্লেয়ার
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="stopYouTubeVideo()"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9 bg-black">
                        <iframe id="videoIframe" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function playYouTubeVideo(videoId, title) {
        if (!videoId) return;
        const modalEl = document.getElementById('videoModal');
        const iframe = document.getElementById('videoIframe');
        const titleEl = document.getElementById('videoModalLabel');
        
        if (titleEl) {
            titleEl.innerHTML = `<i class="fa-brands fa-youtube text-danger me-2"></i>` + (title || 'ভিডিও প্লেয়ার');
        }
        if (iframe) {
            iframe.src = `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&rel=0`;
        }
        if (modalEl && typeof bootstrap !== 'undefined') {
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }
    }

    function stopYouTubeVideo() {
        const iframe = document.getElementById('videoIframe');
        if (iframe) {
            iframe.src = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('videoModal');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function () {
                stopYouTubeVideo();
            });
        }
    });
</script>
@endsection
