@extends('layouts.app')

@section('title', 'মন্তব্য প্রকাশের নীতিমালা (Comment Policy) | দৈনিক ভোলা জার্নাল')

@section('meta')
    <meta name="description" content="দৈনিক ভোলা জার্নাল ডিজিটাল প্ল্যাটফর্মের মন্তব্য প্রকাশের নীতিমালা ও গাইডলাইন (Comment Policy)।">
    <meta property="og:title" content="মন্তব্য প্রকাশের নীতিমালা (Comment Policy) | দৈনিক ভোলা জার্নাল">
    <meta property="og:description" content="দৈনিক ভোলা জার্নাল ডিজিটাল প্ল্যাটফর্মের মন্তব্য ও পাঠক মতামত প্রকাশের নীতিমালা।">
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
    .policy-rule-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid var(--accent, #c90000);
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 14px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .policy-rule-card:hover {
        transform: translateX(3px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.04);
    }
    .policy-rule-card h5 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .policy-rule-card p {
        margin: 0;
        color: #475569;
        font-size: 0.94rem;
        line-height: 1.65;
    }
    .disclaimer-alert {
        background-color: #fee2e2;
        border: 1px solid #fecaca;
        border-left: 4px solid #dc2626;
        border-radius: 8px;
        padding: 16px 20px;
        margin-top: 24px;
        color: #991b1b;
        font-size: 0.94rem;
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
            <span>মন্তব্য প্রকাশের নীতিমালা</span>
        </div>
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="legal-title" id="pageMainHeading">মন্তব্য প্রকাশের নীতিমালা (Comment Policy)</h1>
                <p class="legal-subtitle m-0">একটি সুস্থ, শালীন ও গঠনমূলক আলোচনার পরিবেশ বজায় রাখার নিয়মাবলী</p>
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
            <p class="lead" style="font-size: 1.08rem; color: #1e293b; font-weight: 500;">
                <strong>ভোলা জার্নাল (Bhola Journal)</strong> পাঠকদের মতামত ও গঠনমূলক আলোচনাকে সবসময় স্বাগত জানায়। তবে একটি সুস্থ, শালীন ও নিরাপদ আলোচনার পরিবেশ বজায় রাখতে আমাদের ওয়েবসাইটে (<a href="https://bholajournal.com" target="_blank" class="text-danger fw-bold">bholajournal.com</a>) এবং সোশ্যাল মিডিয়া প্ল্যাটফর্মে মন্তব্য করার ক্ষেত্রে পাঠকদের নিম্নলিখিত নীতিমালা মেনে চলার অনুরোধ করা হচ্ছে:
            </p>

            <div class="mt-4">
                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-check-circle text-danger"></i> প্রাসঙ্গিকতা (Relevance)</h5>
                    <p>পাঠকদের মন্তব্য অবশ্যই প্রকাশিত সংবাদের বিষয় বা বিষয়বস্তুর সাথে প্রাসঙ্গিক হতে হবে।</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-scale-balanced text-danger"></i> আইনের প্রতি শ্রদ্ধা (Legal Compliance)</h5>
                    <p>বাংলাদেশের প্রচলিত আইন লঙ্ঘন করে বা রাষ্ট্রবিরোধী কোনো মন্তব্য করা যাবে না। আদালতে বিচারাধীন কোনো বিষয়ে আদালত অবমাননার শামিল হতে পারে এমন মন্তব্য থেকে বিরত থাকতে হবে।</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-hand-holding-heart text-danger"></i> ধর্মীয় ও সামাজিক সম্প্রীতি</h5>
                    <p>কোনো ধর্ম, ধর্মীয় গ্রন্থ বা কারও ধর্মীয় অনুভূতিতে আঘাত দিতে পারে এমন কোনো মন্তব্য করা সম্পূর্ণ নিষিদ্ধ। এছাড়া কোনো ব্যক্তি, জাতি, গোষ্ঠী, বর্ণ বা ভাষার প্রতি অবমাননাকর মন্তব্য করা যাবে না।</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-user-xmark text-danger"></i> ব্যক্তিগত আক্রমণ ও নাম বিকৃতি রোধ</h5>
                    <p>কাউকে ব্যক্তিগতভাবে আক্রমণ করা, ভয় দেখানো বা হুমকি দেওয়া যাবে না। কোনো ব্যক্তিকে হেয় করতে অবমাননাকরভাবে কোনো প্রাণীবাচক নাম দেওয়া বা কারও নাম বিকৃত করে মন্তব্য করা যাবে না।</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-shield-virus text-danger"></i> ভাষা ও শালীনতা</h5>
                    <p>মন্তব্যে কোনো প্রকার অশ্লীল, কুরুচিপূর্ণ বা অশালীন ইঙ্গিতপূর্ণ শব্দ ব্যবহার করা যাবে না।</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-mask text-danger"></i> ছদ্মনাম বা ভুয়া প্রোফাইল নিষিদ্ধ</h5>
                    <p>উদ্দেশ্যমূলক, আপত্তিকর বা ইঙ্গিতপূর্ণ নাম কিংবা ভুয়া পরিচয় (Fake Profile) ব্যবহার করে মন্তব্য করা যাবে না।</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-font text-danger"></i> ভাষার ব্যবহার (বাংলা হরফ)</h5>
                    <p>বাংলায় মন্তব্য করার ক্ষেত্রে অবশ্যই বাংলা হরফ (Unicode / Bangla Script) ব্যবহার করতে হবে। ইংরেজি হরফে বাংলা (Banglish) মন্তব্য করলে তা প্রকাশের অযোগ্য বলে বিবেচিত হবে। তবে প্রাসঙ্গিক ক্ষেত্রে সরাসরি শুদ্ধ ইংরেজিতে মন্তব্য করা যাবে।</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-link-slash text-danger"></i> লিংক ও স্প্যাম নিষিদ্ধ</h5>
                    <p>সংবাদের মন্তব্যে কোনো ধরনের ওয়েবসাইট লিংক, বিজ্ঞাপন, প্রচারণামূলক লেখা বা স্প্যাম শেয়ার করা যাবে না।</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-pen-ruler text-danger"></i> বাক্যগঠন ও সম্পাদনা</h5>
                    <p>অসংলগ্ন বাক্যের মন্তব্য প্রকাশ করা হবে না। তবে দৃষ্টিকটু বানান ভুল বা অসম্পূর্ণ বাক্যের গঠনমূলক মন্তব্য কর্তৃপক্ষের সম্পাদনা সাপেক্ষে প্রকাশিত হতে পারে।</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-user-shield text-danger"></i> দায়বদ্ধতা ও মডারেশন</h5>
                    <p>পাঠকদের দ্বারা প্রকাশিত কোনো মতামতের জন্য ভোলা জার্নাল কর্তৃপক্ষ দায়বদ্ধ থাকবে না; মন্তব্যের সম্পূর্ণ দায়ভার সংশ্লিষ্ট মন্তব্যকারীর। ভোলা জার্নাল কর্তৃপক্ষ কোনো পূর্ব নোটিশ ছাড়াই যেকোনো মন্তব্য অনুমোদন না করা, সম্পাদনা করা বা মুছে দেওয়ার এবং নিয়ম ভঙ্গকারী ব্যবহারকারীর অ্যাকাউন্ট ব্লক করার পূর্ণ অধিকার সংরক্ষণ করে।</p>
                </div>
            </div>

            <div class="disclaimer-alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <strong>সতর্কবার্তা:</strong> পাঠকদের মন্তব্য কোনো অবস্থাতেই ভোলা জার্নালের সম্পাদকীয় অবস্থান প্রকাশ করে না। সকল পাঠককে সুস্থ ও শিষ্ট ভাষায় মত প্রকাশের আহ্বান জানানো হচ্ছে।
            </div>
        </div>

        <!-- ==========================================================================
             2. ENGLISH VERSION
             ========================================================================== -->
        <div id="versionEnglish" style="display: none;">
            <p class="lead" style="font-size: 1.08rem; color: #1e293b; font-weight: 500;">
                <strong>Bhola Journal</strong> values constructive discussion and welcomes feedback from its readers. To maintain a respectful, safe, and lawful community on <a href="https://bholajournal.com" target="_blank" class="text-danger fw-bold">bholajournal.com</a>, all users must adhere to the following comment guidelines:
            </p>

            <div class="mt-4">
                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-check-circle text-danger"></i> Relevance</h5>
                    <p>Comments must be directly relevant to the topic or subject matter of the published news article.</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-scale-balanced text-danger"></i> Legal Compliance</h5>
                    <p>No comment may violate the prevailing laws of Bangladesh or promote unlawful activities.</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-hand-holding-heart text-danger"></i> Respect for Diversity &amp; Religion</h5>
                    <p>Comments that insult, demean, or hurt religious sentiments, or attack any individual, race, community, gender, or language are strictly prohibited.</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-user-xmark text-danger"></i> No Personal Attacks or Name-Calling</h5>
                    <p>Personal attacks, harassment, intimidation, or threats against any individual are forbidden. Using derogatory animal names to belittle someone or deliberately distorting a person's name is not allowed.</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-shield-virus text-danger"></i> Decency</h5>
                    <p>Profane, obscene, vulgar, or sexually suggestive words and expressions must not be used.</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-mask text-danger"></i> Authentic Identity</h5>
                    <p>Users must not use offensive, misleading, or suggestive pseudonyms/usernames to post comments.</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-font text-danger"></i> Script &amp; Language Guidelines</h5>
                    <p>Bengali comments must be written in Bengali script. Bengali written in English alphabets (phonetic/Banglish) will be rejected. Standard English comments are permitted where appropriate.</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-link-slash text-danger"></i> No Links or Spam</h5>
                    <p>Sharing external URLs, promotional links, commercial advertisements, or repetitive spam in the comment section is strictly prohibited.</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-pen-ruler text-danger"></i> Clarity &amp; Editing</h5>
                    <p>Incoherent or meaningless comments will not be published. Comments with minor typographical errors or incomplete sentences may be published subject to moderation and editing.</p>
                </div>

                <div class="policy-rule-card">
                    <h5><i class="fa-solid fa-user-shield text-danger"></i> Liability &amp; Moderation Rights</h5>
                    <p>Bhola Journal is not responsible or liable for any opinions expressed by readers in the comments section. Bhola Journal reserves the absolute right to reject, edit, or delete any comment on any issue, and to ban users who violate these guidelines at its sole discretion.</p>
                </div>
            </div>

            <div class="disclaimer-alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <strong>Notice:</strong> Opinions expressed in comments are solely those of the individual commentators and do not reflect the views or editorial policy of Bhola Journal.
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
            heading.textContent = 'Comment Policy';
            window.location.hash = 'en';
        } else {
            enDiv.style.display = 'none';
            bnDiv.style.display = 'block';
            btnEn.classList.remove('active');
            btnBn.classList.add('active');
            heading.textContent = 'মন্তব্য প্রকাশের নীতিমালা (Comment Policy)';
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