{{-- =========================================================================
     TEMPLATE 1: CLASSIC (ডিফল্ট ক্লাসিক ফটো কার্ড)
     ========================================================================= --}}
<style>
    /* STYLE 1: CLASSIC (Default Photo Card Layout) */
    .news-card-1080.style-classic .news-image-wrapper {
        flex: 0 0 648px;
        height: 648px;
    }
    .news-card-1080.style-classic .bottom-content-wrapper {
        flex: 0 0 332px;
        height: 332px;
    }

    /* 1. Brand stack container transparent in classic; stack-date hidden */
    .news-card-1080.style-classic .card-brand-date-stack {
        display: contents !important;
    }
    .news-card-1080.style-classic .style-stack-date {
        display: none !important;
    }

    /* 2. Top-right Corner Logo on image */
    .news-card-1080.style-classic .card-top-right-logo {
        position: absolute !important;
        top: 0 !important;
        right: 45px !important;
        left: auto !important;
        z-index: 20 !important;
        display: flex !important;
    }

    /* 3. Reporter Name Badge: Attached flush to the LEFT edge of the photo */
    .news-card-1080.style-classic .card-reporter-badge-wrapper {
        position: absolute !important;
        left: 0 !important;
        right: auto !important;
        bottom: 25px !important;
        display: flex !important;
        z-index: 10 !important;
    }
    .news-card-1080.style-classic .card-reporter-badge {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        border-top-right-radius: 10px !important;
        border-bottom-right-radius: 10px !important;
        padding: 8px 22px 8px 18px !important;
        font-size: 22px !important;
        font-weight: 700 !important;
        box-shadow: 4px 6px 18px rgba(0, 0, 0, 0.7) !important;
    }

    /* 4. Meta Row: Bengali Date with pill background */
    .news-card-1080.style-classic .bottom-content-wrapper .meta-row {
        justify-content: flex-start !important;
        display: flex !important;
        width: 100% !important;
        margin-bottom: 8px !important;
    }
    .news-card-1080.style-classic .bottom-content-wrapper .meta-row > div {
        background: rgba(0, 0, 0, 0.4) !important;
        backdrop-filter: blur(10px) !important;
        -webkit-backdrop-filter: blur(10px) !important;
        padding: 7px 20px !important;
        border-radius: 20px !important;
        border: 1px solid rgba(255, 255, 255, 0.16) !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 10px !important;
    }
    .news-card-1080.style-classic .bottom-content-wrapper .meta-row .news-date {
        font-size: 20px !important;
        font-weight: 600 !important;
        color: #f8fafc !important;
    }

    /* 5. Details hint: Aligned to the RIGHT side */
    .news-card-1080.style-classic .details-hint {
        align-self: flex-end !important;
        text-align: right !important;
        margin-left: auto !important;
        margin-right: 0 !important;
        margin-top: auto !important;
        display: inline-block !important;
    }
</style>
