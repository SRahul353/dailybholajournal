{{-- =========================================================================
     TEMPLATE 3: QUOTE (বক্তব্য / বিশিষ্ট ব্যক্তিদের উক্তি কোটেশন কার্ড)
     ========================================================================= --}}
<style>
    /* STYLE 3: QUOTE (বক্তব্য / উক্তি কোটেশন কার্ড) */
    .quote-symbol-badge { display: none; }
    .quote-card-texture { display: none; }
    .quote-side-column { display: none; }

    .news-card-1080.style-quote {
        background: linear-gradient(160deg, #1e3a8a 0%, #0f172a 100%);
        position: relative !important;
    }

    /* 1. Subtle luxury texture overlay on full card background */
    .news-card-1080.style-quote .quote-card-texture {
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

    .news-card-1080.style-quote .quote-side-column {
        display: none !important;
    }

    /* 2. Top-right Logo (attached to top edge) */
    .news-card-1080.style-quote .card-top-right-logo {
        display: flex;
        position: absolute !important;
        top: 0 !important;
        right: 45px;
        left: auto;
        z-index: 20 !important;
    }

    /* 3. Top-right Date (under logo) */
    .news-card-1080.style-quote .meta-row {
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
    .news-card-1080.style-quote .meta-row > div {
        background: rgba(0, 0, 0, 0.45) !important;
        padding: 7px 18px !important;
        border-radius: 20px !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
    }
    .news-card-1080.style-quote .meta-row .news-date {
        font-size: 19px !important;
        font-weight: 700 !important;
        color: #facc15 !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8) !important;
    }
    .news-card-1080.style-quote .meta-row i {
        font-size: 18px !important;
        color: #facc15 !important;
    }

    /* 4A. Normal Mode: Picture Frame Box (নরমাল ফ্রেম মোড) */
    .news-card-1080.style-quote .news-image-wrapper {
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
    .news-card-1080.style-quote.footer-none .news-image-wrapper {
        bottom: 35px !important;
        height: 580px !important;
    }
    .news-card-1080.style-quote .news-image-wrapper .news-image {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        object-position: top center !important;
        filter: none !important;
    }
    .news-card-1080.style-quote .card-reporter-badge-wrapper {
        display: none;
    }
    .news-card-1080.style-quote #cardImagePlaceholder {
        border-radius: 20px !important;
        background: rgba(15, 23, 42, 0.75) !important;
        border: 2px dashed rgba(255, 255, 255, 0.25) !important;
        height: 380px !important;
        width: 320px !important;
        margin: auto !important;
    }

    /* 4B. Cutout Mode: Max Width 1080px Cutout PNG (কাটআউট মোড - স্বচ্ছ পিএনজি) */
    .news-card-1080.style-quote .news-image-wrapper.quote-cutout-mode {
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
    .news-card-1080.style-quote.footer-none .news-image-wrapper.quote-cutout-mode {
        bottom: 0 !important;
        height: 1080px !important;
    }
    .news-card-1080.style-quote .news-image-wrapper.quote-cutout-mode .news-image {
        width: 100% !important;
        max-width: 1080px !important;
        height: 100% !important;
        object-fit: contain !important;
        object-position: bottom right !important;
        filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.85)) !important;
        transform-origin: bottom right !important;
        transition: transform 0.12s ease-out;
    }

    /* 5. Content Section Container */
    .news-card-1080.style-quote .bottom-content-wrapper {
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

    /* 6. Extra Large Quotation mark symbol */
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

    /* 7. Quote Headline & Speaker Wrapper */
    .quote-excerpt-text,
    .quote-speaker-wrapper {
        display: none;
    }
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

    /* 8. Details hint at bottom */
    .news-card-1080.style-quote .details-hint {
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
    .news-card-1080.style-quote.footer-none .details-hint {
        bottom: 45px !important;
    }

    /* 9. Watermark hidden on quote style */
    .news-card-1080.style-quote .text-area-watermark {
        display: none !important;
    }

    /* 10. Bottom footer bar */
    .news-card-1080.style-quote .full-width-ad-bar,
    .news-card-1080.style-quote .official-brand-footer {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        z-index: 20 !important;
    }
</style>
