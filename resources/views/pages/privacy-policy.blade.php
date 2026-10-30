@extends('layouts.app')

@section('title', 'গোপনীয়তা নীতি ও ডেটা সুরক্ষা (Privacy Policy) | দৈনিক ভোলা জার্নাল')

@section('meta')
    <meta name="description" content="দৈনিক ভোলা জার্নাল ডিজিটাল প্ল্যাটফর্মের অফিসিয়াল গোপনীয়তা নীতি (Privacy Policy) ও ইউজার ডেটা প্রটেকশন নীতিমালা।">
    <meta property="og:title" content="গোপনীয়তা নীতি (Privacy Policy) | দৈনিক ভোলা জার্নাল">
    <meta property="og:description" content="দৈনিক ভোলা জার্নাল ডিজিটাল প্ল্যাটফর্মের অফিসিয়াল গোপনীয়তা নীতি (Privacy Policy) ও ইউজার ডেটা প্রটেকশন নীতিমালা।">
    <meta property="og:type" content="article">
@endsection

@section('styles')
<style>
    .legal-page-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        padding: 42px 0 32px 0;
        margin-bottom: 36px;
        border-bottom: 3px solid var(--accent, #c90000);
    }
    .legal-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.84rem;
        color: #94a3b8;
        margin-bottom: 14px;
    }
    .legal-breadcrumb a {
        color: #cbd5e1;
        text-decoration: none;
    }
    .legal-breadcrumb a:hover {
        color: #ffffff;
    }
    .legal-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 2.1rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 8px;
    }
    .legal-subtitle {
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
    .legal-content-card {
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
        .legal-content-card {
            padding: 24px 20px;
        }
        .legal-title {
            font-size: 1.6rem;
        }
    }
    .legal-sec-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.32rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 32px;
        margin-bottom: 12px;
        padding-bottom: 6px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .legal-sec-title span.sec-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background: #fee2e2;
        color: #b91c1c;
        border-radius: 50%;
        font-size: 0.85rem;
        font-weight: 800;
        flex-shrink: 0;
    }
    .legal-highlight-box {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-left: 4px solid var(--accent, #c90000);
        border-radius: 8px;
        padding: 20px 22px;
        margin: 22px 0;
    }
    .legal-highlight-box h5 {
        color: #0f172a;
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 1.05rem;
    }
    .legal-notice-warning {
        background-color: #fffbeb;
        border: 1px solid #fde68a;
        border-left: 4px solid #f59e0b;
        border-radius: 8px;
        padding: 16px 20px;
        margin: 20px 0;
        color: #92400e;
        font-size: 0.94rem;
    }
    .legal-steps-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
        margin: 16px 0;
    }
    @media (min-width: 768px) {
        .legal-steps-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    .legal-step-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .legal-step-card strong {
        display: block;
        color: #0f172a;
        margin-bottom: 6px;
        font-size: 0.95rem;
    }
    .effective-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fee2e2;
        color: #991b1b;
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 0.82rem;
        font-weight: 700;
        margin-bottom: 18px;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<section class="legal-page-header">
    <div class="container">
        <div class="legal-breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house-chimney me-1"></i>প্রচ্ছদ</a>
            <span>/</span>
            <span>গোপনীয়তা নীতি</span>
        </div>
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="legal-title" id="pageMainHeading">গোপনীয়তা নীতি ও ইউজার ডেটা প্রটেকশন</h1>
                <p class="legal-subtitle m-0">দৈনিক ভোলা জার্নাল ডিজিটাল প্ল্যাটফর্মের অফিসিয়াল নীতিমালা ও ইউজার ডেটা নির্দেশনা</p>
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
    <div class="legal-content-card">

        <!-- ==========================================================================
             1. BANGLA VERSION
             ========================================================================== -->
        <div id="versionBangla">
            <div class="effective-badge">
                <i class="fa-regular fa-calendar-check"></i>
                <span>কার্যকর হওয়ার তারিখ: ৩০ অক্টোবর, ২০২৬</span>
            </div>

            <p class="lead" style="font-size: 1.08rem; color: #1e293b; font-weight: 500;">
                আপনার গোপনীয়তা আমাদের কাছে অত্যন্ত গুরুত্বপূর্ণ। <strong>ভোলা জার্নাল (Bhola Journal)</strong>-এর ওয়েবসাইট 
                (<a href="https://bholajournal.com" target="_blank" class="text-danger fw-bold">https://bholajournal.com</a>) এবং আমাদের অন্যান্য ডিজিটাল প্ল্যাটফর্ম ব্যবহারের সময় আপনার কাছ থেকে সংগৃহীত যেকোনো তথ্যের গোপনীয়তা রক্ষা করা আমাদের নীতি।
            </p>
            <p>
                এই পাতাটি আপনাকে আমাদের পরিষেবা ব্যবহারের সময় ব্যক্তিগত তথ্য সংগ্রহ, ব্যবহার ও সুরক্ষার নীতিমালা সম্পর্কে অবহিত করবে। আমাদের ওয়েবসাইট ব্যবহারের মাধ্যমে আপনি এই গোপনীয়তা নীতির শর্তাবলীতে সম্মতি প্রদান করছেন।
            </p>

            <!-- ১. আমরা কী ধরনের তথ্য সংগ্রহ করি -->
            <h3 class="legal-sec-title">
                <span class="sec-num">১</span>
                <span>আমরা কী ধরনের তথ্য সংগ্রহ করি</span>
            </h3>
            <p>ভোলা জার্নাল নিম্নলিখিত উপায়ে পাঠকদের তথ্য সংগ্রহ করতে পারে:</p>
            <ul class="ps-3">
                <li class="mb-2"><strong>অ্যাকাউন্ট রেজিস্ট্রেশন ও লগইন:</strong> আমাদের সাইটে সরাসরি রেজিস্ট্রেশন বা লগইন করার সময় আপনার নাম, ইমেইল ঠিকানা, ফোন নম্বর বা প্রোফাইল সংক্রান্ত তথ্য চাওয়া হতে পারে।</li>
                <li class="mb-2"><strong>সোশ্যাল লগইন (Google ও Facebook লগইন):</strong> পাঠকদের সুবিধার জন্য আমরা গুগল (Google) বা ফেসবুক (Facebook) অ্যাকাউন্টের মাধ্যমে ওয়ান-ক্লিক লগইন করার সুবিধা প্রদান করি। আপনি যখন সোশ্যাল লগইন ব্যবহার করেন, তখন আপনার অ্যাকাউন্ট যাচাই ও প্রোফাইল তৈরির জন্য আমরা শুধুমাত্র আপনার পাবলিক প্রোফাইলের নাম, ইমেইল ঠিকানা এবং প্রোফাইল ছবির লিংক সংগ্রহ করি। আপনার সোশ্যাল মিডিয়ার পাসওয়ার্ডে আমাদের কোনো অ্যাক্সেস থাকে না এবং আপনার অনুমতি ছাড়া আপনার টাইমলাইনে কিছুই পোস্ট করা হয় না।</li>
                <li class="mb-2"><strong>কমেন্ট (মন্তব্য) ও অংশগ্রহণ:</strong> পাঠকরা যখন কোনো সংবাদে মন্তব্য করেন, জরিপে (Poll/Survey) অংশ নেন বা মতামত জানান, তখন ফর্মে দেওয়া তথ্যের পাশাপাশি স্প্যাম প্রতিরোধে ব্যবহারকারীর আইপি (IP) অ্যাড্রেস ও ব্রাউজারের তথ্য সংরক্ষিত হয়।</li>
                <li class="mb-2"><strong>নিউজলেটার ও পুশ নোটিফিকেশন:</strong> আপনি যখন আমাদের নিউজলেটার সাবস্ক্রাইব করেন অথবা ব্রাউজার/অ্যাপের পুশ নোটিফিকেশন চালু করেন, তখন আপনাকে সংবাদের আপডেট পাঠানোর জন্য আপনার ইমেইল বা ডিভাইস টোকেন সংগ্রহ করা হয়।</li>
                <li class="mb-2"><strong>স্বয়ংক্রিয় লগ ডেটা:</strong> সাইটের নিরাপত্তা ও মানোন্নয়নের জন্য ব্যবহারকারীর আইপি অ্যাড্রেস, ব্রাউজারের ধরন, ডিভাইস এবং ভিজিটের সময় সংক্রান্ত সাধারণ তথ্য স্বয়ংক্রিয়ভাবে সংরক্ষিত হতে পারে।</li>
            </ul>

            <!-- ২. আপনার তথ্য আমরা কীভাবে ব্যবহার করি -->
            <h3 class="legal-sec-title">
                <span class="sec-num">২</span>
                <span>আপনার তথ্য আমরা কীভাবে ব্যবহার করি</span>
            </h3>
            <p>সংগৃহীত তথ্যগুলো আমরা নিম্নলিখিত কাজে ব্যবহার করি:</p>
            <ul class="ps-3">
                <li>আপনার ইউজার অ্যাকাউন্ট তৈরি ও পরিচালনা করতে, লগইন যাচাই করতে এবং আপনার মন্তব্যে প্রোফাইল প্রদর্শন করতে।</li>
                <li>আপনার পছন্দের বিষয়বস্তু অনুযায়ী সংবাদ ও নোটিফিকেশন পৌঁছে দিতে এবং আপনার পাঠ-অভিজ্ঞতা উন্নত করতে।</li>
                <li>আমাদের ওয়েবসাইটের কারিগরি মান, ডিজাইন ও সম্পাদকীয় কন্টেন্ট উন্নত করতে।</li>
                <li>ব্রেকিং নিউজ বা নিয়মিত নিউজলেটার ইমেইলের মাধ্যমে পাঠাতে (যা আপনি যেকোনো সময় বন্ধ করতে পারবেন)।</li>
                <li>ওয়েবসাইটের নিরাপত্তা বজায় রাখতে, স্প্যাম রোধ করতে এবং অননুমোদিত প্রবেশ ঠেকাতে।</li>
            </ul>

            <!-- ৩. ইউজার ডেটা ও অ্যাকাউন্ট মুছে ফেলার নির্দেশনা (Data Deletion) -->
            <div class="legal-highlight-box">
                <h3 class="legal-sec-title border-0 mt-0 pt-0">
                    <span class="sec-num"><i class="fa-solid fa-user-shield" style="font-size: 0.75rem;"></i></span>
                    <span>৩. ইউজার ডেটা ও অ্যাকাউন্ট মুছে ফেলার নির্দেশনা (Data Deletion Instructions)</span>
                </h3>
                <p>
                    যেকোনো ব্যবহারকারী আমাদের সার্ভার থেকে তার অ্যাকাউন্ট এবং সংরক্ষিত সকল ব্যক্তিগত তথ্য (ফেসবুক বা গুগল লগইনের মাধ্যমে প্রাপ্ত তথ্যসহ) সম্পূর্ণ মুছে ফেলার পূর্ণ অধিকার রাখেন। নিচের যেকোনো একটি পদ্ধতির মাধ্যমে আপনি আপনার ডেটা মুছে ফেলতে পারেন:
                </p>
                <div class="legal-steps-grid">
                    <div class="legal-step-card">
                        <strong><i class="fa-solid fa-id-card text-danger me-1"></i> ১. অ্যাকাউন্ট ড্যাশবোর্ড থেকে</strong>
                        <span>bholajournal.com-এ আপনার অ্যাকাউন্টে লগইন করে প্রোফাইল বা অ্যাকাউন্ট সেটিংসে যান এবং <em>"Delete Account"</em> অপশনে ক্লিক করে আপনার অ্যাকাউন্ট ও ডেটা স্থায়ীভাবে মুছে ফেলুন।</span>
                    </div>
                    <div class="legal-step-card">
                        <strong><i class="fa-brands fa-facebook text-primary me-1"></i> ২. ফেসবুক সেটিংস থেকে</strong>
                        <span>ফেসবুক অ্যাকাউন্টের Settings & Privacy &gt; Settings &gt; Apps and Websites-এ গিয়ে Bhola Journal সিলেক্ট করুন এবং <em>"Remove"</em> বাটনে ক্লিক করে অ্যাক্সেস প্রত্যাহার করুন।</span>
                    </div>
                    <div class="legal-step-card">
                        <strong><i class="fa-solid fa-envelope text-success me-1"></i> ৩. ইমেইলের মাধ্যমে অনুরোধ</strong>
                        <span>আপনার রেজিস্টার্ড ইমেইল থেকে <em>"Data Deletion Request"</em> সাবজেক্ট লিখে <a href="mailto:{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}">{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}</a>-এ ইমেইল পাঠান। ৪৮-৭২ ঘণ্টার মধ্যে তথ্য মুছে কনফার্মেশন পাঠানো হবে।</span>
                    </div>
                </div>
            </div>

            <!-- ৪. আপনার তথ্যের সুরক্ষা -->
            <h3 class="legal-sec-title">
                <span class="sec-num">৪</span>
                <span>আপনার তথ্যের সুরক্ষা</span>
            </h3>
            <p>
                আমরা আপনার ব্যক্তিগত তথ্যের সুরক্ষাকে সর্বোচ্চ অগ্রাধিকার দিই। আপনার প্রদানকৃত তথ্য সুরক্ষিত নেটওয়ার্কের অধীনে থাকে এবং কেবল সীমিত সংখ্যক অনুমোদিত ব্যক্তির কাছেই তা অ্যাক্সেসযোগ্য, যারা এই তথ্যের গোপনীয়তা বজায় রাখতে বাধ্য। আপনার আদান-প্রদানকৃত সকল সংবেদনশীল তথ্য SSL (Secure Socket Layer) / HTTPS প্রযুক্তির মাধ্যমে এনক্রিপ্ট করা থাকে। এছাড়া আমাদের সার্ভারকে সুরক্ষিত রাখতে নিয়মিত ম্যালওয়্যার স্ক্যানিং ও ফায়ারওয়াল নিরাপত্তা ব্যবস্থা ব্যবহার করা হয়।
            </p>

            <!-- ৫. কুকিজ (Cookies)-এর ব্যবহার -->
            <h3 class="legal-sec-title">
                <span class="sec-num">৫</span>
                <span>কুকিজ (Cookies)-এর ব্যবহার</span>
            </h3>
            <p>ব্যবহারকারীর অভিজ্ঞতা সহজ ও উন্নত করতে আমরা কুকিজ ব্যবহার করি:</p>
            <ul class="ps-3">
                <li><strong>কার্যকরী কুকিজ:</strong> আপনাকে সাইটে লগইন অবস্থায় রাখতে এবং আপনার ব্রাউজিং প্রিফারেন্স মনে রাখতে।</li>
                <li><strong>অ্যানালিটিক্স ও বিজ্ঞাপন কুকিজ:</strong> সাইটের ট্রাফিক বিশ্লেষণ করতে এবং প্রাসঙ্গিক বিজ্ঞাপন প্রদর্শনের জন্য।</li>
            </ul>
            <p class="text-muted small">
                আপনি চাইলে আপনার ব্রাউজারের সেটিংস থেকে যেকোনো সময় কুকিজ বন্ধ (Disable) করে দিতে পারেন। তবে কুকিজ বন্ধ করলে সাইটের কিছু ফিচার (যেমন: স্বয়ংক্রিয় লগইন) সঠিকভাবে কাজ নাও করতে পারে।
            </p>

            <!-- ৬. গুগল অ্যাডসেন্স ও অ্যানালিটিক্স -->
            <h3 class="legal-sec-title">
                <span class="sec-num">৬</span>
                <span>গুগল অ্যাডসেন্স (Google AdSense) ও অ্যানালিটিক্স</span>
            </h3>
            <p>
                <strong>Google AdSense:</strong> আমাদের ওয়েবসাইটে বিজ্ঞাপন প্রদর্শনের জন্য আমরা গুগল অ্যাডসেন্স ব্যবহার করি। তৃতীয় পক্ষের ভেন্ডর হিসেবে গুগল আমাদের সাইটে ব্যবহারকারীদের পূর্ববর্তী ভিজিটের ওপর ভিত্তি করে বিজ্ঞাপন দেখানোর জন্য কুকিজ (যেমন: DoubleClick বা DART কুকি) ব্যবহার করে। ব্যবহারকারীরা চাইলে গুগলের <a href="https://adssettings.google.com/" target="_blank" class="text-danger fw-bold">Ad Settings</a> পেজে গিয়ে পার্সোনালাইজড বিজ্ঞাপন বন্ধ (Opt-out) করতে পারেন।
            </p>
            <p>
                <strong>Google Analytics:</strong> ওয়েবসাইটের পাঠকসংখ্যা ও ট্রাফিক বিশ্লেষণের জন্য আমরা গুগল অ্যানালিটিক্স ব্যবহার করি। আপনি চাইলে <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" class="text-danger fw-bold">Google Analytics Opt-out Add-on</a> ব্যবহার করে এটি বন্ধ রাখতে পারেন।
            </p>

            <!-- ৭. তৃতীয় পক্ষের কাছে তথ্য প্রকাশ ও বাহ্যিক লিংক -->
            <h3 class="legal-sec-title">
                <span class="sec-num">৭</span>
                <span>তৃতীয় পক্ষের কাছে তথ্য প্রকাশ ও বাহ্যিক লিংক</span>
            </h3>
            <p>
                আমরা ব্যবহারকারীদের আগাম অনুমতি ছাড়া কোনো ব্যক্তিগত শনাক্তকরণযোগ্য তথ্য (PII) কোনো তৃতীয় পক্ষের কাছে বিক্রি, বিনিময় বা হস্তান্তর করি না। তবে ওয়েবসাইট পরিচালনায় সহায়তাকারী বিশ্বস্ত হোস্টিং বা কারিগরি পার্টনারদের ক্ষেত্রে এটি প্রযোজ্য নয় (যতক্ষণ তারা তথ্যের গোপনীয়তা বজায় রাখতে চুক্তিবদ্ধ থাকে)। এছাড়া রাষ্ট্রীয় আইন মেনে চলা বা সাইটের নিরাপত্তা ও অধিকার রক্ষার স্বার্থে আইনানুগভাবে তথ্য প্রকাশ করা হতে পারে।
            </p>
            <p>
                আমাদের সংবাদে বা ওয়েবসাইটে প্রাসঙ্গিক কারণে অন্য ওয়েবসাইটের লিংক থাকতে পারে। সেসব বাহ্যিক সাইটের নিজস্ব প্রাইভেসি পলিসি রয়েছে এবং তাদের কন্টেন্ট বা কার্যক্রমের জন্য ভোলা জার্নাল দায়ী থাকবে না।
            </p>

            <!-- ৮. বিশেষ সতর্কবার্তা -->
            <div class="legal-notice-warning">
                <h5 class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> ৮. বিশেষ সতর্কবার্তা (নকল পেজ ও ওয়েবসাইট প্রসঙ্গে)</h5>
                <span>অনলাইনে ‘ভোলা জার্নাল’ (Bhola Journal) নাম বা লোগো ব্যবহার করে একাধিক ভুয়া ওয়েবসাইট, অননুমোদিত ফেসবুক পেজ বা গ্রুপ থাকতে পারে। আমাদের অফিসিয়াল ডোমেইন (bholajournal.com) এবং ভেরিফায়েড/অফিসিয়াল সোশ্যাল মিডিয়া পেজ ব্যতীত অন্য কোনো ভুয়া সাইট বা পেজে প্রকাশিত কোনো সংবাদ বা কন্টেন্টের দায়ভার ভোলা জার্নাল কর্তৃপক্ষ বহন করবে না।</span>
            </div>

            <!-- ৯. শিশুদের গোপনীয়তা -->
            <h3 class="legal-sec-title">
                <span class="sec-num">৯</span>
                <span>শিশুদের গোপনীয়তা</span>
            </h3>
            <p>
                আমরা জেনেশুনে ১৩ বছরের কম বয়সী কোনো শিশুর ব্যক্তিগত তথ্য সংগ্রহ করি না। কোনো অভিভাবক যদি জানতে পারেন যে তার সন্তান আমাদের সাইটে ব্যক্তিগত তথ্য প্রদান করেছে, তবে আমাদের সাথে যোগাযোগ করলে আমরা তা দ্রুত সার্ভার থেকে মুছে ফেলার ব্যবস্থা করব।
            </p>

            <!-- ১০. ডেটা ব্রিচ সংক্রান্ত বিজ্ঞপ্তি -->
            <h3 class="legal-sec-title">
                <span class="sec-num">১০</span>
                <span>ডেটা ব্রিচ সংক্রান্ত বিজ্ঞপ্তি</span>
            </h3>
            <p>
                যদি কখনো কোনো অপ্রত্যাশিত কারিগরি ত্রুটি বা ডেটা ব্রিচের (Data Breach) ঘটনা ঘটে, তবে আমরা বিষয়টি জানার ৭২ ঘণ্টার মধ্যে ইমেইল বা ওয়েবসাইটে বিজ্ঞপ্তির মাধ্যমে ব্যবহারকারীদের অবহিত করব।
            </p>

            <!-- ১১. নিউজলেটার ও নোটিফিকেশন বন্ধ করা -->
            <h3 class="legal-sec-title">
                <span class="sec-num">১১</span>
                <span>নিউজলেটার ও নোটিফিকেশন বন্ধ করা (Opt-Out)</span>
            </h3>
            <p>
                <strong>ইমেইল নিউজলেটার:</strong> আপনি যদি আমাদের কাছ থেকে কোনো ইমেইল পেতে না চান, তবে প্রতিটি ইমেইলের নিচে থাকা "Unsubscribe" লিংকে ক্লিক করে অথবা আমাদের ইমেইল করে যেকোনো সময় তা বন্ধ করতে পারবেন।<br>
                <strong>পুশ নোটিফিকেশন:</strong> আপনার ব্রাউজার বা মোবাইল ডিভাইসের নোটিফিকেশন সেটিংস থেকে যেকোনো সময় পুশ নোটিফিকেশন অফ (Block/Disable) করে দিতে পারবেন।
            </p>

            <!-- ১২. গোপনীয়তা নীতি পরিবর্তন -->
            <h3 class="legal-sec-title">
                <span class="sec-num">১২</span>
                <span>গোপনীয়তা নীতি পরিবর্তন</span>
            </h3>
            <p>
                প্রয়োজনে আমরা সময়ে সময়ে আমাদের এই গোপনীয়তা নীতি হালনাগাদ বা পরিবর্তন করতে পারি। কোনো পরিবর্তন করা হলে তা এই পাতায় প্রকাশ করা হবে এবং ওপরে উল্লিখিত "কার্যকর হওয়ার তারিখ" আপডেট করা হবে।
            </p>

            <!-- ১৩. যোগাযোগ -->
            <div class="mt-4 p-4 rounded bg-light border">
                <h4 class="fw-bold text-dark mb-3"><i class="fa-solid fa-headset text-danger me-2"></i>১৩. যোগাযোগ ও ডেটা সাপোর্ট</h4>
                <p class="mb-2">এই গোপনীয়তা নীতি সম্পর্কে আপনার কোনো প্রশ্ন থাকলে অথবা আপনার ডেটা মুছে ফেলার অনুরোধ জানাতে নিচের ঠিকানায় যোগাযোগ করুন:</p>
                <ul class="list-unstyled mb-0 ps-2" style="font-size: 0.95rem; line-height: 1.8;">
                    <li><strong>ওয়েবসাইট:</strong> <a href="https://bholajournal.com" target="_blank" class="text-danger">https://bholajournal.com</a></li>
                    <li><strong>ইমেইল:</strong> <a href="mailto:{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}">{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}</a></li>
                    <li><strong>মোবাইল / হটলাইন:</strong> {{ $themeSettings['contact_phone'] ?? '01716-674375' }}</li>
                    <li><strong>ঠিকানা:</strong> {{ $themeSettings['contact_address'] ?? 'বার্তা ও বাণিজ্যিক কার্যালয়- ভোলা সদর, ভোলা, বাংলাদেশ।' }}</li>
                </ul>
            </div>
        </div>

        <!-- ==========================================================================
             2. ENGLISH VERSION (Fully aligned with user request)
             ========================================================================== -->
        <div id="versionEnglish" style="display: none;">
            <div class="effective-badge">
                <i class="fa-regular fa-calendar-check"></i>
                <span>Effective Date: October 30, 2026</span>
            </div>

            <p class="lead" style="font-size: 1.08rem; color: #1e293b; font-weight: 500;">
                Your privacy is important to us. It is <strong>Bhola Journal’s</strong> policy to respect your privacy regarding any information we may collect from you across our website, 
                <a href="https://bholajournal.com" target="_blank" class="text-danger fw-bold">https://bholajournal.com</a>, and other digital platforms or applications we own and operate.
            </p>
            <p>
                This page informs you of our policies regarding the collection, use, and disclosure of personal data when you use our Service and the choices you have associated with that data. By accessing or using the Service, you agree to the collection and use of information in accordance with this policy.
            </p>

            <!-- 1. Information We Collect -->
            <h3 class="legal-sec-title">
                <span class="sec-num">1</span>
                <span>Information We Collect</span>
            </h3>
            <p>Bhola Journal collects information from users in the following ways:</p>
            <ul class="ps-3">
                <li class="mb-2"><strong>Account Registration &amp; Login:</strong> When you register or log in directly on our site, you may be asked to enter your name, email address, phone number, or profile details to personalize your experience.</li>
                <li class="mb-2"><strong>Social Login (Google &amp; Facebook OAuth):</strong> We allow you to create an account and log in using your third-party social media accounts (such as Google or Facebook). When you choose to log in using these services, we only collect your public profile name, email address, and profile picture URL as permitted by your privacy settings on that platform to authenticate your account. We never gain access to your social media passwords or post anything to your timeline without your explicit permission.</li>
                <li class="mb-2"><strong>Comments &amp; User Interactions:</strong> When visitors leave comments on articles, participate in polls/surveys, or interact with our site features, we collect the data shown in the form as well as the visitor’s IP address and browser user agent string to help spam detection.</li>
                <li class="mb-2"><strong>Newsletter &amp; Push Notifications:</strong> When you subscribe to our email newsletter or opt-in to browser/app push notifications, we collect your email address or device token to deliver news alerts and updates.</li>
                <li class="mb-2"><strong>Automated Log Data:</strong> Like most website operators, we automatically collect non-personally identifiable information such as your IP address, browser type, device type, referring pages, and date/time stamps for analytics and security purposes.</li>
            </ul>

            <!-- 2. How We Use Your Information -->
            <h3 class="legal-sec-title">
                <span class="sec-num">2</span>
                <span>How We Use Your Information</span>
            </h3>
            <p>We may use the information we collect from you in the following ways:</p>
            <ul class="ps-3">
                <li>To create and manage your user account, authenticate logins, and display your profile on comments.</li>
                <li>To personalize your reading experience and deliver news, content, and notifications in which you are most interested.</li>
                <li>To improve our website performance, editorial content, and user interface.</li>
                <li>To send periodic emails, breaking news alerts, or newsletters (which you can unsubscribe from at any time).</li>
                <li>To detect, prevent, and address technical issues, spam, or unauthorized activities.</li>
            </ul>

            <!-- 3. User Data Deletion Instructions -->
            <div class="legal-highlight-box">
                <h3 class="legal-sec-title border-0 mt-0 pt-0">
                    <span class="sec-num"><i class="fa-solid fa-user-shield" style="font-size: 0.75rem;"></i></span>
                    <span>3. User Data Deletion Instructions (Required for Social Login)</span>
                </h3>
                <p>
                    Users have the full right to request the deletion of their account and all associated personal data (including data retrieved via Facebook or Google Login) from our servers. You can delete your data in any of the following ways:
                </p>
                <div class="legal-steps-grid">
                    <div class="legal-step-card">
                        <strong><i class="fa-solid fa-id-card text-danger me-1"></i> 1. Via Account Settings</strong>
                        <span>Log in to your account on bholajournal.com, navigate to your Profile/Account Settings, and click on the <em>"Delete Account"</em> option to permanently remove your data.</span>
                    </div>
                    <div class="legal-step-card">
                        <strong><i class="fa-brands fa-facebook text-primary me-1"></i> 2. Via Facebook Settings</strong>
                        <span>Go to your Facebook Account’s Settings &amp; Privacy &gt; Settings &gt; Apps and Websites, select Bhola Journal, and click <em>"Remove"</em> to revoke access and trigger data deletion.</span>
                    </div>
                    <div class="legal-step-card">
                        <strong><i class="fa-solid fa-envelope text-success me-1"></i> 3. Via Email Request</strong>
                        <span>Send an email to our support team at <a href="mailto:{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}">{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}</a> with the subject line <em>"Data Deletion Request"</em> from your registered email. We will delete your data within 48 to 72 hours.</span>
                    </div>
                </div>
            </div>

            <!-- 4. How We Protect Your Information -->
            <h3 class="legal-sec-title">
                <span class="sec-num">4</span>
                <span>How We Protect Your Information</span>
            </h3>
            <p>
                We prioritize the security of your personal information. Your personal data is contained behind secured networks and is only accessible by a limited number of authorized personnel who are required to keep the information confidential. All sensitive information you supply is encrypted in transit via Secure Socket Layer (SSL) / HTTPS technology. We also implement regular security monitoring, firewall protection, and malware scanning to safeguard our servers against unauthorized access, alteration, or disclosure.
            </p>

            <!-- 5. Cookies and Web Beacons -->
            <h3 class="legal-sec-title">
                <span class="sec-num">5</span>
                <span>Cookies and Web Beacons</span>
            </h3>
            <p>We use cookies and similar tracking technologies to enhance your experience:</p>
            <ul class="ps-3">
                <li><strong>Essential &amp; Functional Cookies:</strong> To keep you logged in and remember your site preferences.</li>
                <li><strong>Analytics &amp; Performance Cookies:</strong> To understand and save your preferences for future visits and compile aggregate data about site traffic and site interaction.</li>
                <li><strong>Advertising Cookies:</strong> Used by third-party vendors to serve relevant advertisements.</li>
            </ul>
            <p class="text-muted small">
                You can choose to have your computer warn you each time a cookie is being sent, or you can choose to turn off all cookies through your browser settings. Please note that disabling cookies may affect the functionality of certain features (such as staying logged into your account).
            </p>

            <!-- 6. Google AdSense, Analytics & Third-Party Advertising -->
            <h3 class="legal-sec-title">
                <span class="sec-num">6</span>
                <span>Google AdSense, Analytics &amp; Third-Party Advertising</span>
            </h3>
            <p>
                <strong>Google AdSense:</strong> We use Google AdSense Advertising on our website. Google, as a third-party vendor, uses cookies (including the DoubleClick/DART cookie) to serve ads to our users based on previous visits to our site and other sites on the Internet. Users may opt-out of personalized advertising by visiting the <a href="https://adssettings.google.com/" target="_blank" class="text-danger fw-bold">Google Ad Settings</a> page.
            </p>
            <p>
                <strong>Google Analytics:</strong> We use Google Analytics to track and report website traffic. Google uses the collected data to track and monitor the use of our Service. You can opt-out of Google Analytics by installing the <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" class="text-danger fw-bold">Google Analytics Opt-out Browser Add-on</a>.
            </p>
            <p class="text-muted small">
                <strong>Opting Out:</strong> You can also opt-out of third-party vendor cookies by visiting the Network Advertising Initiative Opt-Out page (optout.networkadvertising.org) or the Digital Advertising Alliance Opt-Out page (optout.aboutads.info).
            </p>

            <!-- 7. Third-Party Disclosure & Links -->
            <h3 class="legal-sec-title">
                <span class="sec-num">7</span>
                <span>Third-Party Disclosure &amp; Links</span>
            </h3>
            <p>
                We do not sell, trade, or otherwise transfer to outside parties your Personally Identifiable Information unless we provide users with advance notice. This does not include trusted website hosting partners and service providers who assist us in operating our website or serving our users, so long as those parties agree to keep this information confidential. We may also release information when its release is appropriate to comply with the law, enforce our site policies, or protect ours or others' rights, property, or safety.
            </p>
            <p>
                Occasionally, our articles or pages may contain links to third-party websites. These third-party sites have separate and independent privacy policies. We therefore have no responsibility or liability for the content and activities of these linked sites.
            </p>

            <!-- 8. Special Precaution Against Fake Pages & Clones -->
            <div class="legal-notice-warning">
                <h5 class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> 8. Special Precaution Against Fake Pages &amp; Clones</h5>
                <span>Please be aware that unauthorized individuals may create fake websites, Facebook pages, or social media groups using the name or logo of Bhola Journal (ভোলা জার্নাল). Bhola Journal holds no responsibility for any content generated, published, or shared on any domain other than bholajournal.com and our verified official social media channels.</span>
            </div>

            <!-- 9. Children’s Privacy (COPPA Compliance) -->
            <h3 class="legal-sec-title">
                <span class="sec-num">9</span>
                <span>Children’s Privacy (COPPA Compliance)</span>
            </h3>
            <p>
                We do not knowingly collect personally identifiable information from children under the age of 13. If you are a parent or guardian and you are aware that your child has provided us with personal data, please contact us so that we can take necessary steps to remove that information from our servers.
            </p>

            <!-- 10. Fair Information Practices & Data Breach Notification -->
            <h3 class="legal-sec-title">
                <span class="sec-num">10</span>
                <span>Fair Information Practices &amp; Data Breach Notification</span>
            </h3>
            <p>
                In accordance with Fair Information Practices, should a data breach occur that compromises your personal information, we will notify affected users via email or a prominent notice on our website within 72 hours of becoming aware of the breach.
            </p>

            <!-- 11. CAN-SPAM Compliance & Unsubscribing -->
            <h3 class="legal-sec-title">
                <span class="sec-num">11</span>
                <span>CAN-SPAM Compliance &amp; Unsubscribing</span>
            </h3>
            <p>
                In accordance with the CAN-SPAM Act, we agree not to use false or misleading subjects or email addresses, and we honor opt-out/unsubscribe requests quickly.
            </p>
            <ul class="ps-3">
                <li><strong>Emails/Newsletters:</strong> You can unsubscribe at any time by clicking the "Unsubscribe" link at the bottom of any email or by contacting us directly.</li>
                <li><strong>Push Notifications:</strong> You can disable push notifications at any time from your browser or device notification settings.</li>
            </ul>

            <!-- 12. Changes to This Privacy Policy -->
            <h3 class="legal-sec-title">
                <span class="sec-num">12</span>
                <span>Changes to This Privacy Policy</span>
            </h3>
            <p>
                We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Effective Date" at the top. You are advised to review this Privacy Policy periodically for any changes.
            </p>

            <!-- 13. Contact Us -->
            <div class="mt-4 p-4 rounded bg-light border">
                <h4 class="fw-bold text-dark mb-3"><i class="fa-solid fa-headset text-danger me-2"></i>13. Contact Us &amp; Data Support</h4>
                <p class="mb-2">If you have any questions about this Privacy Policy or wish to request data deletion, please contact us:</p>
                <ul class="list-unstyled mb-0 ps-2" style="font-size: 0.95rem; line-height: 1.8;">
                    <li><strong>Website:</strong> <a href="https://bholajournal.com" target="_blank" class="text-danger">https://bholajournal.com</a></li>
                    <li><strong>Email:</strong> <a href="mailto:{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}">{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}</a></li>
                    <li><strong>Phone / Hotline:</strong> {{ $themeSettings['contact_phone'] ?? '01716-674375' }}</li>
                    <li><strong>Address:</strong> {{ $themeSettings['contact_address'] ?? 'Bhola Sadar, Bhola, Bangladesh.' }}</li>
                </ul>
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
            heading.textContent = 'Privacy Policy & Data Protection';
            window.location.hash = 'en';
        } else {
            enDiv.style.display = 'none';
            bnDiv.style.display = 'block';
            btnEn.classList.remove('active');
            btnBn.classList.add('active');
            heading.textContent = 'গোপনীয়তা নীতি ও ইউজার ডেটা প্রটেকশন';
            window.location.hash = 'bn';
        }
    }

    // Auto-detect hash if #en is present
    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash === '#en') {
            switchLanguage('en');
        }
    });
</script>
@endsection