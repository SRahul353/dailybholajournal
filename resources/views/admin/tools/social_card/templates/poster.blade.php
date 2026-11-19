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
</style>
