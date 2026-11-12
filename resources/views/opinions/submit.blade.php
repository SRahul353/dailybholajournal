@extends('layouts.app')

@section('title', 'মতামত ও কলামে লেখা পাঠান | দৈনিক ভোলা জার্নাল')
@section('meta_description', 'দৈনিক ভোলা জার্নাল-এর মতামত ও কলাম বিভাগে আপনার বিশ্লেষণমূলক ও সমসাময়িক লেখা পাঠিয়ে আমাদের সাথে যুক্ত হোন।')

@section('styles')
<style>
    /* Opinion Submission Page Styles */
    .opinion-submit-wrap {
        margin-top: 14px;
        margin-bottom: 56px;
        font-family: 'Noto Sans Bengali', sans-serif;
    }

    .opinion-hero-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        border-radius: 12px;
        padding: 36px 32px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
        border-bottom: 4px solid var(--accent, #c90000);
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
    }
    .opinion-hero-card::before {
        content: '\f5ad';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 24px;
        bottom: -20px;
        font-size: 8rem;
        color: rgba(255, 255, 255, 0.03);
        pointer-events: none;
    }
    .opinion-hero-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 10px;
        color: #ffffff;
    }
    .opinion-hero-subtitle {
        color: #cbd5e1;
        font-size: 0.98rem;
        max-width: 680px;
        line-height: 1.6;
        margin-bottom: 0;
    }

    /* Form Container */
    .submit-form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
    }
    .form-sec-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 18px;
        padding-bottom: 8px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-sec-title i {
        color: var(--accent, #c90000);
    }

    .form-label {
        font-weight: 700;
        font-size: 0.90rem;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-control, .form-select {
        border-radius: 6px;
        border-color: #cbd5e1;
        padding: 10px 14px;
        font-size: 0.95rem;
        font-family: 'Noto Sans Bengali', sans-serif;
        color: #0f172a;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--accent, #c90000);
        box-shadow: 0 0 0 3px rgba(201, 0, 0, 0.12);
    }

    /* Guidelines Card */
    .guidelines-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
    }
    .guideline-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
        font-size: 0.90rem;
        color: #475569;
        line-height: 1.55;
    }
    .guideline-item i {
        color: #16a34a;
        margin-top: 3px;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    /* Word Counter */
    .char-counter-bar {
        font-size: 0.80rem;
        color: #64748b;
        text-align: right;
        margin-top: 6px;
    }

    /* Photo Upload Box Preview */
    .photo-preview-box {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f1f5f9;
        border: 2px dashed #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }
    .photo-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Success Card */
    .submission-success-banner {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 10px;
        padding: 28px;
        text-align: center;
        margin-bottom: 28px;
    }
</style>
@endsection

@section('content')

<div class="opinion-submit-wrap">
    
    <!-- Breadcrumb -->
    <nav class="archive-breadcrumb mb-3" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                    <i class="fa-solid fa-house me-1"></i> প্রচ্ছদ
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('category', 'opinion') }}" class="text-decoration-none text-muted">
                    মতামত ও কলাম
                </a>
            </li>
            <li class="breadcrumb-item active text-danger fw-bold" aria-current="page">
                লেখা পাঠান
            </li>
        </ol>
    </nav>

    <!-- Hero Card -->
    <div class="opinion-hero-card">
        <h1 class="opinion-hero-title">মতামত ও কলাম বিভাগে আপনার লেখা পাঠান</h1>
        <p class="opinion-hero-subtitle">
            সমসাময়িক জাতীয় ও স্থানীয় প্রেক্ষাপট, রাজনীতি, উপকূলীয় উন্নয়ন, অর্থনীতি, সাহিত্য ও সমাজে আপনার সুচিন্তিত মতামত ও বিশ্লেষণ আমাদের লাখো পাঠকের কাছে পৌঁছে দিন।
        </p>
    </div>

    <!-- Success Message if just submitted -->
    @if(session('submission_success'))
        @php $info = session('submission_success'); @endphp
        <div class="submission-success-banner">
            <i class="fa-solid fa-circle-check text-success mb-2" style="font-size: 3rem;"></i>
            <h3 class="fw-bold text-dark mb-2" style="font-size: 1.35rem;">ধন্যবাদ, {{ $info['author_name'] }}! আপনার লেখাটি সফলভাবে জমা হয়েছে।</h3>
            <p class="text-muted mb-2">
                শিরোনাম: <strong>"{{ $info['title'] }}"</strong> (ট্র্যাকিং আইডি: #{{ $info['tracking_id'] }})
            </p>
            <p class="text-secondary small mb-4">
                আমাদের সম্পাদকীয় পর্ষদ লেখাটি পর্যালোচনা করে দ্রুততম সময়ে প্রকাশ করবেন।
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('opinion.submit') }}" class="btn btn-outline-danger fw-bold">
                    <i class="fa-solid fa-pen-nib me-1"></i> আরেকটি লেখা পাঠান
                </a>
                <a href="{{ route('category', 'opinion') }}" class="btn btn-danger fw-bold">
                    <i class="fa-solid fa-newspaper me-1"></i> প্রকাশিত মতামতসমূহ দেখুন
                </a>
            </div>
        </div>
    @endif

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="fw-bold mb-2"><i class="fa-solid fa-triangle-exclamation me-1"></i> অনুগ্রহ করে নিচের ভুলগুলো সংশোধন করুন:</h6>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Main Form Column -->
        <div class="col-lg-8">
            <div class="submit-form-card">
                <form action="{{ route('opinion.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- 1. Writer Information -->
                    <h3 class="form-sec-title">
                        <i class="fa-solid fa-user-pen"></i>
                        <span>১. লেখকের পরিচিতি ও তথ্য</span>
                    </h3>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">আপনার পূর্ণ নাম <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="author_name" 
                                   value="{{ old('author_name') }}" 
                                   class="form-control" 
                                   placeholder="যেমন: ড. রফিকুল ইসলাম" 
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">পেশা বা পদবি <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="author_designation" 
                                   value="{{ old('author_designation') }}" 
                                   class="form-control" 
                                   placeholder="যেমন: কলামিস্ট ও গবেষক" 
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">মোবাইল / হোয়াটসঅ্যাপ নম্বর <span class="text-danger">*</span></label>
                            <input type="tel" 
                                   name="author_phone" 
                                   value="{{ old('author_phone') }}" 
                                   class="form-control" 
                                   placeholder="০১XXXXXXXXX" 
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ইমেইল ঠিকানা <span class="text-danger">*</span></label>
                            <input type="email" 
                                   name="author_email" 
                                   value="{{ old('author_email') }}" 
                                   class="form-control" 
                                   placeholder="writer@gmail.com" 
                                   required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">সংক্ষিপ্ত পরিচিতি বা বায়ো (ঐচ্ছিক)</label>
                            <textarea name="author_bio" 
                                      rows="2" 
                                      class="form-control" 
                                      placeholder="আপনার কাজের ক্ষেত্র, শিক্ষাগত যোগ্যতা বা লেখক পরিচিতির সংক্ষিপ্ত বিবরণ...">{{ old('author_bio') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">লেখকের ছবি (ঐচ্ছিক, তবে সুপারিশকৃত)</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="photo-preview-box" id="authorPhotoPreviewBox">
                                    <i class="fa-solid fa-user text-muted fs-4" id="authorPhotoPlaceholder"></i>
                                    <img src="" alt="Author Preview" id="authorPhotoImg" style="display: none;">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" 
                                           name="author_photo" 
                                           id="authorPhotoInput" 
                                           class="form-control" 
                                           accept="image/*" 
                                           onchange="previewAuthorPhoto(this)">
                                    <small class="text-muted d-block mt-1">পাসপোর্ট সাইজ বা পরিষ্কার প্রতিকৃতি ছবি (JPG, PNG, WebP — সর্বোচ্চ ৩ এমবি)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Column / Article Content -->
                    <h3 class="form-sec-title">
                        <i class="fa-solid fa-file-lines"></i>
                        <span>২. কলাম বা মতামতের বিবরণ</span>
                    </h3>

                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label">কলামের আকর্ষণীয় শিরোনাম <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   class="form-control" 
                                   placeholder="লেখার মূল বার্তা বহনকারী স্পষ্ট শিরোনাম লিখুন..." 
                                   required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">বিষয় বা ক্ষেত্র</label>
                            <select name="topic" class="form-select">
                                <option value="সমসাময়িক বিষয়" {{ old('topic') == 'সমসাময়িক বিষয়' ? 'selected' : '' }}>সমসাময়িক বিষয়</option>
                                <option value="জাতীয় রাজনীতি" {{ old('topic') == 'জাতীয় রাজনীতি' ? 'selected' : '' }}>জাতীয় রাজনীতি</option>
                                <option value="অর্থনীতি ও উন্নয়ন" {{ old('topic') == 'অর্থনীতি ও উন্নয়ন' ? 'selected' : '' }}>অর্থনীতি ও উন্নয়ন</option>
                                <option value="উপকূল ও পরিবেশ" {{ old('topic') == 'উপকূল ও পরিবেশ' ? 'selected' : '' }}>উপকূল ও পরিবেশ</option>
                                <option value="শিক্ষা ও তরুণসমাজ" {{ old('topic') == 'শিক্ষা ও তরুণসমাজ' ? 'selected' : '' }}>শিক্ষা ও তরুণসমাজ</option>
                                <option value="সাহিত্য ও সংস্কৃতি" {{ old('topic') == 'সাহিত্য ও সংস্কৃতি' ? 'selected' : '' }}>সাহিত্য ও সংস্কৃতি</option>
                                <option value="আন্তর্জাতিক" {{ old('topic') == 'আন্তর্জাতিক' ? 'selected' : '' }}>আন্তর্জাতিক</option>
                                <option value="অন্যান্য" {{ old('topic') == 'অন্যান্য' ? 'selected' : '' }}>অন্যান্য</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">মূল বক্তব্য / কলামের লেখা <span class="text-danger">*</span></label>
                            <textarea name="content" 
                                      id="opinionContentTextarea" 
                                      rows="14" 
                                      class="form-control" 
                                      placeholder="আপনার কলামের সম্পূর্ণ লেখাটি এখানে লিখুন বা পেস্ট করুন..." 
                                      oninput="updateWordCount(this)" 
                                      required>{{ old('content') }}</textarea>
                            <div class="char-counter-bar">
                                <span id="wordCountDisplay">০ শব্দ</span> | <span id="charCountDisplay">০ অক্ষর</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">লেখার সাথে প্রাসঙ্গিক কোনো ছবি থাকলে সংযুক্ত করুন (ঐচ্ছিক)</label>
                            <input type="file" 
                                   name="featured_image" 
                                   class="form-control" 
                                   accept="image/*">
                            <small class="text-muted d-block mt-1">প্রাসঙ্গিক কোনো ব্যানার বা বিষয়বস্তুর ছবি (সর্বোচ্চ ৫ এমবি)</small>
                        </div>
                    </div>

                    <!-- 3. Declaration & Agreement -->
                    <div class="mb-4 p-3 bg-light rounded border">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="agreement" 
                                   id="opinionAgreement" 
                                   required {{ old('agreement') ? 'checked' : '' }}>
                            <label class="form-check-label text-dark small" for="opinionAgreement">
                                আমি ঘোষণা করছি যে, এই লেখাটি আমার নিজস্ব ও মৌলিক। পূর্বে কোনো অনলাইন বা মুদ্রিত মাধ্যমে এটি প্রকাশিত হয়নি। আমি দৈনিক ভোলা জার্নাল-এর <a href="{{ route('editorial.policy') }}" target="_blank" class="text-danger fw-bold">সম্পাদকীয় নীতিমালা</a> মেনে লেখাটি পাঠাচ্ছি।
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="btn btn-danger px-4 py-3 fw-bold w-100" style="font-size: 1.05rem;">
                            <i class="fa-solid fa-paper-plane me-2"></i> মতামত সাবমিট করুন
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Sidebar Guidelines Column -->
        <div class="col-lg-4">
            <div class="guidelines-card mb-4">
                <h4 class="fw-bold text-dark mb-3" style="font-size: 1.15rem; font-family: 'Noto Serif Bengali', serif;">
                    <i class="fa-solid fa-circle-info text-danger me-2"></i>লেখকদের জন্য নির্দেশিকা
                </h4>
                
                <div class="guideline-item">
                    <i class="fa-solid fa-check-circle"></i>
                    <div>
                        <strong>শব্দসীমা:</strong> মতামত ও কলামের লেখা সাধারণত ৫০০ থেকে ১,০০০ শব্দের মধ্যে রাখা বাঞ্ছনীয়।
                    </div>
                </div>

                <div class="guideline-item">
                    <i class="fa-solid fa-check-circle"></i>
                    <div>
                        <strong>মৌলিকত্ব:</strong> লেখাটি সম্পূর্ণ মৌলিক হওয়া আবশ্যক। অন্য কোথাও থেকে সরাসরি কপি করা লেখা গ্রহণযোগ্য নয়।
                    </div>
                </div>

                <div class="guideline-item">
                    <i class="fa-solid fa-check-circle"></i>
                    <div>
                        <strong>তথ্যনিষ্ঠতা:</strong> বক্তব্যে ব্যবহৃত পরিসংখ্যান ও তথ্যের গ্রহণযোগ্য উৎস থাকা প্রয়োজন।
                    </div>
                </div>

                <div class="guideline-item">
                    <i class="fa-solid fa-check-circle"></i>
                    <div>
                        <strong>শালীন ভাষা:</strong> কোনো ব্যক্তি, ধর্মীয় অনুভূতি বা সম্প্রদায়ের প্রতি আক্রমণাত্মক ভাষা পরিহার করতে হবে।
                    </div>
                </div>

                <div class="guideline-item">
                    <i class="fa-solid fa-check-circle"></i>
                    <div>
                        <strong>সম্পাদনার অধিকার:</strong> পত্রিকার সম্পাদকীয় পর্ষদ লেখার মূল ভাব বজায় রেখে শিরোনাম বা বানান পরিমার্জন করার অধিকার সংরক্ষণ করে।
                    </div>
                </div>
            </div>

            <!-- Contact Box for Writers -->
            <div class="card p-3 border rounded shadow-sm text-center">
                <i class="fa-solid fa-envelope-open-text text-danger fs-2 mb-2"></i>
                <h5 class="fw-bold text-dark mb-1" style="font-size: 1rem;">সরাসরি ইমেইলে পাঠাতে চান?</h5>
                <p class="text-muted small mb-2">ওয়ার্ড ফাইল বা লেখার টেক্সট আমাদের সম্পাদকীয় মেইলেও পাঠাতে পারেন:</p>
                <a href="mailto:news.dailybholajournal@gmail.com" class="text-danger fw-bold small text-decoration-none">
                    news.dailybholajournal@gmail.com
                </a>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    // Live Image Preview for Author Photo
    function previewAuthorPhoto(input) {
        const placeholder = document.getElementById('authorPhotoPlaceholder');
        const img = document.getElementById('authorPhotoImg');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                img.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Live Word & Character Counter in Bengali
    function toBanglaNumber(num) {
        const bnNums = ["০", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"];
        return num.toString().split("").map(d => bnNums[d] || d).join("");
    }

    function updateWordCount(textarea) {
        const text = textarea.value.trim();
        const words = text ? text.split(/\s+/).length : 0;
        const chars = text.length;

        document.getElementById('wordCountDisplay').textContent = toBanglaNumber(words) + ' শব্দ';
        document.getElementById('charCountDisplay').textContent = toBanglaNumber(chars) + ' অক্ষর';
    }

    // Trigger count on page load if old content exists
    document.addEventListener('DOMContentLoaded', function() {
        const ta = document.getElementById('opinionContentTextarea');
        if (ta && ta.value) {
            updateWordCount(ta);
        }
    });
</script>
@endsection
