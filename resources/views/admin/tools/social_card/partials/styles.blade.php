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
        font-size: 24px; 
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
        padding: 0 35px 0 25px;
        z-index: 20;
        font-family: 'Noto Sans Bengali', sans-serif;
        box-sizing: border-box;
        position: relative;
        overflow: visible;
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
        flex-shrink: 0;
        height: 100%;
    }
    .brand-footer-watermark-logo,
    .brand-footer-icon {
        height: 95px !important;
        max-height: 95px !important;
        max-width: 440px !important;
        width: auto !important;
        object-fit: contain !important;
        display: block !important;
        filter: drop-shadow(0 0 1.5px rgba(255, 255, 255, 0.95)) 
                drop-shadow(0 0 8px rgba(255, 255, 255, 0.5)) 
                drop-shadow(0 3px 12px rgba(0, 0, 0, 0.9)) !important;
        transition: filter 0.2s ease, transform 0.2s ease;
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

</style>
