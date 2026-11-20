{{-- =========================================================================
     TEMPLATE 4: BREAKING NEWS (জরুরি ও ব্রেকিং নিউজ বুলেটিন কার্ড)
     ========================================================================= --}}
<style>
    /* STYLE 4: BREAKING NEWS (ব্রেকিং নিউজ বুলেটিন কার্ড) */
    .breaking-news-header { display: none !important; }
    .breaking-badge-pill { display: none !important; }
    .breaking-excerpt-text { display: none; }

    /* 1. Subtle luxury texture overlay on breaking news card */
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

    .news-card-1080.style-breaking .quote-side-column {
        display: none !important;
    }

    /* 2. Headline at TOP and Sub-Headline below in FULL WIDTH (width: 960px) */
    .news-card-1080.style-breaking .headline-wrapper {
        position: absolute !important;
        top: 60px !important;
        left: 60px !important;
        width: 960px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        pointer-events: auto !important;
        z-index: 15 !important;
    }
    .news-card-1080.style-breaking .news-headline {
        display: block !important;
        font-size: 50px !important;
        line-height: 1.35 !important;
        font-weight: 800 !important;
        color: #ffffff !important;
        text-align: left !important;
        text-shadow: 0 4px 16px rgba(0, 0, 0, 0.95), 0 2px 4px rgba(0, 0, 0, 0.9) !important;
        font-family: 'Noto Sans Bengali', sans-serif !important;
        letter-spacing: 0.2px !important;
        margin-bottom: 0 !important;
        width: 100% !important;
        word-break: break-word !important;
    }
    .news-card-1080.style-breaking .breaking-excerpt-text {
        display: block !important;
        margin-top: 20px !important;
        font-size: 28px !important;
        line-height: 1.55 !important;
        font-weight: 600 !important;
        color: #f8fafc !important;
        opacity: 0.95 !important;
        text-align: left !important;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.9) !important;
        font-family: 'Noto Sans Bengali', sans-serif !important;
        word-break: break-word !important;
        border-left: 4px solid #ef4444 !important;
        padding-left: 18px !important;
        width: 100% !important;
    }
    .news-card-1080.style-breaking .quote-symbol-badge,
    .news-card-1080.style-breaking .quote-excerpt-text,
    .news-card-1080.style-breaking .quote-speaker-wrapper {
        display: none !important;
    }

    /* 3. Unified Logo & Date Stack at BOTTOM LEFT (Logo on top, Date below with background capsule) */
    .news-card-1080.style-breaking .card-brand-date-stack {
        position: absolute !important;
        bottom: 185px !important;
        left: 60px !important;
        right: auto !important;
        top: auto !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 8px !important;
        background: rgba(10, 15, 30, 0.85) !important;
        backdrop-filter: blur(14px) !important;
        -webkit-backdrop-filter: blur(14px) !important;
        padding: 12px 22px !important;
        border-radius: 18px !important;
        border: 1.5px solid rgba(255, 255, 255, 0.22) !important;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.6) !important;
        z-index: 20 !important;
        pointer-events: auto !important;
    }
    .news-card-1080.style-breaking.footer-none .card-brand-date-stack {
        bottom: 105px !important;
    }
    .news-card-1080.style-breaking .card-top-right-logo {
        display: flex !important;
        position: relative !important;
        top: auto !important;
        right: auto !important;
        left: auto !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .news-card-1080.style-breaking .card-top-right-logo img {
        width: 120px !important;
        height: auto !important;
        max-height: 55px !important;
        object-fit: contain !important;
        filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.7)) !important;
    }
    .news-card-1080.style-breaking .meta-row.style-stack-date {
        display: flex !important;
        position: relative !important;
        top: auto !important;
        right: auto !important;
        left: auto !important;
        width: auto !important;
        height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .news-card-1080.style-breaking .meta-row.style-stack-date > div {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        gap: 8px !important;
        display: inline-flex !important;
        align-items: center !important;
    }
    .news-card-1080.style-breaking .meta-row.style-stack-date .news-date {
        font-size: 19px !important;
        font-weight: 700 !important;
        color: #f1f5f9 !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8) !important;
    }
    .news-card-1080.style-breaking .meta-row.style-stack-date i {
        font-size: 17px !important;
        color: #ef4444 !important;
    }

    /* Hide the bottom-content-wrapper meta row */
    .news-card-1080.style-breaking .bottom-content-wrapper .meta-row {
        display: none !important;
    }

    /* 4. Details hint: positioned directly UNDER the Logo & Date stack on the left */
    .news-card-1080.style-breaking .details-hint {
        display: inline-block !important;
        position: absolute !important;
        bottom: 135px !important;
        left: 60px !important;
        right: auto !important;
        top: auto !important;
        margin: 0 !important;
        font-size: 22px !important;
        font-weight: 700 !important;
        color: #7dd3fc !important;
        text-align: left !important;
        pointer-events: auto !important;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.8) !important;
        z-index: 20 !important;
    }
    .news-card-1080.style-breaking.footer-none .details-hint {
        bottom: 55px !important;
    }

    /* 5A. Normal Mode: Picture Frame Box on the Right Side */
    .news-card-1080.style-breaking .news-image-wrapper {
        position: absolute !important;
        right: 50px !important;
        bottom: 120px !important;
        left: auto !important;
        top: auto !important;
        width: 400px !important;
        height: 480px !important;
        border-radius: 24px !important;
        overflow: hidden !important;
        border: 3px solid rgba(255, 255, 255, 0.25) !important;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(0, 0, 0, 0.4) !important;
        z-index: 15 !important;
        flex: none !important;
        background: #0f172a !important;
        display: block !important;
    }
    .news-card-1080.style-breaking.footer-none .news-image-wrapper {
        bottom: 40px !important;
        height: 540px !important;
    }
    .news-card-1080.style-breaking .news-image-wrapper .news-image {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        object-position: top center !important;
        filter: none !important;
    }
    .news-card-1080.style-breaking .card-reporter-badge-wrapper {
        display: none;
    }
    .news-card-1080.style-breaking #cardImagePlaceholder {
        border-radius: 20px !important;
        background: rgba(15, 23, 42, 0.75) !important;
        border: 2px dashed rgba(255, 255, 255, 0.25) !important;
        height: 380px !important;
        width: 320px !important;
        margin: auto !important;
    }

    /* 5B. Cutout Mode: 420px Width Cutout PNG on Right Side */
    .news-card-1080.style-breaking .news-image-wrapper.quote-cutout-mode {
        position: absolute !important;
        right: 0 !important;
        left: auto !important;
        bottom: 100px !important;
        top: auto !important;
        width: 420px !important;
        max-width: 420px !important;
        height: 870px !important;
        border-radius: 0 !important;
        overflow: visible !important;
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
        display: flex !important;
        align-items: flex-end !important;
        justify-content: flex-end !important;
        pointer-events: none !important;
        z-index: 5 !important;
    }
    .news-card-1080.style-breaking.footer-none .news-image-wrapper.quote-cutout-mode {
        bottom: 0 !important;
        height: 970px !important;
    }
    .news-card-1080.style-breaking .news-image-wrapper.quote-cutout-mode .news-image {
        width: 420px !important;
        max-width: 420px !important;
        height: 100% !important;
        object-fit: contain !important;
        object-position: bottom right !important;
        filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.85)) !important;
        transform-origin: bottom right !important;
    }

    /* 6. Content Section Container */
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

    /* 7. Watermark hidden on breaking style */
    .news-card-1080.style-breaking .text-area-watermark {
        display: none !important;
    }

    /* 8. Bottom footer bar */
    .news-card-1080.style-breaking .full-width-ad-bar,
    .news-card-1080.style-breaking .official-brand-footer {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        z-index: 20 !important;
    }
</style>
