@extends('layouts.app')

@section('title', 'আমাদের সম্পর্কে (About Us) | দৈনিক ভোলা জার্নাল')

@section('meta')
    <meta name="description" content="দৈনিক ভোলা জার্নাল — আমাদের পরিচিতি, লক্ষ্য, উদ্দেশ্য ও বস্তুনিষ্ঠ সাংবাদিকতার অঙ্গীকার (About Us)।">
    <meta property="og:title" content="আমাদের সম্পর্কে (About Us) | দৈনিক ভোলা জার্নাল">
    <meta property="og:description" content="দৈনিক ভোলা জার্নাল — আমাদের পরিচিতি, লক্ষ্য, উদ্দেশ্য ও বস্তুনিষ্ঠ সাংবাদিকতার অঙ্গীকার।">
    <meta property="og:type" content="article">
@endsection

@section('styles')
<style>
    .about-page-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        padding: 42px 0 32px 0;
        margin-bottom: 36px;
        border-bottom: 3px solid var(--accent, #c90000);
    }
    .about-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.84rem;
        color: #94a3b8;
        margin-bottom: 14px;
    }
    .about-breadcrumb a {
        color: #cbd5e1;
        text-decoration: none;
    }
    .about-breadcrumb a:hover {
        color: #ffffff;
    }
    .about-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 2.1rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 8px;
    }
    .about-subtitle {
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
    .about-content-card {
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
        .about-content-card {
            padding: 24px 20px;
        }
        .about-title {
            font-size: 1.6rem;
        }
    }
    .value-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 22px;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .value-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.06);
        border-color: var(--accent, #c90000);
    }
    .value-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: #fee2e2;
        color: var(--accent, #c90000);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin-bottom: 14px;
    }
    .value-card h5 {
        font-size: 1.10rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }
    .value-card p {
        font-size: 0.92rem;
        color: #475569;
        line-height: 1.65;
        margin: 0;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<section class="about-page-header">
    <div class="container">
        <div class="about-breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house-chimney me-1"></i>প্রচ্ছদ</a>
            <span>/</span>
            <span>আমাদের সম্পর্কে</span>
        </div>
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="about-title" id="pageMainHeading">আমাদের সম্পর্কে (About Us)</h1>
                <p class="about-subtitle m-0">"সত্যের পথে, সময়ের সাথে" — দ্বীপজেলা ভোলা ও বাংলাদেশের সার্বক্ষণিক কণ্ঠস্বর</p>
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
    <div class="about-content-card">

        <!-- ==========================================================================
             1. BANGLA VERSION
             ========================================================================== -->
        <div id="versionBangla">
            <p class="lead" style="font-size: 1.15rem; color: #0f172a; font-weight: 600; line-height: 1.7;">
                <strong>ভোলা জার্নাল (Bhola Journal)</strong> বাংলাদেশের অন্যতম একটি আধুনিক, বস্তুনিষ্ঠ ও দায়িত্বশীল ডিজিটাল সংবাদ মাধ্যম। 
                <span class="text-danger">"সত্যের পথে, সময়ের সাথে"</span>—এই প্রত্যয়কে ধারণ করে আমরা দ্বীপজেলা ভোলাসহ সমগ্র বাংলাদেশের এবং বিশ্বজুড়ে ঘটে যাওয়া প্রতিটি গুরুত্বপূর্ণ সংবাদ দ্রুততম সময়ে পাঠকের কাছে পৌঁছে দিতে প্রতিশ্রুতিবদ্ধ।
            </p>

            <p style="font-size: 1.02rem;">
                তথ্যপ্রযুক্তির এই যুগে সংবাদপত্রের প্রচলিত ধারার বাইরে গিয়ে মাল্টিমিডিয়া, ডিজিটাল ভিজ্যুয়ালাইজেশন এবং যাচাইকৃত তথ্যের সমন্বয়ে আমরা গড়ে তুলেছি একটি আধুনিক নিউজরুম। স্থানীয় জনপদ, অর্থনীতি, শিক্ষা, কৃষি, পরিবেশ, জাতীয় রাজনীতি, খেলাধুলা, বিনোদন এবং তথ্যপ্রযুক্তির সর্বশেষ খবরাখবর শতভাগ নিরপেক্ষতার সাথে তুলে ধরাই আমাদের মূল লক্ষ্য।
            </p>

            <h3 class="fw-bold text-dark mt-4 mb-3" style="font-family: 'Noto Serif Bengali', serif; font-size: 1.35rem;">
                <i class="fa-solid fa-compass text-danger me-2"></i>আমাদের লক্ষ্য ও উদ্দেশ্য:
            </h3>

            <div class="row g-4 mt-1 mb-4">
                <div class="col-md-6">
                    <div class="value-card">
                        <div class="value-icon-box">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <h5>১. বস্তুনিষ্ঠ সাংবাদিকতা</h5>
                        <p>কোনো দল, গোষ্ঠী বা বিশেষ মহলের প্রভাবমুক্ত থেকে নিরপেক্ষ ও তথ্যনির্ভর সংবাদ পরিবেশন করা।</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="value-card">
                        <div class="value-icon-box">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <h5>২. তৃণমূলের কণ্ঠস্বর</h5>
                        <p>ভোলার প্রতিটি উপজেলা, ইউনিয়ন ও প্রত্যন্ত অঞ্চলের মানুষের সমস্যা, সম্ভাবনা, উন্নয়ন ও নাগরিক অধিকারের কথা জাতীয় পর্যায়ে তুলে ধরা।</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="value-card">
                        <div class="value-icon-box">
                            <i class="fa-solid fa-magnifying-glass-chart"></i>
                        </div>
                        <h5>৩. গুজব প্রতিরোধ ও ফ্যাক্ট-চেকিং</h5>
                        <p>সোশ্যাল মিডিয়ার অবাধ তথ্যপ্রবাহের যুগে যেকোনো সংবাদের সত্যতা যাচাই (Fact-check) করে বিভ্রান্তিমুক্ত ও নির্ভরযোগ্য তথ্য পাঠকদের সামনে উপস্থাপন করা।</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="value-card">
                        <div class="value-icon-box">
                            <i class="fa-solid fa-mobile-screen-button"></i>
                        </div>
                        <h5>৪. আধুনিক পাঠ-অভিজ্ঞতা</h5>
                        <p>ওয়েব পোর্টাল, মোবাইল ফ্রেন্ডলি ইন্টারফেস এবং ডিজিটাল ই-পেপারের মাধ্যমে পাঠকদের জন্য সহজ, পরিচ্ছন্ন ও দ্রুত সংবাদ পাঠের অভিজ্ঞতা নিশ্চিত করা।</p>
                    </div>
                </div>
            </div>

            <div class="p-4 rounded border bg-light">
                <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-heart text-danger me-2"></i>পাঠকদের প্রতি আমাদের অঙ্গীকার</h5>
                <p class="mb-0 text-muted" style="font-size: 0.96rem;">
                    পাঠকদের আস্থা ও ভালোবাসাই আমাদের এগিয়ে যাওয়ার প্রধান শক্তি। যেকোনো সংবাদ, গঠনমূলক মতামত বা পরামর্শ দিয়ে আপনিও হতে পারেন ভোলা জার্নাল পরিবারের একজন গর্বিত অংশীদার।
                </p>
            </div>
        </div>

        <!-- ==========================================================================
             2. ENGLISH VERSION
             ========================================================================== -->
        <div id="versionEnglish" style="display: none;">
            <p class="lead" style="font-size: 1.15rem; color: #0f172a; font-weight: 600; line-height: 1.7;">
                <strong>Bhola Journal</strong> (<a href="https://bholajournal.com" target="_blank" class="text-danger">bholajournal.com</a>) is a modern, independent, and progressive digital news portal based in Bangladesh. Driven by a commitment to truth, accuracy, and ethical journalism, we bring comprehensive coverage of local, national, and international news to Bengali-speaking readers worldwide.
            </p>

            <p style="font-size: 1.02rem;">
                While deeply rooted in highlighting the socio-economic development, culture, climate challenges, and grassroots stories of the island district of Bhola and the coastal region, Bhola Journal equally covers national politics, economy, technology, sports, entertainment, and global affairs with a dedicated team of journalists and digital content creators.
            </p>

            <h3 class="fw-bold text-dark mt-4 mb-3" style="font-size: 1.35rem;">
                <i class="fa-solid fa-compass text-danger me-2"></i>Our Core Values:
            </h3>

            <div class="row g-4 mt-1 mb-4">
                <div class="col-md-4">
                    <div class="value-card">
                        <div class="value-icon-box">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <h5>Accuracy &amp; Integrity</h5>
                        <p>We verify every piece of information from credible sources before publication, ensuring our readers receive factual and unbiased news.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="value-card">
                        <div class="value-icon-box">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h5>Voice of the Grassroots</h5>
                        <p>We prioritize public interest journalism, bringing underreported local issues, riverbank challenges, and civic concerns to the forefront of national attention.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="value-card">
                        <div class="value-icon-box">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <h5>Digital Innovation</h5>
                        <p>Combining fast web technologies, interactive e-paper features, and multimedia storytelling, we deliver news tailored for today’s digital-first audience.</p>
                    </div>
                </div>
            </div>

            <div class="p-4 rounded border bg-light">
                <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-shield-halved text-danger me-2"></i>Accountability to Our Readers</h5>
                <p class="mb-0 text-muted" style="font-size: 0.96rem;">
                    At Bhola Journal, we believe that credible information empowers society. We are accountable to our readers and strive every day to uphold the highest standards of professional journalism.
                </p>
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
            heading.textContent = 'About Us';
            window.location.hash = 'en';
        } else {
            enDiv.style.display = 'none';
            bnDiv.style.display = 'block';
            btnEn.classList.remove('active');
            btnBn.classList.add('active');
            heading.textContent = 'আমাদের সম্পর্কে (About Us)';
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