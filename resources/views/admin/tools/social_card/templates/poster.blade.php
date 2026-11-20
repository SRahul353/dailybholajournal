{{-- =========================================================================
     TEMPLATE 2: POSTER (ফুল ব্যাকগ্রাউন্ড ইমেজ ও ড্রামাটিক টেক্সট ওভারলে)
     ========================================================================= --}}
<style>
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

    /* 1. Unified Brand & Date Stack (Logo on top, Date below with shared backdrop) */
    .news-card-1080.style-poster .card-brand-date-stack {
        position: absolute !important;
        top: 45px !important;
        right: 50px !important;
        left: auto !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        gap: 8px !important;
        background: rgba(10, 15, 30, 0.85) !important;
        backdrop-filter: blur(14px) !important;
        -webkit-backdrop-filter: blur(14px) !important;
        padding: 14px 22px !important;
        border-radius: 20px !important;
        border: 1.5px solid rgba(255, 255, 255, 0.22) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6) !important;
        z-index: 20 !important;
        pointer-events: auto !important;
    }

    /* 2. Logo: width 120px, height auto */
    .news-card-1080.style-poster .card-top-right-logo {
        display: flex !important;
        position: relative !important;
        top: auto !important;
        right: auto !important;
        left: auto !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .news-card-1080.style-poster .card-top-right-logo img {
        width: 120px !important;
        height: auto !important;
        max-height: 60px !important;
        object-fit: contain !important;
        filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.7)) !important;
    }

    /* 3. Date under logo inside the stack */
    .news-card-1080.style-poster .meta-row.style-stack-date {
        display: flex !important;
        position: relative !important;
        top: auto !important;
        right: auto !important;
        left: auto !important;
        margin: 0 !important;
        padding: 0 !important;
        width: auto !important;
        height: auto !important;
        justify-content: center !important;
    }
    .news-card-1080.style-poster .meta-row.style-stack-date > div {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        gap: 8px !important;
        display: inline-flex !important;
        align-items: center !important;
    }
    .news-card-1080.style-poster .meta-row.style-stack-date .news-date {
        font-size: 19px !important;
        font-weight: 700 !important;
        letter-spacing: 0.3px !important;
        color: #f1f5f9 !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8) !important;
    }
    .news-card-1080.style-poster .meta-row.style-stack-date i {
        font-size: 17px !important;
        color: #38bdf8 !important;
    }

    /* 4. Hide bottom-content meta-row */
    .news-card-1080.style-poster .bottom-content-wrapper .meta-row {
        display: none !important;
    }

    /* 5. Default hide reporter name badge on full poster */
    .news-card-1080.style-poster .card-reporter-badge-wrapper {
        display: none;
    }

    /* 6. Default hide details hint on full poster */
    .news-card-1080.style-poster .details-hint {
        display: none;
    }

    /* 7. Watermark logo hidden by default on poster */
    .news-card-1080.style-poster .text-area-watermark {
        display: none;
    }

    /* 8. Full poster content overlay container (top: 0 to bottom: 100px or 0px) */
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
        justify-content: flex-end !important;
        pointer-events: none !important;
        border-top: none !important;
    }
    .news-card-1080.style-poster.footer-none .bottom-content-wrapper {
        bottom: 0 !important;
        padding-bottom: 50px !important;
    }

    /* 9. Caption bottom aligned */
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
</style>
