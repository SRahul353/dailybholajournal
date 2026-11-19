@extends('layouts.admin')

@section('title', 'সোশ্যাল মিডিয়া কার্ড জেনারেটর | ' . $post->title)
@section('header_title', 'সোশ্যাল মিডিয়া কার্ড জেনারেটর')

@section('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@400;700&family=Baloo+Da+2:wght@400;700&family=Galada&family=Hind+Siliguri:wght@400;500;700&family=Mina:wght@400;700&family=Noto+Sans+Bengali:wght@400;500;700&family=Tiro+Bangla:ital@0;1&display=swap');

    /* Full-screen immersive overrides */
    .admin-content {
        padding: 0 !important;
        overflow: hidden !important;
        background-color: #f8fafc; /* Slate 50 light background */
    }

    .admin-header {
        box-shadow: none !important;
        border-bottom: 1px solid #e2e8f0 !important;
        background-color: #ffffff !important;
    }
    
    .admin-header .header-title {
        color: #0f172a !important;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    
    .admin-header .view-site-btn {
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #334155;
    }

    /* Main Studio Container */
    .studio-container {
        display: flex;
        width: 100%;
        height: calc(100vh - 70px);
        position: relative;
        overflow: hidden;
    }

    /* 1. Canvas Workspace (Right side) */
    .canvas-workspace {
        flex: 1;
        height: 100%;
        background-color: #f1f5f9; /* Slate 100 light background */
        background-image: 
            radial-gradient(rgba(15, 23, 42, 0.05) 1.5px, transparent 1.5px),
            linear-gradient(rgba(0, 0, 0, 0.005) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 0, 0, 0.005) 1px, transparent 1px);
        background-size: 24px 24px, 24px 24px, 24px 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
        box-shadow: inset 0 0 40px rgba(15, 23, 42, 0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Glowing Aura behind canvas */
    .canvas-workspace::before {
        content: '';
        position: absolute;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.8) 0%, transparent 70%);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
        z-index: 0;
    }

    .scale-container {
        width: 1080px;
        height: 1080px;
        transform-origin: center center;
        flex-shrink: 0;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25), 0 0 40px rgba(15, 23, 42, 0.05);
        border-radius: 8px;
        background-color: #000000;
        position: relative;
        transition: transform 0.15s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1;
        border: 1px solid rgba(15, 23, 42, 0.1);
    }

    /* Crop Marks / Designer Guides */
    .canvas-guide {
        position: absolute;
        width: 30px;
        height: 30px;
        border-color: #dc2626; /* Crimson brand color guide */
        border-style: solid;
        pointer-events: none;
        z-index: 5;
    }
    .guide-tl { top: -8px; left: -8px; border-width: 2px 0 0 2px; }
    .guide-tr { top: -8px; right: -8px; border-width: 2px 2px 0 0; }
    .guide-bl { bottom: -8px; left: -8px; border-width: 0 0 2px 2px; }
    .guide-br { bottom: -8px; right: -8px; border-width: 0 2px 2px 0; }

    .canvas-resolution-badge {
        position: absolute;
        top: -36px;
        left: 0;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(4px);
        pointer-events: none;
        z-index: 5;
    }

    /* 2. Left-side Inspector Panel */
    .inspector-panel {
        width: 380px;
        height: 100%;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-right: 1px solid #e2e8f0;
        box-shadow: 10px 0 30px rgba(15, 23, 42, 0.04);
        display: flex;
        flex-direction: column;
        z-index: 10;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .inspector-panel.collapsed {
        margin-left: -380px;
    }

    .inspector-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .inspector-title {
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .inspector-title i {
        color: #dc2626;
        font-size: 0.95rem;
        filter: drop-shadow(0 0 8px rgba(220, 38, 38, 0.3));
    }

    .inspector-content {
        flex: 1;
        overflow-y: auto;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Inspector Sections / Cards */
    .inspector-section {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        transition: border-color 0.2s;
    }

    .inspector-section:hover {
        border-color: rgba(220, 38, 38, 0.2);
    }

    .section-title {
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 8px;
        margin-bottom: 4px;
    }

    .section-title i {
        color: #dc2626;
    }

    /* Premium Styled Form Elements */
    .studio-label {
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
        display: block;
    }

    .studio-select, .studio-input {
        width: 100%;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
        padding: 10px 14px !important;
        border-radius: 8px !important;
        font-size: 0.85rem !important;
        outline: none !important;
        transition: all 0.2s !important;
    }

    .studio-select:focus, .studio-input:focus {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15) !important;
    }

    /* Custom range slider wrapper */
    .slider-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .studio-range {
        flex: 1;
        accent-color: #dc2626;
        cursor: pointer;
        height: 6px;
        border-radius: 3px;
        background: #e2e8f0;
    }

    .slider-val-badge {
        background: rgba(220, 38, 38, 0.06);
        border: 1px solid rgba(220, 38, 38, 0.15);
        color: #dc2626;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 700;
        min-width: 48px;
        text-align: center;
    }

    /* Custom Color Picker Swatches */
    .color-swatch-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .color-swatch {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 1px solid rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: transform 0.15s, border-color 0.15s;
    }

    .color-swatch:hover {
        transform: scale(1.15);
        border-color: #0f172a;
    }

    .color-picker-studio {
        width: 32px;
        height: 32px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        cursor: pointer;
        padding: 0;
        overflow: hidden;
        background: transparent;
        transition: transform 0.2s;
    }

    .color-picker-studio:hover {
        transform: scale(1.1);
    }

    .color-picker-studio::-webkit-color-swatch-wrapper {
        padding: 0;
    }

    .color-picker-studio::-webkit-color-swatch {
        border: none;
    }

    /* Ad Preset Buttons */
    .ad-presets {
        display: flex;
        gap: 8px;
    }
    
    .btn-preset-ad {
        flex: 1;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        padding: 8px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        font-family: 'Noto Sans Bengali', sans-serif;
    }

    .btn-preset-ad:hover, .btn-preset-ad.active {
        border-color: #dc2626;
        background: rgba(220, 38, 38, 0.05);
        color: #dc2626;
    }

    /* Card Color Theme Presets */
    .card-theme-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .btn-theme-preset {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        padding: 7px 10px;
        border-radius: 6px;
        font-size: 0.76rem;
        font-weight: 700;
        color: #334155;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Noto Sans Bengali', sans-serif;
    }

    .btn-theme-preset:hover {
        border-color: #dc2626;
        background: #fff5f5;
        color: #dc2626;
    }

    .btn-theme-preset.active {
        border-color: #dc2626;
        background: #fef2f2;
        color: #dc2626;
        box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.2);
    }

    .theme-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        flex-shrink: 0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    /* Drag and Drop BG Button */
    .bg-upload-zone {
        border: 1.5px dashed #cbd5e1;
        border-radius: 8px;
        padding: 14px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        color: #64748b;
    }

    .bg-upload-zone:hover {
        border-color: #dc2626;
        background: rgba(220, 38, 38, 0.02);
        color: #334155;
    }

    .bg-upload-zone i {
        font-size: 1.25rem;
        color: #dc2626;
    }

    .bg-upload-preview {
        width: 100%;
        height: 50px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        margin-top: 4px;
    }

    /* Primary Downloads Actions styling */
    .download-gradient-btn {
        width: 100%;
        padding: 14px !important;
        border-radius: 10px !important;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 0.95rem !important;
        font-family: 'Noto Sans Bengali', sans-serif;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.25) !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        border: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .download-gradient-btn:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.4) !important;
        background: linear-gradient(135deg, #34d399 0%, #059669 100%) !important;
    }

    .download-gradient-btn:active {
        transform: translateY(0) !important;
    }

    /* Premium Facebook Sharing Action Button styling */
    .btn-facebook-share {
        width: 100%;
        padding: 13px !important;
        border-radius: 10px !important;
        background: #1877f2 !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 0.9rem !important;
        font-family: 'Noto Sans Bengali', sans-serif;
        box-shadow: 0 6px 15px rgba(24, 119, 242, 0.25) !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        border: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-facebook-share:hover {
        background: #1565c0 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 20px rgba(24, 119, 242, 0.4) !important;
    }

    .btn-facebook-share:active {
        transform: translateY(0) !important;
    }

    /* Toggle Floating Panel Button */
    .toggle-studio-panel-btn {
        position: absolute;
        top: 20px;
        left: 20px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 12;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(8px);
    }

    .toggle-studio-panel-btn:hover {
        background: #dc2626;
        border-color: #dc2626;
        color: #ffffff;
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(220, 38, 38, 0.3);
    }

    /* 3. Card Elements in-canvas feedback */
    [contenteditable="true"] {
        position: relative;
        outline: none;
        border: 1px dashed transparent;
        border-radius: 6px;
        padding: 4px 8px;
        transition: all 0.2s;
    }

    [contenteditable="true"]:hover {
        border-color: rgba(243, 156, 18, 0.5);
        background: rgba(0, 0, 0, 0.03);
    }

    [contenteditable="true"]:focus {
        border-color: #f39c12;
        background: rgba(0, 0, 0, 0.05);
        box-shadow: 0 0 0 4px rgba(243, 156, 18, 0.15);
    }

    /* Dynamic "Edit" Tooltip on Hover */
    [contenteditable="true"]::after {
        content: 'সম্পাদনা করুন';
        position: absolute;
        bottom: -28px;
        right: 10px;
        background: #f39c12;
        color: #000;
        font-family: 'Noto Sans Bengali', sans-serif !important;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 4px;
        pointer-events: none;
        opacity: 0;
        transform: translateY(-5px);
        transition: all 0.2s;
        z-index: 100;
        white-space: nowrap;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    [contenteditable="true"]:hover::after {
        opacity: 1;
        transform: translateY(0);
    }

    [contenteditable="true"]:focus::after {
        display: none; /* Hide when typing */
    }

    /* Exporting mode overrides to prevent any html2canvas shifts or artifacts */
    .exporting [contenteditable="true"] {
        border-color: transparent !important;
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 2px 6px !important; /* Perfect match to original padding exactly */
        outline: none !important;
    }
    
    .exporting [contenteditable="true"]::after {
        display: none !important;
        content: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
    }

    /* Count character indicator inside Inspector */
    .char-count-wrapper {
        display: flex;
        justify-content: flex-end;
        font-size: 11px;
        color: #64748b;
        margin-top: 4px;
    }

    .char-count-badge {
        font-weight: 700;
        color: #dc2626;
    }

    /* Canvas Card Content Styling Fixes */
    .news-card-1080 { 
        width: 1080px; 
        height: 1080px;
        position: relative; 
        overflow: hidden; 
        display: flex; 
        flex-direction: column; 
        background-color: #000; 
        flex-shrink: 0;
    }

    /* Top Right Corner Profile/Emblem Logo (attached to top edge) */
    .card-top-right-logo { 
        position: absolute; 
        top: 0; 
        right: 50px; 
        z-index: 20; 
        pointer-events: none; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
    }
    .card-top-right-logo img { 
        width: 135px; 
        height: 135px; 
        object-fit: contain; 
        display: block; 
        filter: drop-shadow(0 10px 22px rgba(0, 0, 0, 0.85)) drop-shadow(0 3px 6px rgba(0, 0, 0, 0.6)); 
        transition: width 0.15s ease, height 0.15s ease, filter 0.2s ease;
    }

    .card-top-right-logo img.logo-shadow-effect,
    .card-top-right-logo img.logo-3d-effect {
        filter: drop-shadow(0 14px 28px rgba(0, 0, 0, 0.9)) drop-shadow(0 4px 10px rgba(0, 0, 0, 0.75)) !important;
        border: none !important;
        background-color: transparent !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }

    .card-top-right-logo img.no-shadow {
        filter: none !important;
    }

    /* Watermark positioned down behind text */
    .text-area-watermark { 
        position: absolute; 
        top: 50%; 
        left: 50%; 
        transform: translate(-50%, -50%); 
        width: 82%; 
        max-width: 850px; 
        opacity: 0.12; 
        z-index: 1; /* strictly behind text */
        pointer-events: none; 
        filter: brightness(220%) grayscale(100%); 
    }

    .news-image-wrapper { 
        flex: 0 0 648px; 
        width: 1080px; 
        position: relative; 
        z-index: 2; 
        overflow: hidden; 
        border-bottom: 3px solid rgba(255,255,255,0.1); 
        background-color: #000; 
    }
    
    .news-image { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        display: block; 
    }

    .bottom-content-wrapper { 
        flex: 0 0 332px; 
        width: 1080px; 
        background: linear-gradient(160deg, #1e3a8a 0%, #0f172a 100%); /* Brand Signature Royal Blue Default */
        display: flex; 
        flex-direction: column; 
        padding: 20px 60px 15px 60px;
        position: relative;
        z-index: 2; 
        overflow: hidden;
        transition: background 0.3s ease;
    }

    .meta-row {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        width: 100%;
        height: 50px;
        margin-bottom: 10px;
        position: relative;
        z-index: 3;
    }
    
    .news-date { 
        font-family: 'Noto Sans Bengali', sans-serif !important;
        font-size: 24px; 
        color: #38bdf8; /* Royal Sky Blue */
        font-weight: 600; 
        transition: color 0.2s ease;
    }

    .headline-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        position: relative;
        z-index: 3;
    }

    .news-headline { 
        font-family: 'Noto Sans Bengali', sans-serif; 
        font-size: 52px; 
        line-height: 1.35; 
        font-weight: 700; 
        color: #ffffff; 
        text-shadow: 2px 2px 4px rgba(0,0,0,0.6); 
        width: 100%; 
    }
    
    .details-hint { 
        font-family: 'Noto Sans Bengali', sans-serif !important;
        font-size: 22px; 
        color: #7dd3fc; /* Soft Sky Blue */
        margin-top: 15px; 
        font-weight: 500; 
        display: inline-block;
        background: transparent; 
        transition: color 0.2s ease;
    }

    .full-width-ad-bar {
        flex: 0 0 100px; 
        width: 1080px;
        background: #111;
        border-top: 3px solid #38bdf8; /* Royal Sky Blue Accent Border */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 3;
        overflow: hidden;
        transition: border-color 0.2s ease;
    }
    
    .full-width-ad-bar img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        display: block; 
    }

    /* Success Toast Notification */
    .studio-toast {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translate(-50%, 50px);
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(16, 185, 129, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(16, 185, 129, 0.1);
        padding: 16px 24px;
        border-radius: 12px;
        color: #ffffff;
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 14px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        font-family: 'Noto Sans Bengali', sans-serif;
        min-width: 480px;
    }

    .studio-toast.show {
        transform: translate(-50%, 0);
        opacity: 1;
        visibility: visible;
    }

    .toast-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10b981;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .toast-body {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .toast-title {
        font-weight: 700;
        font-size: 0.92rem;
        color: #ffffff;
    }

    .toast-desc {
        font-size: 0.78rem;
        color: #cbd5e1;
        line-height: 1.4;
    }

    /* Mobile and tablet responsive adaptations */
    @media (max-width: 1200px) {
        .inspector-panel {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            transform: translateX(-100%);
            margin-left: 0 !important;
        }
        
        .inspector-panel.open {
            transform: translateX(0);
        }
        
        .toggle-studio-panel-btn {
            display: flex !important;
        }
    }

    /* ============================================
       MOBILE RESPONSIVE — Social Card Studio
       max-width: 768px
    ============================================ */
    @media (max-width: 768px) {

        /* 1. Stack layout vertically, allow scrolling */
        .studio-container {
            flex-direction: column !important;
            height: auto !important;
            min-height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* 2. Inspector panel: full-width, below canvas, hidden by default */
        .inspector-panel {
            position: relative !important;
            left: auto !important;
            top: auto !important;
            transform: none !important;
            width: 100% !important;
            height: auto !important;
            max-height: 60vh;
            border-right: none !important;
            border-top: 2px solid #e2e8f0;
            order: 2;
            display: none !important;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        .inspector-panel.mobile-open {
            display: flex !important;
        }

        /* 3. Canvas workspace on top */
        .canvas-workspace {
            order: 1;
            height: auto !important;
            min-height: 55vw;
            padding: 10px 8px !important;
            overflow: visible !important;
        }

        /* 4. Inspector content spacing */
        .inspector-content {
            padding: 14px !important;
            gap: 12px !important;
            padding-bottom: 80px !important; /* room for sticky download btn */
        }
        .inspector-section {
            padding: 12px !important;
            gap: 10px !important;
        }

        /* 5. Theme grid — 2 columns on mobile */
        .card-theme-grid {
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 8px !important;
        }

        /* 6. Sticky download button at bottom */
        .download-gradient-btn {
            position: fixed !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            border-radius: 0 !important;
            z-index: 200;
            padding: 15px 20px !important;
            font-size: 1rem !important;
            width: 100% !important;
            text-align: center;
        }

        /* 7. Hide resolution badge on mobile */
        .canvas-resolution-badge { display: none !important; }

        /* 8. Toast notification — full width */
        .studio-toast {
            min-width: 90vw !important;
            width: 90vw !important;
            left: 5vw !important;
            right: 5vw !important;
            bottom: 70px !important;
        }

        /* 9. Desktop toggle button — hide on mobile */
        .toggle-studio-panel-btn { display: none !important; }

        /* 10. Inspector header stays readable */
        .inspector-header { padding: 12px 14px !important; }
        .inspector-title { font-size: 0.95rem !important; }

        /* 11. Facebook share button full width */
        .btn-share-facebook {
            width: 100%;
            justify-content: center;
        }
    }

    /* Studio Gear Button (Inspector Header) */
    .btn-studio-gear {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 700;
        font-family: 'Noto Sans Bengali', sans-serif;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-studio-gear:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.25);
    }
    .btn-studio-gear i {
        transition: transform 0.4s ease;
    }
    .btn-studio-gear:hover i {
        transform: rotate(90deg);
    }

    /* Reporter Badge on News Image (Left Bottom Side) */
    .card-reporter-badge-wrapper {
        position: absolute;
        bottom: 25px;
        left: 50px;
        z-index: 10;
        pointer-events: auto;
        display: flex;
        align-items: center;
        transition: bottom 0.15s ease, left 0.15s ease;
    }

    .card-category-badge,
    .card-reporter-badge {
        background: #dc2626;
        color: #ffffff !important;
        padding: 6px 20px;
        border-radius: 8px;
        font-size: 22px;
        font-weight: 700;
        font-family: 'Noto Sans Bengali', sans-serif !important;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.65);
        white-space: nowrap;
        border: none;
        letter-spacing: 0.3px;
        transition: all 0.2s ease;
        line-height: 1.4;
    }
    .exporting .card-category-badge,
    .exporting .card-reporter-badge {
        box-shadow: none !important;
    }

    /* Official Brand Footer on Card */
    .official-brand-footer {
        flex: 0 0 100px;
        height: 100px;
        width: 1080px;
        background: linear-gradient(135deg, #070b13 0%, #0c1424 50%, #070b13 100%);
        border-top: 3px solid #38bdf8;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.12), 0 -8px 25px rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 45px;
        z-index: 20;
        font-family: 'Noto Sans Bengali', sans-serif;
        box-sizing: border-box;
        position: relative;
        overflow: hidden;
        transition: border-color 0.2s ease;
    }
    .official-brand-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 20%;
        width: 60%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(56, 189, 248, 0.4), transparent);
        pointer-events: none;
    }
    .brand-footer-left {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-shrink: 0;
    }
    .brand-logo-frame {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: #ffffff;
        padding: 3px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5), 0 0 0 2px rgba(255, 255, 255, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .brand-footer-icon {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 50%;
    }
    .brand-text-block {
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: left;
    }
    .brand-footer-title {
        font-size: 25px;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: 0.3px;
        line-height: 1.15;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
        outline: none;
    }
    .brand-footer-tagline {
        font-size: 13.5px;
        font-weight: 600;
        color: #94a3b8;
        letter-spacing: 0.4px;
        margin-top: 2px;
        outline: none;
    }
    .brand-footer-title:focus,
    .brand-footer-tagline:focus,
    .brand-pill-text:focus {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 4px;
        padding: 0 6px;
    }
    .brand-footer-center,
    .brand-footer-right {
        display: flex;
        align-items: center;
    }
    .brand-pill-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 7px 20px 7px 8px;
        border-radius: 30px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.16);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(4px);
        transition: all 0.2s ease;
    }
    .brand-pill-badge:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.25);
    }
    .pill-icon-box {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .pill-icon-box.web-icon {
        background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(56, 189, 248, 0.5);
    }
    .pill-icon-box.fb-icon {
        width: 32px;
        height: 32px;
        font-size: 15px;
        background: linear-gradient(135deg, #1877f2 0%, #3b82f6 100%);
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(24, 119, 242, 0.5);
    }
    .pill-icon-box.yt-icon {
        width: 32px;
        height: 32px;
        font-size: 15px;
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.5);
    }
    .brand-pill-text {
        font-size: 20px;
        font-weight: 700;
        color: #f8fafc;
        letter-spacing: 0.6px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        outline: none;
    }

    /* Settings Modal Styling */
    .studio-modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25);
        overflow: hidden;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .gear-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: #fee2e2;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .custom-studio-tabs {
        gap: 6px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 12px;
        flex-wrap: wrap;
    }
    .custom-studio-tabs .nav-link {
        color: #475569;
        font-weight: 700;
        font-size: 0.84rem;
        border-radius: 8px;
        padding: 7px 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .custom-studio-tabs .nav-link:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .custom-studio-tabs .nav-link.active {
        background: #0f172a !important;
        border-color: #0f172a !important;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.15);
    }
    .modal-theme-btn {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .modal-theme-btn:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
        transform: translateY(-1px);
    }
    .modal-theme-btn.active {
        border-color: #dc2626 !important;
        background: #fff5f5 !important;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.15);
    }
    .theme-color-bullet {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        flex-shrink: 0;
        border: 2px solid #ffffff;
        box-shadow: 0 1px 4px rgba(0,0,0,0.25);
    }
    /* Modal Card Style Selector */
    .modal-style-card {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px;
        cursor: pointer;
        transition: all 0.22s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        user-select: none;
    }
    .modal-style-card:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }
    .modal-style-card.active {
        border-color: #dc2626 !important;
        background: #fffdfd !important;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.12);
    }
    .modal-style-card .style-check-icon {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 2px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        color: transparent;
        font-size: 11px;
        transition: all 0.2s ease;
        background: #f8fafc;
    }
    .modal-style-card.active .style-check-icon {
        border-color: #dc2626;
        background: #dc2626;
        color: #ffffff;
    }
    .btn-studio-quicksave {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: 'Noto Sans Bengali', sans-serif;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .btn-studio-quicksave:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 3px 10px rgba(37, 99, 235, 0.25);
    }
    .settings-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }
    .settings-card-header {
        padding: 12px 16px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .settings-card-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1e293b;
    }
    .settings-card-body {
        padding: 16px;
    }
    .logo-preview-box {
        width: 72px;
        height: 72px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 4px;
        flex-shrink: 0;
    }
    .logo-preview-box.watermark-bg {
        background: #1e3a8a;
    }
    .logo-preview-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .footer-mode-card {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        padding: 14px 12px;
        cursor: pointer;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
    }
    .footer-mode-card:hover {
        border-color: #dc2626;
        background: #fff5f5;
    }
    .footer-mode-card.active {
        border-color: #dc2626;
        background: #fef2f2;
        box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.2);
    }
    .footer-mode-card .mode-icon {
        font-size: 1.35rem;
        color: #64748b;
        margin-bottom: 4px;
    }
    .footer-mode-card.active .mode-icon {
        color: #dc2626;
    }
    .footer-mode-card .mode-title {
        font-size: 0.86rem;
        font-weight: 700;
        color: #0f172a;
    }
    .footer-mode-card .mode-desc {
        font-size: 0.72rem;
        color: #64748b;
    }

    /* ===================================================
       CARD STYLE SELECTOR & DYNAMIC CARD TEMPLATES
       =================================================== */

    /* Card Styles Grid in Left Inspector */
    .card-style-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 10px;
    }
    .style-select-card {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-align: center;
        user-select: none;
        position: relative;
    }
    .style-select-card:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }
    .style-select-card.active {
        background: #ffffff;
        border-color: #dc2626;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.16);
    }
    .style-select-card.active::after {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        top: 6px;
        right: 6px;
        font-size: 10px;
        color: #fff;
        background: #dc2626;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .style-thumb-box {
        width: 100%;
        height: 60px;
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 6px;
        border: 1px solid rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        position: relative;
    }
    /* Thumbnails for 4 styles */
    .thumb-classic { background: #1e3a8a; }
    .thumb-classic .thumb-top-img { height: 60%; background: #94a3b8; }
    .thumb-classic .thumb-bottom-card { height: 40%; background: #1e3a8a; padding: 4px; display: flex; flex-direction: column; gap: 2px; justify-content: center; }
    .thumb-line-sm { width: 35%; height: 3px; background: #38bdf8; border-radius: 2px; }
    .thumb-line-lg { width: 85%; height: 4px; background: #ffffff; border-radius: 2px; }

    .thumb-poster { background: #64748b; position: relative; }
    .thumb-poster .thumb-full-img { width: 100%; height: 100%; background: #64748b; }
    .thumb-poster .thumb-scrim { position: absolute; bottom: 0; left: 0; right: 0; height: 35%; background: linear-gradient(to top, rgba(0,0,0,0.92), transparent); padding: 5px; display: flex; align-items: flex-end; }

    .thumb-quote { background: #0f172a; }
    .thumb-quote .thumb-quote-img { height: 48%; background: #94a3b8; }
    .thumb-quote .thumb-quote-card { height: 52%; background: #091326; padding: 3px 6px; display: flex; flex-direction: column; justify-content: center; gap: 2px; }
    .thumb-quote-icon { font-size: 8px; color: #facc15; }

    .thumb-breaking { background: #450a0a; }
    .thumb-break-bar { height: 11px; background: #dc2626; display: flex; align-items: center; padding-left: 4px; }
    .thumb-break-img { height: 48%; background: #94a3b8; }
    .thumb-break-card { height: calc(52% - 11px); background: #180505; padding: 4px; display: flex; align-items: center; }

    .style-title { font-size: 0.78rem; font-weight: 700; color: #1e293b; line-height: 1.2; }
    .style-badge-tag { font-size: 0.65rem; font-weight: 600; border-radius: 4px; padding: 1px 6px; margin-top: 3px; display: inline-block; }
    .tag-blue { background: #e0f2fe; color: #0284c7; }
    .tag-purple { background: #f3e8ff; color: #9333ea; }
    .tag-amber { background: #fef3c7; color: #d97706; }
    .tag-red { background: #fee2e2; color: #dc2626; }

    /* Canvas Top Bar Pill Switcher */
    .canvas-style-toolbar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 30px;
        padding: 6px 14px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin: 0 auto 20px auto;
        flex-wrap: wrap;
        justify-content: center;
    }
    .btn-style-pill {
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
        font-size: 0.82rem;
        font-weight: 600;
        padding: 5px 14px;
        border-radius: 20px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        cursor: pointer;
    }
    .btn-style-pill:hover { background: #f1f5f9; color: #0f172a; border-color: #cbd5e1; }
    .btn-style-pill.active { background: #dc2626 !important; color: #ffffff !important; border-color: #dc2626 !important; box-shadow: 0 3px 8px rgba(220, 38, 38, 0.3); }

    /* ===================================================
       4 DYNAMIC CARD STYLES ON #social_card_node (1080x1080)
       =================================================== */

    .breaking-news-header { display: none; }
    .quote-symbol-badge { display: none; }

    /* STYLE 1: CLASSIC (Default) */
    .news-card-1080.style-classic .news-image-wrapper { flex: 0 0 648px; height: 648px; }
    .news-card-1080.style-classic .bottom-content-wrapper { flex: 0 0 332px; height: 332px; }
    .news-card-1080.style-classic .meta-row {
        justify-content: flex-start !important;
    }

    /* STYLE 2: POSTER (Full Background Image + Overlay) */
    .news-card-1080.style-poster .news-image-wrapper {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 1080px !important;
        height: 1080px !important;
        flex: none !important;
        z-index: 1 !important;
        border-bottom: none !important;
    }
    .news-card-1080.style-poster .news-image-wrapper .news-image {
        height: 1080px !important;
    }
    /* 1. Default hide corner logo on full poster (can be enabled via style settings) */
    .news-card-1080.style-poster .card-top-right-logo {
        display: none;
    }
    /* 2. Default hide reporter name badge on full poster (can be enabled via style settings) */
    .news-card-1080.style-poster .card-reporter-badge-wrapper {
        display: none;
    }
    /* 3. Default hide details hint on full poster (can be enabled via style settings) */
    .news-card-1080.style-poster .details-hint {
        display: none;
    }
    /* 4. Watermark logo placed normally above date in small size on full poster (hidden by default) */
    .news-card-1080.style-poster .text-area-watermark {
        display: none;
        position: relative !important;
        top: auto !important;
        left: auto !important;
        transform: none !important;
        width: 230px !important;
        max-width: 250px !important;
        height: auto !important;
        max-height: 55px !important;
        object-fit: contain !important;
        opacity: 1 !important;
        align-self: flex-end !important;
        margin-bottom: 12px !important;
        filter: drop-shadow(0 4px 14px rgba(0, 0, 0, 0.95)) drop-shadow(0 2px 5px rgba(0, 0, 0, 0.85)) !important;
        z-index: 15 !important;
        pointer-events: auto !important;
        user-select: none !important;
    }
    /* 5. Full poster content overlay container (top: 0 to bottom: 100px or 0px) */
    .news-card-1080.style-poster .bottom-content-wrapper {
        position: absolute !important;
        top: 0 !important;
        bottom: 100px !important;
        left: 0 !important;
        width: 1080px !important;
        height: auto !important;
        flex: none !important;
        z-index: 5 !important;
        background: linear-gradient(to top, rgba(10, 15, 30, 0.98) 0%, rgba(10, 15, 30, 0.92) 10%, rgba(10, 15, 30, 0.65) 18%, rgba(10, 15, 30, 0.20) 25%, transparent 30%);
        padding: 50px 60px 35px 60px !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        pointer-events: none !important;
        border-top: none !important;
    }
    .news-card-1080.style-poster.footer-none .bottom-content-wrapper {
        bottom: 0 !important;
        padding-bottom: 50px !important;
    }
    /* 6. Date at top right/left (opposite to logo) */
    .news-card-1080.style-poster .meta-row {
        position: relative !important;
        display: flex !important;
        justify-content: flex-start;
        align-items: center !important;
        width: 100% !important;
        height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
        z-index: 15 !important;
        pointer-events: auto !important;
    }
    .news-card-1080.style-poster .meta-row > div {
        background: rgba(10, 15, 30, 0.82) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        padding: 10px 24px !important;
        border-radius: 30px !important;
        border: 1.5px solid rgba(255, 255, 255, 0.25) !important;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.6) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 10px !important;
        pointer-events: auto !important;
    }
    .news-card-1080.style-poster .meta-row .news-date {
        font-size: 21px !important;
        font-weight: 700 !important;
        letter-spacing: 0.5px !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8) !important;
    }
    .news-card-1080.style-poster .meta-row i {
        font-size: 20px !important;
    }
    /* 7. Caption bottom aligned */
    .news-card-1080.style-poster .headline-wrapper {
        margin-top: auto !important;
        margin-bottom: 0 !important;
        width: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: flex-end !important;
        pointer-events: auto !important;
    }
    .news-card-1080.style-poster .news-headline {
        margin-bottom: 0 !important;
        text-shadow: 0 4px 18px rgba(0, 0, 0, 0.98), 0 2px 6px rgba(0, 0, 0, 0.95) !important;
    }
    .news-card-1080.style-poster .full-width-ad-bar,
    .news-card-1080.style-poster .official-brand-footer {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        z-index: 10 !important;
    }

    /* STYLE 3: QUOTE (বক্তব্য / উক্তি কোটেশন কার্ড) */
    .news-card-1080.style-quote {
        background: linear-gradient(160deg, #1e3a8a 0%, #0f172a 100%);
        position: relative !important;
    }

    /* ==========================================================================
       STYLE 3 & 4: QUOTE (উক্তি/বক্তব্য) & BREAKING NEWS (ব্রেকিং নিউজ)
       ========================================================================== */

    /* 1. Subtle luxury texture overlay on full card background */
    .quote-card-texture {
        display: none;
    }
    .news-card-1080.style-quote .quote-card-texture,
    .news-card-1080.style-breaking .quote-card-texture {
        display: block !important;
        position: absolute;
        top: 0;
        left: 0;
        width: 1080px;
        height: 1080px;
        background-image: 
            radial-gradient(circle at 18% 28%, rgba(255, 255, 255, 0.14) 0%, transparent 48%),
            radial-gradient(circle at 82% 80%, rgba(0, 0, 0, 0.38) 0%, transparent 55%),
            repeating-linear-gradient(
                45deg,
                rgba(255, 255, 255, 0.025) 0px,
                rgba(255, 255, 255, 0.025) 1.5px,
                transparent 1.5px,
                transparent 6px
            );
        pointer-events: none;
        z-index: 1;
    }

    /* 2. Top-right Dark Header Panel - Removed as requested */
    .quote-side-column,
    .news-card-1080.style-quote .quote-side-column,
    .news-card-1080.style-breaking .quote-side-column {
        display: none !important;
    }

    /* 3. Top-right Logo (attached to top edge) */
    .news-card-1080.style-quote .card-top-right-logo,
    .news-card-1080.style-breaking .card-top-right-logo {
        display: flex;
        position: absolute !important;
        top: 0 !important;
        right: 45px;
        left: auto;
        z-index: 20 !important;
    }

    /* 4. Top-right Date (under logo) */
    .news-card-1080.style-quote .meta-row,
    .news-card-1080.style-breaking .meta-row {
        position: absolute !important;
        top: 145px !important;
        right: 45px !important;
        left: auto !important;
        width: auto !important;
        height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
        z-index: 20 !important;
        display: flex;
        justify-content: flex-end !important;
        align-items: center !important;
        pointer-events: auto !important;
    }
    .news-card-1080.style-quote .meta-row > div,
    .news-card-1080.style-breaking .meta-row > div {
        background: rgba(0, 0, 0, 0.45) !important;
        padding: 7px 18px !important;
        border-radius: 20px !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
    }
    .news-card-1080.style-quote .meta-row .news-date,
    .news-card-1080.style-breaking .meta-row .news-date {
        font-size: 19px !important;
        font-weight: 700 !important;
        color: #facc15 !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8) !important;
    }
    .news-card-1080.style-quote .meta-row i,
    .news-card-1080.style-breaking .meta-row i {
        font-size: 18px !important;
        color: #facc15 !important;
    }

    /* 5A. Normal Mode: Original Picture Frame Box (নরমাল মোড) */
    .news-card-1080.style-quote .news-image-wrapper,
    .news-card-1080.style-breaking .news-image-wrapper {
        position: absolute !important;
        right: 35px !important;
        bottom: 125px !important;
        left: auto !important;
        top: auto !important;
        width: 400px !important;
        height: 520px !important;
        border-radius: 24px !important;
        overflow: hidden !important;
        border: 3px solid rgba(255, 255, 255, 0.25) !important;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(0, 0, 0, 0.4) !important;
        z-index: 15 !important;
        flex: none !important;
        background: #0f172a !important;
        display: block !important;
    }
    .news-card-1080.style-quote.footer-none .news-image-wrapper,
    .news-card-1080.style-breaking.footer-none .news-image-wrapper {
        bottom: 35px !important;
        height: 580px !important;
    }
    .news-card-1080.style-quote .news-image-wrapper .news-image,
    .news-card-1080.style-breaking .news-image-wrapper .news-image {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        object-position: top center !important;
        filter: none !important;
    }
    .news-card-1080.style-quote .card-reporter-badge-wrapper,
    .news-card-1080.style-breaking .card-reporter-badge-wrapper {
        display: none;
    }
    .news-card-1080.style-quote #cardImagePlaceholder,
    .news-card-1080.style-breaking #cardImagePlaceholder {
        border-radius: 20px !important;
        background: rgba(15, 23, 42, 0.75) !important;
        border: 2px dashed rgba(255, 255, 255, 0.25) !important;
        height: 380px !important;
        width: 320px !important;
        margin: auto !important;
    }

    /* 5B. Cutout Mode: Max Width 1080px Cutout PNG (কাটআউট মোড - ম্যাক্সিমাম ১০৮০ পিক্সেল) */
    .news-card-1080.style-quote .news-image-wrapper.quote-cutout-mode,
    .news-card-1080.style-breaking .news-image-wrapper.quote-cutout-mode {
        position: absolute !important;
        right: 0 !important;
        left: 0 !important;
        bottom: 100px !important;
        top: 0 !important;
        width: 1080px !important;
        max-width: 1080px !important;
        height: 980px !important;
        border-radius: 0 !important;
        overflow: hidden !important;
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
        display: flex !important;
        align-items: flex-end !important;
        justify-content: flex-end !important;
        pointer-events: none !important;
        z-index: 5 !important;
    }
    .news-card-1080.style-quote.footer-none .news-image-wrapper.quote-cutout-mode,
    .news-card-1080.style-breaking.footer-none .news-image-wrapper.quote-cutout-mode {
        bottom: 0 !important;
        height: 1080px !important;
    }
    .news-card-1080.style-quote .news-image-wrapper.quote-cutout-mode .news-image,
    .news-card-1080.style-breaking .news-image-wrapper.quote-cutout-mode .news-image {
        width: 100% !important;
        max-width: 1080px !important;
        height: 100% !important;
        object-fit: contain !important;
        object-position: bottom right !important;
        filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.85)) !important;
        transform-origin: bottom right !important;
        transition: transform 0.12s ease-out;
    }

    /* 6. Content Section Container */
    .news-card-1080.style-quote .bottom-content-wrapper,
    .news-card-1080.style-breaking .bottom-content-wrapper {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 1080px !important;
        height: 1080px !important;
        flex: none !important;
        background: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
        display: block !important;
        border-top: none !important;
        z-index: 10 !important;
        box-sizing: border-box !important;
        pointer-events: none !important;
    }

    /* 7A. Extra Large Quotation mark symbol (Style 3: Quote) */
    .news-card-1080.style-quote .quote-symbol-badge {
        display: inline-flex;
        position: absolute !important;
        top: 55px !important;
        left: 60px !important;
        align-items: center !important;
        justify-content: flex-start !important;
        font-size: 115px !important;
        line-height: 0.8 !important;
        color: #facc15;
        margin-bottom: 0 !important;
        filter: drop-shadow(0 6px 20px rgba(250, 204, 21, 0.5)) !important;
        pointer-events: none !important;
        z-index: 15 !important;
    }

    /* 7B. Breaking News Live Pill Badge (Style 4: Breaking News - Quotation এর জায়গায়) */
    .breaking-badge-pill {
        display: none;
    }
    .news-card-1080.style-breaking .breaking-badge-pill {
        display: inline-flex !important;
        position: absolute !important;
        top: 55px !important;
        left: 60px !important;
        background: #dc2626 !important;
        color: #ffffff !important;
        padding: 8px 24px !important;
        border-radius: 30px !important;
        font-family: 'Noto Sans Bengali', sans-serif !important;
        font-size: 22px !important;
        font-weight: 800 !important;
        letter-spacing: 0.8px !important;
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.65), 0 0 0 2px rgba(255, 255, 255, 0.25) !important;
        align-items: center !important;
        gap: 10px !important;
        z-index: 15 !important;
        pointer-events: auto !important;
    }
    .breaking-badge-pill .live-dot {
        width: 12px;
        height: 12px;
        background: #ffffff;
        border-radius: 50%;
        box-shadow: 0 0 8px #ffffff;
        animation: pulseLiveDot 1.5s infinite;
    }
    @keyframes pulseLiveDot {
        0% { transform: scale(0.95); opacity: 0.85; }
        50% { transform: scale(1.3); opacity: 1; }
        100% { transform: scale(0.95); opacity: 0.85; }
    }

    /* 8. Quote Text vs Breaking News Headline & Excerpt Container */
    .quote-excerpt-text,
    .breaking-excerpt-text,
    .quote-speaker-wrapper {
        display: none;
    }

    /* 8A. Style 3: Quote Excerpt & Speaker */
    .news-card-1080.style-quote .news-headline {
        display: none !important;
    }
    .news-card-1080.style-quote .headline-wrapper {
        position: absolute !important;
        top: 175px !important;
        left: 60px !important;
        width: 530px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        pointer-events: auto !important;
        z-index: 15 !important;
    }
    .news-card-1080.style-quote .quote-excerpt-text {
        display: block !important;
        color: #ffffff !important;
        font-size: 38px !important;
        line-height: 1.55 !important;
        font-weight: 700 !important;
        text-align: left !important;
        text-shadow: 0 4px 16px rgba(0, 0, 0, 0.95), 0 2px 4px rgba(0, 0, 0, 0.9) !important;
        font-family: 'Noto Sans Bengali', sans-serif !important;
        letter-spacing: 0.3px !important;
        margin-bottom: 0 !important;
        pointer-events: auto !important;
        word-break: break-word !important;
    }
    .news-card-1080.style-quote .quote-speaker-wrapper {
        display: flex;
        flex-direction: column !important;
        align-items: flex-end !important;
        text-align: right !important;
        margin-top: 35px !important;
        margin-left: auto !important;
        width: 100% !important;
        pointer-events: auto !important;
    }
    .news-card-1080.style-quote .quote-speaker-name {
        font-size: 28px !important;
        font-weight: 800 !important;
        color: #facc15 !important;
        font-family: 'Noto Sans Bengali', sans-serif !important;
        line-height: 1.3 !important;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.8) !important;
    }
    .news-card-1080.style-quote .quote-speaker-title {
        font-size: 20px !important;
        font-weight: 600 !important;
        color: #e2e8f0 !important;
        opacity: 0.9 !important;
        font-family: 'Noto Sans Bengali', sans-serif !important;
        margin-top: 5px !important;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.8) !important;
    }

    /* 8B. Style 4: Breaking News (News Caption/Headline + Sub-Excerpt) */
    .news-card-1080.style-breaking .headline-wrapper {
        position: absolute !important;
        top: 135px !important;
        left: 60px !important;
        width: 530px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        pointer-events: auto !important;
        z-index: 15 !important;
    }
    .news-card-1080.style-breaking .news-headline {
        display: block !important;
        font-size: 46px !important;
        line-height: 1.35 !important;
        font-weight: 800 !important;
        color: #ffffff !important;
        text-align: left !important;
        text-shadow: 0 4px 16px rgba(0, 0, 0, 0.95), 0 2px 4px rgba(0, 0, 0, 0.9) !important;
        font-family: 'Noto Sans Bengali', sans-serif !important;
        letter-spacing: 0.2px !important;
        margin-bottom: 0 !important;
        word-break: break-word !important;
    }
    .news-card-1080.style-breaking .breaking-excerpt-text {
        display: block;
        margin-top: 18px !important;
        font-size: 26px !important;
        line-height: 1.5 !important;
        font-weight: 600 !important;
        color: #f1f5f9 !important;
        opacity: 0.95 !important;
        text-align: left !important;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.9) !important;
        font-family: 'Noto Sans Bengali', sans-serif !important;
        word-break: break-word !important;
        border-left: 3px solid #ef4444 !important;
        padding-left: 14px !important;
    }
    .news-card-1080.style-breaking .quote-symbol-badge,
    .news-card-1080.style-breaking .quote-excerpt-text,
    .news-card-1080.style-breaking .quote-speaker-wrapper,
    .news-card-1080.style-breaking .breaking-news-header {
        display: none !important;
    }

    /* 9. Details hint at the bottom left */
    .news-card-1080.style-quote .details-hint,
    .news-card-1080.style-breaking .details-hint {
        display: inline-block;
        position: absolute !important;
        bottom: 125px !important;
        left: 60px !important;
        margin: 0 !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        color: rgba(255, 255, 255, 0.85) !important;
        text-align: left !important;
        pointer-events: auto !important;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.8) !important;
        z-index: 20 !important;
    }
    .news-card-1080.style-quote.footer-none .details-hint,
    .news-card-1080.style-breaking.footer-none .details-hint {
        bottom: 45px !important;
    }

    /* 10. Watermark hidden on quote & breaking style */
    .news-card-1080.style-quote .text-area-watermark,
    .news-card-1080.style-breaking .text-area-watermark {
        display: none !important;
    }

    /* 11. Bottom footer bar */
    .news-card-1080.style-quote .full-width-ad-bar,
    .news-card-1080.style-quote .official-brand-footer,
    .news-card-1080.style-breaking .full-width-ad-bar,
    .news-card-1080.style-breaking .official-brand-footer {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        z-index: 20 !important;
    }
</style>
@endsection

@section('content')

{{-- Mobile-only top bar: title + inspector toggle + settings gear --}}
<div class="d-flex d-md-none align-items-center justify-content-between px-3 py-2 border-bottom bg-white"
     style="position: sticky; top: 70px; z-index: 50; box-shadow: 0 2px 6px rgba(0,0,0,0.07);">
    <span style="font-size: 0.88rem; font-weight: 700; color: #0f172a;">
        <i class="fa-solid fa-wand-magic-sparkles text-danger me-2"></i>সোশ্যাল কার্ড স্টুডিও
    </span>
    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="savePersistentCardSettings()" title="ডিফল্ট হিসেবে সেভ করুন" style="border-radius: 6px; font-weight: 700; font-size: 0.82rem;">
            <i class="fa-solid fa-floppy-disk me-1"></i> সেভ
        </button>
        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cardSettingsModal" style="border-radius: 6px; font-weight: 600; font-size: 0.82rem;">
            <i class="fa-solid fa-gear me-1"></i> সেটিংস
        </button>
        <button type="button" id="mobileInspectorToggle"
                onclick="toggleMobileInspector()"
                class="btn btn-sm"
                style="background:#f1f5f9; border:1px solid #e2e8f0; color:#334155; font-size:0.82rem; border-radius:6px; padding:6px 12px;">
            <i class="fa-solid fa-sliders me-1"></i> কাস্টমাইজ
        </button>
    </div>
</div>

<div class="studio-container">
    <!-- Inspector Panel (Left side) -->
    <div class="inspector-panel" id="inspectorPanel">
        <div class="inspector-header">
            <span class="inspector-title">
                <i class="fa-solid fa-palette text-danger"></i> ক্যানভাস স্টুডিও
            </span>
            <div class="d-flex align-items-center gap-1">
                <button type="button" class="btn-studio-quicksave" id="quickSaveDefaultBtn" onclick="savePersistentCardSettings()" title="বর্তমান সব স্টাইল, ফন্ট ও কালার ডিফল্ট হিসেবে সেভ করুন">
                    <i class="fa-solid fa-floppy-disk text-primary"></i>
                    <span>ডিফল্ট সেভ</span>
                </button>
                <button type="button" class="btn-studio-gear" data-bs-toggle="modal" data-bs-target="#cardSettingsModal" title="মাস্টার কার্ড সেটিংস (৫টি ট্যাব)">
                    <i class="fa-solid fa-gear"></i>
                    <span>সেটিংস</span>
                </button>
            </div>
        </div>

        <div class="inspector-content">
            <!-- Section 0: কার্ড ডিজাইন স্টাইল নির্বাচন (Select Card Style) -->
            <div class="inspector-section pt-1">
                <span class="section-title">
                    <i class="fa-solid fa-shapes text-danger"></i> কার্ড ডিজাইন স্টাইল (Style)
                </span>
                
                <div class="card-style-grid">
                    <!-- Style 1: Classic Split -->
                    <div class="style-select-card {{ ($cardSettings['card_style'] ?? 'classic') === 'classic' ? 'active' : '' }}" data-style="classic" onclick="setCardStyle('classic')">
                        <div class="style-thumb-box thumb-classic">
                            <div class="thumb-top-img"></div>
                            <div class="thumb-bottom-card">
                                <div class="thumb-line-sm"></div>
                                <div class="thumb-line-lg"></div>
                            </div>
                        </div>
                        <span class="style-title">ক্লাসিক স্প্লিট</span>
                        <span class="style-badge-tag tag-blue">ডিফল্ট</span>
                    </div>

                    <!-- Style 2: Full Poster Overlay -->
                    <div class="style-select-card {{ ($cardSettings['card_style'] ?? '') === 'poster' ? 'active' : '' }}" data-style="poster" onclick="setCardStyle('poster')">
                        <div class="style-thumb-box thumb-poster">
                            <div class="thumb-full-img"></div>
                            <div class="thumb-scrim">
                                <div class="thumb-line-lg"></div>
                            </div>
                        </div>
                        <span class="style-title">ফুল পোস্টার</span>
                        <span class="style-badge-tag tag-purple">সিনেমাটিক</span>
                    </div>

                    <!-- Style 3: Quote / Statement -->
                    <div class="style-select-card {{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'active' : '' }}" data-style="quote" onclick="setCardStyle('quote')">
                        <div class="style-thumb-box thumb-quote">
                            <div class="thumb-quote-img"></div>
                            <div class="thumb-quote-card">
                                <i class="fa-solid fa-quote-left thumb-quote-icon"></i>
                                <div class="thumb-line-lg"></div>
                            </div>
                        </div>
                        <span class="style-title">উক্তি / বক্তব্য</span>
                        <span class="style-badge-tag tag-amber">কোটেশন</span>
                    </div>

                    <!-- Style 4: Breaking News Flash -->
                    <div class="style-select-card {{ ($cardSettings['card_style'] ?? '') === 'breaking' ? 'active' : '' }}" data-style="breaking" onclick="setCardStyle('breaking')">
                        <div class="style-thumb-box thumb-breaking">
                            <div class="thumb-break-bar"></div>
                            <div class="thumb-break-img"></div>
                            <div class="thumb-break-card">
                                <div class="thumb-line-lg"></div>
                            </div>
                        </div>
                        <span class="style-title">ব্রেকিং নিউজ</span>
                        <span class="style-badge-tag tag-red">জরুরি</span>
                    </div>
                </div>
            </div>

            <!-- Section 1: পোস্ট ও শিরোনাম -->
            <div class="inspector-section">
                <span class="section-title">
                    <i class="fa-solid fa-newspaper"></i> পোস্ট ও শিরোনাম
                </span>
                
                <div>
                    <label class="studio-label"><i class="fa-solid fa-shuffle text-danger me-1"></i> পোস্ট পরিবর্তন করুন</label>
                    <select id="post_switcher" class="studio-select" onchange="window.location.href = '{{ url('admin/tools/social-card') }}/' + this.value">
                        @foreach($recentPosts as $p)
                            <option value="{{ $p->id }}" {{ $p->id == $post->id ? 'selected' : '' }}>
                                {{ Str::limit($p->title, 25) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="studio-label"><i class="fa-solid fa-user-pen text-danger me-1"></i> প্রতিবেদক (Reporter / Author)</label>
                    <input type="text" id="live_category_input" class="studio-input" value="{{ !empty($post->reporter_name) ? $post->reporter_name : ($post->author_name ?? 'নিজস্ব প্রতিবেদক') }}" placeholder="প্রতিবেদকের নাম লিখুন...">
                </div>

                <div>
                    <label class="studio-label">ইমেজ থেকে উপরে উচ্চতা (Bottom Offset)</label>
                    <div class="slider-wrapper">
                        <input type="range" class="studio-range" id="reporterBottomSlider" min="0" max="80" value="{{ $cardSettings['reporter_badge_bottom'] ?? 25 }}" oninput="setReporterBadgeBottom(this.value)">
                        <span class="slider-val-badge" id="reporterBottomBadge">{{ $cardSettings['reporter_badge_bottom'] ?? 25 }}px</span>
                    </div>
                </div>

                <div id="headlineControlGroup" style="display: {{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'none' : 'block' }};">
                    <label class="studio-label"><i class="fa-solid fa-heading text-danger me-1"></i> কাস্টম শিরোনাম (News Caption)</label>
                    <textarea id="live_headline_input" class="studio-input" rows="3" style="resize: none;" placeholder="শিরোনাম টাইপ করুন...">{{ $post->title }}</textarea>
                    <div class="char-count-wrapper">
                        <span>অক্ষর সংখ্যা: <span id="charCount" class="char-count-badge">0</span></span>
                    </div>

                    <!-- Breaking News Sub-excerpt (only for Breaking style) -->
                    <div id="breakingExcerptControlGroup" class="mt-2" style="display: {{ ($cardSettings['card_style'] ?? '') === 'breaking' ? 'block' : 'none' }};">
                        <label class="studio-label"><i class="fa-solid fa-align-left text-danger me-1"></i> সাব-শিরোনাম / পোস্ট এক্সার্প্ট (Sub-Excerpt)</label>
                        <textarea id="live_breaking_excerpt_input" class="studio-input" rows="3" style="resize: none;" placeholder="পোস্টের বিবরণ বা সারসংক্ষেপ...">{{ !empty($post->excerpt) ? trim($post->excerpt) : (!empty($post->content) ? Str::limit(strip_tags($post->content), 180) : '') }}</textarea>
                    </div>
                </div>

                <!-- Quote & Breaking Photo/Speaker Controls -->
                <div id="quoteSidebarControls" style="display: {{ in_array($cardSettings['card_style'] ?? '', ['quote', 'breaking']) ? 'block' : 'none' }};">
                    <!-- Speaker fields only for Quote style -->
                    <div id="quoteSpeakerFields" style="display: {{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'block' : 'none' }};">
                        <div>
                            <label class="studio-label"><i class="fa-solid fa-quote-left text-danger me-1"></i> উক্তি / বক্তব্য (News Excerpt)</label>
                            <textarea id="live_quote_input" class="studio-input" rows="4" style="resize: none;" placeholder="উক্তি বা বক্তব্য টাইপ করুন...">{{ !empty($post->excerpt) ? trim($post->excerpt) : (!empty($post->content) ? Str::limit(strip_tags($post->content), 180) : $post->title) }}</textarea>
                        </div>

                        <div class="row g-2 mt-2">
                            <div class="col-6">
                                <label class="studio-label mb-1" style="font-size: 11px;"><i class="fa-solid fa-user me-1 text-danger"></i> বক্তার নাম</label>
                                <input type="text" id="live_speaker_name_input" class="studio-input" style="height: 34px; font-size: 12px;" value="— {{ !empty($post->reporter_name) ? $post->reporter_name : ($post->author_name ?? 'বক্তার নাম') }}">
                            </div>
                            <div class="col-6">
                                <label class="studio-label mb-1" style="font-size: 11px;"><i class="fa-solid fa-id-badge me-1 text-danger"></i> পদবি / পরিচয়</label>
                                <input type="text" id="live_speaker_title_input" class="studio-input" style="height: 34px; font-size: 12px;" value="পদবি / পরিচয় এখানে লিখুন">
                            </div>
                        </div>
                    </div>

                    <!-- Photo Display Mode (Normal vs Cutout) for Quote & Breaking -->
                    <div id="photoModeGroup" class="mt-3 pt-2" style="border-top: 1px dashed #334155;">
                        <label class="studio-label mb-1" style="font-size: 11px;">
                            <i class="fa-regular fa-image text-danger me-1"></i> <span id="photoModeLabel">{{ ($cardSettings['card_style'] ?? '') === 'breaking' ? 'নিউজ ছবির মোড (Display Mode)' : 'বক্তার ছবির মোড (Display Mode)' }}</span>
                        </label>
                        <div class="btn-group w-100 mb-2" role="group">
                            <button type="button" class="btn btn-sm btn-outline-secondary {{ empty($cardSettings['quote_cutout_mode']) ? 'active' : '' }}" id="modeNormalBtn" onclick="setQuotePhotoMode('normal')">
                                <i class="fa-regular fa-square me-1"></i> নরমাল মোড (আগের মতো)
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary {{ !empty($cardSettings['quote_cutout_mode']) ? 'active' : '' }}" id="modeCutoutBtn" onclick="setQuotePhotoMode('cutout')">
                                <i class="fa-solid fa-wand-magic-sparkles me-1 text-warning"></i> কাটআউট মোড (ফুল উইথ)
                            </button>
                        </div>

                        <label for="quote_speaker_file_input" class="bg-upload-zone py-2 px-3 mt-1" style="cursor: pointer; background: #0f172a; border: 1.5px dashed #475569; border-radius: 8px;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-cloud-arrow-up text-warning" style="font-size: 1.3rem;"></i>
                                <div class="text-start">
                                    <div style="font-size: 0.8rem; font-weight: 700; color: #f1f5f9;">ছবি আপলোড করুন</div>
                                    <div id="photoUploadSubtext" style="font-size: 0.68rem; color: #94a3b8;">{{ ($cardSettings['card_style'] ?? '') === 'breaking' ? 'সংবাদের সাধারণ ছবি বা স্বচ্ছ কাটআউট PNG ফাইল' : 'সাধারণ ছবি বা স্বচ্ছ কাটআউট PNG ফাইল' }}</div>
                                </div>
                            </div>
                            <img id="quote_speaker_thumb" class="bg-upload-preview mt-2" src="" style="display: none; height: 50px; object-fit: contain;">
                        </label>
                        <input type="file" id="quote_speaker_file_input" accept="image/*" style="display: none;" onchange="previewQuoteSpeakerImage(this)">

                        <!-- Cutout Adjustment Controls -->
                        <div id="cutoutSlidersBox" class="mt-2 p-2 rounded" style="display: {{ !empty($cardSettings['quote_cutout_mode']) ? 'block' : 'none' }}; background: rgba(15, 23, 42, 0.6); border: 1px solid #1e293b;">
                            <div class="row g-2">
                                <div class="col-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="studio-label mb-0" style="font-size: 10px;">সাইজ (জুম)</label>
                                        <span class="slider-val-badge" id="quoteScaleBadge" style="font-size: 9px; padding: 1px 3px;">{{ $cardSettings['quote_img_scale'] ?? 100 }}%</span>
                                    </div>
                                    <input type="range" class="studio-range" id="quoteScaleSlider" min="50" max="180" value="{{ $cardSettings['quote_img_scale'] ?? 100 }}" oninput="setQuoteImgScale(this.value)">
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="studio-label mb-0" style="font-size: 10px;">উপরে/নিচে</label>
                                        <span class="slider-val-badge" id="quoteYBadge" style="font-size: 9px; padding: 1px 3px;">{{ $cardSettings['quote_img_y'] ?? 0 }}px</span>
                                    </div>
                                    <input type="range" class="studio-range" id="quoteYSlider" min="-180" max="180" value="{{ $cardSettings['quote_img_y'] ?? 0 }}" oninput="setQuoteImgY(this.value)">
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="studio-label mb-0" style="font-size: 10px;">ডানে/বামে</label>
                                        <span class="slider-val-badge" id="quoteXBadge" style="font-size: 9px; padding: 1px 3px;">{{ $cardSettings['quote_img_x'] ?? 0 }}px</span>
                                    </div>
                                    <input type="range" class="studio-range" id="quoteXSlider" min="-300" max="300" value="{{ $cardSettings['quote_img_x'] ?? 0 }}" oninput="setQuoteImgX(this.value)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: ফন্ট ও টেক্সট স্টাইল -->
            <div class="inspector-section">
                <span class="section-title">
                    <i class="fa-solid fa-font"></i> ফন্ট ও টেক্সট স্টাইল
                </span>

                <div>
                    <label class="studio-label">ফন্ট ফ্যামিলি</label>
                    <select class="studio-select" id="font_switcher" onchange="changeFontFamily(this.value)">
                        <option value="'Noto Sans Bengali', sans-serif" selected>Noto Sans (ক্লিন)</option>
                        <option value="'Baloo Da 2', sans-serif">Baloo Da 2 (রাউন্ডেড)</option>
                        <option value="'Anek Bangla', sans-serif">Anek Bangla (মডার্ন)</option>
                        <option value="'Tiro Bangla', serif">Tiro Bangla (পত্রিকা স্টাইল)</option>
                        <option value="'Hind Siliguri', sans-serif">Hind Siliguri</option>
                        <option value="'Mina', sans-serif">Mina</option>
                        <option value="'Galada', cursive">Galada (স্টাইলিশ)</option>
                    </select>
                </div>

                <div>
                    <label class="studio-label">ফন্ট সাইজ</label>
                    <div class="slider-wrapper">
                        <input type="range" class="studio-range" id="fontSizeSlider" min="40" max="80" value="52" step="1" oninput="updateFontSize(this.value)">
                        <span class="slider-val-badge" id="fontSizeBadge">52px</span>
                    </div>
                </div>

                <div>
                    <label class="studio-label">লাইন হাইট (স্পেসিং)</label>
                    <div class="slider-wrapper">
                        <input type="range" class="studio-range" id="lineHeightSlider" min="1.0" max="1.6" value="1.3" step="0.05" oninput="updateLineHeight(this.value)">
                        <span class="slider-val-badge" id="lineHeightBadge">1.3</span>
                    </div>
                </div>

                <div>
                    <label class="studio-label">শিরোনামের অ্যালাইনমেন্ট</label>
                    <div class="btn-group w-100" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="alignLeftBtn" onclick="setHeadlineAlignment('left')">
                            <i class="fa-solid fa-align-left me-1"></i> বামে
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary active" id="alignCenterBtn" onclick="setHeadlineAlignment('center')">
                            <i class="fa-solid fa-align-center me-1"></i> মাঝে (সেন্টার)
                        </button>
                    </div>
                </div>

                <div>
                    <label class="studio-label">টেক্সট কালার (সিলেক্টেড অংশ)</label>
                    <div class="color-swatch-wrapper">
                        <div class="color-swatch" style="background: #ffffff;" onclick="applyQuickColor('#ffffff')" title="সাদা"></div>
                        <div class="color-swatch" style="background: #f39c12;" onclick="applyQuickColor('#f39c12')" title="সোনালী"></div>
                        <div class="color-swatch" style="background: #ef4444;" onclick="applyQuickColor('#ef4444')" title="লাল"></div>
                        <div class="color-swatch" style="background: #10b981;" onclick="applyQuickColor('#10b981')" title="সবুজ"></div>
                        <div class="color-swatch" style="background: #0ea5e9;" onclick="applyQuickColor('#0ea5e9')" title="আকাশী"></div>
                        <input type="color" class="color-picker-studio" id="colorPicker" oninput="changeSelectedColor(this.value)" value="#ffffff" title="কাস্টম কালার">
                    </div>
                </div>
            </div>

            <!-- Section 3: কার্ড কালার ও থিম (Card Color Themes) -->
            <div class="inspector-section">
                <span class="section-title">
                    <i class="fa-solid fa-palette"></i> কার্ড কালার ও থিম
                </span>

                <div>
                    <label class="studio-label"><i class="fa-solid fa-swatchbook text-danger me-1"></i> ব্যাকগ্রাউন্ড কালার থিম</label>
                    <div class="card-theme-grid">
                        <button type="button" class="btn-theme-preset active" data-theme="royal" onclick="applyCardTheme('royal')">
                            <span class="theme-dot" style="background: linear-gradient(135deg, #1e3a8a, #0f172a);"></span>
                            <span>রয়েল ব্লু</span>
                        </button>
                        <button type="button" class="btn-theme-preset" data-theme="crimson" onclick="applyCardTheme('crimson')">
                            <span class="theme-dot" style="background: linear-gradient(135deg, #990000, #3a0000);"></span>
                            <span>জার্নাল রেড</span>
                        </button>
                        <button type="button" class="btn-theme-preset" data-theme="midnight" onclick="applyCardTheme('midnight')">
                            <span class="theme-dot" style="background: linear-gradient(135deg, #18181b, #09090b);"></span>
                            <span>মিডনাইট ব্ল্যাক</span>
                        </button>
                        <button type="button" class="btn-theme-preset" data-theme="navy" onclick="applyCardTheme('navy')">
                            <span class="theme-dot" style="background: linear-gradient(135deg, #1e293b, #0a0f1d);"></span>
                            <span>নেভি ব্লু</span>
                        </button>
                        <button type="button" class="btn-theme-preset" data-theme="emerald" onclick="applyCardTheme('emerald')">
                            <span class="theme-dot" style="background: linear-gradient(135deg, #064e3b, #022c22);"></span>
                            <span>গাঢ় সবুজ</span>
                        </button>
                        <button type="button" class="btn-theme-preset" data-theme="maroon" onclick="applyCardTheme('maroon')">
                            <span class="theme-dot" style="background: linear-gradient(135deg, #581c87, #2e1065);"></span>
                            <span>ডিপ মেরুন</span>
                        </button>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="studio-label">কাস্টম ব্যাকগ্রাউন্ড কালার</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="color" class="color-picker-studio" id="customBgColor" value="#1e3a8a" oninput="setCustomCardBg(this.value)">
                        <input type="text" class="studio-input py-1 px-2" id="customBgHex" value="#1e3a8a" style="font-size: 0.8rem; height: 32px;" onchange="setCustomCardBg(this.value)">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="studio-label">তারিখ ও ডিটেইলস কালার</label>
                    <div class="color-swatch-wrapper">
                        <div class="color-swatch" style="background: #38bdf8;" onclick="setCardDateColor('#38bdf8')" title="রয়েল স্কাই"></div>
                        <div class="color-swatch" style="background: #ffd700;" onclick="setCardDateColor('#ffd700')" title="সোনালী"></div>
                        <div class="color-swatch" style="background: #ffffff;" onclick="setCardDateColor('#ffffff')" title="সাদা"></div>
                        <div class="color-swatch" style="background: #ef4444;" onclick="setCardDateColor('#ef4444')" title="লাল"></div>
                        <div class="color-swatch" style="background: #34d399;" onclick="setCardDateColor('#34d399')" title="হালকা সবুজ"></div>
                        <input type="color" class="color-picker-studio" id="dateColorPicker" oninput="setCardDateColor(this.value)" value="#38bdf8" title="কাস্টম কালার">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="studio-label">ডিভাইডার বর্ডার কালার</label>
                    <div class="color-swatch-wrapper">
                        <div class="color-swatch" style="background: #38bdf8;" onclick="setCardBorderColor('#38bdf8')" title="রয়েল স্কাই"></div>
                        <div class="color-swatch" style="background: #ffd700;" onclick="setCardBorderColor('#ffd700')" title="সোনালী"></div>
                        <div class="color-swatch" style="background: #ef4444;" onclick="setCardBorderColor('#ef4444')" title="লাল"></div>
                        <div class="color-swatch" style="background: #ffffff;" onclick="setCardBorderColor('#ffffff')" title="সাদা"></div>
                        <div class="color-swatch" style="background: #0ea5e9;" onclick="setCardBorderColor('#0ea5e9')" title="নীল"></div>
                        <input type="color" class="color-picker-studio" id="borderColorPicker" oninput="setCardBorderColor(this.value)" value="#38bdf8" title="কাস্টম কালার">
                    </div>
                </div>
            </div>

            <!-- Section 4: ছবির ফ্রেম ও পজিশনিং -->
            <div class="inspector-section">
                <span class="section-title" id="imageSectionTitle">
                    <i class="fa-regular fa-image"></i> {{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'বক্তার ছবি ও পজিশন' : 'ছবির ফ্রেম ও পজিশন' }}
                </span>

                <div>
                    <label class="studio-label" id="bgUploadLabel">{{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'বক্তার ছবি পরিবর্তন (PNG Cutout)' : 'ব্যাকগ্রাউন্ড ছবি পরিবর্তন' }}</label>
                    <label for="social_card_image" class="bg-upload-zone">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span id="bgUploadPrompt" style="font-size: 0.8rem; font-weight: 700;">{{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'বক্তার পিএনজি আপলোড করুন' : 'নতুন ব্যাকগ্রাউন্ড আপলোড করুন' }}</span>
                        <span style="font-size: 0.7rem; color:#64748b;">(JPG, PNG, WebP supported)</span>
                        <img id="bg_thumb_preview" class="bg-upload-preview" src="" style="display: none;">
                    </label>
                    <input type="file" id="social_card_image" accept="image/*" style="display: none;" onchange="previewSocialCardImage(this)">
                </div>

                <div class="mt-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="studio-label mb-0"><i class="fa-solid fa-arrows-up-down text-danger me-1"></i> ছবির ভার্টিক্যাল পজিশন (প্যান)</label>
                        <span class="slider-val-badge" id="imgPanBadge">50%</span>
                    </div>
                    <div class="slider-wrapper">
                        <input type="range" class="studio-range" id="imgPanSlider" min="0" max="100" value="50" oninput="setImagePan(this.value)">
                    </div>
                    <div class="d-flex justify-content-between text-muted mt-1" style="font-size: 10px;">
                        <span>শীর্ষ (Top)</span>
                        <span>মধ্য (Center)</span>
                        <span>নিচ (Bottom)</span>
                    </div>
                </div>
            </div>

            <!-- Section 5: কুইক ডাউনলোড ও ফেসবুক পোস্ট -->
            <div class="inspector-section" style="background: transparent; border: none; padding: 0;">
                <button type="button" onclick="download_SocialCard(event)" class="download-gradient-btn">
                    <i class="fa-solid fa-download" style="font-size: 1.1rem;"></i>  কার্ডটি সেভ করুন
                </button>

                <button type="button" onclick="shareOnFacebook(event)" class="btn-facebook-share mt-2">
                    <i class="fa-brands fa-facebook" style="font-size: 1.15rem;"></i> ফেসবুকে পোস্ট করুন
                </button>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-secondary w-100 justify-content-center" style="border-radius: 8px; font-size: 0.85rem; font-weight: 600;">
                        <i class="fa-solid fa-pen-to-square"></i> সংবাদ সম্পাদনা
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Studio Canvas Workspace (Right side) -->
    <div class="canvas-workspace" id="canvasWorkspace">
        <!-- Toggle button to open/close inspector panel on mobile or desktop -->
        <button class="toggle-studio-panel-btn" id="togglePanelBtn" onclick="toggleInspectorPanel()" title="প্যানেল লুকান/দেখান">
            <i class="fa-solid fa-sliders" id="togglePanelIcon"></i>
        </button>



        <!-- 1080x1080 Canvas Scaled Box -->
        <div class="scale-container" id="scaleContainer">
            <!-- Figma-like crop marks and guidelines -->
            <div class="canvas-guide guide-tl"></div>
            <div class="canvas-guide guide-tr"></div>
            <div class="canvas-guide guide-bl"></div>
            <div class="canvas-guide guide-br"></div>
            <div class="canvas-resolution-badge"><i class="fa-solid fa-vector-square text-danger me-1"></i> ১০৮০ × ১০৮০ পিক্সেল (১:১)</div>

            <div id="social_card_node" class="news-card-1080 style-{{ $cardSettings['card_style'] ?? 'classic' }}">
                <!-- Quote Style Background Texture (Style 3) -->
                <div class="quote-card-texture" id="quoteCardTexture"></div>

                <!-- Quote Style Vertical Side Column (Style 3) -->
                <div class="quote-side-column" id="quoteSideColumn"></div>

                <!-- Top Right Corner Profile/Emblem Logo (attached to top edge) -->
                <div class="card-top-right-logo" id="cardTopLogo">
                    <img id="cornerLogoImg" src="{{ !empty($cardSettings['corner_logo_image']) ? asset($cardSettings['corner_logo_image']) : asset('BJ_Content/Profile Pic b.png') }}" alt="Daily Bhola Journal" crossorigin="anonymous" class="{{ !empty($cardSettings['corner_logo_shadow']) || !isset($cardSettings['corner_logo_shadow']) ? 'logo-shadow-effect' : 'no-shadow' }}">
                </div>

                <!-- Breaking News Header Strip (Style 4) -->
                <div class="breaking-news-header" id="breakingNewsHeader">
                    <div class="breaking-tag">
                        <span class="live-dot"></span>
                        <span>ব্রেকিং নিউজ</span>
                    </div>
                    <div class="breaking-bar-marquee">
                        <span>দৈনিক ভোলা জার্নাল • জরুরি সংবাদ বুলেটিন</span>
                    </div>
                </div>

                <!-- News Image Section -->
                <div class="news-image-wrapper {{ !empty($cardSettings['quote_cutout_mode']) ? 'quote-cutout-mode' : '' }}" id="newsImageWrapper">
                    @if($post->social_card_image)
                        <img src="{{ $post->social_card_image_url }}" class="news-image" id="cardImagePreview" crossorigin="anonymous" style="object-position: center 50%;">
                    @elseif($post->featured_image)
                        <img src="{{ $post->featured_image_url }}" class="news-image" id="cardImagePreview" crossorigin="anonymous" style="object-position: center 50%;">
                    @else
                        <img src="" class="news-image" id="cardImagePreview" crossorigin="anonymous" style="display: none; object-position: center 50%;">
                        <div id="cardImagePlaceholder" style="width:100%; height:100%; background:#1e293b; display: flex; flex-direction: column; align-items: center; justify-content: center; color: rgba(255,255,255,0.4); gap: 10px;">
                            <i class="fa-regular fa-image" style="font-size: 50px;"></i>
                            <span style="font-family:'Noto Sans Bengali',sans-serif; font-size: 18px; font-weight:700;">ইমেজ পাওয়া যায়নি</span>
                        </div>
                    @endif

                    <!-- Reporter Badge on News Image (Left Bottom) -->
                    <div class="card-reporter-badge-wrapper" id="reporterBadgeWrapper" style="bottom: {{ $cardSettings['reporter_badge_bottom'] ?? 25 }}px; display: {{ !empty($cardSettings['category_badge_visible']) || !isset($cardSettings['category_badge_visible']) ? 'flex' : 'none' }};">
                        <span class="card-category-badge card-reporter-badge" id="cardCategoryPreview" contenteditable="true" spellcheck="false" style="background: {{ $cardSettings['category_badge_color'] ?? '#dc2626' }};">{{ !empty($post->reporter_name) ? $post->reporter_name : ($post->author_name ?? 'নিজস্ব প্রতিবেদক') }}</span>
                    </div>
                </div>

                <!-- Bottom Content Section -->
                <div class="bottom-content-wrapper" id="bottomContentWrapper">
                    <!-- Watermark Logo positioned down behind text -->
                    @if(!empty($themeSettings['logo_image']))
                        <img src="{{ asset($themeSettings['logo_image']) }}" alt="Watermark" class="text-area-watermark" id="cardWatermarkImg" crossorigin="anonymous">
                    @elseif(file_exists(public_path('BJ_Content/Text Logo.png')))
                        <img src="{{ asset('BJ_Content/Text Logo.png') }}" alt="Watermark" class="text-area-watermark" id="cardWatermarkImg" crossorigin="anonymous">
                    @endif

                    <!-- Quote Symbol Badge (Style 3) -->
                    <div class="quote-symbol-badge" id="quoteSymbolBadge">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>

                    <!-- Breaking News Live Pill Badge (Style 4) -->
                    <div class="breaking-badge-pill" id="breakingBadgePill">
                        <span class="live-dot"></span>
                        <span>ব্রেকিং নিউজ</span>
                    </div>

                    @php
                        $currStyle = $cardSettings['card_style'] ?? 'classic';
                        $posterLogoPos = $cardSettings['style_settings']['poster']['logo_position'] ?? ($cardSettings['corner_logo_position'] ?? 'right');
                        $metaJustify = 'center';
                        if ($currStyle === 'classic') {
                            $metaJustify = 'flex-start';
                        } elseif ($currStyle === 'poster') {
                            $metaJustify = ($posterLogoPos === 'left') ? 'flex-end' : 'flex-start';
                        } elseif ($currStyle === 'quote' || $currStyle === 'breaking') {
                            $metaJustify = 'flex-end';
                        } else {
                            $metaJustify = (($cardSettings['headline_align'] ?? 'center') === 'left') ? 'flex-start' : 'center';
                        }
                    @endphp
                    <!-- Meta Row: Bengali Date -->
                    <div class="meta-row" id="cardMetaRow" style="justify-content: {{ $metaJustify }};">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-regular fa-calendar-days" id="cardDateIcon" style="color: {{ $cardSettings['date_color'] ?? '#38bdf8' }}; font-size: 20px;"></i>
                            <div class="news-date" id="cardDatePreview" contenteditable="true" spellcheck="false">
                                তারিখ...
                            </div>
                        </div>
                    </div>

                    <div class="headline-wrapper" id="cardHeadlineWrapper">
                        <div class="news-headline" id="editable_headline" contenteditable="true" spellcheck="false">
                            {{ $post->title }}
                        </div>

                        <!-- Breaking News Sub-Excerpt (Style 4: "sub kore post expict thakbe niche") -->
                        <div class="breaking-excerpt-text" id="editable_breaking_excerpt" contenteditable="true" spellcheck="false">
                            {{ !empty($post->excerpt) ? trim($post->excerpt) : (!empty($post->content) ? Str::limit(strip_tags($post->content), 180) : '') }}
                        </div>

                        <!-- Quote Excerpt Text (Style 3) -->
                        <div class="quote-excerpt-text" id="editable_quote_text" contenteditable="true" spellcheck="false">
                            {{ !empty($post->excerpt) ? trim($post->excerpt) : (!empty($post->content) ? Str::limit(strip_tags($post->content), 180) : $post->title) }}
                        </div>

                        <!-- Quote Speaker Name & Title (Style 3) -->
                        <div class="quote-speaker-wrapper" id="quoteSpeakerWrapper">
                            <div class="quote-speaker-name" id="quoteSpeakerName" contenteditable="true" spellcheck="false">
                                — {{ !empty($post->reporter_name) ? $post->reporter_name : ($post->author_name ?? 'বক্তার নাম') }}
                            </div>
                            <div class="quote-speaker-title" id="quoteSpeakerTitle" contenteditable="true" spellcheck="false">
                                পদবি / পরিচয় এখানে লিখুন
                            </div>
                        </div>
                    </div>

                    <div class="details-hint" id="cardDetailsHint" contenteditable="true" spellcheck="false">
                        বিস্তারিত কমেন্টে......
                    </div>
                </div>

                <!-- Advertisement bottom bar (Default) -->
                <div class="full-width-ad-bar" id="main_ad_bar">
                    <img id="mainAdImage" src="{{ asset('BJ_Content/ads.png') }}" alt="Default Ad" crossorigin="anonymous">
                </div>

                <!-- Official Brand Website Strip (Alternative to Ad Bar) -->
                <div class="official-brand-footer" id="official_brand_footer" style="display: none;">
                    <div class="brand-footer-left">
                        <div class="brand-logo-frame">
                            <img id="brandFooterLogoImg" src="{{ !empty($cardSettings['corner_logo_image']) ? asset($cardSettings['corner_logo_image']) : asset('BJ_Content/Profile Pic b.png') }}" class="brand-footer-icon" alt="Logo" crossorigin="anonymous">
                        </div>
                        <div class="brand-text-block">
                            <div class="brand-footer-title" id="brandFooterTitleText" contenteditable="true" spellcheck="false" title="ক্লিক করে নাম পরিবর্তন করুন">{{ $cardSettings['brand_title'] ?? 'দৈনিক ভোলা জার্নাল' }}</div>
                            <div class="brand-footer-tagline" id="brandFooterTaglineText" contenteditable="true" spellcheck="false" title="ক্লিক করে স্লোগান পরিবর্তন করুন">{{ $cardSettings['brand_tagline'] ?? 'সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর' }}</div>
                        </div>
                    </div>
                    <div class="brand-footer-center">
                        <div class="brand-pill-badge website-pill">
                            <div class="pill-icon-box web-icon"><i class="fa-solid fa-globe"></i></div>
                            <span class="brand-pill-text" id="brandFooterWebText" contenteditable="true" spellcheck="false" title="ক্লিক করে ওয়েবসাইট লিংক পরিবর্তন করুন">{{ $cardSettings['brand_web'] ?? 'dailybholajournal.com' }}</span>
                        </div>
                    </div>
                    <div class="brand-footer-right">
                        <div class="brand-pill-badge social-pill">
                            <div class="d-flex align-items-center gap-1">
                                <div class="pill-icon-box fb-icon" title="ফেসবুক"><i class="fa-brands fa-facebook-f"></i></div>
                                <div class="pill-icon-box yt-icon" title="ইউটিউব"><i class="fa-brands fa-youtube"></i></div>
                            </div>
                            <span class="brand-pill-text" id="brandFooterFbText" contenteditable="true" spellcheck="false" title="ক্লিক করে সোশ্যাল হ্যান্ডেল পরিবর্তন করুন">{{ $cardSettings['brand_social'] ?? '/dailybholajournalBN' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Settings Gear Modal: Logo, Ads & Card Options -->
<div class="modal fade" id="cardSettingsModal" tabindex="-1" aria-labelledby="cardSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content studio-modal-content">
            <div class="modal-header border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="gear-icon-box">
                        <i class="fa-solid fa-gear text-danger"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-bangla mb-0" id="cardSettingsModalLabel" style="font-weight: 700;">মাস্টার কার্ড সেটিংস (Global Defaults)</h5>
                        <small class="text-muted">ব্র্যান্ড লোগো, বিজ্ঞাপন/ফুটার, ডিফল্ট থিম ও টাইপোগ্রাফি স্থায়ীভাবে কনফিগার করুন</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-info py-2 px-3 mb-3 d-flex align-items-center gap-2" style="font-size: 0.82rem; border-radius: 8px;">
                    <i class="fa-solid fa-circle-info text-info fs-6"></i>
                    <span>এখানে সংরক্ষিত সব সেটিংস আপনার পোর্টালের সব কার্ডের জন্য ডিফল্ট হিসেবে সংরক্ষিত থাকবে।</span>
                </div>

                <!-- Nav tabs -->
                <ul class="nav nav-pills custom-studio-tabs mb-4" id="settingsTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="style-tab" data-bs-toggle="pill" data-bs-target="#tab-style" type="button" role="tab">
                            <i class="fa-solid fa-shapes me-1 text-danger"></i> কার্ড ডিজাইন স্টাইল
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="logo-tab" data-bs-toggle="pill" data-bs-target="#tab-logo" type="button" role="tab">
                            <i class="fa-solid fa-award me-1 text-danger"></i> ব্র্যান্ড ও লোগো
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ads-tab" data-bs-toggle="pill" data-bs-target="#tab-ads" type="button" role="tab">
                            <i class="fa-solid fa-rectangle-ad me-1 text-primary"></i> ফুটার ও বিজ্ঞাপন
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="theme-tab" data-bs-toggle="pill" data-bs-target="#tab-theme" type="button" role="tab">
                            <i class="fa-solid fa-palette me-1 text-warning"></i> থিম ও কালার
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="typo-tab" data-bs-toggle="pill" data-bs-target="#tab-typo" type="button" role="tab">
                            <i class="fa-solid fa-font me-1 text-info"></i> টাইপোগ্রাফি
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="layout-tab" data-bs-toggle="pill" data-bs-target="#tab-layout" type="button" role="tab">
                            <i class="fa-solid fa-sliders me-1 text-success"></i> লেআউট ও ব্যাজ
                        </button>
                    </li>
                </ul>

                <!-- Tab content -->
                <div class="tab-content">
                    <!-- Tab 0: Card Style -->
                    <div class="tab-pane fade show active" id="tab-style" role="tabpanel">
                        <div class="alert alert-light border py-2 px-3 mb-3 d-flex align-items-center justify-content-between" style="border-radius: 8px;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-shapes text-danger fs-5"></i>
                                <div>
                                    <strong class="d-block" style="font-size: 0.88rem;">ডিফল্ট কার্ড ডিজাইন স্টাইল নির্বাচন করুন</strong>
                                    <small class="text-muted">যেকোনো স্টাইলে ক্লিক করলে ক্যানভাসে সাথে সাথে প্রিভিউ দেখা যাবে এবং সেভ করলে ডিফল্ট কার্যকর থাকবে।</small>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Style 1: Classic Split -->
                            <div class="col-md-6">
                                <div class="modal-style-card {{ ($cardSettings['card_style'] ?? 'classic') === 'classic' ? 'active' : '' }}" data-style="classic" onclick="setCardStyle('classic')">
                                    <div class="style-check-icon"><i class="fa-solid fa-check"></i></div>
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="style-thumb-box thumb-classic" style="width: 100px; height: 75px; flex-shrink: 0; margin-bottom: 0;">
                                            <div class="thumb-top-img"></div>
                                            <div class="thumb-bottom-card">
                                                <div class="thumb-line-sm"></div>
                                                <div class="thumb-line-lg"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">১. ক্লাসিক স্প্লিট (Classic)</span>
                                                <span class="style-badge-tag tag-blue">ডিফল্ট</span>
                                            </div>
                                            <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.35;">
                                                উপরের অংশে মূল নিউজ ছবি এবং নিচের অংশে ব্যাকগ্রাউন্ড কালারে আকর্ষণীয় বড় হেডলাইন, রিপোর্টার ব্যাজ ও তারিখ।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Style 2: Full Poster Overlay -->
                            <div class="col-md-6">
                                <div class="modal-style-card {{ ($cardSettings['card_style'] ?? '') === 'poster' ? 'active' : '' }}" data-style="poster" onclick="setCardStyle('poster')">
                                    <div class="style-check-icon"><i class="fa-solid fa-check"></i></div>
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="style-thumb-box thumb-poster" style="width: 100px; height: 75px; flex-shrink: 0; margin-bottom: 0;">
                                            <div class="thumb-full-img"></div>
                                            <div class="thumb-scrim">
                                                <div class="thumb-line-lg"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">২. ফুল পোস্টার (Poster)</span>
                                                <span class="style-badge-tag tag-purple">সিনেমাটিক</span>
                                            </div>
                                            <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.35;">
                                                ১০৮০x১০৮০ সম্পূর্ণ ক্যানভাস জুড়ে ফুল ব্যাকগ্রাউন্ড ছবি, নিচে সিনেমাটিক ডার্ক শেড গ্রেডিয়েন্ট এবং হেডলাইন।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Style 3: Quote / Statement -->
                            <div class="col-md-6">
                                <div class="modal-style-card {{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'active' : '' }}" data-style="quote" onclick="setCardStyle('quote')">
                                    <div class="style-check-icon"><i class="fa-solid fa-check"></i></div>
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="style-thumb-box thumb-quote" style="width: 100px; height: 75px; flex-shrink: 0; margin-bottom: 0;">
                                            <div class="thumb-quote-img"></div>
                                            <div class="thumb-quote-card">
                                                <i class="fa-solid fa-quote-left thumb-quote-icon"></i>
                                                <div class="thumb-line-lg"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">৩. উক্তি / বক্তব্য (Quote)</span>
                                                <span class="style-badge-tag tag-amber">কোটেশন</span>
                                            </div>
                                            <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.35;">
                                                বিশিষ্ট ব্যক্তিদের সাক্ষাৎকার, বক্তব্য বা উক্তির জন্য। সাধারণ ছবি বা স্বচ্ছ কাটআউট পিএনজি (Cutout PNG) ব্যাকগ্রাউন্ড সাপোর্ট করে।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Style 4: Breaking News Flash -->
                            <div class="col-md-6">
                                <div class="modal-style-card {{ ($cardSettings['card_style'] ?? '') === 'breaking' ? 'active' : '' }}" data-style="breaking" onclick="setCardStyle('breaking')">
                                    <div class="style-check-icon"><i class="fa-solid fa-check"></i></div>
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="style-thumb-box thumb-breaking" style="width: 100px; height: 75px; flex-shrink: 0; margin-bottom: 0;">
                                            <div class="thumb-break-bar"></div>
                                            <div class="thumb-break-img"></div>
                                            <div class="thumb-break-card">
                                                <div class="thumb-line-lg"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">৪. ব্রেকিং নিউজ (Breaking)</span>
                                                <span class="style-badge-tag tag-red">জরুরি সংবাদ</span>
                                            </div>
                                            <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.35;">
                                                জরুরি ও ব্রেকিং নিউজের বিশেষ কোটেশন-স্টাইল লেআউট, আকর্ষণীয় বড় হেডলাইন এবং সংবাদের সাব-ক্যাপশন এক্সসার্প্ট।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Per-Style Object Visibility & Logo Customization -->
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-sliders text-danger me-1"></i> প্রতিটি স্টাইলের আলাদা লোগো ও উপাদান দৃশ্যমানতা</h6>
                                    <small class="text-muted">নিচের যেকোনো স্টাইল নির্বাচন করে তার নিজস্ব লোগো ও উপাদানগুলো (Show/Hide) কনফিগার করুন</small>
                                </div>
                            </div>

                            <!-- Style Sub Tabs -->
                            <ul class="nav nav-pills custom-studio-tabs mb-3" id="styleCfgSubTabs" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link {{ ($cardSettings['card_style'] ?? 'classic') === 'classic' ? 'active' : '' }}" id="subtab-btn-classic" data-bs-toggle="pill" data-bs-target="#style-pane-classic" type="button" role="tab">
                                        <i class="fa-solid fa-table-columns text-primary me-1"></i> ক্লাসিক স্প্লিট
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link {{ ($cardSettings['card_style'] ?? '') === 'poster' ? 'active' : '' }}" id="subtab-btn-poster" data-bs-toggle="pill" data-bs-target="#style-pane-poster" type="button" role="tab">
                                        <i class="fa-regular fa-image text-purple me-1"></i> ফুল পোস্টার
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link {{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'active' : '' }}" id="subtab-btn-quote" data-bs-toggle="pill" data-bs-target="#style-pane-quote" type="button" role="tab">
                                        <i class="fa-solid fa-quote-left text-warning me-1"></i> উক্তি / বক্তব্য
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link {{ ($cardSettings['card_style'] ?? '') === 'breaking' ? 'active' : '' }}" id="subtab-btn-breaking" data-bs-toggle="pill" data-bs-target="#style-pane-breaking" type="button" role="tab">
                                        <i class="fa-solid fa-bolt text-danger me-1"></i> ব্রেকিং নিউজ
                                    </button>
                                </li>
                            </ul>

                            <!-- Style Sub Panes -->
                            <div class="tab-content">
                                @foreach(['classic' => 'ক্লাসিক স্প্লিট', 'poster' => 'ফুল পোস্টার', 'quote' => 'উক্তি / বক্তব্য', 'breaking' => 'ব্রেকিং নিউজ'] as $sKey => $sTitle)
                                    @php
                                        $sCfg = $cardSettings['style_settings'][$sKey] ?? [];
                                        $isActivePane = ($cardSettings['card_style'] ?? 'classic') === $sKey;
                                        $hasCustomLogo = !empty($sCfg['logo_image']);
                                        $styleLogo = $hasCustomLogo ? asset($sCfg['logo_image']) : ($sKey === 'poster' ? '' : (!empty($cardSettings['corner_logo_image']) ? asset($cardSettings['corner_logo_image']) : asset('BJ_Content/Profile Pic b.png')));
                                    @endphp
                                    <div class="tab-pane fade {{ $isActivePane ? 'show active' : '' }}" id="style-pane-{{ $sKey }}" role="tabpanel">
                                        <div class="row g-3">
                                            <!-- Column 1: Logo selection for this style -->
                                            <div class="col-md-6">
                                                <div class="settings-card h-100">
                                                    <div class="settings-card-header">
                                                        <div class="d-flex justify-content-between align-items-center w-100">
                                                            <span class="settings-card-title">
                                                                <i class="fa-solid fa-award text-danger me-1"></i> {{ $sTitle }} এর লোগো
                                                            </span>
                                                            <div class="form-check form-switch m-0">
                                                                <input class="form-check-input" type="checkbox" id="style_obj_{{ $sKey }}_logo" {{ !empty($sCfg['logo_visible']) ? 'checked' : '' }} onchange="toggleStyleObject('{{ $sKey }}', 'logo_visible', this.checked)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="settings-card-body">
                                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                            <div class="logo-preview-box" id="styleLogoBox_{{ $sKey }}" style="{{ empty($styleLogo) ? 'display: none;' : '' }}">
                                                                <img id="styleLogoPreview_{{ $sKey }}" src="{{ $styleLogo ?: asset('BJ_Content/Profile Pic b.png') }}" alt="{{ $sTitle }} Logo">
                                                            </div>
                                                            <div id="styleNoLogoBox_{{ $sKey }}" class="logo-preview-box d-flex flex-column align-items-center justify-content-center text-muted" style="{{ !empty($styleLogo) ? 'display: none;' : '' }}; font-size: 0.72rem; text-align: center; border: 2px dashed #475569; background: rgba(15, 23, 42, 0.6); padding: 4px;">
                                                                <i class="fa-solid fa-ban text-muted mb-1" style="font-size: 1.1rem;"></i>
                                                                <span>লোগো নেই</span>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <label class="btn btn-sm btn-outline-danger w-100 mb-1" for="style_logo_input_{{ $sKey }}" style="font-weight: 600; font-size: 0.8rem;">
                                                                    <i class="fa-solid fa-cloud-arrow-up me-1"></i> এই স্টাইলের জন্য আলাদা লোগো আপলোড
                                                                </label>
                                                                <input type="file" id="style_logo_input_{{ $sKey }}" accept="image/*" class="d-none" onchange="previewStyleLogo('{{ $sKey }}', this)">
                                                                <button type="button" class="btn btn-sm btn-link text-muted w-100 p-0 text-decoration-none" onclick="resetStyleLogo('{{ $sKey }}')" style="font-size: 0.75rem;">
                                                                    <i class="fa-solid fa-rotate-left me-1"></i> {{ $sKey === 'poster' ? 'লোগো রিমুভ / নিষ্ক্রিয় রাখুন' : 'মাস্টার/ডিফল্ট লোগো ব্যবহার করুন' }}
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label class="studio-label">লোগোর অবস্থান (Position)</label>
                                                            <div class="btn-group w-100" role="group">
                                                                <input type="radio" class="btn-check" name="style_pos_radio_{{ $sKey }}" id="style_pos_right_{{ $sKey }}" autocomplete="off" {{ ($sCfg['logo_position'] ?? 'right') === 'right' ? 'checked' : '' }} onchange="setStyleLogoPosition('{{ $sKey }}', 'right')">
                                                                <label class="btn btn-sm btn-outline-secondary" for="style_pos_right_{{ $sKey }}"><i class="fa-solid fa-align-right me-1"></i> ডান কোণে</label>

                                                                <input type="radio" class="btn-check" name="style_pos_radio_{{ $sKey }}" id="style_pos_left_{{ $sKey }}" autocomplete="off" {{ ($sCfg['logo_position'] ?? '') === 'left' ? 'checked' : '' }} onchange="setStyleLogoPosition('{{ $sKey }}', 'left')">
                                                                <label class="btn btn-sm btn-outline-secondary" for="style_pos_left_{{ $sKey }}"><i class="fa-solid fa-align-left me-1"></i> বাম কোণে</label>
                                                            </div>
                                                        </div>

                                                        <div class="mb-2 pt-2 border-top">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <label class="studio-label mb-0">লোগোর সাইজ (Size)</label>
                                                                <span class="badge bg-secondary" id="style_logo_size_badge_{{ $sKey }}">{{ $sCfg['logo_size'] ?? ($cardSettings['corner_logo_size'] ?? 135) }}px</span>
                                                            </div>
                                                            <div class="slider-wrapper">
                                                                <input type="range" class="studio-range" id="style_logo_size_slider_{{ $sKey }}" min="80" max="300" value="{{ $sCfg['logo_size'] ?? ($cardSettings['corner_logo_size'] ?? 135) }}" oninput="setStyleLogoSize('{{ $sKey }}', this.value)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Column 2: Object Visibility show/hide toggles -->
                                            <div class="col-md-6">
                                                <div class="settings-card h-100">
                                                    <div class="settings-card-header">
                                                        <span class="settings-card-title">
                                                            <i class="fa-solid fa-eye text-primary me-1"></i> {{ $sTitle }} এর বিভিন্ন অবজেক্ট (Show / Hide)
                                                        </span>
                                                    </div>
                                                    <div class="settings-card-body p-3">
                                                        <!-- Watermark toggle -->
                                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="fa-solid fa-droplet text-info" style="width: 18px;"></i>
                                                                <span style="font-size: 0.84rem; font-weight: 600;">টেক্সট ওয়াটারমার্ক লোগো</span>
                                                            </div>
                                                            <div class="form-check form-switch m-0">
                                                                <input class="form-check-input" type="checkbox" id="style_obj_{{ $sKey }}_watermark" {{ !empty($sCfg['watermark_visible']) ? 'checked' : '' }} onchange="toggleStyleObject('{{ $sKey }}', 'watermark_visible', this.checked)">
                                                            </div>
                                                        </div>

                                                        <!-- Reporter Badge toggle -->
                                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="fa-solid fa-id-badge text-danger" style="width: 18px;"></i>
                                                                <span style="font-size: 0.84rem; font-weight: 600;">রিপোর্টার / ক্যাটাগরি ব্যাজ</span>
                                                            </div>
                                                            <div class="form-check form-switch m-0">
                                                                <input class="form-check-input" type="checkbox" id="style_obj_{{ $sKey }}_badge" {{ !empty($sCfg['badge_visible']) ? 'checked' : '' }} onchange="toggleStyleObject('{{ $sKey }}', 'badge_visible', this.checked)">
                                                            </div>
                                                        </div>

                                                        <!-- Date Row toggle -->
                                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="fa-regular fa-calendar-days text-warning" style="width: 18px;"></i>
                                                                <span style="font-size: 0.84rem; font-weight: 600;">তারিখ ও ক্যালেন্ডার বার</span>
                                                            </div>
                                                            <div class="form-check form-switch m-0">
                                                                <input class="form-check-input" type="checkbox" id="style_obj_{{ $sKey }}_date" {{ !empty($sCfg['date_visible']) ? 'checked' : '' }} onchange="toggleStyleObject('{{ $sKey }}', 'date_visible', this.checked)">
                                                            </div>
                                                        </div>

                                                        <!-- Details Hint toggle -->
                                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="fa-solid fa-comment-dots text-secondary" style="width: 18px;"></i>
                                                                <span style="font-size: 0.84rem; font-weight: 600;">বিস্তারিত কমেন্টে হিন্ট</span>
                                                            </div>
                                                            <div class="form-check form-switch m-0">
                                                                <input class="form-check-input" type="checkbox" id="style_obj_{{ $sKey }}_hint" {{ !empty($sCfg['hint_visible']) ? 'checked' : '' }} onchange="toggleStyleObject('{{ $sKey }}', 'hint_visible', this.checked)">
                                                            </div>
                                                        </div>

                                                        <!-- Footer/Ad bar toggle -->
                                                        <div class="d-flex justify-content-between align-items-center py-2 {{ ($sKey === 'quote' || $sKey === 'breaking') ? 'border-bottom' : '' }}">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="fa-solid fa-rectangle-ad text-success" style="width: 18px;"></i>
                                                                <span style="font-size: 0.84rem; font-weight: 600;">বিজ্ঞাপন / ব্রান্ডিং ফুটার বার</span>
                                                            </div>
                                                            <div class="form-check form-switch m-0">
                                                                <input class="form-check-input" type="checkbox" id="style_obj_{{ $sKey }}_footer" {{ !empty($sCfg['footer_visible']) ? 'checked' : '' }} onchange="toggleStyleObject('{{ $sKey }}', 'footer_visible', this.checked)">
                                                            </div>
                                                        </div>

                                                        @if($sKey === 'quote')
                                                            <!-- Quote Symbol toggle -->
                                                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="fa-solid fa-quote-left text-warning" style="width: 18px;"></i>
                                                                    <span style="font-size: 0.84rem; font-weight: 600;">কোটেশন মার্ক আইকন (“)</span>
                                                                </div>
                                                                <div class="form-check form-switch m-0">
                                                                    <input class="form-check-input" type="checkbox" id="style_obj_{{ $sKey }}_quote_symbol" {{ ($sCfg['quote_symbol_visible'] ?? true) ? 'checked' : '' }} onchange="toggleStyleObject('{{ $sKey }}', 'quote_symbol_visible', this.checked)">
                                                                </div>
                                                            </div>

                                                            <!-- Speaker Info toggle -->
                                                            <div class="d-flex justify-content-between align-items-center py-2">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="fa-solid fa-user-tie text-info" style="width: 18px;"></i>
                                                                    <span style="font-size: 0.84rem; font-weight: 600;">বক্তার নাম ও পদবি</span>
                                                                </div>
                                                                <div class="form-check form-switch m-0">
                                                                    <input class="form-check-input" type="checkbox" id="style_obj_{{ $sKey }}_speaker" {{ ($sCfg['speaker_visible'] ?? true) ? 'checked' : '' }} onchange="toggleStyleObject('{{ $sKey }}', 'speaker_visible', this.checked)">
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if($sKey === 'breaking')
                                                            <!-- Breaking Excerpt toggle -->
                                                            <div class="d-flex justify-content-between align-items-center py-2">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="fa-solid fa-align-left text-danger" style="width: 18px;"></i>
                                                                    <span style="font-size: 0.84rem; font-weight: 600;">সংবাদের সাব-ক্যাপশন এক্সসার্প্ট</span>
                                                                </div>
                                                                <div class="form-check form-switch m-0">
                                                                    <input class="form-check-input" type="checkbox" id="style_obj_{{ $sKey }}_excerpt" {{ ($sCfg['excerpt_visible'] ?? true) ? 'checked' : '' }} onchange="toggleStyleObject('{{ $sKey }}', 'excerpt_visible', this.checked)">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Tab 1: Logo -->
                    <div class="tab-pane fade" id="tab-logo" role="tabpanel">
                        <div class="row g-3">
                            <!-- 1. Corner Logo Card -->
                            <div class="col-md-6">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="settings-card-title"><i class="fa-solid fa-circle-dot text-danger me-1"></i> কর্নার প্রোফাইল লোগো</span>
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" id="toggleCornerLogo" checked onchange="toggleCornerLogoVisibility(this.checked)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="settings-card-body">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="logo-preview-box">
                                                <img id="cornerLogoPreviewImg" src="{{ !empty($cardSettings['corner_logo_image']) ? asset($cardSettings['corner_logo_image']) : asset('BJ_Content/Profile Pic b.png') }}" alt="Corner Logo">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="btn btn-sm btn-outline-danger w-100 mb-1" for="customCornerLogoInput" style="font-weight: 600;">
                                                    <i class="fa-solid fa-cloud-arrow-up me-1"></i> নতুন লোগো আপলোড
                                                </label>
                                                <input type="file" id="customCornerLogoInput" accept="image/*" class="d-none" onchange="previewCornerLogo(this)">
                                                <button type="button" class="btn btn-sm btn-link text-muted w-100 p-0 text-decoration-none" onclick="resetCornerLogo()" style="font-size: 0.75rem;">
                                                    <i class="fa-solid fa-rotate-left me-1"></i> ডিফল্ট লোগো ফিরিয়ে আনুন
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="studio-label">লোগোর অবস্থান (Position)</label>
                                            <div class="btn-group w-100" role="group">
                                                <input type="radio" class="btn-check" name="logoPosRadio" id="logoPosRight" autocomplete="off" checked onchange="setCornerLogoPosition('right')">
                                                <label class="btn btn-sm btn-outline-secondary" for="logoPosRight"><i class="fa-solid fa-align-right me-1"></i> ডান কোণে (ডিফল্ট)</label>

                                                <input type="radio" class="btn-check" name="logoPosRadio" id="logoPosLeft" autocomplete="off" onchange="setCornerLogoPosition('left')">
                                                <label class="btn btn-sm btn-outline-secondary" for="logoPosLeft"><i class="fa-solid fa-align-left me-1"></i> বাম কোণে</label>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="studio-label">লোগো সাইজ (৮০px - ২৬০px)</label>
                                            <div class="slider-wrapper">
                                                <input type="range" class="studio-range" id="cornerLogoSizeSlider" min="80" max="260" value="{{ $cardSettings['corner_logo_size'] ?? 135 }}" oninput="setCornerLogoSize(this.value)">
                                                <span class="slider-val-badge" id="cornerLogoSizeBadge">{{ $cardSettings['corner_logo_size'] ?? 135 }}px</span>
                                            </div>
                                        </div>

                                        <div class="form-check form-switch mt-3 pt-2 border-top">
                                            <input class="form-check-input" type="checkbox" id="toggleCornerLogoShadow" {{ !empty($cardSettings['corner_logo_shadow']) || !isset($cardSettings['corner_logo_shadow']) ? 'checked' : '' }} onchange="toggleCornerLogoShadow(this.checked)">
                                            <label class="form-check-label studio-label mb-0" for="toggleCornerLogoShadow" style="cursor: pointer;">
                                                <i class="fa-solid fa-wand-magic-sparkles text-danger me-1"></i> লোগোতে ড্রপ শ্যাডো (Drop Shadow)
                                            </label>
                                            <div class="text-muted mt-1" style="font-size: 0.72rem;">লোগোর নিচে স্পষ্ট ও আকর্ষণীয় ড্রপ শ্যাডো দিয়ে ছবি থেকে ফুটিয়ে তোলে।</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Watermark Logo Card -->
                            <div class="col-md-6">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="settings-card-title"><i class="fa-solid fa-stamp text-danger me-1"></i> লেখার পেছনের ওয়াটারমার্ক</span>
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" id="toggleWatermark" checked onchange="toggleWatermarkVisibility(this.checked)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="settings-card-body">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="logo-preview-box watermark-bg">
                                                <img id="watermarkPreviewImg" src="{{ !empty($themeSettings['logo_image']) ? asset($themeSettings['logo_image']) : asset('BJ_Content/Text Logo.png') }}" alt="Watermark">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="btn btn-sm btn-outline-secondary w-100 mb-1" for="customWatermarkInput" style="font-weight: 600;">
                                                    <i class="fa-solid fa-cloud-arrow-up me-1"></i> ওয়াটারমার্ক আপলোড
                                                </label>
                                                <input type="file" id="customWatermarkInput" accept="image/*" class="d-none" onchange="previewWatermark(this)">
                                                <button type="button" class="btn btn-sm btn-link text-muted w-100 p-0 text-decoration-none" onclick="resetWatermark()" style="font-size: 0.75rem;">
                                                    <i class="fa-solid fa-rotate-left me-1"></i> ডিফল্ট ওয়াটারমার্ক
                                                </button>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="studio-label">ওয়াটারমার্ক অপাসিটি (Opacity)</label>
                                            <div class="slider-wrapper">
                                                <input type="range" class="studio-range" id="watermarkOpacitySlider" min="0" max="30" value="12" oninput="setWatermarkOpacity(this.value)">
                                                <span class="slider-val-badge" id="watermarkOpacityBadge">12%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Ads & Footer -->
                    <div class="tab-pane fade" id="tab-ads" role="tabpanel">
                        <div class="settings-card mb-3">
                            <div class="settings-card-header">
                                <span class="settings-card-title"><i class="fa-solid fa-bars-progress text-danger me-1"></i> কার্ড ফুটার ডিসপ্লে মোড</span>
                            </div>
                            <div class="settings-card-body">
                                <div class="row g-2 mb-3">
                                    <div class="col-md-4">
                                        <div class="footer-mode-card active" id="fModeAd" onclick="setFooterMode('ad')">
                                            <i class="fa-solid fa-rectangle-ad mode-icon"></i>
                                            <span class="mode-title">বিজ্ঞাপন ব্যানার</span>
                                            <span class="mode-desc">১০৮০×১০০ বিজ্ঞাপনী ব্যানার</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="footer-mode-card" id="fModeBrand" onclick="setFooterMode('brand')">
                                            <i class="fa-solid fa-globe mode-icon"></i>
                                            <span class="mode-title">অফিশিয়াল ব্র্যান্ডিং</span>
                                            <span class="mode-desc">ওয়েবসাইট ও সোশ্যাল লিংক</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="footer-mode-card" id="fModeNone" onclick="setFooterMode('none')">
                                            <i class="fa-solid fa-eye-slash mode-icon"></i>
                                            <span class="mode-title">ফুটার বন্ধ</span>
                                            <span class="mode-desc">ফুল কন্টেন্ট ও পরিচ্ছন্ন কার্ড</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ad Controls (Shown when mode is 'ad') -->
                                <div id="footerAdControls">
                                    <label class="studio-label mb-2">বিজ্ঞাপন ব্যানার উৎস (Source)</label>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="custom_ad_file_input" class="bg-upload-zone p-3 h-100" style="min-height: 110px;">
                                                <i class="fa-solid fa-cloud-arrow-up text-danger mb-1" style="font-size: 1.3rem;"></i>
                                                <span style="font-size: 0.82rem; font-weight: 700;">পিসি থেকে ব্যানার আপলোড</span>
                                                <span style="font-size: 0.72rem; color: #64748b;">(১০৮০ × ১০০ পিক্সেল আদর্শ)</span>
                                            </label>
                                            <input type="file" id="custom_ad_file_input" accept="image/*" class="d-none" onchange="previewCustomAdFile(this)">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 border rounded bg-white h-100 d-flex flex-column justify-content-between">
                                                <div>
                                                    <label class="studio-label">অনলাইন ব্যানার লিংক (URL)</label>
                                                    <input type="text" id="modal_ad_url_input" placeholder="https://.../banner.png" class="studio-input" oninput="updateModalAdUrl(this.value)">
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-secondary w-100 mt-2" onclick="resetToDefaultAd()">
                                                    <i class="fa-solid fa-rotate-left me-1"></i> ডিফল্ট বিজ্ঞাপনে রিসেট
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Brand Controls (Shown when mode is 'brand') -->
                                <div id="footerBrandControls" style="display: none;">
                                    <label class="studio-label mb-2">অফিশিয়াল ব্র্যান্ডিং টেক্সট ও লিংক কনফিগারেশন</label>
                                    <div class="row g-2 mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small mb-1 fw-bold">ব্র্যান্ডের নাম (Title)</label>
                                            <input type="text" id="modal_brand_title_input" class="studio-input" value="{{ $cardSettings['brand_title'] ?? 'দৈনিক ভোলা জার্নাল' }}" placeholder="দৈনিক ভোলা জার্নাল" oninput="updateBrandFooterTitle(this.value)">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small mb-1 fw-bold">স্লোগান / ট্যাগলাইন (Tagline)</label>
                                            <input type="text" id="modal_brand_tagline_input" class="studio-input" value="{{ $cardSettings['brand_tagline'] ?? 'সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর' }}" placeholder="সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর" oninput="updateBrandFooterTagline(this.value)">
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small mb-1 fw-bold"><i class="fa-solid fa-globe text-info me-1"></i> ওয়েবসাইট ইউআরএল</label>
                                            <input type="text" id="modal_brand_web_input" class="studio-input" value="{{ $cardSettings['brand_web'] ?? 'dailybholajournal.com' }}" placeholder="dailybholajournal.com" oninput="updateBrandFooterWeb(this.value)">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small mb-1 fw-bold"><i class="fa-brands fa-facebook text-primary me-1"></i> সোশ্যাল হ্যান্ডেল</label>
                                            <input type="text" id="modal_brand_social_input" class="studio-input" value="{{ $cardSettings['brand_social'] ?? '/dailybholajournalBN' }}" placeholder="/dailybholajournalBN" oninput="updateBrandFooterSocial(this.value)">
                                        </div>
                                    </div>
                                    <div class="mt-2 text-muted small">
                                        <i class="fa-solid fa-circle-info text-primary me-1"></i> কার্ডের ফুটারের টেক্সটগুলোতে সরাসরি ক্লিক করেও তাৎক্ষণিক এডিট করা যাবে।
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Themes & Colors Default -->
                    <div class="tab-pane fade" id="tab-theme" role="tabpanel">
                        <div class="row g-3">
                            <!-- 1. Default Theme Presets Card -->
                            <div class="col-md-7">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <span class="settings-card-title"><i class="fa-solid fa-palette text-danger me-1"></i> ডিফল্ট কালার থিম প্রিসেট</span>
                                        <span class="badge bg-danger-subtle text-danger" style="font-size: 0.72rem;">৬টি প্রিসেট</span>
                                    </div>
                                    <div class="settings-card-body">
                                        <label class="studio-label mb-2">ডিফল্ট থিম নির্বাচন করুন (Click to Select & Apply)</label>
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <button type="button" class="modal-theme-btn w-100 {{ ($cardSettings['theme_key'] ?? 'royal') === 'royal' ? 'active' : '' }}" data-modal-theme="royal" onclick="applyModalTheme('royal')">
                                                    <span class="theme-color-bullet" style="background: #1e3a8a;"></span>
                                                    <div class="text-start">
                                                        <span class="d-block fw-bold text-dark" style="font-size: 0.8rem;">রয়েল ব্লু</span>
                                                        <span class="text-muted" style="font-size: 0.68rem;">Royal #1E3A8A</span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="modal-theme-btn w-100 {{ ($cardSettings['theme_key'] ?? '') === 'crimson' ? 'active' : '' }}" data-modal-theme="crimson" onclick="applyModalTheme('crimson')">
                                                    <span class="theme-color-bullet" style="background: #dc2626;"></span>
                                                    <div class="text-start">
                                                        <span class="d-block fw-bold text-dark" style="font-size: 0.8rem;">ক্রিমসন রেড</span>
                                                        <span class="text-muted" style="font-size: 0.68rem;">Crimson #DC2626</span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="modal-theme-btn w-100 {{ ($cardSettings['theme_key'] ?? '') === 'midnight' ? 'active' : '' }}" data-modal-theme="midnight" onclick="applyModalTheme('midnight')">
                                                    <span class="theme-color-bullet" style="background: #0f172a;"></span>
                                                    <div class="text-start">
                                                        <span class="d-block fw-bold text-dark" style="font-size: 0.8rem;">মিডনাইট স্লেট</span>
                                                        <span class="text-muted" style="font-size: 0.68rem;">Slate #0F172A</span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="modal-theme-btn w-100 {{ ($cardSettings['theme_key'] ?? '') === 'navy' ? 'active' : '' }}" data-modal-theme="navy" onclick="applyModalTheme('navy')">
                                                    <span class="theme-color-bullet" style="background: #0369a1;"></span>
                                                    <div class="text-start">
                                                        <span class="d-block fw-bold text-dark" style="font-size: 0.8rem;">ডিপ নেভি</span>
                                                        <span class="text-muted" style="font-size: 0.68rem;">Navy #0369A1</span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="modal-theme-btn w-100 {{ ($cardSettings['theme_key'] ?? '') === 'emerald' ? 'active' : '' }}" data-modal-theme="emerald" onclick="applyModalTheme('emerald')">
                                                    <span class="theme-color-bullet" style="background: #047857;"></span>
                                                    <div class="text-start">
                                                        <span class="d-block fw-bold text-dark" style="font-size: 0.8rem;">ফরেস্ট এমারেল্ড</span>
                                                        <span class="text-muted" style="font-size: 0.68rem;">Emerald #047857</span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="modal-theme-btn w-100 {{ ($cardSettings['theme_key'] ?? '') === 'maroon' ? 'active' : '' }}" data-modal-theme="maroon" onclick="applyModalTheme('maroon')">
                                                    <span class="theme-color-bullet" style="background: #881337;"></span>
                                                    <div class="text-start">
                                                        <span class="d-block fw-bold text-dark" style="font-size: 0.8rem;">লাক্সারি মেরুন</span>
                                                        <span class="text-muted" style="font-size: 0.68rem;">Maroon #881337</span>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="text-muted small" style="font-size: 0.72rem;">
                                            <i class="fa-solid fa-circle-info text-primary me-1"></i> নির্বাচিত থিমটি সব নতুন কার্ডে ডিফল্ট হিসেবে প্রযোজ্য থাকবে।
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Custom Colors & Accents Card -->
                            <div class="col-md-5">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <span class="settings-card-title"><i class="fa-solid fa-eye-dropper text-danger me-1"></i> কাস্টম কালার ও অ্যাকসেন্ট</span>
                                    </div>
                                    <div class="settings-card-body d-flex flex-column gap-3">
                                        <div>
                                            <label class="studio-label">কাস্টম ব্যাকগ্রাউন্ড কালার</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="color" class="color-picker-studio" id="modalCustomBgColor" value="{{ $cardSettings['custom_bg_color'] ?? '#1e3a8a' }}" oninput="syncCustomBg(this.value)">
                                                <span class="text-muted small font-monospace" id="modalCustomBgHex">{{ $cardSettings['custom_bg_color'] ?? '#1e3a8a' }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="studio-label">কার্ড বর্ডার ও অ্যাকসেন্ট কালার</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="color" class="color-picker-studio" id="modalBorderColorPicker" value="{{ $cardSettings['border_color'] ?? '#38bdf8' }}" oninput="syncBorderColor(this.value)">
                                                <span class="text-muted small font-monospace" id="modalBorderHex">{{ $cardSettings['border_color'] ?? '#38bdf8' }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="studio-label">তারিখ ও মেটা টেক্সট কালার</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="color" class="color-picker-studio" id="modalDateColorPicker" value="{{ $cardSettings['date_color'] ?? '#38bdf8' }}" oninput="syncDateColor(this.value)">
                                                <span class="text-muted small font-monospace" id="modalDateHex">{{ $cardSettings['date_color'] ?? '#38bdf8' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Typography Default -->
                    <div class="tab-pane fade" id="tab-typo" role="tabpanel">
                        <div class="row g-3">
                            <!-- 1. Font Family & Alignment -->
                            <div class="col-md-6">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <span class="settings-card-title"><i class="fa-solid fa-font text-danger me-1"></i> ডিফল্ট ফন্ট ও টেক্সট অ্যালাইনমেন্ট</span>
                                    </div>
                                    <div class="settings-card-body d-flex flex-column gap-3">
                                        <div>
                                            <label class="studio-label">ডিফল্ট বাংলা ফন্ট ফ্যামিলি</label>
                                            <select class="studio-select" id="modal_font_switcher" onchange="syncFontFamily(this.value)">
                                                <option value="'Noto Sans Bengali', sans-serif" {{ ($cardSettings['font_family'] ?? '') === "'Noto Sans Bengali', sans-serif" ? 'selected' : '' }}>নোটো সান্স বেঙ্গলি (Noto Sans) — আদর্শ ও স্পষ্ট</option>
                                                <option value="'Hind Siliguri', sans-serif" {{ ($cardSettings['font_family'] ?? '') === "'Hind Siliguri', sans-serif" ? 'selected' : '' }}>হিন্দ শিলিগুড়ি (Hind Siliguri) — জনপ্রিয় সংবাদ ফন্ট</option>
                                                <option value="'Anek Bangla', sans-serif" {{ ($cardSettings['font_family'] ?? '') === "'Anek Bangla', sans-serif" ? 'selected' : '' }}>অনেক বাংলা (Anek Bangla) — আধুনিক জ্যামিতিক</option>
                                                <option value="'Baloo Da 2', cursive" {{ ($cardSettings['font_family'] ?? '') === "'Baloo Da 2', cursive" ? 'selected' : '' }}>বালু দা ২ (Baloo Da 2) — বোল্ড ও গোলগাল</option>
                                                <option value="'Mina', sans-serif" {{ ($cardSettings['font_family'] ?? '') === "'Mina', sans-serif" ? 'selected' : '' }}>মিনা (Mina) — স্লিম ও পরিচ্ছন্ন</option>
                                                <option value="'Tiro Bangla', serif" {{ ($cardSettings['font_family'] ?? '') === "'Tiro Bangla', serif" ? 'selected' : '' }}>তিরো বাংলা (Tiro Bangla) — ঐতিহ্যবাহী সেরিফ</option>
                                                <option value="'Galada', cursive" {{ ($cardSettings['font_family'] ?? '') === "'Galada', cursive" ? 'selected' : '' }}>গালাদা (Galada) — আকর্ষণীয় ক্যালিগ্রাফি</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="studio-label">শিরোনামের ডিফল্ট অ্যালাইনমেন্ট</label>
                                            <div class="btn-group w-100" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary {{ ($cardSettings['headline_align'] ?? 'center') === 'left' ? 'active' : '' }}" id="modalAlignLeftBtn" onclick="syncHeadlineAlign('left')">
                                                    <i class="fa-solid fa-align-left me-1"></i> বামে সাজান (Left)
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary {{ ($cardSettings['headline_align'] ?? 'center') !== 'left' ? 'active' : '' }}" id="modalAlignCenterBtn" onclick="syncHeadlineAlign('center')">
                                                    <i class="fa-solid fa-align-center me-1"></i> মাঝে সাজান (Center)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Font Size & Line Height -->
                            <div class="col-md-6">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <span class="settings-card-title"><i class="fa-solid fa-text-height text-danger me-1"></i> শিরোনাম সাইজ ও লাইন উচ্চতা</span>
                                    </div>
                                    <div class="settings-card-body d-flex flex-column gap-3">
                                        <div>
                                            <label class="studio-label">ডিফল্ট শিরোনাম ফন্ট সাইজ (৩৬px - ৭২px)</label>
                                            <div class="slider-wrapper">
                                                <input type="range" class="studio-range" id="modalFontSizeSlider" min="36" max="72" value="{{ $cardSettings['font_size'] ?? 52 }}" oninput="syncFontSize(this.value)">
                                                <span class="slider-val-badge" id="modalFontSizeBadge">{{ $cardSettings['font_size'] ?? 52 }}px</span>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="studio-label">ডিফল্ট লাইন উচ্চতা (Line Height: ১.১ - ১.৮)</label>
                                            <div class="slider-wrapper">
                                                <input type="range" class="studio-range" id="modalLineHeightSlider" min="1.1" max="1.8" step="0.05" value="{{ $cardSettings['line_height'] ?? 1.3 }}" oninput="syncLineHeight(this.value)">
                                                <span class="slider-val-badge" id="modalLineHeightBadge">{{ $cardSettings['line_height'] ?? 1.3 }}</span>
                                            </div>
                                        </div>
                                        <div class="text-muted small" style="font-size: 0.72rem;">
                                            <i class="fa-solid fa-circle-info text-primary me-1"></i> যেকোনো পোস্টে কাজের সময় সাইডবার থেকেও তাৎক্ষণিক ফন্ট পরিবর্তন করা যায়।
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 5: Layout & Badges -->
                    <div class="tab-pane fade" id="tab-layout" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="settings-card-title"><i class="fa-solid fa-user-pen text-danger me-1"></i> প্রতিবেদক ব্যাজ (Reporter Pill)</span>
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" id="toggleCategoryBadge" {{ !empty($cardSettings['category_badge_visible']) || !isset($cardSettings['category_badge_visible']) ? 'checked' : '' }} onchange="toggleCategoryBadgeVisibility(this.checked)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="settings-card-body">
                                        <label class="studio-label">ব্যাজের ব্যাকগ্রাউন্ড কালার</label>
                                        <div class="color-swatch-wrapper">
                                            <div class="color-swatch" style="background: #dc2626;" onclick="setCategoryBadgeColor('#dc2626')" title="লাল"></div>
                                            <div class="color-swatch" style="background: #1e3a8a;" onclick="setCategoryBadgeColor('#1e3a8a')" title="রয়েল ব্লু"></div>
                                            <div class="color-swatch" style="background: #059669;" onclick="setCategoryBadgeColor('#059669')" title="সবুজ"></div>
                                            <div class="color-swatch" style="background: #d97706;" onclick="setCategoryBadgeColor('#d97706')" title="অরেঞ্জ"></div>
                                            <div class="color-swatch" style="background: #7c3aed;" onclick="setCategoryBadgeColor('#7c3aed')" title="পার্পল"></div>
                                            <input type="color" class="color-picker-studio" id="badgeColorPicker" oninput="setCategoryBadgeColor(this.value)" value="{{ $cardSettings['category_badge_color'] ?? '#dc2626' }}">
                                        </div>

                                        <div class="mt-3 pt-2 border-top">
                                            <label class="studio-label">ইমেজ থেকে উপরে উচ্চতা (Bottom Offset)</label>
                                            <div class="slider-wrapper">
                                                <input type="range" class="studio-range" id="modalReporterBottomSlider" min="0" max="80" value="{{ $cardSettings['reporter_badge_bottom'] ?? 25 }}" oninput="setReporterBadgeBottom(this.value)">
                                                <span class="slider-val-badge" id="modalReporterBottomBadge">{{ $cardSettings['reporter_badge_bottom'] ?? 25 }}px</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="settings-card-title"><i class="fa-solid fa-comment-dots text-danger me-1"></i> বিস্তারিত কমেন্টে হিন্ট</span>
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" id="toggleDetailsHint" checked onchange="toggleDetailsHintVisibility(this.checked)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="settings-card-body">
                                        <div class="mb-3">
                                            <label class="studio-label">কাস্টম হিন্ট টেক্সট</label>
                                            <input type="text" id="customHintInput" class="studio-input" value="{{ $cardSettings['details_hint_text'] ?? 'বিস্তারিত কমেন্টে......' }}" oninput="updateCustomHint(this.value)">
                                        </div>
                                        <div class="border-top pt-2">
                                            <label class="studio-label">উক্তি/ব্রেকিং ফটো ডিফল্ট মোড</label>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-secondary flex-grow-1 {{ empty($cardSettings['quote_cutout_mode']) ? 'active' : '' }}" onclick="syncQuoteMode('normal')" id="modalQuoteModeNormal">
                                                    <i class="fa-regular fa-image me-1"></i> নরমাল ফ্রেম
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary flex-grow-1 {{ !empty($cardSettings['quote_cutout_mode']) ? 'active' : '' }}" onclick="syncQuoteMode('cutout')" id="modalQuoteModeCutout">
                                                    <i class="fa-solid fa-user-ninja me-1"></i> ফুল কাটআউট
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light d-flex justify-content-between align-items-center w-100">
                <button type="button" class="btn btn-outline-secondary font-bangla btn-sm" onclick="resetAllCardSettings()">
                    <i class="fa-solid fa-rotate-left me-1"></i> ডিফল্ট রিসেট
                </button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-dark font-bangla" data-bs-dismiss="modal">
                        বন্ধ করুন
                    </button>
                    <button type="button" id="saveCardSettingsBtn" class="btn btn-danger font-bangla px-4 shadow-sm" onclick="savePersistentCardSettings()">
                        <i class="fa-solid fa-floppy-disk me-1"></i> সেটিংস স্থায়ীভাবে সেভ করুন
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Beautiful floating success toast -->
<div class="studio-toast" id="studioToast">
    <div class="toast-icon">
        <i class="fa-solid fa-circle-check"></i>
    </div>
    <div class="toast-body">
        <span class="toast-title" id="toastTitle">ক্যাপশন কপি করা হয়েছে!</span>
        <span class="toast-desc" id="toastDesc">ইমেজ ডাউনলোড হয়েছে। ফেসবুকে পেস্ট করুন।</span>
    </div>
</div>
@endsection

@section('scripts')
<!-- html2canvas Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    // Saved settings from server
    const serverCardSettings = @json($cardSettings);
    const saveSettingsRoute = "{{ route('admin.tools.social-card.settings') }}";
    const csrfToken = "{{ csrf_token() }}";

    // Pre-populate background image sources from database values
    let featuredImageSrc = '{{ $post->featured_image ? $post->featured_image_url : "" }}';
    let socialCardImageSrc = '{{ $post->social_card_image ? $post->social_card_image_url : "" }}';

    // Convert date numbers to Bengali numerals
    function toBengaliDigits(num) {
        const bnDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return num.toString().replace(/[0-9]/g, w => bnDigits[+w]);
    }

    // Format and inject dynamic Bengali Date
    function updateBengaliDate() {
        const monthNames = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
        const dayNames = ['রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'শনিবার'];
        const d = new Date('{{ $post->created_at ? $post->created_at->toIso8601String() : "" }}' || new Date());
        const bnDayName = dayNames[d.getDay()];
        const bnDay = toBengaliDigits(d.getDate());
        const bnMonth = monthNames[d.getMonth()];
        const bnYear = toBengaliDigits(d.getFullYear());
        const formattedDate = `${bnDayName}, ${bnDay} ${bnMonth}, ${bnYear}`;
        
        const dateEl = document.getElementById('cardDatePreview');
        if (dateEl) {
            dateEl.innerText = formattedDate;
        }
    }

    // Font selection logic
    function changeFontFamily(fontName) {
        const selection = window.getSelection();
        if (selection.rangeCount > 0 && selection.toString().length > 0) {
            document.execCommand("fontName", false, fontName);
        } else {
            const target = document.getElementById('editable_headline');
            if (target) {
                target.style.fontFamily = fontName;
            }
            const quoteTarget = document.getElementById('editable_quote_text');
            if (quoteTarget) {
                quoteTarget.style.fontFamily = fontName;
            }
            const breakingExcerptTarget = document.getElementById('editable_breaking_excerpt');
            if (breakingExcerptTarget) {
                breakingExcerptTarget.style.fontFamily = fontName;
            }
            const switcher = document.getElementById('font_switcher');
            if (switcher) switcher.value = fontName;
            const modalSwitcher = document.getElementById('modal_font_switcher');
            if (modalSwitcher && modalSwitcher.value !== fontName) modalSwitcher.value = fontName;
        }
    }

    // Font color logic
    function changeSelectedColor(color) {
        document.execCommand('styleWithCSS', false, true); 
        document.execCommand('foreColor', false, color);
        const picker = document.getElementById('colorPicker');
        if (picker) picker.value = color;
    }

    // Apply quick brand color swatches
    function applyQuickColor(color) {
        changeSelectedColor(color);
    }

    // Font size logic (called by range slider)
    function updateFontSize(size) {
        const badge = document.getElementById('fontSizeBadge');
        if (badge) badge.innerText = size + 'px';
        
        const slider = document.getElementById('fontSizeSlider');
        if (slider) slider.value = size;

        const modalSlider = document.getElementById('modalFontSizeSlider');
        const modalBadge = document.getElementById('modalFontSizeBadge');
        if (modalSlider && modalSlider.value != size) modalSlider.value = size;
        if (modalBadge) modalBadge.innerText = size + 'px';

        const selection = window.getSelection();
        if (selection.rangeCount > 0 && selection.toString().length > 0) {
            document.execCommand("fontSize", false, "7"); 
            const fontElements = document.querySelectorAll("font[size='7']");
            fontElements.forEach(el => {
                el.removeAttribute("size");
                el.style.fontSize = size + "px";
            });
        } else {
            const target = document.getElementById('editable_headline');
            if (target) target.style.fontSize = size + 'px';
            const quoteTarget = document.getElementById('editable_quote_text');
            if (quoteTarget) {
                const quoteSize = Math.max(24, parseInt(size) - 14);
                quoteTarget.style.fontSize = quoteSize + 'px';
            }
            const breakingExcerptTarget = document.getElementById('editable_breaking_excerpt');
            if (breakingExcerptTarget) {
                const excerptSize = Math.max(18, Math.round(parseInt(size) * 0.52));
                breakingExcerptTarget.style.fontSize = excerptSize + 'px';
            }
        }
    }

    // Base font size logic (for back-compatibility)
    function changeFontSize(size) {
        updateFontSize(size);
    }

    // Line height logic
    function updateLineHeight(val) {
        const badge = document.getElementById('lineHeightBadge');
        if (badge) badge.innerText = val;
        
        const slider = document.getElementById('lineHeightSlider');
        if (slider) slider.value = val;

        const modalSlider = document.getElementById('modalLineHeightSlider');
        const modalBadge = document.getElementById('modalLineHeightBadge');
        if (modalSlider && modalSlider.value != val) modalSlider.value = val;
        if (modalBadge) modalBadge.innerText = val;

        const target = document.getElementById('editable_headline');
        if (target) target.style.lineHeight = val;
        const quoteTarget = document.getElementById('editable_quote_text');
        if (quoteTarget) quoteTarget.style.lineHeight = (parseFloat(val) + 0.25);
    }

    // Base line height logic (for back-compatibility)
    function changeLineHeight(val) {
        updateLineHeight(val);
    }

    // Card Theme Color Presets & Management
    const cardThemes = {
        crimson: {
            bg: 'linear-gradient(160deg, #990000 0%, #3a0000 100%)',
            posterBg: 'linear-gradient(to top, rgba(58, 0, 0, 0.98) 0%, rgba(58, 0, 0, 0.92) 10%, rgba(153, 0, 0, 0.65) 18%, rgba(153, 0, 0, 0.20) 25%, transparent 30%)',
            breakingBg: 'linear-gradient(160deg, #450a0a 0%, #1c0505 100%)',
            dateColor: '#ffd700',
            borderColor: '#ffd700',
            headlineColor: '#ffffff'
        },
        midnight: {
            bg: 'linear-gradient(160deg, #18181b 0%, #09090b 100%)',
            posterBg: 'linear-gradient(to top, rgba(9, 9, 11, 0.98) 0%, rgba(9, 9, 11, 0.92) 10%, rgba(24, 24, 27, 0.65) 18%, rgba(24, 24, 27, 0.20) 25%, transparent 30%)',
            breakingBg: 'linear-gradient(160deg, #27272a 0%, #09090b 100%)',
            dateColor: '#ef4444',
            borderColor: '#dc2626',
            headlineColor: '#ffffff'
        },
        navy: {
            bg: 'linear-gradient(160deg, #1e293b 0%, #0a0f1d 100%)',
            posterBg: 'linear-gradient(to top, rgba(10, 15, 29, 0.98) 0%, rgba(10, 15, 29, 0.92) 10%, rgba(30, 41, 59, 0.65) 18%, rgba(30, 41, 59, 0.20) 25%, transparent 30%)',
            breakingBg: 'linear-gradient(160deg, #1e293b 0%, #050a14 100%)',
            dateColor: '#f59e0b',
            borderColor: '#ef4444',
            headlineColor: '#ffffff'
        },
        royal: {
            bg: 'linear-gradient(160deg, #1e3a8a 0%, #0f172a 100%)',
            posterBg: 'linear-gradient(to top, rgba(15, 23, 42, 0.98) 0%, rgba(15, 23, 42, 0.92) 10%, rgba(30, 58, 138, 0.65) 18%, rgba(30, 58, 138, 0.20) 25%, transparent 30%)',
            breakingBg: 'linear-gradient(160deg, #1e3a8a 0%, #091024 100%)',
            dateColor: '#38bdf8',
            borderColor: '#38bdf8',
            headlineColor: '#ffffff'
        },
        emerald: {
            bg: 'linear-gradient(160deg, #064e3b 0%, #022c22 100%)',
            posterBg: 'linear-gradient(to top, rgba(2, 44, 34, 0.98) 0%, rgba(2, 44, 34, 0.92) 10%, rgba(6, 78, 59, 0.65) 18%, rgba(6, 78, 59, 0.20) 25%, transparent 30%)',
            breakingBg: 'linear-gradient(160deg, #064e3b 0%, #021a14 100%)',
            dateColor: '#34d399',
            borderColor: '#10b981',
            headlineColor: '#ffffff'
        },
        maroon: {
            bg: 'linear-gradient(160deg, #581c87 0%, #2e1065 100%)',
            posterBg: 'linear-gradient(to top, rgba(46, 16, 101, 0.98) 0%, rgba(46, 16, 101, 0.92) 10%, rgba(88, 28, 135, 0.65) 18%, rgba(88, 28, 135, 0.20) 25%, transparent 30%)',
            breakingBg: 'linear-gradient(160deg, #581c87 0%, #1e0538 100%)',
            dateColor: '#f472b6',
            borderColor: '#e11d48',
            headlineColor: '#ffffff'
        }
    };

    let currentCardStyle = '{{ $cardSettings["card_style"] ?? "classic" }}';
    let currentThemeKey = '{{ $cardSettings["theme_key"] ?? "royal" }}';

    // Per-style settings and state
    const defaultStyleSettings = {
        classic: { logo_visible: true, logo_image: '', logo_position: 'right', logo_size: 135, watermark_visible: true, badge_visible: true, date_visible: true, hint_visible: true, footer_visible: true },
        poster: { logo_visible: false, logo_image: '', logo_position: 'right', logo_size: 135, watermark_visible: false, badge_visible: false, date_visible: true, hint_visible: false, footer_visible: false },
        quote: { logo_visible: true, logo_image: '', logo_position: 'right', logo_size: 135, watermark_visible: true, badge_visible: false, date_visible: true, hint_visible: true, footer_visible: false, quote_symbol_visible: true, speaker_visible: true },
        breaking: { logo_visible: true, logo_image: '', logo_position: 'right', logo_size: 135, watermark_visible: true, badge_visible: false, date_visible: true, hint_visible: true, footer_visible: false, excerpt_visible: true }
    };
    let currentStyleSettings = @json($cardSettings['style_settings'] ?? []);
    if (!currentStyleSettings || typeof currentStyleSettings !== 'object' || Array.isArray(currentStyleSettings)) {
        currentStyleSettings = {};
    }
    for (const k of ['classic', 'poster', 'quote', 'breaking']) {
        currentStyleSettings[k] = Object.assign({}, defaultStyleSettings[k], currentStyleSettings[k] || {});
    }
    const styleLogoFiles = {};
    const resetStyleLogoFlags = {};

    function toggleStyleObject(sKey, objKey, isChecked) {
        if (!currentStyleSettings[sKey]) currentStyleSettings[sKey] = {};
        currentStyleSettings[sKey][objKey] = isChecked;
        if (currentCardStyle === sKey) {
            applyStyleObjectSettings(sKey);
            if (objKey === 'logo_visible') {
                const masterToggle = document.getElementById('toggleCornerLogo');
                if (masterToggle) masterToggle.checked = isChecked;
            }
            if (objKey === 'watermark_visible') {
                const masterToggle = document.getElementById('toggleWatermark');
                if (masterToggle) masterToggle.checked = isChecked;
            }
            if (objKey === 'badge_visible') {
                const masterToggle = document.getElementById('toggleCategoryBadge');
                if (masterToggle) masterToggle.checked = isChecked;
            }
            if (objKey === 'hint_visible') {
                const masterToggle = document.getElementById('toggleDetailsHint');
                if (masterToggle) masterToggle.checked = isChecked;
            }
        }
    }

    function setStyleLogoPosition(sKey, pos) {
        if (!currentStyleSettings[sKey]) currentStyleSettings[sKey] = {};
        currentStyleSettings[sKey]['logo_position'] = pos;
        if (currentCardStyle === sKey) {
            applyStyleObjectSettings(sKey);
            const lRadio = document.getElementById('logoPosLeft');
            const rRadio = document.getElementById('logoPosRight');
            if (pos === 'left' && lRadio) lRadio.checked = true;
            if (pos === 'right' && rRadio) rRadio.checked = true;
            if (sKey === 'poster') {
                const metaRow = document.getElementById('cardMetaRow');
                if (metaRow) {
                    metaRow.style.setProperty('justify-content', pos === 'left' ? 'flex-end' : 'flex-start', 'important');
                }
            }
        }
    }

    function setStyleLogoSize(sKey, size) {
        size = parseInt(size, 10) || 135;
        if (!currentStyleSettings[sKey]) currentStyleSettings[sKey] = {};
        currentStyleSettings[sKey]['logo_size'] = size;

        const badge = document.getElementById('style_logo_size_badge_' + sKey);
        if (badge) badge.innerText = size + 'px';

        const slider = document.getElementById('style_logo_size_slider_' + sKey);
        if (slider) slider.value = size;

        if (currentCardStyle === sKey) {
            const img = document.getElementById('cornerLogoImg');
            if (img) {
                img.style.width = size + 'px';
                img.style.height = size + 'px';
            }
            const masterSlider = document.getElementById('cornerLogoSizeSlider');
            const masterBadge = document.getElementById('cornerLogoSizeBadge');
            if (masterSlider) masterSlider.value = size;
            if (masterBadge) masterBadge.innerText = size + 'px';
        }
    }

    function previewStyleLogo(sKey, input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            styleLogoFiles[sKey] = file;
            delete resetStyleLogoFlags[sKey];
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('styleLogoPreview_' + sKey);
                if (previewImg) previewImg.src = e.target.result;
                const logoBox = document.getElementById('styleLogoBox_' + sKey);
                const noLogoBox = document.getElementById('styleNoLogoBox_' + sKey);
                if (logoBox) logoBox.style.display = '';
                if (noLogoBox) noLogoBox.style.display = 'none';
                if (!currentStyleSettings[sKey]) currentStyleSettings[sKey] = {};
                currentStyleSettings[sKey].logo_image_preview = e.target.result;
                if (currentCardStyle === sKey) {
                    applyStyleObjectSettings(sKey);
                }
            };
            reader.readAsDataURL(file);
        }
    }

    function resetStyleLogo(sKey) {
        delete styleLogoFiles[sKey];
        resetStyleLogoFlags[sKey] = true;
        if (currentStyleSettings[sKey]) {
            currentStyleSettings[sKey].logo_image = '';
            delete currentStyleSettings[sKey].logo_image_preview;
        }
        if (sKey === 'poster') {
            const logoBox = document.getElementById('styleLogoBox_' + sKey);
            const noLogoBox = document.getElementById('styleNoLogoBox_' + sKey);
            if (logoBox) logoBox.style.display = 'none';
            if (noLogoBox) noLogoBox.style.display = 'flex';
        } else {
            const defaultCornerLogo = "{{ !empty($cardSettings['corner_logo_image']) ? asset($cardSettings['corner_logo_image']) : asset('BJ_Content/Profile Pic b.png') }}";
            const previewImg = document.getElementById('styleLogoPreview_' + sKey);
            if (previewImg) previewImg.src = defaultCornerLogo;
            const logoBox = document.getElementById('styleLogoBox_' + sKey);
            const noLogoBox = document.getElementById('styleNoLogoBox_' + sKey);
            if (logoBox) logoBox.style.display = '';
            if (noLogoBox) noLogoBox.style.display = 'none';
        }
        const fileInput = document.getElementById('style_logo_input_' + sKey);
        if (fileInput) fileInput.value = '';
        if (currentCardStyle === sKey) {
            applyStyleObjectSettings(sKey);
        }
    }

    function applyStyleObjectSettings(styleKey) {
        if (!styleKey) styleKey = currentCardStyle || 'classic';
        const cfg = currentStyleSettings[styleKey] || defaultStyleSettings[styleKey] || {};
        const cardNode = document.getElementById('social_card_node');
        if (!cardNode) return;

        // 1. Logo
        const cardTopLogo = document.getElementById('cardTopLogo');
        const cornerLogoImg = document.getElementById('cornerLogoImg');
        if (cardTopLogo) {
            const isLogoVis = cfg.hasOwnProperty('logo_visible') ? !!cfg.logo_visible : (styleKey !== 'poster');
            cardTopLogo.style.setProperty('display', isLogoVis ? 'flex' : 'none', 'important');
            const pos = cfg.logo_position || 'right';
            if (pos === 'left') {
                cardTopLogo.style.setProperty('left', '45px', 'important');
                cardTopLogo.style.setProperty('right', 'auto', 'important');
            } else {
                cardTopLogo.style.setProperty('right', '45px', 'important');
                cardTopLogo.style.setProperty('left', 'auto', 'important');
            }
        }
        if (cornerLogoImg) {
            const defaultLogo = "{{ !empty($cardSettings['corner_logo_image']) ? asset($cardSettings['corner_logo_image']) : asset('BJ_Content/Profile Pic b.png') }}";
            if (cfg.logo_image_preview) {
                cornerLogoImg.src = cfg.logo_image_preview;
            } else if (cfg.logo_image) {
                const src = (cfg.logo_image.startsWith('http') || cfg.logo_image.startsWith('/')) ? cfg.logo_image : ('/' + cfg.logo_image);
                cornerLogoImg.src = src;
            } else {
                if (cornerLogoImg.dataset.masterSrc) {
                    cornerLogoImg.src = cornerLogoImg.dataset.masterSrc;
                } else {
                    cornerLogoImg.src = defaultLogo;
                }
            }

            // Apply style logo size
            const logoSize = cfg.logo_size || (serverCardSettings && serverCardSettings.corner_logo_size) || 135;
            cornerLogoImg.style.width = logoSize + 'px';
            cornerLogoImg.style.height = logoSize + 'px';

            const masterSizeSlider = document.getElementById('cornerLogoSizeSlider');
            const masterSizeBadge = document.getElementById('cornerLogoSizeBadge');
            if (masterSizeSlider) masterSizeSlider.value = logoSize;
            if (masterSizeBadge) masterSizeBadge.innerText = logoSize + 'px';

            const styleSlider = document.getElementById('style_logo_size_slider_' + styleKey);
            const styleBadge = document.getElementById('style_logo_size_badge_' + styleKey);
            if (styleSlider) styleSlider.value = logoSize;
            if (styleBadge) styleBadge.innerText = logoSize + 'px';
        }

        // 2. Watermark
        const watermark = document.getElementById('cardWatermarkImg');
        if (watermark) {
            const isWatermarkVis = cfg.hasOwnProperty('watermark_visible') ? !!cfg.watermark_visible : (styleKey !== 'poster');
            watermark.style.setProperty('display', isWatermarkVis ? 'block' : 'none', 'important');
        }

        // 3. Reporter Badge
        const badgeWrapper = document.getElementById('reporterBadgeWrapper');
        if (badgeWrapper) {
            const isBadgeVis = cfg.hasOwnProperty('badge_visible') ? !!cfg.badge_visible : false;
            badgeWrapper.style.setProperty('display', isBadgeVis ? 'flex' : 'none', 'important');
        }

        // 4. Date bar
        const metaRow = document.getElementById('cardMetaRow');
        if (metaRow) {
            const isDateVis = cfg.hasOwnProperty('date_visible') ? !!cfg.date_visible : true;
            metaRow.style.setProperty('display', isDateVis ? 'flex' : 'none', 'important');

            if (styleKey === 'poster') {
                const pos = cfg.logo_position || 'right';
                metaRow.style.setProperty('justify-content', pos === 'left' ? 'flex-end' : 'flex-start', 'important');
            } else if (styleKey === 'classic') {
                metaRow.style.setProperty('justify-content', 'flex-start', 'important');
            } else if (styleKey === 'quote' || styleKey === 'breaking') {
                metaRow.style.setProperty('justify-content', 'flex-end', 'important');
            }
        }

        // 5. Details hint
        const detailsHint = document.getElementById('cardDetailsHint');
        if (detailsHint) {
            const isHintVis = cfg.hasOwnProperty('hint_visible') ? !!cfg.hint_visible : true;
            const displayType = (styleKey === 'quote' || styleKey === 'breaking') ? 'inline-block' : 'block';
            detailsHint.style.setProperty('display', isHintVis ? displayType : 'none', 'important');
        }

        // 6. Footer bar (Ad / Official Brand)
        const adBar = document.getElementById('main_ad_bar');
        const brandBar = document.getElementById('official_brand_footer');
        const isFooterVis = cfg.hasOwnProperty('footer_visible') ? !!cfg.footer_visible : true;
        if (!isFooterVis) {
            if (adBar) adBar.style.setProperty('display', 'none', 'important');
            if (brandBar) brandBar.style.setProperty('display', 'none', 'important');
            cardNode.classList.add('footer-none');
        } else {
            cardNode.classList.toggle('footer-none', currentFooterMode === 'none');
            if (adBar) adBar.style.removeProperty('display');
            if (brandBar) brandBar.style.removeProperty('display');
            if (typeof setFooterMode === 'function') {
                setFooterMode(currentFooterMode);
            }
        }

        // 7. Quote style specifics
        const quoteSymbol = document.getElementById('quoteSymbolBadge');
        if (quoteSymbol) {
            if (styleKey === 'quote') {
                const isSymVis = cfg.quote_symbol_visible !== false;
                quoteSymbol.style.setProperty('display', isSymVis ? 'inline-flex' : 'none', 'important');
            }
        }
        const quoteSpeaker = document.getElementById('quoteSpeakerWrapper');
        if (quoteSpeaker) {
            if (styleKey === 'quote') {
                const isSpkVis = cfg.speaker_visible !== false;
                quoteSpeaker.style.setProperty('display', isSpkVis ? 'flex' : 'none', 'important');
            }
        }

        // 8. Breaking style specifics
        const breakingExcerpt = document.getElementById('editable_breaking_excerpt');
        if (breakingExcerpt) {
            if (styleKey === 'breaking') {
                const isExcVis = cfg.excerpt_visible !== false;
                breakingExcerpt.style.setProperty('display', isExcVis ? 'block' : 'none', 'important');
            }
        }
    }

    function hexToRgb(hex) {
        if (!hex) return { r: 30, g: 58, b: 138 };
        hex = hex.replace('#', '').trim();
        if (hex.length === 3) {
            hex = hex.split('').map(c => c + c).join('');
        }
        const num = parseInt(hex, 16);
        if (isNaN(num)) return { r: 30, g: 58, b: 138 };
        return {
            r: (num >> 16) & 255,
            g: (num >> 8) & 255,
            b: num & 255
        };
    }

    function updateCardBackgroundTheme() {
        const cardNode = document.getElementById('social_card_node');
        const bottomWrapper = document.getElementById('bottomContentWrapper');
        if (!bottomWrapper) return;
        const quoteSymbol = document.getElementById('quoteSymbolBadge');

        if (currentThemeKey !== 'custom' && cardThemes[currentThemeKey]) {
            const theme = cardThemes[currentThemeKey];
            if (currentCardStyle === 'poster') {
                if (cardNode) cardNode.style.removeProperty('background');
                bottomWrapper.style.setProperty('background', theme.posterBg || theme.bg, 'important');
                bottomWrapper.style.borderTopColor = 'transparent';
            } else if (currentCardStyle === 'quote' || currentCardStyle === 'breaking') {
                if (cardNode) cardNode.style.setProperty('background', currentCardStyle === 'breaking' ? (theme.breakingBg || theme.bg) : theme.bg, 'important');
                bottomWrapper.style.setProperty('background', 'transparent', 'important');
                bottomWrapper.style.borderTopColor = 'transparent';
            } else {
                if (cardNode) cardNode.style.removeProperty('background');
                bottomWrapper.style.setProperty('background', theme.bg, 'important');
                bottomWrapper.style.borderTopColor = 'transparent';
            }

            if (quoteSymbol) {
                quoteSymbol.style.color = theme.borderColor || theme.dateColor;
            }
        } else {
            const customHex = document.getElementById('customBgColor') ? document.getElementById('customBgColor').value : '#1e3a8a';
            if (currentCardStyle === 'poster') {
                if (cardNode) cardNode.style.removeProperty('background');
                try {
                    const rgb = hexToRgb(customHex);
                    const posterGrad = `linear-gradient(to top, rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, 0.98) 0%, rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, 0.90) 10%, rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, 0.60) 18%, rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, 0.20) 25%, transparent 30%)`;
                    bottomWrapper.style.setProperty('background', posterGrad, 'important');
                } catch(e) {
                    bottomWrapper.style.setProperty('background', customHex, 'important');
                }
                bottomWrapper.style.borderTopColor = 'transparent';
            } else if (currentCardStyle === 'quote' || currentCardStyle === 'breaking') {
                if (cardNode) cardNode.style.setProperty('background', customHex, 'important');
                bottomWrapper.style.setProperty('background', 'transparent', 'important');
                bottomWrapper.style.borderTopColor = 'transparent';
            } else {
                if (cardNode) cardNode.style.removeProperty('background');
                bottomWrapper.style.setProperty('background', customHex, 'important');
                const borderPicker = document.getElementById('borderColorPicker');
                const bColor = borderPicker ? borderPicker.value : '#38bdf8';
                bottomWrapper.style.borderTopColor = 'transparent';
            }

            const borderPicker = document.getElementById('borderColorPicker');
            const bColor = borderPicker ? borderPicker.value : '#38bdf8';
            if (quoteSymbol) {
                quoteSymbol.style.color = bColor;
            }
        }
    }

    function setCardStyle(styleKey) {
        if (!styleKey) return;
        currentCardStyle = styleKey;
        const cardNode = document.getElementById('social_card_node');
        if (!cardNode) return;

        // Remove previous style classes
        cardNode.classList.remove('style-classic', 'style-poster', 'style-quote', 'style-breaking');
        cardNode.classList.add('style-' + styleKey);

        // Update all style selector buttons / cards active state
        document.querySelectorAll('.style-select-card').forEach(el => {
            el.classList.toggle('active', el.getAttribute('data-style') === styleKey);
        });
        document.querySelectorAll('.modal-style-card').forEach(el => {
            el.classList.toggle('active', el.getAttribute('data-style') === styleKey);
        });
        document.querySelectorAll('.btn-style-pill').forEach(el => {
            el.classList.toggle('active', el.getAttribute('data-style') === styleKey);
        });

        // Activate matching sub-tab in Modal Settings if open or when opened
        const subTabBtn = document.getElementById('subtab-btn-' + styleKey);
        if (subTabBtn && typeof bootstrap !== 'undefined') {
            try {
                const tabTrigger = new bootstrap.Tab(subTabBtn);
                tabTrigger.show();
            } catch(e) {}
        }

        // Date row and watermark logo alignment according to style requirements
        const metaRow = document.getElementById('cardMetaRow');
        const watermark = document.getElementById('cardWatermarkImg');
        if (metaRow) {
            if (styleKey === 'classic') {
                metaRow.style.setProperty('justify-content', 'flex-start', 'important');
            } else if (styleKey === 'quote' || styleKey === 'breaking') {
                metaRow.style.setProperty('justify-content', 'flex-end', 'important');
            } else if (styleKey === 'poster') {
                const sCfg = (currentStyleSettings && currentStyleSettings['poster']) || {};
                const logoPos = sCfg.logo_position || (document.getElementById('style_pos_left_poster') && document.getElementById('style_pos_left_poster').checked ? 'left' : (document.getElementById('logoPosLeft') && document.getElementById('logoPosLeft').checked ? 'left' : 'right'));
                metaRow.style.setProperty('justify-content', logoPos === 'left' ? 'flex-end' : 'flex-start', 'important');
            } else {
                const isLeft = document.getElementById('alignLeftBtn') && document.getElementById('alignLeftBtn').classList.contains('active');
                metaRow.style.justifyContent = isLeft ? 'flex-start' : 'center';
            }
        }
        if (watermark) {
            if (styleKey === 'poster') {
                const isLeft = document.getElementById('logoPosLeft') && document.getElementById('logoPosLeft').checked;
                watermark.style.setProperty('align-self', isLeft ? 'flex-start' : 'flex-end', 'important');
            } else {
                watermark.style.removeProperty('align-self');
            }
        }

        // Adjust wrapper sizing
        const bottomWrapper = document.getElementById('bottomContentWrapper');
        if (bottomWrapper) {
            if (styleKey === 'poster' || styleKey === 'quote' || styleKey === 'breaking') {
                bottomWrapper.style.removeProperty('height');
                bottomWrapper.style.removeProperty('flex');
            } else {
                if (typeof setFooterMode === 'function') {
                    setFooterMode(currentFooterMode);
                }
            }
        }

        // Dynamically update card background for the active style
        updateCardBackgroundTheme();

        // Toggle inspector headline vs quote vs breaking input panels
        const headlineGroup = document.getElementById('headlineControlGroup');
        const breakingExcerptGroup = document.getElementById('breakingExcerptControlGroup');
        const quoteGroup = document.getElementById('quoteSidebarControls');
        const quoteSpeakerFields = document.getElementById('quoteSpeakerFields');
        const photoModeLabel = document.getElementById('photoModeLabel');
        const photoUploadSubtext = document.getElementById('photoUploadSubtext');

        if (headlineGroup) {
            headlineGroup.style.display = (styleKey === 'quote') ? 'none' : 'block';
        }
        if (breakingExcerptGroup) {
            breakingExcerptGroup.style.display = (styleKey === 'breaking') ? 'block' : 'none';
        }
        if (quoteGroup) {
            quoteGroup.style.display = (styleKey === 'quote' || styleKey === 'breaking') ? 'block' : 'none';
        }
        if (quoteSpeakerFields) {
            quoteSpeakerFields.style.display = (styleKey === 'quote') ? 'block' : 'none';
        }
        if (photoModeLabel) {
            photoModeLabel.innerText = (styleKey === 'breaking') ? 'নিউজ ছবির মোড (Display Mode)' : 'বক্তার ছবির মোড (Display Mode)';
        }
        if (photoUploadSubtext) {
            photoUploadSubtext.innerText = (styleKey === 'breaking') ? 'সংবাদের সাধারণ ছবি বা স্বচ্ছ কাটআউট PNG ফাইল' : 'সাধারণ ছবি বা স্বচ্ছ কাটআউট PNG ফাইল';
        }

        const imgSecTitle = document.getElementById('imageSectionTitle');
        const bgUploadLabel = document.getElementById('bgUploadLabel');
        const bgUploadPrompt = document.getElementById('bgUploadPrompt');
        if (imgSecTitle) imgSecTitle.innerHTML = `<i class="fa-regular fa-image"></i> ${(styleKey === 'quote' || styleKey === 'breaking') ? 'ছবির মোড ও পজিশন' : 'ছবির ফ্রেম ও পজিশন'}`;
        if (bgUploadLabel) bgUploadLabel.innerText = (styleKey === 'quote' || styleKey === 'breaking') ? 'ছবি পরিবর্তন (PNG Cutout বা সাধারণ)' : 'ব্যাকগ্রাউন্ড ছবি পরিবর্তন';
        if (bgUploadPrompt) bgUploadPrompt.innerText = (styleKey === 'quote' || styleKey === 'breaking') ? 'ছবি / পিএনজি আপলোড করুন' : 'নতুন ব্যাকগ্রাউন্ড আপলোড করুন';

        // Apply quote cutout transform or reset for other styles
        if (typeof updateQuoteImgTransform === 'function') {
            updateQuoteImgTransform();
        }

        if (styleKey === 'quote' || styleKey === 'breaking') {
            const wrapper = document.getElementById('newsImageWrapper');
            if (wrapper) {
                if (typeof isQuoteCutout !== 'undefined' && isQuoteCutout) {
                    wrapper.classList.add('quote-cutout-mode');
                } else {
                    wrapper.classList.remove('quote-cutout-mode');
                }
            }
        } else {
            const wrapper = document.getElementById('newsImageWrapper');
            if (wrapper) {
                wrapper.classList.remove('quote-cutout-mode');
            }
        }

        // Apply per-style custom logo & object visibility settings
        applyStyleObjectSettings(styleKey);

        // Trigger canvas auto-fit resize
        if (typeof resizeCanvasWorkspace === 'function') {
            resizeCanvasWorkspace();
        }
    }

    function applyCardTheme(themeKey) {
        currentThemeKey = themeKey;
        const theme = cardThemes[themeKey];
        if (!theme) return;

        // Update background & style-specific accents
        updateCardBackgroundTheme();

        setCardDateColor(theme.dateColor);
        setCardBorderColor(theme.borderColor);

        // Update active button state
        document.querySelectorAll('.btn-theme-preset').forEach(btn => {
            btn.classList.toggle('active', btn.getAttribute('data-theme') === themeKey);
        });
        document.querySelectorAll('.modal-theme-btn').forEach(btn => {
            btn.classList.toggle('active', btn.getAttribute('data-modal-theme') === themeKey);
        });

        // Update color inputs
        const bgPicker = document.getElementById('customBgColor');
        const bgHex = document.getElementById('customBgHex');
        const modalBg = document.getElementById('modalCustomBgColor');
        const modalBgHex = document.getElementById('modalCustomBgHex');
        const defaultHexes = {
            crimson: '#990000',
            midnight: '#18181b',
            navy: '#1e293b',
            royal: '#1e3a8a',
            emerald: '#064e3b',
            maroon: '#581c87'
        };
        if (defaultHexes[themeKey]) {
            if (bgPicker) bgPicker.value = defaultHexes[themeKey];
            if (bgHex) bgHex.value = defaultHexes[themeKey];
            if (modalBg) modalBg.value = defaultHexes[themeKey];
            if (modalBgHex) modalBgHex.innerText = defaultHexes[themeKey];
        }
    }

    function setCustomCardBg(color) {
        if (!color) return;
        currentThemeKey = 'custom';
        const bgPicker = document.getElementById('customBgColor');
        const bgHex = document.getElementById('customBgHex');
        const modalBg = document.getElementById('modalCustomBgColor');
        const modalBgHex = document.getElementById('modalCustomBgHex');
        if (bgPicker && bgPicker.value !== color && color.startsWith('#')) bgPicker.value = color;
        if (bgHex && bgHex.value !== color) bgHex.value = color;
        if (modalBg && modalBg.value !== color && color.startsWith('#')) modalBg.value = color;
        if (modalBgHex && modalBgHex.innerText !== color) modalBgHex.innerText = color;

        // Apply background dynamically
        updateCardBackgroundTheme();

        // remove active class from presets
        document.querySelectorAll('.btn-theme-preset').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.modal-theme-btn').forEach(btn => btn.classList.remove('active'));
    }

    function setCardDateColor(color) {
        if (!color) return;
        const dateEl = document.getElementById('cardDatePreview');
        const hintEl = document.getElementById('cardDetailsHint');
        const dateIcon = document.getElementById('cardDateIcon');
        if (dateEl) dateEl.style.color = color;
        if (hintEl) hintEl.style.color = color;
        if (dateIcon) dateIcon.style.color = color;

        const datePicker = document.getElementById('dateColorPicker');
        if (datePicker && color.startsWith('#')) datePicker.value = color;
        const modalDatePicker = document.getElementById('modalDateColorPicker');
        const modalDateHex = document.getElementById('modalDateHex');
        if (modalDatePicker && color.startsWith('#') && modalDatePicker.value !== color) modalDatePicker.value = color;
        if (modalDateHex) modalDateHex.innerText = color;
    }

    function setCardBorderColor(color) {
        if (!color) return;
        const adBar = document.getElementById('main_ad_bar');
        const brandBar = document.getElementById('official_brand_footer');
        const bottomWrapper = document.getElementById('bottomContentWrapper');
        const quoteSymbol = document.getElementById('quoteSymbolBadge');

        if (adBar) adBar.style.borderTopColor = color;
        if (brandBar) brandBar.style.borderTopColor = color;
        if (bottomWrapper && (currentCardStyle === 'quote' || currentCardStyle === 'breaking')) {
            bottomWrapper.style.borderTopColor = color;
        }
        if (quoteSymbol) quoteSymbol.style.color = color;

        const borderPicker = document.getElementById('borderColorPicker');
        if (borderPicker && color.startsWith('#')) borderPicker.value = color;
        const modalBorderPicker = document.getElementById('modalBorderColorPicker');
        const modalBorderHex = document.getElementById('modalBorderHex');
        if (modalBorderPicker && color.startsWith('#') && modalBorderPicker.value !== color) modalBorderPicker.value = color;
        if (modalBorderHex) modalBorderHex.innerText = color;
    }

    // Modal Synchronization Helpers
    function applyModalTheme(themeKey) {
        applyCardTheme(themeKey);
    }

    function syncCustomBg(color) {
        setCustomCardBg(color);
        const hex = document.getElementById('modalCustomBgHex');
        if (hex) hex.innerText = color;
    }

    function syncBorderColor(color) {
        setCardBorderColor(color);
        const hex = document.getElementById('modalBorderHex');
        if (hex) hex.innerText = color;
    }

    function syncDateColor(color) {
        setCardDateColor(color);
        const hex = document.getElementById('modalDateHex');
        if (hex) hex.innerText = color;
    }

    function syncFontFamily(font) {
        changeFontFamily(font);
        const ins = document.getElementById('font_switcher');
        if (ins && ins.value !== font) ins.value = font;
    }

    function syncFontSize(val) {
        updateFontSize(val);
        const ins = document.getElementById('fontSizeSlider');
        const badge = document.getElementById('modalFontSizeBadge');
        if (ins && ins.value != val) ins.value = val;
        if (badge) badge.innerText = val + 'px';
    }

    function syncLineHeight(val) {
        updateLineHeight(val);
        const ins = document.getElementById('lineHeightSlider');
        const badge = document.getElementById('modalLineHeightBadge');
        if (ins && ins.value != val) ins.value = val;
        if (badge) badge.innerText = val;
    }

    function syncHeadlineAlign(align) {
        setHeadlineAlignment(align);
        const btnL = document.getElementById('modalAlignLeftBtn');
        const btnC = document.getElementById('modalAlignCenterBtn');
        if (btnL) btnL.classList.toggle('active', align === 'left');
        if (btnC) btnC.classList.toggle('active', align === 'center');
    }

    function syncQuoteMode(mode) {
        if (typeof setQuotePhotoMode === 'function') {
            setQuotePhotoMode(mode);
        }
        const btnN = document.getElementById('modalQuoteModeNormal');
        const btnC = document.getElementById('modalQuoteModeCutout');
        if (btnN) btnN.classList.toggle('active', mode === 'normal');
        if (btnC) btnC.classList.toggle('active', mode === 'cutout');
    }

    // ----------------------------------------------------
    // Settings Modal Functions: Logo, Ads, Footer & Layout
    // ----------------------------------------------------

    let resetCornerLogoFlag = false;
    let resetWatermarkFlag = false;
    let resetAdFlag = false;

    // 1. Corner Profile Logo Controls
    const defaultCornerLogoSrc = "{{ asset('BJ_Content/Profile Pic b.png') }}";

    function toggleCornerLogoVisibility(visible) {
        const logo = document.getElementById('cardTopLogo');
        if (logo) logo.style.display = visible ? 'flex' : 'none';
    }

    function setCornerLogoPosition(pos) {
        const logo = document.getElementById('cardTopLogo');
        if (logo) {
            if (pos === 'left') {
                logo.style.right = 'auto';
                logo.style.left = '50px';
            } else {
                logo.style.left = 'auto';
                logo.style.right = '50px';
            }
        }
        if (currentCardStyle && currentStyleSettings[currentCardStyle]) {
            currentStyleSettings[currentCardStyle]['logo_position'] = pos;
            const subLeft = document.getElementById('style_pos_left_' + currentCardStyle);
            const subRight = document.getElementById('style_pos_right_' + currentCardStyle);
            if (pos === 'left' && subLeft) subLeft.checked = true;
            if (pos === 'right' && subRight) subRight.checked = true;
        }
        const metaRow = document.getElementById('cardMetaRow');
        const watermark = document.getElementById('cardWatermarkImg');
        if (currentCardStyle === 'poster') {
            if (metaRow) {
                metaRow.style.setProperty('justify-content', pos === 'left' ? 'flex-end' : 'flex-start', 'important');
            }
            if (watermark) {
                watermark.style.setProperty('align-self', pos === 'left' ? 'flex-start' : 'flex-end', 'important');
            }
        }
    }

    function setCornerLogoSize(size) {
        size = parseInt(size, 10) || 135;
        const img = document.getElementById('cornerLogoImg');
        const badge = document.getElementById('cornerLogoSizeBadge');
        if (img) {
            img.style.width = size + 'px';
            img.style.height = size + 'px';
        }
        if (badge) badge.innerText = size + 'px';

        // Keep current style's slider and badge in sync
        if (currentStyleSettings[currentCardStyle]) {
            currentStyleSettings[currentCardStyle].logo_size = size;
            const styleSlider = document.getElementById('style_logo_size_slider_' + currentCardStyle);
            const styleBadge = document.getElementById('style_logo_size_badge_' + currentCardStyle);
            if (styleSlider) styleSlider.value = size;
            if (styleBadge) styleBadge.innerText = size + 'px';
        }
    }

    function toggleCornerLogoShadow(enable) {
        const img = document.getElementById('cornerLogoImg');
        if (img) {
            img.classList.toggle('logo-shadow-effect', !!enable);
            img.classList.toggle('no-shadow', !enable);
        }
    }

    function toggleCornerLogo3DBorder(enable) {
        toggleCornerLogoShadow(enable);
    }

    function previewCornerLogo(input) {
        if (input.files && input.files[0]) {
            resetCornerLogoFlag = false;
            const reader = new FileReader();
            reader.onload = function(e) {
                const cornerImg = document.getElementById('cornerLogoImg');
                const previewImg = document.getElementById('cornerLogoPreviewImg');
                const brandFooterImg = document.getElementById('brandFooterLogoImg');
                if (cornerImg) cornerImg.src = e.target.result;
                if (previewImg) previewImg.src = e.target.result;
                if (brandFooterImg) brandFooterImg.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetCornerLogo() {
        const cornerImg = document.getElementById('cornerLogoImg');
        const previewImg = document.getElementById('cornerLogoPreviewImg');
        const brandFooterImg = document.getElementById('brandFooterLogoImg');
        if (cornerImg) cornerImg.src = defaultCornerLogoSrc;
        if (previewImg) previewImg.src = defaultCornerLogoSrc;
        if (brandFooterImg) brandFooterImg.src = defaultCornerLogoSrc;
        const input = document.getElementById('customCornerLogoInput');
        if (input) input.value = '';
        resetCornerLogoFlag = true;
    }

    // 2. Watermark Logo Controls
    const defaultWatermarkSrc = "{{ !empty($themeSettings['logo_image']) ? asset($themeSettings['logo_image']) : (file_exists(public_path('BJ_Content/Text Logo.png')) ? asset('BJ_Content/Text Logo.png') : '') }}";

    function toggleWatermarkVisibility(visible) {
        const watermark = document.getElementById('cardWatermarkImg');
        if (watermark) watermark.style.display = visible ? 'block' : 'none';
    }

    function setWatermarkOpacity(val) {
        const watermark = document.getElementById('cardWatermarkImg');
        const badge = document.getElementById('watermarkOpacityBadge');
        if (watermark) watermark.style.opacity = (val / 100);
        if (badge) badge.innerText = val + '%';
    }

    function previewWatermark(input) {
        if (input.files && input.files[0]) {
            resetWatermarkFlag = false;
            const reader = new FileReader();
            reader.onload = function(e) {
                const watermark = document.getElementById('cardWatermarkImg');
                const preview = document.getElementById('watermarkPreviewImg');
                if (watermark) watermark.src = e.target.result;
                if (preview) preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetWatermark() {
        const watermark = document.getElementById('cardWatermarkImg');
        const preview = document.getElementById('watermarkPreviewImg');
        if (watermark) watermark.src = defaultWatermarkSrc;
        if (preview) preview.src = defaultWatermarkSrc;
        const input = document.getElementById('customWatermarkInput');
        if (input) input.value = '';
        resetWatermarkFlag = true;
    }

    // 3. Footer & Ads Controls
    const defaultAdSrc = "{{ asset('BJ_Content/ads.png') }}";
    let currentFooterMode = 'ad';

    function setFooterMode(mode) {
        currentFooterMode = mode;
        const cardNode = document.getElementById('social_card_node');
        if (cardNode) {
            cardNode.classList.toggle('footer-none', mode === 'none');
        }
        const adBar = document.getElementById('main_ad_bar');
        const brandBar = document.getElementById('official_brand_footer');
        const bottomWrapper = document.getElementById('bottomContentWrapper');
        const adControls = document.getElementById('footerAdControls');
        const brandControls = document.getElementById('footerBrandControls');

        const btnAd = document.getElementById('fModeAd');
        const btnBrand = document.getElementById('fModeBrand');
        const btnNone = document.getElementById('fModeNone');

        if (btnAd) btnAd.classList.toggle('active', mode === 'ad');
        if (btnBrand) btnBrand.classList.toggle('active', mode === 'brand');
        if (btnNone) btnNone.classList.toggle('active', mode === 'none');

        if (adControls) {
            adControls.style.display = mode === 'ad' ? 'block' : 'none';
        }
        if (brandControls) {
            brandControls.style.display = mode === 'brand' ? 'block' : 'none';
        }

        if (mode === 'ad') {
            if (adBar) adBar.style.display = 'flex';
            if (brandBar) brandBar.style.display = 'none';
            if (bottomWrapper && currentCardStyle !== 'poster') {
                bottomWrapper.style.flex = '0 0 332px';
                bottomWrapper.style.height = '332px';
            }
        } else if (mode === 'brand') {
            if (adBar) adBar.style.display = 'none';
            if (brandBar) brandBar.style.display = 'flex';
            if (bottomWrapper && currentCardStyle !== 'poster') {
                bottomWrapper.style.flex = '0 0 332px';
                bottomWrapper.style.height = '332px';
            }
        } else { // 'none'
            if (adBar) adBar.style.display = 'none';
            if (brandBar) brandBar.style.display = 'none';
            if (bottomWrapper && currentCardStyle !== 'poster') {
                bottomWrapper.style.flex = '0 0 432px';
                bottomWrapper.style.height = '432px';
            }
        }
    }

    function updateBrandFooterTitle(val) {
        const titleEl = document.getElementById('brandFooterTitleText');
        if (titleEl) titleEl.innerText = val.trim() || 'দৈনিক ভোলা জার্নাল';
    }

    function updateBrandFooterTagline(val) {
        const taglineEl = document.getElementById('brandFooterTaglineText');
        if (taglineEl) taglineEl.innerText = val.trim() || 'সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর';
    }

    function updateBrandFooterWeb(val) {
        const webEl = document.getElementById('brandFooterWebText');
        if (webEl) webEl.innerText = val.trim() || 'dailybholajournal.com';
    }

    function updateBrandFooterSocial(val) {
        const socialEl = document.getElementById('brandFooterFbText');
        if (socialEl) socialEl.innerText = val.trim() || '/dailybholajournalBN';
    }

    function previewCustomAdFile(input) {
        if (input.files && input.files[0]) {
            resetAdFlag = false;
            const reader = new FileReader();
            reader.onload = function(e) {
                const adImg = document.getElementById('mainAdImage');
                if (adImg) adImg.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function updateModalAdUrl(url) {
        resetAdFlag = false;
        const adImg = document.getElementById('mainAdImage');
        if (adImg) {
            adImg.src = url.trim() || defaultAdSrc;
        }
    }

    function resetToDefaultAd() {
        const adImg = document.getElementById('mainAdImage');
        if (adImg) adImg.src = defaultAdSrc;
        const fileInput = document.getElementById('custom_ad_file_input');
        const urlInput = document.getElementById('modal_ad_url_input');
        if (fileInput) fileInput.value = '';
        if (urlInput) urlInput.value = '';
        resetAdFlag = true;
    }

    // 4. Reporter Badge & Hint Controls
    function toggleCategoryBadgeVisibility(visible) {
        const wrapper = document.getElementById('reporterBadgeWrapper');
        const badge = document.getElementById('cardCategoryPreview');
        if (wrapper) wrapper.style.display = visible ? 'flex' : 'none';
        else if (badge) badge.style.display = visible ? 'inline-flex' : 'none';
    }

    function setCategoryBadgeColor(color) {
        const badge = document.getElementById('cardCategoryPreview');
        if (badge) badge.style.background = color;
        const picker = document.getElementById('badgeColorPicker');
        if (picker && color.startsWith('#')) picker.value = color;
    }

    function setReporterBadgeBottom(val) {
        const wrapper = document.getElementById('reporterBadgeWrapper');
        const badge1 = document.getElementById('reporterBottomBadge');
        const badge2 = document.getElementById('modalReporterBottomBadge');
        const slider1 = document.getElementById('reporterBottomSlider');
        const slider2 = document.getElementById('modalReporterBottomSlider');

        if (wrapper) wrapper.style.bottom = val + 'px';
        if (badge1) badge1.innerText = val + 'px';
        if (badge2) badge2.innerText = val + 'px';
        if (slider1 && slider1.value != val) slider1.value = val;
        if (slider2 && slider2.value != val) slider2.value = val;
    }

    function toggleDetailsHintVisibility(visible) {
        const hint = document.getElementById('cardDetailsHint');
        if (hint) hint.style.display = visible ? 'inline-block' : 'none';
    }

    function updateCustomHint(text) {
        const hint = document.getElementById('cardDetailsHint');
        if (hint) hint.innerText = text;
    }

    // 5. Headline Alignment
    function setHeadlineAlignment(align) {
        const headline = document.getElementById('editable_headline');
        const wrapper = document.getElementById('cardHeadlineWrapper');
        const metaRow = document.getElementById('cardMetaRow');
        if (headline) headline.style.textAlign = align;
        if (wrapper) wrapper.style.alignItems = align === 'left' ? 'flex-start' : 'center';
        if (metaRow) {
            if (currentCardStyle === 'classic') {
                metaRow.style.setProperty('justify-content', 'flex-start', 'important');
            } else if (currentCardStyle === 'poster') {
                const sCfg = (currentStyleSettings && currentStyleSettings['poster']) || {};
                const logoPos = sCfg.logo_position || (document.getElementById('style_pos_left_poster') && document.getElementById('style_pos_left_poster').checked ? 'left' : (document.getElementById('logoPosLeft') && document.getElementById('logoPosLeft').checked ? 'left' : 'right'));
                metaRow.style.setProperty('justify-content', logoPos === 'left' ? 'flex-end' : 'flex-start', 'important');
            } else {
                metaRow.style.justifyContent = align === 'left' ? 'flex-start' : 'center';
            }
        }

        const btnLeft = document.getElementById('alignLeftBtn');
        const btnCenter = document.getElementById('alignCenterBtn');
        if (btnLeft) btnLeft.classList.toggle('active', align === 'left');
        if (btnCenter) btnCenter.classList.toggle('active', align === 'center');
        const modalBtnLeft = document.getElementById('modalAlignLeftBtn');
        const modalBtnCenter = document.getElementById('modalAlignCenterBtn');
        if (modalBtnLeft) modalBtnLeft.classList.toggle('active', align === 'left');
        if (modalBtnCenter) modalBtnCenter.classList.toggle('active', align === 'center');
    }

    // 6. Image Pan (Vertical Object Position)
    function setImagePan(val) {
        const img = document.getElementById('cardImagePreview');
        const badge = document.getElementById('imgPanBadge');
        if (img) img.style.objectPosition = `center ${val}%`;
        if (badge) badge.innerText = `${val}%`;
    }

    // ----------------------------------------------------
    // Permanent Settings Persistence (Save & Apply)
    // ----------------------------------------------------

    function savePersistentCardSettings() {
        const saveBtn = document.getElementById('saveCardSettingsBtn');
        const quickSaveBtn = document.getElementById('quickSaveDefaultBtn');
        const originalText = saveBtn ? saveBtn.innerHTML : '';
        const originalQuickText = quickSaveBtn ? quickSaveBtn.innerHTML : '';

        if (saveBtn) {
            saveBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-1"></i> সংরক্ষণ হচ্ছে...';
            saveBtn.disabled = true;
        }
        if (quickSaveBtn) {
            quickSaveBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-1"></i> সেভ হচ্ছে...';
            quickSaveBtn.disabled = true;
        }

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('card_style', currentCardStyle);

        // 1. Theme and colors
        const activeThemeBtn = document.querySelector('.btn-theme-preset.active') || document.querySelector('.modal-theme-btn.active');
        const themeKey = currentThemeKey || (activeThemeBtn ? (activeThemeBtn.getAttribute('data-theme') || activeThemeBtn.getAttribute('data-modal-theme')) : 'royal');
        formData.append('theme_key', themeKey);

        const customBg = document.getElementById('customBgColor') ? document.getElementById('customBgColor').value : '#1e3a8a';
        formData.append('custom_bg_color', customBg);

        const dateColor = document.getElementById('dateColorPicker') ? document.getElementById('dateColorPicker').value : '#38bdf8';
        formData.append('date_color', dateColor);

        const borderColor = document.getElementById('borderColorPicker') ? document.getElementById('borderColorPicker').value : '#38bdf8';
        formData.append('border_color', borderColor);

        // 2. Typography
        const fontSwitcher = document.getElementById('font_switcher') || document.getElementById('modal_font_switcher');
        formData.append('font_family', fontSwitcher ? fontSwitcher.value : "'Noto Sans Bengali', sans-serif");

        const fontSizeSlider = document.getElementById('fontSizeSlider') || document.getElementById('modalFontSizeSlider');
        formData.append('font_size', fontSizeSlider ? fontSizeSlider.value : 52);

        const lineHeightSlider = document.getElementById('lineHeightSlider') || document.getElementById('modalLineHeightSlider');
        formData.append('line_height', lineHeightSlider ? lineHeightSlider.value : 1.3);

        const isAlignLeft = document.getElementById('alignLeftBtn') && document.getElementById('alignLeftBtn').classList.contains('active');
        formData.append('headline_align', isAlignLeft ? 'left' : 'center');

        // 3. Corner Logo
        const cornerVisible = document.getElementById('toggleCornerLogo') ? document.getElementById('toggleCornerLogo').checked : true;
        formData.append('corner_logo_visible', cornerVisible ? 1 : 0);

        const logoPosLeft = document.getElementById('logoPosLeft') && document.getElementById('logoPosLeft').checked;
        formData.append('corner_logo_position', logoPosLeft ? 'left' : 'right');

        const cornerSize = document.getElementById('cornerLogoSizeSlider') ? document.getElementById('cornerLogoSizeSlider').value : 135;
        formData.append('corner_logo_size', cornerSize);

        const shadowCheckbox = document.getElementById('toggleCornerLogoShadow') || document.getElementById('toggleCornerLogo3DBorder');
        const cornerShadow = shadowCheckbox ? shadowCheckbox.checked : true;
        formData.append('corner_logo_shadow', cornerShadow ? 1 : 0);
        formData.append('corner_logo_3d_border', 0);

        const cornerFileInput = document.getElementById('customCornerLogoInput');
        if (cornerFileInput && cornerFileInput.files && cornerFileInput.files[0]) {
            formData.append('corner_logo_file', cornerFileInput.files[0]);
        }
        if (resetCornerLogoFlag) {
            formData.append('reset_corner_logo', 1);
        }

        // 4. Watermark
        const watermarkVisible = document.getElementById('toggleWatermark') ? document.getElementById('toggleWatermark').checked : true;
        formData.append('watermark_visible', watermarkVisible ? 1 : 0);

        const watermarkOpacity = document.getElementById('watermarkOpacitySlider') ? document.getElementById('watermarkOpacitySlider').value : 12;
        formData.append('watermark_opacity', watermarkOpacity);

        const watermarkFileInput = document.getElementById('customWatermarkInput');
        if (watermarkFileInput && watermarkFileInput.files && watermarkFileInput.files[0]) {
            formData.append('watermark_file', watermarkFileInput.files[0]);
        }
        if (resetWatermarkFlag) {
            formData.append('reset_watermark', 1);
        }

        // 5. Footer mode, ad & branding
        formData.append('footer_mode', currentFooterMode);

        const brandTitle = document.getElementById('brandFooterTitleText') ? document.getElementById('brandFooterTitleText').innerText.trim() : 'দৈনিক ভোলা জার্নাল';
        formData.append('brand_title', brandTitle);

        const brandTagline = document.getElementById('brandFooterTaglineText') ? document.getElementById('brandFooterTaglineText').innerText.trim() : 'সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর';
        formData.append('brand_tagline', brandTagline);

        const brandWeb = document.getElementById('brandFooterWebText') ? document.getElementById('brandFooterWebText').innerText.trim() : 'dailybholajournal.com';
        formData.append('brand_web', brandWeb);

        const brandSocial = document.getElementById('brandFooterFbText') ? document.getElementById('brandFooterFbText').innerText.trim() : '/dailybholajournalBN';
        formData.append('brand_social', brandSocial);

        const adFileInput = document.getElementById('custom_ad_file_input');
        if (adFileInput && adFileInput.files && adFileInput.files[0]) {
            formData.append('ad_file', adFileInput.files[0]);
        }
        const adUrlInput = document.getElementById('modal_ad_url_input');
        if (adUrlInput && adUrlInput.value.trim()) {
            formData.append('ad_url', adUrlInput.value.trim());
        }
        if (resetAdFlag) {
            formData.append('reset_ad', 1);
        }

        // 6. Reporter badge & hint
        const catBadgeVisible = document.getElementById('toggleCategoryBadge') ? document.getElementById('toggleCategoryBadge').checked : true;
        formData.append('category_badge_visible', catBadgeVisible ? 1 : 0);

        const badgeColor = document.getElementById('badgeColorPicker') ? document.getElementById('badgeColorPicker').value : '#dc2626';
        formData.append('category_badge_color', badgeColor);

        const repBottom = document.getElementById('reporterBottomSlider') ? document.getElementById('reporterBottomSlider').value : 25;
        formData.append('reporter_badge_bottom', repBottom);

        const hintVisible = document.getElementById('toggleDetailsHint') ? document.getElementById('toggleDetailsHint').checked : true;
        formData.append('details_hint_visible', hintVisible ? 1 : 0);

        const hintText = document.getElementById('customHintInput') ? document.getElementById('customHintInput').value : 'বিস্তারিত কমেন্টে......';
        formData.append('details_hint_text', hintText);

        // 7. Quote style photo mode & positioning
        formData.append('quote_cutout_mode', (typeof isQuoteCutout !== 'undefined' && isQuoteCutout) ? 1 : 0);
        formData.append('quote_img_scale', quoteImgScale || 100);
        formData.append('quote_img_y', quoteImgY || 0);
        formData.append('quote_img_x', quoteImgX || 0);

        // 8. Per-style configurations & custom style logos
        const cleanStyleSettings = JSON.parse(JSON.stringify(currentStyleSettings));
        for (const sKey of ['classic', 'poster', 'quote', 'breaking']) {
            if (cleanStyleSettings[sKey]) {
                delete cleanStyleSettings[sKey].logo_image_preview;
            }
        }
        formData.append('style_settings', JSON.stringify(cleanStyleSettings));
        for (const sKey of ['classic', 'poster', 'quote', 'breaking']) {
            if (styleLogoFiles[sKey]) {
                formData.append('style_logo_file_' + sKey, styleLogoFiles[sKey]);
            }
            if (resetStyleLogoFlags[sKey]) {
                formData.append('reset_style_logo_' + sKey, 1);
            }
        }

        fetch(saveSettingsRoute, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (saveBtn) {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            }
            if (quickSaveBtn) {
                quickSaveBtn.innerHTML = originalQuickText;
                quickSaveBtn.disabled = false;
            }
            if (data.success) {
                resetCornerLogoFlag = false;
                resetWatermarkFlag = false;
                resetAdFlag = false;
                for (const sKey of ['classic', 'poster', 'quote', 'breaking']) {
                    delete styleLogoFiles[sKey];
                    delete resetStyleLogoFlags[sKey];
                }

                try {
                    localStorage.setItem('dailybhola_social_card_settings', JSON.stringify(data.settings));
                } catch(e) {}

                showToast(
                    'সেটিংস সংরক্ষিত! 💾',
                    'কার্ডের এই সেটিংস স্থায়ীভাবে সেভ করা হয়েছে। সব পোস্টে এই ডিফল্ট কার্যকর থাকবে।'
                );

                const modalEl = document.getElementById('cardSettingsModal');
                if (modalEl && typeof bootstrap !== 'undefined') {
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) {
                        setTimeout(() => modalInstance.hide(), 600);
                    }
                }
            } else {
                alert('সেটিংস সেভ করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
            }
        })
        .catch(err => {
            console.error('Save settings failed:', err);
            if (saveBtn) {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            }
            if (quickSaveBtn) {
                quickSaveBtn.innerHTML = originalQuickText;
                quickSaveBtn.disabled = false;
            }
            alert('সার্ভারে রিকোয়েস্ট পাঠাতে সমস্যা হয়েছে।');
        });
    }

    function applySavedSettings(settings) {
        if (!settings || typeof settings !== 'object') return;

        // 0. Card Style
        if (settings.card_style) {
            setCardStyle(settings.card_style);
        }

        // 1. Theme
        if (settings.theme_key && settings.theme_key !== 'custom' && cardThemes[settings.theme_key]) {
            applyCardTheme(settings.theme_key);
        } else if (settings.custom_bg_color) {
            setCustomCardBg(settings.custom_bg_color);
        }
        if (settings.date_color) {
            setCardDateColor(settings.date_color);
        }
        if (settings.border_color) {
            setCardBorderColor(settings.border_color);
        }

        // 2. Typography
        if (settings.font_family) {
            changeFontFamily(settings.font_family);
        }
        if (settings.font_size) {
            updateFontSize(settings.font_size);
        }
        if (settings.line_height) {
            updateLineHeight(settings.line_height);
        }
        if (settings.headline_align) {
            setHeadlineAlignment(settings.headline_align);
        }

        // 3. Corner Logo
        if (settings.hasOwnProperty('corner_logo_visible')) {
            const toggle = document.getElementById('toggleCornerLogo');
            if (toggle) toggle.checked = !!settings.corner_logo_visible;
            toggleCornerLogoVisibility(!!settings.corner_logo_visible);
        }
        if (settings.corner_logo_position) {
            const rRadio = document.getElementById('logoPosRight');
            const lRadio = document.getElementById('logoPosLeft');
            if (settings.corner_logo_position === 'left') {
                if (lRadio) lRadio.checked = true;
            } else {
                if (rRadio) rRadio.checked = true;
            }
            setCornerLogoPosition(settings.corner_logo_position);
        }
        if (settings.corner_logo_size) {
            const sizeSlider = document.getElementById('cornerLogoSizeSlider');
            if (sizeSlider) sizeSlider.value = settings.corner_logo_size;
            setCornerLogoSize(settings.corner_logo_size);
        }
        if (settings.hasOwnProperty('corner_logo_shadow') || settings.hasOwnProperty('corner_logo_3d_border')) {
            const shadowVal = settings.hasOwnProperty('corner_logo_shadow') ? !!settings.corner_logo_shadow : true;
            const toggleShadow = document.getElementById('toggleCornerLogoShadow') || document.getElementById('toggleCornerLogo3DBorder');
            if (toggleShadow) toggleShadow.checked = shadowVal;
            toggleCornerLogoShadow(shadowVal);
        }
        if (settings.corner_logo_image) {
            const fullUrl = settings.corner_logo_image.startsWith('http') ? settings.corner_logo_image : '{{ url("/") }}/' + settings.corner_logo_image;
            const cImg = document.getElementById('cornerLogoImg');
            const pImg = document.getElementById('cornerLogoPreviewImg');
            const bImg = document.getElementById('brandFooterLogoImg');
            if (cImg) cImg.src = fullUrl;
            if (pImg) pImg.src = fullUrl;
            if (bImg) bImg.src = fullUrl;
        }

        // 4. Watermark
        if (settings.hasOwnProperty('watermark_visible')) {
            const toggle = document.getElementById('toggleWatermark');
            if (toggle) toggle.checked = !!settings.watermark_visible;
            toggleWatermarkVisibility(!!settings.watermark_visible);
        }
        if (settings.watermark_opacity !== undefined) {
            const slider = document.getElementById('watermarkOpacitySlider');
            if (slider) slider.value = settings.watermark_opacity;
            setWatermarkOpacity(settings.watermark_opacity);
        }
        if (settings.watermark_image) {
            const fullUrl = settings.watermark_image.startsWith('http') ? settings.watermark_image : '{{ url("/") }}/' + settings.watermark_image;
            const wImg = document.getElementById('cardWatermarkImg');
            const pImg = document.getElementById('watermarkPreviewImg');
            if (wImg) wImg.src = fullUrl;
            if (pImg) pImg.src = fullUrl;
        }

        // 5. Footer Mode, Ads & Branding
        if (settings.footer_mode) {
            setFooterMode(settings.footer_mode);
        }
        if (settings.brand_title) {
            const el = document.getElementById('brandFooterTitleText');
            const inp = document.getElementById('modal_brand_title_input');
            if (el) el.innerText = settings.brand_title;
            if (inp) inp.value = settings.brand_title;
        }
        if (settings.brand_tagline) {
            const el = document.getElementById('brandFooterTaglineText');
            const inp = document.getElementById('modal_brand_tagline_input');
            if (el) el.innerText = settings.brand_tagline;
            if (inp) inp.value = settings.brand_tagline;
        }
        if (settings.brand_web) {
            const el = document.getElementById('brandFooterWebText');
            const inp = document.getElementById('modal_brand_web_input');
            if (el) el.innerText = settings.brand_web;
            if (inp) inp.value = settings.brand_web;
        }
        if (settings.brand_social) {
            const el = document.getElementById('brandFooterFbText');
            const inp = document.getElementById('modal_brand_social_input');
            if (el) el.innerText = settings.brand_social;
            if (inp) inp.value = settings.brand_social;
        }
        if (settings.ad_image) {
            const fullUrl = settings.ad_image.startsWith('http') ? settings.ad_image : '{{ url("/") }}/' + settings.ad_image;
            const adImg = document.getElementById('mainAdImage');
            if (adImg) adImg.src = fullUrl;
            const adUrlInput = document.getElementById('modal_ad_url_input');
            if (adUrlInput && settings.ad_image.startsWith('http')) {
                adUrlInput.value = settings.ad_image;
            }
        }

        // 6. Reporter Badge
        if (settings.hasOwnProperty('category_badge_visible')) {
            const toggle = document.getElementById('toggleCategoryBadge');
            if (toggle) toggle.checked = !!settings.category_badge_visible;
            toggleCategoryBadgeVisibility(!!settings.category_badge_visible);
        }
        if (settings.category_badge_color) {
            setCategoryBadgeColor(settings.category_badge_color);
        }
        if (settings.reporter_badge_bottom !== undefined) {
            setReporterBadgeBottom(settings.reporter_badge_bottom);
        }

        // 7. Details Hint
        if (settings.hasOwnProperty('details_hint_visible')) {
            const toggle = document.getElementById('toggleDetailsHint');
            if (toggle) toggle.checked = !!settings.details_hint_visible;
            toggleDetailsHintVisibility(!!settings.details_hint_visible);
        }
        if (settings.details_hint_text) {
            const hintInput = document.getElementById('customHintInput');
            if (hintInput) hintInput.value = settings.details_hint_text;
            updateCustomHint(settings.details_hint_text);
        }

        // 8. Quote Photo Mode & Transform
        if (settings.hasOwnProperty('quote_cutout_mode')) {
            if (typeof setQuotePhotoMode === 'function') {
                setQuotePhotoMode(settings.quote_cutout_mode ? 'cutout' : 'normal');
            }
        }
        if (settings.quote_img_scale !== undefined && settings.quote_img_scale !== false) {
            setQuoteImgScale(settings.quote_img_scale);
            const slider = document.getElementById('quoteScaleSlider');
            if (slider) slider.value = settings.quote_img_scale;
        }
        if (settings.quote_img_y !== undefined && settings.quote_img_y !== false) {
            setQuoteImgY(settings.quote_img_y);
            const slider = document.getElementById('quoteYSlider');
            if (slider) slider.value = settings.quote_img_y;
        }
        if (settings.quote_img_x !== undefined && settings.quote_img_x !== false) {
            setQuoteImgX(settings.quote_img_x);
            const slider = document.getElementById('quoteXSlider');
            if (slider) slider.value = settings.quote_img_x;
        }

        // 9. Sync Modal-specific typography & theme controls
        if (settings.theme_key) {
            document.querySelectorAll('.modal-theme-btn').forEach(btn => {
                btn.classList.toggle('active', btn.getAttribute('data-modal-theme') === settings.theme_key);
            });
        }
        if (settings.custom_bg_color) {
            const mBg = document.getElementById('modalCustomBgColor');
            const mHex = document.getElementById('modalCustomBgHex');
            if (mBg) mBg.value = settings.custom_bg_color;
            if (mHex) mHex.innerText = settings.custom_bg_color;
        }
        if (settings.border_color) {
            const mBorder = document.getElementById('modalBorderColorPicker');
            const mHex = document.getElementById('modalBorderHex');
            if (mBorder) mBorder.value = settings.border_color;
            if (mHex) mHex.innerText = settings.border_color;
        }
        if (settings.date_color) {
            const mDate = document.getElementById('modalDateColorPicker');
            const mHex = document.getElementById('modalDateHex');
            if (mDate) mDate.value = settings.date_color;
            if (mHex) mHex.innerText = settings.date_color;
        }
        if (settings.font_family) {
            const mFont = document.getElementById('modal_font_switcher');
            if (mFont) mFont.value = settings.font_family;
        }
        if (settings.font_size) {
            const mSize = document.getElementById('modalFontSizeSlider');
            const mBadge = document.getElementById('modalFontSizeBadge');
            if (mSize) mSize.value = settings.font_size;
            if (mBadge) mBadge.innerText = settings.font_size + 'px';
        }
        if (settings.line_height) {
            const mLine = document.getElementById('modalLineHeightSlider');
            const mBadge = document.getElementById('modalLineHeightBadge');
            if (mLine) mLine.value = settings.line_height;
            if (mBadge) mBadge.innerText = settings.line_height;
        }
        if (settings.headline_align) {
            const btnL = document.getElementById('modalAlignLeftBtn');
            const btnC = document.getElementById('modalAlignCenterBtn');
            if (btnL) btnL.classList.toggle('active', settings.headline_align === 'left');
            if (btnC) btnC.classList.toggle('active', settings.headline_align === 'center');
        }
        if (settings.hasOwnProperty('quote_cutout_mode')) {
            const mBtnN = document.getElementById('modalQuoteModeNormal');
            const mBtnC = document.getElementById('modalQuoteModeCutout');
            if (mBtnN) mBtnN.classList.toggle('active', !settings.quote_cutout_mode);
            if (mBtnC) mBtnC.classList.toggle('active', !!settings.quote_cutout_mode);
        }

        // 10. Per-style configurations & show/hide objects
        if (settings.style_settings && typeof settings.style_settings === 'object') {
            for (const sKey of ['classic', 'poster', 'quote', 'breaking']) {
                if (settings.style_settings[sKey]) {
                    currentStyleSettings[sKey] = Object.assign({}, defaultStyleSettings[sKey], settings.style_settings[sKey]);
                    const cfg = currentStyleSettings[sKey];

                    const logoSw = document.getElementById('style_obj_' + sKey + '_logo');
                    if (logoSw) logoSw.checked = !!cfg.logo_visible;
                    const wmSw = document.getElementById('style_obj_' + sKey + '_watermark');
                    if (wmSw) wmSw.checked = !!cfg.watermark_visible;
                    const bdgSw = document.getElementById('style_obj_' + sKey + '_badge');
                    if (bdgSw) bdgSw.checked = !!cfg.badge_visible;
                    const dtSw = document.getElementById('style_obj_' + sKey + '_date');
                    if (dtSw) dtSw.checked = !!cfg.date_visible;
                    const hntSw = document.getElementById('style_obj_' + sKey + '_hint');
                    if (hntSw) hntSw.checked = !!cfg.hint_visible;
                    const ftrSw = document.getElementById('style_obj_' + sKey + '_footer');
                    if (ftrSw) ftrSw.checked = !!cfg.footer_visible;

                    if (sKey === 'quote') {
                        const qSymSw = document.getElementById('style_obj_quote_quote_symbol');
                        if (qSymSw) qSymSw.checked = cfg.quote_symbol_visible !== false;
                        const spkSw = document.getElementById('style_obj_quote_speaker');
                        if (spkSw) spkSw.checked = cfg.speaker_visible !== false;
                    }
                    if (sKey === 'breaking') {
                        const excSw = document.getElementById('style_obj_breaking_excerpt');
                        if (excSw) excSw.checked = cfg.excerpt_visible !== false;
                    }

                    const rRadio = document.getElementById('style_pos_right_' + sKey);
                    const lRadio = document.getElementById('style_pos_left_' + sKey);
                    if (cfg.logo_position === 'left') {
                        if (lRadio) lRadio.checked = true;
                    } else {
                        if (rRadio) rRadio.checked = true;
                    }

                    if (cfg.logo_size) {
                        const styleSlider = document.getElementById('style_logo_size_slider_' + sKey);
                        const styleBadge = document.getElementById('style_logo_size_badge_' + sKey);
                        if (styleSlider) styleSlider.value = cfg.logo_size;
                        if (styleBadge) styleBadge.innerText = cfg.logo_size + 'px';
                    }

                    const previewImg = document.getElementById('styleLogoPreview_' + sKey);
                    const logoBox = document.getElementById('styleLogoBox_' + sKey);
                    const noLogoBox = document.getElementById('styleNoLogoBox_' + sKey);
                    if (previewImg) {
                        const fallbackLogo = (sKey === 'poster') ? '' : (settings.corner_logo_image ? (settings.corner_logo_image.startsWith('http') || settings.corner_logo_image.startsWith('/') ? settings.corner_logo_image : ('/' + settings.corner_logo_image)) : "{{ asset('BJ_Content/Profile Pic b.png') }}");
                        const sLogo = cfg.logo_image ? (cfg.logo_image.startsWith('http') || cfg.logo_image.startsWith('/') ? cfg.logo_image : ('/' + cfg.logo_image)) : fallbackLogo;
                        if (sLogo) {
                            previewImg.src = sLogo;
                            if (logoBox) logoBox.style.display = '';
                            if (noLogoBox) noLogoBox.style.display = 'none';
                        } else {
                            if (logoBox) logoBox.style.display = 'none';
                            if (noLogoBox) noLogoBox.style.display = 'flex';
                        }
                    }
                }
            }
        }
        applyStyleObjectSettings(currentCardStyle);
    }

    function resetAllCardSettings() {
        if (!confirm('আপনি কি সব কার্ড সেটিংস ডিফল্টে রিসেট করতে চান?')) return;
        const defaultSettings = {
            card_style: 'classic',
            theme_key: 'royal',
            custom_bg_color: '#1e3a8a',
            date_color: '#38bdf8',
            border_color: '#38bdf8',
            font_family: "'Noto Sans Bengali', sans-serif",
            font_size: 52,
            line_height: 1.3,
            headline_align: 'center',
            corner_logo_visible: true,
            corner_logo_position: 'right',
            corner_logo_size: 135,
            corner_logo_shadow: true,
            corner_logo_3d_border: false,
            corner_logo_image: '',
            watermark_visible: true,
            watermark_opacity: 12,
            watermark_image: '',
            footer_mode: 'ad',
            ad_image: '',
            brand_title: 'দৈনিক ভোলা জার্নাল',
            brand_tagline: 'সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর',
            brand_web: 'dailybholajournal.com',
            brand_social: '/dailybholajournalBN',
            category_badge_visible: true,
            category_badge_color: '#dc2626',
            reporter_badge_bottom: 25,
            details_hint_visible: true,
            details_hint_text: 'বিস্তারিত কমেন্টে......',
            style_settings: defaultStyleSettings
        };
        resetCornerLogo();
        resetWatermark();
        resetToDefaultAd();
        applySavedSettings(defaultSettings);
        savePersistentCardSettings();
    }

    // Toggle left inspector panel collapse/expand
    function toggleInspectorPanel() {
        const panel = document.getElementById('inspectorPanel');
        const btn = document.getElementById('togglePanelBtn');
        const icon = document.getElementById('togglePanelIcon');
        
        if (panel.classList.contains('collapsed')) {
            panel.classList.remove('collapsed');
            panel.classList.add('open');
            icon.className = 'fa-solid fa-sliders';
            btn.title = 'প্যানেল লুকান';
        } else {
            panel.classList.add('collapsed');
            panel.classList.remove('open');
            icon.className = 'fa-solid fa-chevron-right';
            btn.title = 'প্যানেল দেখান';
        }
        
        // Wait for CSS transition then trigger canvas resizing
        setTimeout(resizeCanvasWorkspace, 305);
    }

    // Toggle bottom control bar (back-compatibility/no-op)
    function toggleBottomBar() {
        toggleInspectorPanel();
    }

    // Background Image updater
    function updateCardBackground() {
        const cardImg = document.getElementById('cardImagePreview');
        const placeholder = document.getElementById('cardImagePlaceholder');
        const src = socialCardImageSrc || featuredImageSrc;
        const thumb = document.getElementById('bg_thumb_preview');
        const qThumb = document.getElementById('quote_speaker_thumb');

        if (src) {
            if (cardImg) {
                cardImg.src = src;
                cardImg.style.display = 'block';
            }
            if (placeholder) placeholder.style.display = 'none';
            if (thumb) {
                thumb.src = src;
                thumb.style.display = 'block';
            }
            if (qThumb) {
                qThumb.src = src;
                qThumb.style.display = 'block';
            }
        } else {
            if (cardImg) {
                cardImg.src = '';
                cardImg.style.display = 'none';
            }
            if (placeholder) placeholder.style.display = 'flex';
            if (thumb) {
                thumb.src = '';
                thumb.style.display = 'none';
            }
            if (qThumb) {
                qThumb.src = '';
                qThumb.style.display = 'none';
            }
        }
    }

    // Sync Custom Social Card Image upload
    function previewSocialCardImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                socialCardImageSrc = e.target.result;
                updateCardBackground();
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            socialCardImageSrc = '{{ $post->social_card_image ? $post->social_card_image_url : "" }}';
            updateCardBackground();
        }
    }

    // Quote Photo Mode (Normal Frame vs Full-Width Cutout) & Transformation
    let isQuoteCutout = @json(!empty($cardSettings['quote_cutout_mode']));
    let quoteImgScale = @json(is_numeric($cardSettings['quote_img_scale'] ?? null) ? (float)$cardSettings['quote_img_scale'] : 100);
    let quoteImgY = @json(is_numeric($cardSettings['quote_img_y'] ?? null) ? (int)$cardSettings['quote_img_y'] : 0);
    let quoteImgX = @json(is_numeric($cardSettings['quote_img_x'] ?? null) ? (int)$cardSettings['quote_img_x'] : 0);

    function setQuotePhotoMode(mode) {
        isQuoteCutout = (mode === 'cutout');
        const wrapper = document.getElementById('newsImageWrapper');
        const normalBtn = document.getElementById('modeNormalBtn');
        const cutoutBtn = document.getElementById('modeCutoutBtn');
        const slidersBox = document.getElementById('cutoutSlidersBox');
        if (wrapper) {
            if (isQuoteCutout) {
                wrapper.classList.add('quote-cutout-mode');
            } else {
                wrapper.classList.remove('quote-cutout-mode');
            }
        }
        if (normalBtn) normalBtn.classList.toggle('active', !isQuoteCutout);
        if (cutoutBtn) cutoutBtn.classList.toggle('active', isQuoteCutout);
        if (slidersBox) slidersBox.style.display = isQuoteCutout ? 'block' : 'none';
        updateQuoteImgTransform();
    }

    function updateQuoteImgTransform() {
        const cardImg = document.getElementById('cardImagePreview');
        if (!cardImg) return;
        if ((currentCardStyle === 'quote' || currentCardStyle === 'breaking') && isQuoteCutout) {
            cardImg.style.transform = `scale(${quoteImgScale / 100}) translate(${quoteImgX}px, ${quoteImgY}px)`;
        } else {
            cardImg.style.removeProperty('transform');
        }
    }

    function setQuoteImgScale(val) {
        quoteImgScale = parseFloat(val) || 100;
        const badge = document.getElementById('quoteScaleBadge');
        if (badge) badge.innerText = quoteImgScale + '%';
        updateQuoteImgTransform();
    }

    function setQuoteImgY(val) {
        quoteImgY = parseInt(val) || 0;
        const badge = document.getElementById('quoteYBadge');
        if (badge) badge.innerText = quoteImgY + 'px';
        updateQuoteImgTransform();
    }

    function setQuoteImgX(val) {
        quoteImgX = parseInt(val) || 0;
        const badge = document.getElementById('quoteXBadge');
        if (badge) badge.innerText = quoteImgX + 'px';
        updateQuoteImgTransform();
    }

    // Sync Speaker Photo upload (auto detects PNG for cutout mode)
    function previewQuoteSpeakerImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const isPng = file.type === 'image/png' || file.name.toLowerCase().endsWith('.png');
            const reader = new FileReader();
            reader.onload = function(e) {
                socialCardImageSrc = e.target.result;
                updateCardBackground();
                if (isPng) {
                    setQuotePhotoMode('cutout');
                }
            }
            reader.readAsDataURL(file);
        }
    }

    // Custom Toast Notification Controller
    function showToast(title, desc) {
        const toast = document.getElementById('studioToast');
        const tTitle = document.getElementById('toastTitle');
        const tDesc = document.getElementById('toastDesc');
        
        if (toast && tTitle && tDesc) {
            tTitle.innerText = title;
            tDesc.innerText = desc;
            
            toast.classList.add('show');
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                toast.classList.remove('show');
            }, 5000);
        }
    }

    // Share & Copy to Clipboard Workflow for Facebook
    function shareOnFacebook(e) {
        e.preventDefault();
        const node = document.getElementById('social_card_node');
        const scaleContainer = document.getElementById('scaleContainer');
        const btn = e.currentTarget;
        const originalText = btn.innerHTML;

        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i> পোস্ট প্রসেস হচ্ছে...';
        btn.style.pointerEvents = 'none';

        // 1. Remove text cursor caret by blurring active editable element
        const activeEl = document.activeElement;
        if (activeEl && activeEl.isContentEditable) {
            activeEl.blur();
        }

        // 2. Temporarily save and reset scaling transform to 1 (natural 1080x1080 size) to avoid html2canvas crop bugs
        const originalTransform = scaleContainer ? scaleContainer.style.transform : '';
        if (scaleContainer) {
            scaleContainer.style.transform = 'none';
        }

        // 3. Add exporting class to strip borders, outlines, hover tooltips, and revert padding
        node.classList.add('exporting');

        // 4. Capture Canvas image and download it
        setTimeout(() => {
            html2canvas(node, {
                useCORS: true,
                allowTaint: false,
                width: 1080,
                height: 1080,
                scale: 2, 
                backgroundColor: '#000000'
            }).then(canvas => {
                // Restore exporting class and scale transform immediately
                node.classList.remove('exporting');
                if (scaleContainer) {
                    scaleContainer.style.transform = originalTransform;
                }

                // Download JPG card
                const link = document.createElement('a');
                link.download = 'NewsCard-DailyBholaJournal-{{ $post->id }}.jpg';
                link.href = canvas.toDataURL("image/jpeg", 0.95);
                link.click();

                // 5. Copy Headline and Public URL to Clipboard as Caption
                const headlineText = document.getElementById('editable_headline').innerText.trim();
                const postLink = '{{ route("post", $post->slug) }}';
                const clipboardText = `${headlineText}\n\nবিস্তারিত পড়তে ক্লিক করুন: ${postLink}`;

                navigator.clipboard.writeText(clipboardText).then(() => {
                    // Show a stunning premium success toast
                    showToast(
                        'ক্যাপশন ও লিংক কপিড! 📥',
                        'নিউজ ইমেজ ডাউনলোড হয়েছে। ফেসবুকে ছবিটি আপলোড করে ক্যাপশনটি পেস্ট (Ctrl+V) করুন।'
                    );
                    
                    // 6. Open Facebook in a new tab after 1.5 seconds
                    setTimeout(() => {
                        window.open('https://www.facebook.com/', '_blank');
                    }, 1500);
                }).catch(err => {
                    console.error("Clipboard copy failed:", err);
                    showToast('ডাউনলোড সম্পূর্ণ! 📥', 'ছবিটি ডাউনলোড হয়েছে। ফেসবুকে আপলোড করুন।');
                });
                
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            }).catch(err => {
                node.classList.remove('exporting');
                if (scaleContainer) {
                    scaleContainer.style.transform = originalTransform;
                }
                console.error("html2canvas render failed:", err);
                alert("ছবি প্রস্তুত করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।");
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            });
        }, 180);
    }

    // Save as Image Function
    function download_SocialCard(e) {
        e.preventDefault();
        const node = document.getElementById('social_card_node');
        const scaleContainer = document.getElementById('scaleContainer');
        const btn = e.currentTarget;
        const originalText = btn.innerHTML;

        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i> ক্যানভাস প্রস্তুত হচ্ছে...';
        btn.style.pointerEvents = 'none';

        // 1. Remove text cursor caret by blurring active editable element
        const activeEl = document.activeElement;
        if (activeEl && activeEl.isContentEditable) {
            activeEl.blur();
        }

        // 2. Temporarily save and reset scaling transform to 1 (natural 1080x1080 size) to avoid html2canvas crop bugs
        const originalTransform = scaleContainer ? scaleContainer.style.transform : '';
        if (scaleContainer) {
            scaleContainer.style.transform = 'none';
        }

        // 3. Add exporting class to strip borders, outlines, hover tooltips, and revert padding
        node.classList.add('exporting');

        // Brief delay to ensure browser layout adjusts and styles propagate
        setTimeout(() => {
            html2canvas(node, {
                useCORS: true,
                allowTaint: false,
                width: 1080,
                height: 1080,
                scale: 2, 
                backgroundColor: '#000000'
            }).then(canvas => {
                // 4. Restore exporting class and scale transform immediately
                node.classList.remove('exporting');
                if (scaleContainer) {
                    scaleContainer.style.transform = originalTransform;
                }

                const link = document.createElement('a');
                link.download = 'NewsCard-DailyBholaJournal-{{ $post->id }}.jpg';
                link.href = canvas.toDataURL("image/jpeg", 0.95);
                link.click();
                
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            }).catch(err => {
                node.classList.remove('exporting');
                if (scaleContainer) {
                    scaleContainer.style.transform = originalTransform;
                }
                console.error("html2canvas render failed:", err);
                alert("ছবি সেভ করতে সমস্যা হয়েছে। কনসোল লগ চেক করুন বা ইমেজ লিংকগুলো ঠিক আছে কিনা দেখুন।");
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            });
        }, 180);
    }

    // Dynamic Auto-scaling for the 1080x1080 canvas workspace
    function resizeCanvasWorkspace() {
        const workspace = document.getElementById('canvasWorkspace');
        const scaleContainer = document.getElementById('scaleContainer');
        if (!workspace || !scaleContainer) return;

        const isMobile = window.innerWidth <= 768;

        if (isMobile) {
            // Mobile: scale canvas to fit viewport width
            const padding = 20;
            const availableWidth = workspace.clientWidth || (window.innerWidth - padding * 2);
            const scale = Math.min((availableWidth - padding) / 1080, 0.32);
            scaleContainer.style.transform = `scale(${scale})`;
            // Set workspace min-height so the canvas is fully visible
            const scaledHeight = 1080 * scale + 30;
            workspace.style.minHeight = scaledHeight + 'px';
        } else {
            const wWidth = workspace.clientWidth;
            const wHeight = workspace.clientHeight;
            // Fit 1080x1080 canvas inside workspace with dynamic margin padding
            const targetSize = 1080;
            const padding = 70; // 35px padding on each side
            const scale = Math.min((wWidth - padding) / targetSize, (wHeight - padding) / targetSize);
            scaleContainer.style.transform = `scale(${scale})`;
        }
    }

    // Mobile Inspector Panel Toggle
    function toggleMobileInspector() {
        const panel = document.getElementById('inspectorPanel');
        const btn = document.getElementById('mobileInspectorToggle');
        if (!panel) return;

        const isOpen = panel.classList.toggle('mobile-open');
        if (btn) {
            btn.innerHTML = isOpen
                ? '<i class="fa-solid fa-xmark me-1"></i> বন্ধ করুন'
                : '<i class="fa-solid fa-sliders me-1"></i> কাস্টমাইজ';
        }
    }

    // Character length counter function
    function updateCharCount(text) {
        const countBadge = document.getElementById('charCount');
        if (countBadge) {
            countBadge.innerText = text.length;
            if (text.length > 80) {
                countBadge.style.color = '#dc2626';
            } else {
                countBadge.style.color = '#475569';
            }
        }
    }

    // Event Listeners for real-time form bindings and auto-resizing
    document.addEventListener('DOMContentLoaded', function() {
        const headlineInput = document.getElementById('live_headline_input');
        const headlinePreview = document.getElementById('editable_headline');

        if (headlineInput && headlinePreview) {
            headlineInput.addEventListener('input', function() {
                headlinePreview.innerText = this.value || 'সংবাদের শিরোনাম এখানে লিখুন...';
                updateCharCount(this.value);
            });
            updateCharCount(headlineInput.value);
        }

        const catInput = document.getElementById('live_category_input');
        const catPreview = document.getElementById('cardCategoryPreview');
        if (catInput && catPreview) {
            catInput.addEventListener('input', function() {
                catPreview.innerText = this.value || 'নিজস্ব প্রতিবেদক';
            });
            catPreview.addEventListener('input', function() {
                catInput.value = this.innerText;
            });
        }

        // Quote style (Style 3) input two-way synchronization
        const quoteInput = document.getElementById('live_quote_input');
        const quotePreview = document.getElementById('editable_quote_text');
        if (quoteInput && quotePreview) {
            quoteInput.addEventListener('input', function() {
                quotePreview.innerText = this.value || 'উক্তি বা বক্তব্য এখানে লিখুন...';
            });
            quotePreview.addEventListener('input', function() {
                quoteInput.value = this.innerText;
            });
        }

        const speakerNameInput = document.getElementById('live_speaker_name_input');
        const speakerNamePreview = document.getElementById('quoteSpeakerName');
        if (speakerNameInput && speakerNamePreview) {
            speakerNameInput.addEventListener('input', function() {
                speakerNamePreview.innerText = this.value || '— বক্তার নাম';
            });
            speakerNamePreview.addEventListener('input', function() {
                speakerNameInput.value = this.innerText;
            });
        }

        const speakerTitleInput = document.getElementById('live_speaker_title_input');
        const speakerTitlePreview = document.getElementById('quoteSpeakerTitle');
        if (speakerTitleInput && speakerTitlePreview) {
            speakerTitleInput.addEventListener('input', function() {
                speakerTitlePreview.innerText = this.value || 'পদবি / পরিচয়';
            });
            speakerTitlePreview.addEventListener('input', function() {
                speakerTitleInput.value = this.innerText;
            });
        }

        // Breaking News (Style 4) Sub-Excerpt two-way synchronization
        const breakingExcerptInput = document.getElementById('live_breaking_excerpt_input');
        const breakingExcerptPreview = document.getElementById('editable_breaking_excerpt');
        if (breakingExcerptInput && breakingExcerptPreview) {
            breakingExcerptInput.addEventListener('input', function() {
                breakingExcerptPreview.innerText = this.value || '';
            });
            breakingExcerptPreview.addEventListener('input', function() {
                breakingExcerptInput.value = this.innerText;
            });
        }

        // Official Brand Footer two-way synchronization
        const brandTitleInput = document.getElementById('modal_brand_title_input');
        const brandTitlePreview = document.getElementById('brandFooterTitleText');
        if (brandTitleInput && brandTitlePreview) {
            brandTitleInput.addEventListener('input', function() {
                brandTitlePreview.innerText = this.value || 'দৈনিক ভোলা জার্নাল';
            });
            brandTitlePreview.addEventListener('input', function() {
                brandTitleInput.value = this.innerText;
            });
        }

        const brandTaglineInput = document.getElementById('modal_brand_tagline_input');
        const brandTaglinePreview = document.getElementById('brandFooterTaglineText');
        if (brandTaglineInput && brandTaglinePreview) {
            brandTaglineInput.addEventListener('input', function() {
                brandTaglinePreview.innerText = this.value || 'সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর';
            });
            brandTaglinePreview.addEventListener('input', function() {
                brandTaglineInput.value = this.innerText;
            });
        }

        const brandWebInput = document.getElementById('modal_brand_web_input');
        const brandWebPreview = document.getElementById('brandFooterWebText');
        if (brandWebInput && brandWebPreview) {
            brandWebInput.addEventListener('input', function() {
                brandWebPreview.innerText = this.value || 'dailybholajournal.com';
            });
            brandWebPreview.addEventListener('input', function() {
                brandWebInput.value = this.innerText;
            });
        }

        const brandSocialInput = document.getElementById('modal_brand_social_input');
        const brandSocialPreview = document.getElementById('brandFooterFbText');
        if (brandSocialInput && brandSocialPreview) {
            brandSocialInput.addEventListener('input', function() {
                brandSocialPreview.innerText = this.value || '/dailybholajournalBN';
            });
            brandSocialPreview.addEventListener('input', function() {
                brandSocialInput.value = this.innerText;
            });
        }

        // Apply saved permanent card settings
        try {
            applySavedSettings(serverCardSettings);
        } catch(e) {
            console.error('applySavedSettings error:', e);
        }

        // Ensure quote photo mode is initialized
        try {
            if (typeof setQuotePhotoMode === 'function') {
                setQuotePhotoMode(isQuoteCutout ? 'cutout' : 'normal');
            }
        } catch(e) {
            console.error('setQuotePhotoMode error:', e);
        }

        // Generate Bengali dynamic date for first load
        try {
            updateBengaliDate();
        } catch(e) {
            console.error('updateBengaliDate error:', e);
        }

        // Perform initial canvas scaling fit
        try {
            resizeCanvasWorkspace();
        } catch(e) {
            console.error('resizeCanvasWorkspace error:', e);
        }
        
        // Initialize background upload thumbnail if any exists on load
        try {
            updateCardBackground();
        } catch(e) {
            console.error('updateCardBackground error:', e);
        }

        // Apply quote cutout transform
        try {
            updateQuoteImgTransform();
        } catch(e) {
            console.error('updateQuoteImgTransform error:', e);
        }

        // Bind sidebar toggling buttons to resize layout with transition delay
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');
        if (openBtn) openBtn.addEventListener('click', () => setTimeout(resizeCanvasWorkspace, 280));
        if (closeBtn) closeBtn.addEventListener('click', () => setTimeout(resizeCanvasWorkspace, 280));

        // Bind window resize event
        window.addEventListener('resize', resizeCanvasWorkspace);
    });
</script>
@endsection
