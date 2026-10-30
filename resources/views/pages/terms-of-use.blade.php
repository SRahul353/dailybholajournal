@extends('layouts.app')

@section('title', 'ব্যবহারের শর্তাবলী (Terms of Use) | দৈনিক ভোলা জার্নাল')

@section('meta')
    <meta name="description" content="দৈনিক ভোলা জার্নাল ডিজিটাল প্ল্যাটফর্মের অফিসিয়াল ব্যবহারের শর্তাবলী (Terms of Use / Terms and Conditions)।">
    <meta property="og:title" content="ব্যবহারের শর্তাবলী (Terms of Use) | দৈনিক ভোলা জার্নাল">
    <meta property="og:description" content="দৈনিক ভোলা জার্নাল ডিজিটাল প্ল্যাটফর্মের ব্যবহারের শর্তাবলী ও নীতিমালা।">
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
        font-size: 1.30rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 30px;
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
    .legal-highlight-box {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-left: 4px solid var(--accent, #c90000);
        border-radius: 8px;
        padding: 18px 20px;
        margin: 20px 0;
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
            <span>ব্যবহারের শর্তাবলী</span>
        </div>
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="legal-title" id="pageMainHeading">ব্যবহারের শর্তাবলী (Terms of Use)</h1>
                <p class="legal-subtitle m-0">দৈনিক ভোলা জার্নাল ডিজিটাল প্ল্যাটফর্মের সেবা গ্রহণের নিয়ম ও শর্তাবলী</p>
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
                <strong>ভোলা জার্নাল (Bhola Journal)</strong>-এ আপনাকে স্বাগতম। আমাদের ওয়েবসাইট (<a href="https://bholajournal.com" target="_blank" class="text-danger fw-bold">https://bholajournal.com</a>) এবং এর সাথে সম্পর্কিত ডিজিটাল প্ল্যাটফর্ম, সোশ্যাল মিডিয়া পেজ, কন্টেন্ট ও পরিষেবা ব্যবহারের পূর্বে অনুগ্রহ করে এই "ব্যবহারের শর্তাবলী" (Terms of Use) মনোযোগ সহকারে পড়ুন।
            </p>
            <p>
                পাঠক ও ভিজিটররা কম্পিউটার, মোবাইল ফোন বা অন্যান্য ডিভাইসের মাধ্যমে ওয়েব, সোশ্যাল মিডিয়া এবং আরএসএস (RSS) ফিডসহ বিভিন্ন মাধ্যমে আমাদের কন্টেন্ট অ্যাক্সেস করতে পারেন। আমাদের ওয়েবসাইটে প্রবেশ করা, কোনো সংবাদ পড়া, ছবি বা ভিডিও দেখা কিংবা যেকোনো সেবা গ্রহণের মাধ্যমে আপনি ভোলা জার্নালের এই ‘ব্যবহারের শর্তাবলী’ এবং আমাদের ‘গোপনীয়তা নীতি’ (Privacy Policy) মেনে চলতে সম্মতি প্রদান করছেন। আপনি যদি এই শর্তাবলীর কোনো অংশের সাথে একমত না হন, তবে অনুগ্রহ করে আমাদের পরিষেবা ব্যবহার থেকে বিরত থাকুন।
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">১</span>
                <span>মেধাস্বত্ব ও কপিরাইট (Intellectual Property Rights)</span>
            </h3>
            <p>
                ভোলা জার্নালে প্রকাশিত সকল সংবাদ, প্রবন্ধ, লোগো, কপিরাইট, ট্রেডমার্ক, ছবি, গ্রাফিক্স, ডোমেইন নেম, অডিও, ভিডিও এবং সফটওয়্যারের একমাত্র স্বত্বাধিকারী ভোলা জার্নাল অথবা এর লাইসেন্সদাতাগণ। বাণিজ্যিক বা অ-বাণিজ্যিক যেকোনো উদ্দেশ্যেই ব্যবহারকারীরা আমাদের মেধাস্বত্বের ওপর কোনো অধিকার দাবি করতে পারবেন না। কর্তৃপক্ষের লিখিত অনুমতি ছাড়া আমাদের কোনো কন্টেন্ট হুবহু কপি করা, পরিবর্তন করে পুনঃপ্রকাশ করা বা ডেরিভেটিভ কাজ তৈরি করা সম্পূর্ণ নিষিদ্ধ। কপিরাইট লঙ্ঘন সংক্রান্ত যেকোনো অভিযোগ <a href="mailto:{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}">{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}</a> ঠিকানায় পাঠানো যাবে।
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">২</span>
                <span>আমাদের সেবার ব্যবহার ও শেয়ারিং নীতিমালা</span>
            </h3>
            <p><strong>বৈধ ও ব্যক্তিগত ব্যবহার:</strong> পাঠক ও ভিজিটররা শুধুমাত্র বৈধ, ব্যক্তিগত এবং অ-বাণিজ্যিক উদ্দেশ্যে ভোলা জার্নালের সেবা ও কন্টেন্ট ব্যবহার করতে পারবেন। ওয়েবসাইটের অডিও এবং ভিডিও কন্টেন্ট শুধুমাত্র শোনা ও দেখার জন্য উন্মুক্ত।</p>
            <p><strong>সোশ্যাল মিডিয়ায় শেয়ারিং:</strong> ভোলা জার্নাল পাঠকদের আমাদের সংবাদের লিংক বা ফটোকার্ড তাদের ব্যক্তিগত সোশ্যাল মিডিয়া প্রোফাইল, পেজ বা গ্রুপে শেয়ার করতে উৎসাহিত করে। তবে আমাদের কোনো সংবাদ, ছবি বা ফটোকার্ডের লোগো/ওয়াটারমার্ক মুছে ফেলে, বিকৃত করে বা পরিবর্তন করে অন্য কোনো ডিজিটাল প্ল্যাটফর্মে শেয়ার করা যাবে না। কন্টেন্ট বা ছবি শেয়ার করার ক্ষেত্রে ‘ভোলা জার্নাল’-এর নাম ও ক্রেডিট স্পষ্টভাবে দৃশ্যমান থাকতে হবে।</p>
            <p><strong>নিরাপত্তা লঙ্ঘন নিষিদ্ধ:</strong> ওয়েবসাইট হ্যাক করার চেষ্টা করা, বট (Bot) দিয়ে ডেটা স্ক্র্যাপ করা কিংবা সাইটের সিকিউরিটি সিস্টেম বাইপাস করার যেকোনো চেষ্টা কঠোরভাবে নিষিদ্ধ।</p>

            <h3 class="legal-sec-title">
                <span class="sec-num">৩</span>
                <span>ইউজার অ্যাকাউন্ট ও সোশ্যাল লগইন</span>
            </h3>
            <p>
                আপনি যখন আমাদের সাইটে সরাসরি অথবা Google / Facebook লগইন-এর মাধ্যমে অ্যাকাউন্ট তৈরি করবেন, তখন আপনাকে সঠিক তথ্য প্রদান করতে হবে। আপনার অ্যাকাউন্টের নিরাপত্তা এবং সেই অ্যাকাউন্ট থেকে করা যেকোনো কার্যক্রমের দায়ভার আপনার নিজের। শর্তাবলী লঙ্ঘন, ভুয়া পরিচয় ব্যবহার বা স্প্যামিংয়ের কারণে ভোলা জার্নাল যেকোনো অ্যাকাউন্ট স্থগিত বা বাতিল করার অধিকার রাখে।
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">৪</span>
                <span>পাঠকের মন্তব্য ও কন্টেন্ট (User-Generated Content)</span>
            </h3>
            <p>পাঠকরা আমাদের ওয়েবসাইটে সংবাদের নিচে মন্তব্য (Comment) করতে বা মতামত প্রকাশ করতে পারেন। মন্তব্য বা কন্টেন্ট প্রকাশের ক্ষেত্রে ব্যবহারকারীকে অবশ্যই নিশ্চিত করতে হবে যে:</p>
            <ul class="ps-3">
                <li>কোনো অশ্লীল, মানহানিকর, কুরুচিপূর্ণ, প্রতারণামূলক, হুমকিস্বরূপ বা অন্যের ব্যক্তিগত গোপনীয়তা লঙ্ঘনকারী মন্তব্য বা ছবি পোস্ট করা যাবে না।</li>
                <li>ধর্ম, বর্ণ, লিঙ্গ, জাতিসত্তা, জাতীয়তা, বয়স বা শারীরিক প্রতিবন্ধকতার ভিত্তিতে কোনো ব্যক্তি বা গোষ্ঠীকে হেয় প্রতিপন্ন বা আক্রমণ করা যাবে না।</li>
                <li>ভোলা জার্নালকে কোনো রাজনৈতিক দল, উগ্রবাদ বা পক্ষপাতদুষ্টতার সাথে জড়িয়ে প্রতিষ্ঠানের সুনাম ক্ষুণ্ণ করা যাবে না।</li>
                <li>আদালতে বিচারাধীন কোনো বিষয়ে এমন কোনো মন্তব্য করা যাবে না যা আদালত অবমাননার (Contempt of Court) শামিল হতে পারে।</li>
                <li>ভাইরাস, ম্যালওয়্যার বা স্প্যাম/বিজ্ঞাপনের লিংক কমেন্ট বক্সে পোস্ট করা যাবে না।</li>
            </ul>
            <p class="text-muted small">পাঠকদের কোনো মন্তব্যের দায়ভার ভোলা জার্নাল বহন করে না। কোনো পূর্ব নোটিশ ছাড়াই যেকোনো আপত্তিকর মন্তব্য মুছে ফেলা এবং সংশ্লিষ্ট ব্যবহারকারীর অ্যাকাউন্ট বা আইপি ব্লক করার পূর্ণ এখতিয়ার ভোলা জার্নাল সংরক্ষণ করে।</p>

            <h3 class="legal-sec-title">
                <span class="sec-num">৫</span>
                <span>কন্টেন্ট প্রত্যাহার বা অপসারণ</span>
            </h3>
            <p>
                ভোলা জার্নাল কর্তৃপক্ষ যেকোনো সময় নিজস্ব বিবেচনায় ওয়েবসাইট বা সোশ্যাল প্ল্যাটফর্ম থেকে যেকোনো সংবাদ, ছবি বা ভিডিও সম্পাদনা, সংশোধন বা প্রত্যাহার (Take down) করার একচেটিয়া অধিকার রাখে।
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">৬</span>
                <span>তৃতীয় পক্ষের লিংক, কন্টেন্ট ও বিজ্ঞাপন</span>
            </h3>
            <p><strong>বাহ্যিক লিংক ও কন্টেন্ট:</strong> আমাদের সংবাদে বা ওয়েবসাইটে তৃতীয় পক্ষের ওয়েবসাইটের লিংক বা সূত্র থাকতে পারে। সেসব বাহ্যিক ওয়েবসাইটের কন্টেন্ট, সত্যতা বা গোপনীয়তা নীতির ওপর ভোলা জার্নালের কোনো নিয়ন্ত্রণ নেই এবং এর জন্য আমরা কোনো দায়ভার গ্রহণ করি না।</p>
            <p><strong>বিজ্ঞাপন:</strong> ভোলা জার্নালের ওয়েবসাইটে প্রদর্শিত বিজ্ঞাপনসমূহ (যেমন: Google AdSense বা স্পন্সর ব্যানার) তৃতীয় পক্ষের বিজ্ঞাপনদাতা কোম্পানির মাধ্যমে পরিচালিত হয়। কোনো বিজ্ঞাপনের বিষয়বস্তু বা বিজ্ঞাপনদাতার কার্যক্রমের কারণে সৃষ্ট কোনো ক্ষতির দায়ভার ভোলা জার্নাল বহন করবে না।</p>

            <h3 class="legal-sec-title">
                <span class="sec-num">৭</span>
                <span>ব্যবহারকারীর ডিভাইসের সুরক্ষা</span>
            </h3>
            <p>
                আমরা ওয়েবসাইটে আধুনিক SSL এনক্রিপশন ও নিরাপত্তা ব্যবস্থা ব্যবহার করলেও, অনাকাঙ্ক্ষিত ভাইরাস বা ম্যালওয়্যার আক্রমণ থেকে বাঁচার জন্য পাঠকদের নিজস্ব ডিভাইসে প্রয়োজনীয় সতর্কতা (যেমন: অ্যান্টিভাইরাস) গ্রহণের পরামর্শ দেওয়া হচ্ছে। তৃতীয় পক্ষের কোনো লিংক বা বিজ্ঞাপনে ক্লিক করার ফলে ডিভাইসে কোনো কারিগরি সমস্যা হলে তার জন্য ভোলা জার্নাল দায়ী থাকবে না।
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">৮</span>
                <span>দায়মুক্তি (Disclaimer)</span>
            </h3>
            <p>
                ভোলা জার্নাল সবসময় বস্তুনিষ্ঠ ও নির্ভুল সংবাদ পরিবেশনে সচেষ্ট। তা সত্ত্বেও ওয়েবসাইটে প্রকাশিত সকল তথ্য ও মাল্টিমিডিয়া কন্টেন্ট শুধুমাত্র সাধারণ তথ্যের উদ্দেশ্যে প্রদান করা হয়—এটি কোনো আইনি, চিকিৎসাগত বা আর্থিক পরামর্শ নয়। অনিবার্য কারিগরি ত্রুটি বা ইন্টারনেট সংযোগজনিত কারণে ওয়েবসাইট সাময়িকভাবে অপ্রাপ্য থাকলে কিংবা কোনো তথ্যের ওপর নির্ভর করার ফলে কোনো প্রত্যক্ষ বা পরোক্ষ ক্ষতি হলে আইন দ্বারা অনুমোদিত সর্বোচ্চ সীমা পর্যন্ত ভোলা জার্নাল কোনো দায় বহন করবে না।
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">৯</span>
                <span>গোপনীয়তা নীতি ও কুকিজের অন্তর্ভুক্তি</span>
            </h3>
            <p>
                ভোলা জার্নালের <a href="{{ route('privacy.policy') }}" class="text-danger fw-bold">গোপনীয়তা নীতি (Privacy Policy)</a> এই ‘ব্যবহারের শর্তাবলী’র একটি অবিচ্ছেদ্য অংশ। আমাদের কুকিজ, গুগল অ্যানালিটিক্স, পুশ নোটিফিকেশন এবং ইউজার ডেটা ডিলিশন সংক্রান্ত সকল নিয়ম ওই গোপনীয়তা নীতি অনুযায়ী পরিচালিত হবে।
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">১০</span>
                <span>প্রযোজ্য আইন ও বিচারিক এখতিয়ার (Governing Law)</span>
            </h3>
            <p>
                এই ‘ব্যবহারের শর্তাবলী’ এবং ব্যবহারকারীদের সাথে ভোলা জার্নালের সম্পর্ক বাংলাদেশের প্রচলিত আইন অনুযায়ী পরিচালিত ও ব্যাখ্যা করা হবে। এই শর্তাবলী বা তথ্য ব্যবহার সংক্রান্ত যেকোনো বিরোধ বাংলাদেশের সালিশ আইন, ২০০১ (Arbitration Act, 2001) অনুযায়ী অথবা বাংলাদেশের উপযুক্ত আদালতের একচেটিয়া এখতিয়ারাধীন থাকবে। ব্যবহারকারীর জাতীয়তা বা অবস্থান বাংলাদেশ বা বাংলাদেশের বাইরে যেখানেই হোক না কেন, ওয়েবসাইটে প্রবেশের সাথে সাথে এই শর্তাবলী সবার জন্য সমানভাবে প্রযোজ্য হবে।
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">১১</span>
                <span>শর্তাবলী পরিবর্তন ও পরিবর্ধন</span>
            </h3>
            <p>
                ভোলা জার্নাল কর্তৃপক্ষ যেকোনো সময় এই ‘ব্যবহারের শর্তাবলী’র যেকোনো ধারা পরিবর্তন, পরিবর্ধন, সংশোধন বা বাতিল করার অধিকার সংরক্ষণ করে। পরিবর্তিত শর্তাবলী ওয়েবসাইটে আপলোড করার সাথে সাথেই কার্যকর বলে গণ্য হবে। পরিবর্তনের পর আমাদের সেবা ব্যবহার অব্যাহত রাখার অর্থ হলো আপনি সংশোধিত শর্তাবলী মেনে নিয়েছেন।
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">১২</span>
                <span>যোগাযোগ ও অ্যাকাউন্ট বাতিল</span>
            </h3>
            <p>
                আপনি যেকোনো সময় আমাদের ইমেইলের নিচে থাকা "Unsubscribe" অপশন থেকে নিউজলেটার বন্ধ করতে পারেন অথবা আপনার রেজিস্টার্ড অ্যাকাউন্টটি মুছে ফেলার অনুরোধ করতে পারেন। এই শর্তাবলী সম্পর্কে আপনার কোনো প্রশ্ন বা মতামত থাকলে আমাদের সাথে যোগাযোগ করুন:
            </p>

            <div class="mt-4 p-4 rounded bg-light border">
                <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-headset text-danger me-2"></i>অফিসিয়াল যোগাযোগ</h5>
                <ul class="list-unstyled mb-0 ps-2" style="font-size: 0.95rem; line-height: 1.8;">
                    <li><strong>ওয়েবসাইট:</strong> <a href="https://bholajournal.com" target="_blank" class="text-danger">https://bholajournal.com</a></li>
                    <li><strong>ইমেইল:</strong> <a href="mailto:{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}">{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}</a></li>
                    <li><strong>মোবাইল / হটলাইন:</strong> {{ $themeSettings['contact_phone'] ?? '01716-674375' }}</li>
                    <li><strong>ঠিকানা:</strong> {{ $themeSettings['contact_address'] ?? 'বার্তা ও বাণিজ্যিক কার্যালয়- ভোলা সদর, ভোলা, বাংলাদেশ।' }}</li>
                </ul>
            </div>
        </div>

        <!-- ==========================================================================
             2. ENGLISH VERSION
             ========================================================================== -->
        <div id="versionEnglish" style="display: none;">
            <div class="effective-badge">
                <i class="fa-regular fa-calendar-check"></i>
                <span>Effective Date: October 30, 2026</span>
            </div>

            <p class="lead" style="font-size: 1.08rem; color: #1e293b; font-weight: 500;">
                Welcome to <strong>Bhola Journal</strong>. Please read these Terms of Use ("Terms", "Terms and Conditions") carefully before using the <a href="https://bholajournal.com" target="_blank" class="text-danger fw-bold">https://bholajournal.com</a> website and its associated digital platforms, contents, services, and applications (collectively, the "Service") operated by Bhola Journal ("us", "we", or "our").
            </p>
            <p>
                Individuals may access our content through multiple channels—including the web, digital platforms, social media, and RSS feeds—using computers, mobile phones, and other devices. By accessing or using our content and services (including reading articles, viewing images/videos, or logging into an account), you accept and agree to be bound by these Terms of Use and our Privacy Policy. If you disagree with any part of these terms, please discontinue using the Service immediately.
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">1</span>
                <span>Intellectual Property Rights</span>
            </h3>
            <p>
                All content published on Bhola Journal—including news articles, logos, copyright, trademarks, images, text, graphics, domain names, audio, video, and software—belongs to Bhola Journal or its content licensors. Users cannot claim any rights in our intellectual property for either commercial or non-commercial use. Users are strictly prohibited from making derivative works, copying, or republishing our content without explicit permission. Reports of copyright infringement may be sent to <a href="mailto:{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}">{{ $themeSettings['contact_email'] ?? 'info@bholajournal.com' }}</a>.
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">2</span>
                <span>Your Use of Our Services &amp; Sharing Policy</span>
            </h3>
            <p><strong>Lawful &amp; Personal Use:</strong> Readers and visitors are required to use Bhola Journal’s services only for lawful, personal, and non-commercial purposes. Audio and visual elements on the website or application are for viewing and listening only.</p>
            <p><strong>Social Media Sharing:</strong> Bhola Journal encourages readers to share its articles and content on their social media profiles, groups, and communities using official share links or social cards. However, our content, images, or watermarks must not be modified, altered, cropped, or shared without clear and visible credit/attribution to Bhola Journal.</p>
            <p><strong>Security Restrictions:</strong> Users are strictly prohibited from attempting to hack the website, scrape content via automated bots, or bypass our content security and authentication systems.</p>

            <h3 class="legal-sec-title">
                <span class="sec-num">3</span>
                <span>User Accounts &amp; Social Login</span>
            </h3>
            <p>
                When you create an account with us (directly or via Google/Facebook Social Login), you must provide accurate and complete information. You are solely responsible for safeguarding your account access and for any activities or actions under your account. Bhola Journal reserves the right to suspend or terminate accounts that violate these Terms, impersonate others, or engage in spam/abusive behavior.
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">4</span>
                <span>User-Generated Content (Comments, Posts &amp; Media)</span>
            </h3>
            <p>Users of Bhola Journal may submit, post, or upload content (such as comments on articles, poll responses, pictures, or videos). By posting content, you confirm that you own or have consent to post the content, and you agree not to post anything that:</p>
            <ul class="ps-3">
                <li>Is obscene, defamatory, libelous, deceptive, threatening, harassing, or invasive of another's privacy.</li>
                <li>Attacks, degrades, or intimidates any individual or group based on religion, gender, race, ethnicity, nationality, age, or disability.</li>
                <li>Associates Bhola Journal with any political party, extremism, or activities that damage its journalistic reputation.</li>
                <li>Comments on ongoing court proceedings in a manner that may amount to contempt of court.</li>
                <li>Contains software viruses, malicious links, spam, or promotional advertisements.</li>
            </ul>
            <p class="text-muted small">Bhola Journal does not endorse any user-generated content and accepts no liability for comments posted by users. We reserve the absolute right to filter, edit, or remove any user’s content and suspend their posting privileges at any time without prior notice.</p>

            <h3 class="legal-sec-title">
                <span class="sec-num">5</span>
                <span>Taking Down Content</span>
            </h3>
            <p>
                Bhola Journal reserves the right to edit, remove, or take down any article, image, video, or service from its website or digital platforms at any time at its sole discretion.
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">6</span>
                <span>Third-Party Links, Content &amp; Advertisements</span>
            </h3>
            <p><strong>Third-Party Content &amp; Links:</strong> Our Service may contain links to third-party websites or display content supplied by third parties. Bhola Journal has no control over and assumes no responsibility or liability for the accuracy, content, privacy policies, or practices of any third-party websites or services.</p>
            <p><strong>Advertisements:</strong> Advertisements displayed on the Bhola Journal website (including Google AdSense and third-party sponsor banners) are served by third-party networks or advertisers. Bhola Journal bears no liability for any claims, damages, or issues arising from the content of any advertisement or third-party data collection.</p>

            <h3 class="legal-sec-title">
                <span class="sec-num">7</span>
                <span>Protection of User Devices</span>
            </h3>
            <p>
                While Bhola Journal implements SSL encryption and regular security scans, readers and visitors are advised to take their own precautions (such as using updated antivirus software). Bhola Journal accepts no responsibility for any virus infection, malware, or technical contamination of your device resulting from accessing third-party links or external advertisements.
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">8</span>
                <span>Disclaimer of Warranties &amp; Limitation of Liability</span>
            </h3>
            <p>
                Bhola Journal strives to maintain the highest standards of accurate and objective journalism. However, all content and services on Bhola Journal are provided on an "AS IS" and "AS AVAILABLE" basis for informational purposes only and do not constitute professional, legal, or financial advice. Bhola Journal makes no warranties regarding uninterrupted availability of the website or the absolute completeness of all information. To the maximum extent permitted by law, Bhola Journal shall not be liable for any direct or indirect loss or damage resulting from the use of its services.
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">9</span>
                <span>Incorporation of Privacy Policy &amp; Cookies</span>
            </h3>
            <p>
                The <a href="{{ route('privacy.policy') }}" class="text-danger fw-bold">Privacy Policy</a> of Bhola Journal (including our policies on Cookies, Google Analytics, Push Notifications, and User Data Deletion) is an integral part of these Terms of Use and is hereby incorporated by reference.
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">10</span>
                <span>Termination of Access</span>
            </h3>
            <p>
                We may terminate or suspend your account or access to our Service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach these Terms of Use.
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">11</span>
                <span>Governing Law &amp; Jurisdiction</span>
            </h3>
            <p>
                These Terms of Use and your relationship with Bhola Journal shall be governed and construed in accordance with the laws of Bangladesh. Any dispute arising in connection with these Terms shall be subject to the exclusive jurisdiction of the courts of Bangladesh (or resolved through arbitration in accordance with the Arbitration Act, 2001 of Bangladesh). These Terms apply to all users regardless of their nationality, location, or residence.
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">12</span>
                <span>Modification of Terms</span>
            </h3>
            <p>
                Bhola Journal reserves the right, at its sole discretion, to amend, modify, or replace any part of these Terms of Use at any time. Any updated policy will be immediately posted on this page with an updated "Effective Date." By continuing to access or use our Service after changes are posted, you agree to be bound by the revised terms.
            </p>

            <h3 class="legal-sec-title">
                <span class="sec-num">13</span>
                <span>Opt-Out &amp; Contact Information</span>
            </h3>
            <p>
                Users may unsubscribe from newsletters at any time via the link at the bottom of our emails or request account termination. If you have any questions, objections, or inquiries regarding these Terms of Use, please contact us:
            </p>

            <div class="mt-4 p-4 rounded bg-light border">
                <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-headset text-danger me-2"></i>Official Inquiries</h5>
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
            heading.textContent = 'Terms of Use (Terms & Conditions)';
            window.location.hash = 'en';
        } else {
            enDiv.style.display = 'none';
            bnDiv.style.display = 'block';
            btnEn.classList.remove('active');
            btnBn.classList.add('active');
            heading.textContent = 'ব্যবহারের শর্তাবলী (Terms of Use)';
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