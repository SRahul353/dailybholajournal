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

    /* 1. Corner Logo: Exactly the same as Classic */
    .news-card-1080.style-poster .card-top-right-logo {
        position: absolute !important;
        top: 0 !important;
        right: 45px !important;
        left: auto !important;
        z-index: 20 !important;
        display: flex !important;
    }

    /* 2. Meta Row (Date): Exactly the same as Classic */
    .news-card-1080.style-poster .meta-row {
        position: relative !important;
        display: flex !important;
        justify-content: flex-start !important;
        align-items: center !important;
        width: 100% !important;
        height: auto !important;
        margin: 0 0 14px 0 !important;
        padding: 0 !important;
        z-index: 15 !important;
        pointer-events: auto !important;
    }
    .news-card-1080.style-poster .meta-row > div {
        background: rgba(0, 0, 0, 0.45) !important;
        backdrop-filter: blur(10px) !important;
        -webkit-backdrop-filter: blur(10px) !important;
        padding: 7px 20px !important;
        border-radius: 20px !important;
        border: 1px solid rgba(255, 255, 255, 0.18) !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 10px !important;
    }
    .news-card-1080.style-poster .meta-row .news-date {
        font-size: 20px !important;
        font-weight: 600 !important;
        color: #f8fafc !important;
    }
    .news-card-1080.style-poster .meta-row i {
        font-size: 18px !important;
        color: #38bdf8 !important;
    }

    /* 3. Default hide reporter name badge on full poster */
    .news-card-1080.style-poster .card-reporter-badge-wrapper {
        display: none;
    }

    /* 4. Default hide details hint on full poster */
    .news-card-1080.style-poster .details-hint {
        display: none;
    }

    /* 5. Watermark logo hidden by default on poster */
    .news-card-1080.style-poster .text-area-watermark {
        display: none;
    }

    /* 6. Full poster content overlay container (bottom aligned gradient) */
    .news-card-1080.style-poster .bottom-content-wrapper {
        position: absolute !important;
        top: 0 !important;
        bottom: 100px !important;
        left: 0 !important;
        width: 1080px !important;
        height: auto !important;
        flex: none !important;
        z-index: 5 !important;
        background: linear-gradient(to top, rgba(10, 15, 30, 0.98) 0%, rgba(10, 15, 30, 0.92) 14%, rgba(10, 15, 30, 0.65) 24%, rgba(10, 15, 30, 0.20) 32%, transparent 40%);
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

    /* 7. Headline wrapper */
    .news-card-1080.style-poster .headline-wrapper {
        margin-top: 0 !important;
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

    /* 8. Bottom footer bar */
    .news-card-1080.style-poster .full-width-ad-bar,
    .news-card-1080.style-poster .official-brand-footer {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        z-index: 10 !important;
    }
</style>
