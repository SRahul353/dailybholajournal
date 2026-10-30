@extends('layouts.app')

@section('title', 'সম্পাদকীয় নীতিমালা ও দায়মুক্তি (Editorial Policy & Disclaimer) | দৈনিক ভোলা জার্নাল')

@section('meta')
    <meta name="description" content="দৈনিক ভোলা জার্নাল ডিজিটাল প্ল্যাটফর্মের অফিসিয়াল সম্পাদকীয় নীতিমালা, তথ্য যাচাই ও সংশোধনী নীতি (Editorial Policy & Disclaimer)।">
    <meta property="og:title" content="সম্পাদকীয় নীতিমালা ও দায়মুক্তি | দৈনিক ভোলা জার্নাল">
    <meta property="og:description" content="দৈনিক ভোলা জার্নাল — সম্পাদকীয় স্বাধীনতা, তথ্য যাচাই, সংশোধনী নীতি ও আইনি দায়মুক্তি।">
    <meta property="og:type" content="article">
@endsection

@section('styles')
<style>
    .editorial-page-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        padding: 42px 0 32px 0;
        margin-bottom: 36px;
        border-bottom: 3px solid var(--accent, #c90000);
    }
    .editorial-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.84rem;
        color: #94a3b8;
        margin-bottom: 14px;
    }
    .editorial-breadcrumb a {
        color: #cbd5e1;
        text-decoration: none;
    }
    .editorial-breadcrumb a:hover {
        color: #ffffff;
    }
    .editorial-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 2.1rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 8px;
    }
    .editorial-subtitle {
        font-size: 0.96rem;
        color: #94a3b8;
        margin-bottom: 18px;
    }
    .legal-lang-switch {
        display: inline-flex;
        background: rgba(255, 255, 255, 0.1);
        padding: 4px;
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }
    .lang-btn {
        background: none;
        border: none;
        color: #cbd5e1;
        padding: 6px 18px;
        font-size: 0.88rem;
        font-weight: 700;
        border-radius: 24px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .lang-btn.active {
        background: var(--accent, #c90000);
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(201, 0, 0, 0.4);
    }
    .editorial-content-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 36px 40px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        margin-bottom: 50px;
        color: #334155;
        line-height: 1.8;
        font-size: 1rem;
    }
    @media (max-width: 768px) {
        .editorial-content-card {
            padding: 24px 20px;
        }
        .editorial-title {
            font-size: 1.6rem;
        }
    }
    .policy-sec-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }
    .policy-sec-card h4 {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.22rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .policy-sec-card h4 i {
        color: var(--accent, #c90000);
    }
    .correction-box {
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-left: 4px solid #16a34a;
        border-radius: 8px;
        padding: 18px 20px;
        margin: 18px 0;
    }
    .correction-box h5 {
        color: #166534;
        font-weight: 700;
        margin-bottom: 8px;
        font-size: 1.05rem;
    }
    .disclaimer-box {
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        border-left: 4px solid #dc2626;
        border-radius: 8px;
        padding: 20px;
        margin-top: 24px;
    }
    .disclaimer-box h4 {
        color: #991b1b;
        font-weight: 800;
        font-size: 1.25rem;
        margin-bottom: 12px;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<section class="editorial-page-header">
    <div class="container">
        <div class="editorial-breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house-chimney me-1"></i>প্রচ্ছদ</a>
            <span>/</span>
            <span>সম্পাদকীয় নীতিমালা ও দায়মুক্তি</span>
        </div>
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="editorial-title" id="pageMainHeading">সম্পাদকীয় নীতিমালা ও দায়মুক্তি</h1>
                <p class="editorial-subtitle m-0">তথ্য যাচাই, সংশোধনী নীতি ও আইনি দায়মুক্তি নির্দেশিকা (Editorial Policy &amp; Disclaimer)</p>
            </div>
            
            <!-- Bilingual Toggle Switcher -->
            <div class="legal-lang-switch">
                <button type="button" class="lang-btn active" id="btnBangla" onclick="switchLanguage('bn')">
                    <i class="fa-solid fa-language"></i> বাংলা সংস্করণ
                </button>
                <button type="button" class="lang-btn" id="btnEnglish" onclick="switchLanguage('en')">
                    <i class="fa-solid fa-globe"></i> English Version
                </button>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="editorial-content-card">

        <!-- ==========================================================================
             1. BANGLA VERSION
             ========================================================================== -->
        <div id="versionBangla">
            <h3 class="fw-bold text-dark mb-4 pb-2 border-bottom" style="font-family: 'Noto Serif Bengali', serif; font-size: 1.45rem;">
                <i class="fa-solid fa-newspaper text-danger me-2"></i>সম্পাদকীয় নীতিমালা (Editorial Policy)
            </h3>

            <!-- তথ্য যাচাই ও সূত্র -->
            <div class="policy-sec-card">
                <h4><i class="fa-solid fa-check-double"></i> তথ্য যাচাই ও সূত্র (Fact-Checking &amp; Sourcing)</h4>
                <p class="mb-0">
                    ভোলা জার্নালে প্রকাশিত প্রতিটি সংবাদ আমাদের নিজস্ব প্রতিনিধি, বিশ্বস্ত সংবাদ সংস্থা অথবা সরাসরি দায়িত্বশীল সূত্র থেকে যাচাই করার পর প্রকাশ করা হয়। একপাক্ষিক সংবাদ পরিহার করে অভিযুক্ত বা সংশ্লিষ্ট সকল পক্ষের বক্তব্য তুলে ধরতে আমরা সচেষ্ট থাকি।
                </p>
            </div>

            <!-- সংশোধনী নীতি -->
            <div class="correction-box">
                <h5><i class="fa-solid fa-pen-to-square me-2"></i>সংশোধনী নীতি (Correction Policy)</h5>
                <p class="mb-2">
                    মানুষ মাত্রই ভুলের ঊর্ধ্বে নয়। আমাদের প্রকাশিত কোনো সংবাদে যদি অনাকাঙ্ক্ষিতভাবে কোনো তথ্যগত ত্রুটি ধরা পড়ে, তবে তা নজরে আসার সাথে সাথেই আমরা যাচাইপূর্বক দ্রুততম সময়ে সংশোধন করি এবং প্রয়োজনে সংবাদের নিচে ‘সংশোধনী নোট’ যুক্ত করি।
                </p>
                <p class="mb-0 small fw-bold">
                    যেকোনো তথ্যগত ভুলের বিষয়ে পাঠকরা আমাদের <a href="mailto:{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}" class="text-success">{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}</a> ঠিকানায় অবহিত করতে পারেন।
                </p>
            </div>

            <!-- মতামত ও সম্পাদকীয় স্বাতন্ত্র্য -->
            <div class="policy-sec-card">
                <h4><i class="fa-solid fa-feather"></i> মতামত ও সম্পাদকীয় স্বাতন্ত্র্য</h4>
                <p class="mb-0">
                    ওয়েবসাইটের ‘মতামত’ বা ‘কলাম’ বিভাগে প্রকাশিত লেখার বক্তব্য সম্পূর্ণরূপে লেখকের নিজস্ব; এর সাথে ভোলা জার্নালের সম্পাদকীয় নীতির মিল নাও থাকতে পারে। এছাড়া আমাদের সাইটে প্রকাশিত বিজ্ঞাপন বা স্পন্সরড কন্টেন্ট আমাদের সম্পাদকীয় সিদ্ধান্তকে কোনোভাবেই প্রভাবিত করে না।
                </p>
            </div>

            <!-- দায়মুক্তি (Disclaimer) -->
            <div class="disclaimer-box">
                <h4><i class="fa-solid fa-shield-halved me-2"></i>দায়মুক্তি (Disclaimer)</h4>
                <div class="mb-3">
                    <strong class="d-block text-dark mb-1">১. সাধারণ তথ্যের উদ্দেশ্য:</strong>
                    <span style="color: #4b5563;">
                        <a href="https://bholajournal.com" target="_blank" class="text-danger fw-bold">bholajournal.com</a>-এ প্রকাশিত সকল সংবাদ, প্রবন্ধ, ছবি ও ভিডিও শুধুমাত্র সাধারণ তথ্যের উদ্দেশ্যে পরিবেশিত হয়। আমাদের স্বাস্থ্য, আইন, প্রযুক্তি বা অর্থনীতি বিষয়ক কোনো প্রতিবেদনকে বিশেষজ্ঞ বা পেশাদার পরামর্শ (Professional Medical, Legal, or Financial Advice) হিসেবে গণ্য করা উচিত নয়।
                    </span>
                </div>
                <div>
                    <strong class="d-block text-dark mb-1">২. বাহ্যিক লিংক ও বিজ্ঞাপন:</strong>
                    <span style="color: #4b5563;">
                        আমাদের পোর্টালে প্রাসঙ্গিক কারণে অন্যান্য ওয়েবসাইটের লিংক বা তৃতীয় পক্ষের বিজ্ঞাপন (Google AdSense) থাকতে পারে। সেসব বাহ্যিক সাইটের বিষয়বস্তু বা বিজ্ঞাপনের পণ্যের মানের বিষয়ে ভোলা জার্নাল কোনো নিশ্চয়তা প্রদান করে না এবং এর ফলে সৃষ্ট কোনো ক্ষতির দায়ভার বহন করে না।
                    </span>
                </div>
            </div>
        </div>

        <!-- ==========================================================================
             2. ENGLISH VERSION
             ========================================================================== -->
        <div id="versionEnglish" style="display: none;">
            <h3 class="fw-bold text-dark mb-4 pb-2 border-bottom" style="font-size: 1.45rem;">
                <i class="fa-solid fa-newspaper text-danger me-2"></i>Editorial Policy &amp; Disclaimer
            </h3>

            <!-- Fact-Checking & Sourcing -->
            <div class="policy-sec-card">
                <h4><i class="fa-solid fa-check-double"></i> Fact-Checking &amp; Sourcing</h4>
                <p class="mb-0">
                    Every report published on Bhola Journal undergoes strict editorial review. Our reporters and editors verify facts through primary sources, official statements, on-ground reporting, and reputable news agencies. When covering controversies or allegations, we strive to include fair responses from all concerned parties.
                </p>
            </div>

            <!-- Correction Policy -->
            <div class="correction-box">
                <h5><i class="fa-solid fa-pen-to-square me-2"></i>Correction Policy</h5>
                <p class="mb-2">
                    Bhola Journal is committed to transparency. If a factual error is identified after publication, our editorial team promptly updates the article with accurate information and appends an editorial correction note where necessary.
                </p>
                <p class="mb-0 small fw-bold">
                    Readers can report factual discrepancies directly to our editorial team at <a href="mailto:{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}" class="text-success">{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}</a>.
                </p>
            </div>

            <!-- Editorial Independence & Opinion -->
            <div class="policy-sec-card">
                <h4><i class="fa-solid fa-feather"></i> Editorial Independence &amp; Opinion</h4>
                <p class="mb-0">
                    Articles published in the "Opinion" or "Column" sections reflect the personal views of the respective authors and do not necessarily represent the editorial stance of Bhola Journal. Our news coverage remains strictly independent of our commercial and advertising operations.
                </p>
            </div>

            <!-- Disclaimer -->
            <div class="disclaimer-box">
                <h4><i class="fa-solid fa-shield-halved me-2"></i>Disclaimer</h4>
                <div class="mb-3">
                    <strong class="d-block text-dark mb-1">1. Informational Purpose Only:</strong>
                    <span style="color: #4b5563;">
                        All content published on <a href="https://bholajournal.com" target="_blank" class="text-danger fw-bold">https://bholajournal.com</a> is intended for general informational and news purposes only. Content related to health, law, finance, or technology should not be treated as a substitute for professional medical, legal, or financial advice.
                    </span>
                </div>
                <div>
                    <strong class="d-block text-dark mb-1">2. External Links &amp; Third-Party Ads:</strong>
                    <span style="color: #4b5563;">
                        Our website may contain external links or display automated advertisements (such as Google AdSense). Bhola Journal does not endorse and is not responsible for the accuracy, reliability, or safety of any third-party websites, products, or services linked on our portal.
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function switchLanguage(lang) {
        const bnDiv = document.getElementById('versionBangla');
        const enDiv = document.getElementById('versionEnglish');
        const btnBn = document.getElementById('btnBangla');
        const btnEn = document.getElementById('btnEnglish');
        const heading = document.getElementById('pageMainHeading');

        if (lang === 'en') {
            bnDiv.style.display = 'none';
            enDiv.style.display = 'block';
            btnBn.classList.remove('active');
            btnEn.classList.add('active');
            heading.textContent = 'Editorial Policy & Disclaimer';
            window.location.hash = 'en';
        } else {
            enDiv.style.display = 'none';
            bnDiv.style.display = 'block';
            btnEn.classList.remove('active');
            btnBn.classList.add('active');
            heading.textContent = 'সম্পাদকীয় নীতিমালা ও দায়মুক্তি';
            window.location.hash = 'bn';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash === '#en') {
            switchLanguage('en');
        }
    });
</script>
@endsection