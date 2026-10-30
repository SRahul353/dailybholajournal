@extends('layouts.app')

@section('title', 'আমাদের পরিবার, পরিচিতি ও যোগাযোগ | দৈনিক ভোলা জার্নাল')

@section('meta')
    <meta name="description" content="দৈনিক ভোলা জার্নাল — আমাদের পরিবার, সম্পাদকীয় পর্ষদ, বার্তা ও বাণিজ্যিক কার্যালয়ের ঠিকানা এবং যোগাযোগের বিস্তারিত।">
    <meta property="og:title" content="আমাদের পরিবার ও যোগাযোগ | দৈনিক ভোলা জার্নাল">
    <meta property="og:description" content="দৈনিক ভোলা জার্নাল — আমাদের পরিবার, সম্পাদকীয় পর্ষদ এবং বার্তা ও বাণিজ্যিক কার্যালয়ের যোগাযোগের তথ্য।">
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
    }
    .family-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        margin-bottom: 30px;
    }
    .sec-badge-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 20px;
        padding-bottom: 8px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .sec-badge-title i {
        color: var(--accent, #c90000);
    }
    .editorial-member-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .editorial-member-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.06);
        border-color: var(--accent, #c90000);
    }
    .member-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: var(--accent, #c90000);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 12px;
    }
    .member-role {
        font-size: 0.80rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--accent, #c90000);
        margin-bottom: 4px;
        display: block;
    }
    .member-name {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }
    .contact-item-box {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 14px 18px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        margin-bottom: 12px;
    }
    .contact-item-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #fee2e2;
        color: var(--accent, #c90000);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .contact-item-info h6 {
        margin: 0 0 2px 0;
        font-size: 0.85rem;
        font-weight: 700;
        color: #475569;
    }
    .contact-item-info p {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 600;
        color: #0f172a;
    }
    .contact-form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
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
            <span>আমাদের পরিবার ও যোগাযোগ</span>
        </div>
        <h1 class="about-title">আমাদের পরিবার, পরিচিতি ও যোগাযোগ</h1>
        <p class="about-subtitle m-0">সত্য, নিষ্ঠা ও নিরপেক্ষতার সাথে উপকূলীয় জেলা ভোলার সার্বক্ষণিক ডিজিটাল কণ্ঠস্বর</p>
    </div>
</section>

<div class="container mb-5">
    <!-- 1. About Us Section -->
    <div class="family-card">
        <h3 class="sec-badge-title">
            <i class="fa-solid fa-newspaper"></i>
            <span>দৈনিক ভোলা জার্নাল সম্পর্কে</span>
        </h3>
        <p style="font-size: 1.05rem; line-height: 1.8; color: #334155;">
            <strong>দৈনিক ভোলা জার্নাল</strong> উপকূলীয় জেলা ভোলার শীর্ষস্থানীয় একটি স্বাধীন, দায়িত্বশীল ও পাঠকপ্রিয় অনলাইন সংবাদপত্র এবং ডিজিটাল ই-পেপার। 
            আমরা বস্তুনিষ্ঠ সংবাদ পরিবেশন, উপকূলের উন্নয়ন, জনদুর্ভোগ, সামাজিক সমস্যা এবং জেলার ইতিবাচক অর্জন তুলে ধরতে সর্বদা প্রতিশ্রুতিবদ্ধ। স্থানীয় সংবাদের পাশাপাশি জাতীয়, রাজনীতি, অর্থনীতি, আন্তর্জাতিক, খেলাধুলা ও বিনোদনের নির্ভরযোগ্য সংবাদ দ্রুততম সময়ে পৌঁছে দেওয়াই আমাদের লক্ষ্য।
        </p>
        <div class="row g-3 mt-2">
            <div class="col-md-4">
                <div class="p-3 border rounded bg-light text-center h-100">
                    <i class="fa-solid fa-bullseye text-danger fs-3 mb-2"></i>
                    <h5 class="fw-bold text-dark">আমাদের লক্ষ্য</h5>
                    <p class="small text-muted mb-0">সত্য ও ন্যায়ের সন্ধানে সার্বক্ষণিক থেকে নির্মোহ ও নিরপেক্ষ সাংবাদিকতার মাধ্যমে সমাজের দর্পণ হিসেবে কাজ করা।</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 border rounded bg-light text-center h-100">
                    <i class="fa-solid fa-eye text-primary fs-3 mb-2"></i>
                    <h5 class="fw-bold text-dark">আমাদের দৃষ্টিভঙ্গি</h5>
                    <p class="small text-muted mb-0">ভোলা জেলাকে দেশ ও আন্তর্জাতিক পরিমণ্ডলে ইতিবাচকভাবে উপস্থাপন এবং জনস্বার্থ সংশ্লিষ্ট খবরের বিশ্বস্ত উৎস হওয়া।</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 border rounded bg-light text-center h-100">
                    <i class="fa-solid fa-shield-halved text-success fs-3 mb-2"></i>
                    <h5 class="fw-bold text-dark">আমাদের নীতি</h5>
                    <p class="small text-muted mb-0">বস্তুনিষ্ঠতা, নির্ভুলতা, সাংবাদিকতার আচরণবিধি ও পাঠকদের ডেটা সুরক্ষার সর্বোচ্চ মান বজায় রাখা।</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Our Family & Editorial Board -->
    <div class="family-card">
        <h3 class="sec-badge-title">
            <i class="fa-solid fa-users"></i>
            <span>আমাদের পরিবার ও সম্পাদনা পর্ষদ</span>
        </h3>
        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="editorial-member-card">
                    <div class="member-avatar">
                        <i class="fa-solid fa-feather-pointed"></i>
                    </div>
                    <span class="member-role">প্রকাশক</span>
                    <h4 class="member-name">{{ $themeSettings['editorial_publisher'] ?? 'সামিয়া তালুকদার' }}</h4>
                    <p class="small text-muted mb-0">দৈনিক ভোলা জার্নাল</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="editorial-member-card">
                    <div class="member-avatar">
                        <i class="fa-solid fa-pen-nib"></i>
                    </div>
                    <span class="member-role">নির্বাহী সম্পাদক</span>
                    <h4 class="member-name">{{ $themeSettings['editorial_executive_editor'] ?? 'ইসমাইল হোসেন আরিফ' }}</h4>
                    <p class="small text-muted mb-0">দৈনিক ভোলা জার্নাল</p>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top">
            <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-network-wired text-danger me-2"></i>প্রতিনিধি ও টিম নেটওয়ার্ক</h5>
            <p class="small text-muted mb-0" style="line-height: 1.7;">
                ভোলা সদর, দৌলতখান, বোরহানউদ্দিন, তজুমদ্দিন, লালমোহন, চরফ্যাশন ও মনপুরাসহ উপকূলীয় সকল উপজেলা ও চরাঞ্চলের সংবাদ তাৎক্ষণিক সংগ্রহ করতে রয়েছে আমাদের একঝাঁক উদ্যমী সংবাদকর্মী ও আলোকচিত্রী।
            </p>
        </div>
    </div>

    <!-- 3. Contact & Message Form Grid -->
    <div class="row g-4">
        <!-- Contact Information -->
        <div class="col-lg-5">
            <div class="family-card h-100">
                <h3 class="sec-badge-title">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>যোগাযোগের ঠিকানা</span>
                </h3>

                <div class="contact-item-box">
                    <div class="contact-item-icon">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div class="contact-item-info">
                        <h6>বার্তা ও বাণিজ্যিক কার্যালয়:</h6>
                        <p>{{ $themeSettings['contact_address'] ?? 'ভোলা সদর, ভোলা, বাংলাদেশ।' }}</p>
                    </div>
                </div>

                <div class="contact-item-box">
                    <div class="contact-item-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div class="contact-item-info">
                        <h6>হটলাইন ও হোয়াটসঅ্যাপ:</h6>
                        <p><a href="tel:{{ $themeSettings['contact_phone'] ?? '01716-674375' }}" class="text-dark">{{ $themeSettings['contact_phone'] ?? '01716-674375' }}</a></p>
                    </div>
                </div>

                <div class="contact-item-box">
                    <div class="contact-item-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="contact-item-info">
                        <h6>ইমেইল ঠিকানা:</h6>
                        <p><a href="mailto:{{ $themeSettings['contact_email'] ?? 'news.dailybholajournal@gmail.com' }}" class="text-danger">{{ $themeSettings['contact_email'] ?? 'news.dailybholajournal@gmail.com' }}</a></p>
                    </div>
                </div>

                <div class="contact-item-box">
                    <div class="contact-item-icon">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <div class="contact-item-info">
                        <h6>অফিসিয়াল ওয়েবসাইট:</h6>
                        <p><a href="https://bholajournal.com" target="_blank" class="text-dark">https://bholajournal.com</a></p>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <h6 class="fw-bold text-dark mb-2">সোশ্যাল মিডিয়ায় যুক্ত থাকুন:</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ $themeSettings['social_facebook'] ?? '#' }}" target="_blank" class="footer-social-btn" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="{{ $themeSettings['social_twitter'] ?? '#' }}" target="_blank" class="footer-social-btn" title="Twitter / X"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="{{ $themeSettings['social_youtube'] ?? '#' }}" target="_blank" class="footer-social-btn" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        <a href="{{ $themeSettings['social_instagram'] ?? '#' }}" target="_blank" class="footer-social-btn" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feedback & Message Form -->
        <div class="col-lg-7">
            <div class="contact-form-card">
                <h3 class="sec-badge-title">
                    <i class="fa-solid fa-envelope-open-text"></i>
                    <span>আমাদের বার্তা পাঠান</span>
                </h3>
                <p class="small text-muted mb-4">যেকোনো সংবাদ, মতামত, বিজ্ঞাপন বা অভিযোগ জানাতে নিচের ফর্মটি পূরণ করে পাঠান।</p>

                <form onsubmit="handleContactSubmit(event)">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">আপনার নাম <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="আপনার পূর্ণ নাম" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">মোবাইল নম্বর <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" placeholder="০১XXXXXXXXX" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">ইমেইল ঠিকানা</label>
                            <input type="email" class="form-control" placeholder="example@gmail.com">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">বিষয় <span class="text-danger">*</span></label>
                            <select class="form-select">
                                <option value="news">সংবাদ সংক্রান্ত</option>
                                <option value="ad">বিজ্ঞাপন ও প্রচার</option>
                                <option value="opinion">মতামত ও কলাম</option>
                                <option value="complaint">অভিযোগ বা পরামর্শ</option>
                                <option value="other">অন্যান্য</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">আপনার বার্তা <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="5" placeholder="বিস্তারিত লিখুন..." required></textarea>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-danger px-4 py-2 fw-bold">
                                <i class="fa-solid fa-paper-plane me-1"></i> বার্তা পাঠান
                            </button>
                        </div>
                    </div>
                </form>
                <div id="contactSuccessMsg" class="alert alert-success mt-3" style="display: none;">
                    <i class="fa-solid fa-circle-check me-2"></i>আপনার বার্তাটি সফলভাবে পাঠানো হয়েছে। আমাদের প্রতিনিধি দ্রুত আপনার সাথে যোগাযোগ করবেন।
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function handleContactSubmit(e) {
        e.preventDefault();
        const msg = document.getElementById('contactSuccessMsg');
        if (msg) {
            msg.style.display = 'block';
            e.target.reset();
        }
    }
</script>
@endsection