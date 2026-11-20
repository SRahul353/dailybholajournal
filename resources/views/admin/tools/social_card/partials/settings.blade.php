<!-- Settings Gear Modal: Logo, Ads & Card Options -->
<div class="modal fade" id="cardSettingsModal" tabindex="-1" aria-labelledby="cardSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content studio-modal-content">
            <div class="modal-header border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="gear-icon-box">
                        <i class="fa-solid fa-gear text-danger"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-bangla mb-0" id="cardSettingsModalLabel" style="font-weight: 700;">মাস্টার কার্ড সেটিংস (Global Defaults)</h5>
                        <small class="text-muted">ব্র্যান্ড লোগো, বিজ্ঞাপন/ফুটার, ডিফল্ট থিম ও টাইপোগ্রাফি স্থায়ীভাবে কনফিগার করুন</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-info py-2 px-3 mb-3 d-flex align-items-center gap-2" style="font-size: 0.82rem; border-radius: 8px;">
                    <i class="fa-solid fa-circle-info text-info fs-6"></i>
                    <span>এখানে সংরক্ষিত সব সেটিংস আপনার পোর্টালের সব কার্ডের জন্য ডিফল্ট হিসেবে সংরক্ষিত থাকবে।</span>
                </div>

                <!-- Nav tabs -->
                <ul class="nav nav-pills custom-studio-tabs mb-4" id="settingsTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="style-tab" data-bs-toggle="pill" data-bs-target="#tab-style" type="button" role="tab">
                            <i class="fa-solid fa-shapes me-1 text-danger"></i> কার্ড ডিজাইন স্টাইল
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="logo-tab" data-bs-toggle="pill" data-bs-target="#tab-logo" type="button" role="tab">
                            <i class="fa-solid fa-award me-1 text-danger"></i> ব্র্যান্ড ও লোগো
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ads-tab" data-bs-toggle="pill" data-bs-target="#tab-ads" type="button" role="tab">
                            <i class="fa-solid fa-rectangle-ad me-1 text-primary"></i> ফুটার ও বিজ্ঞাপন
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="theme-tab" data-bs-toggle="pill" data-bs-target="#tab-theme" type="button" role="tab">
                            <i class="fa-solid fa-palette me-1 text-warning"></i> থিম ও কালার
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="typo-tab" data-bs-toggle="pill" data-bs-target="#tab-typo" type="button" role="tab">
                            <i class="fa-solid fa-font me-1 text-info"></i> টাইপোগ্রাফি
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="layout-tab" data-bs-toggle="pill" data-bs-target="#tab-layout" type="button" role="tab">
                            <i class="fa-solid fa-sliders me-1 text-success"></i> লেআউট ও ব্যাজ
                        </button>
                    </li>
                </ul>

                <!-- Tab content -->
                <div class="tab-content">
                    <!-- Tab 0: Card Style -->
                    <div class="tab-pane fade show active" id="tab-style" role="tabpanel">
                        <div class="alert alert-light border py-2 px-3 mb-3 d-flex align-items-center justify-content-between" style="border-radius: 8px;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-shapes text-danger fs-5"></i>
                                <div>
                                    <strong class="d-block" style="font-size: 0.88rem;">ডিফল্ট কার্ড ডিজাইন স্টাইল নির্বাচন করুন</strong>
                                    <small class="text-muted">যেকোনো স্টাইলে ক্লিক করলে ক্যানভাসে সাথে সাথে প্রিভিউ দেখা যাবে এবং সেভ করলে ডিফল্ট কার্যকর থাকবে।</small>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Style 1: Classic Split -->
                            <div class="col-md-6">
                                <div class="modal-style-card {{ ($cardSettings['card_style'] ?? 'classic') === 'classic' ? 'active' : '' }}" data-style="classic" onclick="setCardStyle('classic')">
                                    <div class="style-check-icon"><i class="fa-solid fa-check"></i></div>
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="style-thumb-box thumb-classic" style="width: 100px; height: 75px; flex-shrink: 0; margin-bottom: 0;">
                                            <div class="thumb-top-img"></div>
                                            <div class="thumb-bottom-card">
                                                <div class="thumb-line-sm"></div>
                                                <div class="thumb-line-lg"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">১. ক্লাসিক স্প্লিট (Classic)</span>
                                                <span class="style-badge-tag tag-blue">ডিফল্ট</span>
                                            </div>
                                            <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.35;">
                                                উপরের অংশে মূল নিউজ ছবি এবং নিচের অংশে ব্যাকগ্রাউন্ড কালারে আকর্ষণীয় বড় হেডলাইন, রিপোর্টার ব্যাজ ও তারিখ।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Style 2: Full Poster Overlay -->
                            <div class="col-md-6">
                                <div class="modal-style-card {{ ($cardSettings['card_style'] ?? '') === 'poster' ? 'active' : '' }}" data-style="poster" onclick="setCardStyle('poster')">
                                    <div class="style-check-icon"><i class="fa-solid fa-check"></i></div>
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="style-thumb-box thumb-poster" style="width: 100px; height: 75px; flex-shrink: 0; margin-bottom: 0;">
                                            <div class="thumb-full-img"></div>
                                            <div class="thumb-scrim">
                                                <div class="thumb-line-lg"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">২. ফুল পোস্টার (Poster)</span>
                                                <span class="style-badge-tag tag-purple">সিনেমাটিক</span>
                                            </div>
                                            <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.35;">
                                                ১০৮০x১০৮০ সম্পূর্ণ ক্যানভাস জুড়ে ফুল ব্যাকগ্রাউন্ড ছবি, নিচে সিনেমাটিক ডার্ক শেড গ্রেডিয়েন্ট এবং হেডলাইন।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Style 3: Quote / Statement -->
                            <div class="col-md-6">
                                <div class="modal-style-card {{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'active' : '' }}" data-style="quote" onclick="setCardStyle('quote')">
                                    <div class="style-check-icon"><i class="fa-solid fa-check"></i></div>
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="style-thumb-box thumb-quote" style="width: 100px; height: 75px; flex-shrink: 0; margin-bottom: 0;">
                                            <div class="thumb-quote-img"></div>
                                            <div class="thumb-quote-card">
                                                <i class="fa-solid fa-quote-left thumb-quote-icon"></i>
                                                <div class="thumb-line-lg"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">৩. উক্তি / বক্তব্য (Quote)</span>
                                                <span class="style-badge-tag tag-amber">কোটেশন</span>
                                            </div>
                                            <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.35;">
                                                বিশিষ্ট ব্যক্তিদের সাক্ষাৎকার, বক্তব্য বা উক্তির জন্য। সাধারণ ছবি বা স্বচ্ছ কাটআউট পিএনজি (Cutout PNG) ব্যাকগ্রাউন্ড সাপোর্ট করে।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Style 4: Breaking News Flash -->
                            <div class="col-md-6">
                                <div class="modal-style-card {{ ($cardSettings['card_style'] ?? '') === 'breaking' ? 'active' : '' }}" data-style="breaking" onclick="setCardStyle('breaking')">
                                    <div class="style-check-icon"><i class="fa-solid fa-check"></i></div>
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="style-thumb-box thumb-breaking" style="width: 100px; height: 75px; flex-shrink: 0; margin-bottom: 0;">
                                            <div class="thumb-break-bar"></div>
                                            <div class="thumb-break-img"></div>
                                            <div class="thumb-break-card">
                                                <div class="thumb-line-lg"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">৪. ব্রেকিং নিউজ (Breaking)</span>
                                                <span class="style-badge-tag tag-red">জরুরি সংবাদ</span>
                                            </div>
                                            <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.35;">
                                                জরুরি ও ব্রেকিং নিউজের বিশেষ কোটেশন-স্টাইল লেআউট, আকর্ষণীয় বড় হেডলাইন এবং সংবাদের সাব-ক্যাপশন এক্সসার্প্ট।
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 1: Logo -->
                    <div class="tab-pane fade" id="tab-logo" role="tabpanel">
                        <div class="row g-3">
                            <!-- 1. Corner Logo Card -->
                            <div class="col-md-6">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="settings-card-title"><i class="fa-solid fa-circle-dot text-danger me-1"></i> কর্নার প্রোফাইল লোগো</span>
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" id="toggleCornerLogo" checked onchange="toggleCornerLogoVisibility(this.checked)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="settings-card-body">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="logo-preview-box">
                                                <img id="cornerLogoPreviewImg" src="{{ !empty($cardSettings['corner_logo_image']) ? asset($cardSettings['corner_logo_image']) : asset('BJ_Content/Profile Pic b.png') }}" alt="Corner Logo">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="btn btn-sm btn-outline-danger w-100 mb-1" for="customCornerLogoInput" style="font-weight: 600;">
                                                    <i class="fa-solid fa-cloud-arrow-up me-1"></i> নতুন লোগো আপলোড
                                                </label>
                                                <input type="file" id="customCornerLogoInput" accept="image/*" class="d-none" onchange="previewCornerLogo(this)">
                                                <button type="button" class="btn btn-sm btn-link text-muted w-100 p-0 text-decoration-none" onclick="resetCornerLogo()" style="font-size: 0.75rem;">
                                                    <i class="fa-solid fa-rotate-left me-1"></i> ডিফল্ট লোগো ফিরিয়ে আনুন
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="studio-label">লোগোর অবস্থান (Position)</label>
                                            <div class="btn-group w-100" role="group">
                                                <input type="radio" class="btn-check" name="logoPosRadio" id="logoPosRight" autocomplete="off" checked onchange="setCornerLogoPosition('right')">
                                                <label class="btn btn-sm btn-outline-secondary" for="logoPosRight"><i class="fa-solid fa-align-right me-1"></i> ডান কোণে (ডিফল্ট)</label>

                                                <input type="radio" class="btn-check" name="logoPosRadio" id="logoPosLeft" autocomplete="off" onchange="setCornerLogoPosition('left')">
                                                <label class="btn btn-sm btn-outline-secondary" for="logoPosLeft"><i class="fa-solid fa-align-left me-1"></i> বাম কোণে</label>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="studio-label">লোগো সাইজ (৮০px - ২৬০px)</label>
                                            <div class="slider-wrapper">
                                                <input type="range" class="studio-range" id="cornerLogoSizeSlider" min="80" max="260" value="{{ $cardSettings['corner_logo_size'] ?? 135 }}" oninput="setCornerLogoSize(this.value)">
                                                <span class="slider-val-badge" id="cornerLogoSizeBadge">{{ $cardSettings['corner_logo_size'] ?? 135 }}px</span>
                                            </div>
                                        </div>

                                        <div class="form-check form-switch mt-3 pt-2 border-top">
                                            <input class="form-check-input" type="checkbox" id="toggleCornerLogoShadow" {{ !empty($cardSettings['corner_logo_shadow']) || !isset($cardSettings['corner_logo_shadow']) ? 'checked' : '' }} onchange="toggleCornerLogoShadow(this.checked)">
                                            <label class="form-check-label studio-label mb-0" for="toggleCornerLogoShadow" style="cursor: pointer;">
                                                <i class="fa-solid fa-wand-magic-sparkles text-danger me-1"></i> লোগোতে ড্রপ শ্যাডো (Drop Shadow)
                                            </label>
                                            <div class="text-muted mt-1" style="font-size: 0.72rem;">লোগোর নিচে স্পষ্ট ও আকর্ষণীয় ড্রপ শ্যাডো দিয়ে ছবি থেকে ফুটিয়ে তোলে।</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Watermark Logo Card -->
                            <div class="col-md-6">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="settings-card-title"><i class="fa-solid fa-stamp text-danger me-1"></i> লেখার পেছনের ওয়াটারমার্ক</span>
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" id="toggleWatermark" checked onchange="toggleWatermarkVisibility(this.checked)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="settings-card-body">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="logo-preview-box watermark-bg">
                                                <img id="watermarkPreviewImg" src="{{ !empty($themeSettings['logo_image']) ? asset($themeSettings['logo_image']) : asset('BJ_Content/Text Logo.png') }}" alt="Watermark">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="btn btn-sm btn-outline-secondary w-100 mb-1" for="customWatermarkInput" style="font-weight: 600;">
                                                    <i class="fa-solid fa-cloud-arrow-up me-1"></i> ওয়াটারমার্ক আপলোড
                                                </label>
                                                <input type="file" id="customWatermarkInput" accept="image/*" class="d-none" onchange="previewWatermark(this)">
                                                <button type="button" class="btn btn-sm btn-link text-muted w-100 p-0 text-decoration-none" onclick="resetWatermark()" style="font-size: 0.75rem;">
                                                    <i class="fa-solid fa-rotate-left me-1"></i> ডিফল্ট ওয়াটারমার্ক
                                                </button>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="studio-label">ওয়াটারমার্ক অপাসিটি (Opacity)</label>
                                            <div class="slider-wrapper">
                                                <input type="range" class="studio-range" id="watermarkOpacitySlider" min="0" max="30" value="12" oninput="setWatermarkOpacity(this.value)">
                                                <span class="slider-val-badge" id="watermarkOpacityBadge">12%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Ads & Footer -->
                    <div class="tab-pane fade" id="tab-ads" role="tabpanel">
                        <div class="settings-card mb-3">
                            <div class="settings-card-header">
                                <span class="settings-card-title"><i class="fa-solid fa-bars-progress text-danger me-1"></i> কার্ড ফুটার ডিসপ্লে মোড</span>
                            </div>
                            <div class="settings-card-body">
                                <div class="row g-2 mb-3">
                                    <div class="col-md-4">
                                        <div class="footer-mode-card active" id="fModeAd" onclick="setFooterMode('ad')">
                                            <i class="fa-solid fa-rectangle-ad mode-icon"></i>
                                            <span class="mode-title">বিজ্ঞাপন ব্যানার</span>
                                            <span class="mode-desc">১০৮০×১০০ বিজ্ঞাপনী ব্যানার</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="footer-mode-card" id="fModeBrand" onclick="setFooterMode('brand')">
                                            <i class="fa-solid fa-globe mode-icon"></i>
                                            <span class="mode-title">অফিশিয়াল ব্র্যান্ডিং</span>
                                            <span class="mode-desc">ওয়েবসাইট ও সোশ্যাল লিংক</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="footer-mode-card" id="fModeNone" onclick="setFooterMode('none')">
                                            <i class="fa-solid fa-eye-slash mode-icon"></i>
                                            <span class="mode-title">ফুটার বন্ধ</span>
                                            <span class="mode-desc">ফুল কন্টেন্ট ও পরিচ্ছন্ন কার্ড</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ad Controls (Shown when mode is 'ad') -->
                                <div id="footerAdControls">
                                    <label class="studio-label mb-2">বিজ্ঞাপন ব্যানার উৎস (Source)</label>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="custom_ad_file_input" class="bg-upload-zone p-3 h-100" style="min-height: 110px;">
                                                <i class="fa-solid fa-cloud-arrow-up text-danger mb-1" style="font-size: 1.3rem;"></i>
                                                <span style="font-size: 0.82rem; font-weight: 700;">পিসি থেকে ব্যানার আপলোড</span>
                                                <span style="font-size: 0.72rem; color: #64748b;">(১০৮০ × ১০০ পিক্সেল আদর্শ)</span>
                                            </label>
                                            <input type="file" id="custom_ad_file_input" accept="image/*" class="d-none" onchange="previewCustomAdFile(this)">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 border rounded bg-white h-100 d-flex flex-column justify-content-between">
                                                <div>
                                                    <label class="studio-label">অনলাইন ব্যানার লিংক (URL)</label>
                                                    <input type="text" id="modal_ad_url_input" placeholder="https://.../banner.png" class="studio-input" oninput="updateModalAdUrl(this.value)">
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-secondary w-100 mt-2" onclick="resetToDefaultAd()">
                                                    <i class="fa-solid fa-rotate-left me-1"></i> ডিফল্ট বিজ্ঞাপনে রিসেট
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Brand Controls (Shown when mode is 'brand') -->
                                <div id="footerBrandControls" style="display: none;">
                                    <label class="studio-label mb-2">অফিশিয়াল ব্র্যান্ডিং লিংক ও সোশ্যাল কনফিগারেশন</label>
                                    <div class="alert alert-light border py-2 px-3 mb-3 d-flex align-items-center gap-2" style="font-size: 0.8rem; border-radius: 8px;">
                                        <i class="fa-solid fa-stamp text-danger fs-6"></i>
                                        <span>ফুটারের বাম পাশে স্বয়ংক্রিয়ভাবে পোর্টালের প্রধান টেক্সট লোগো (ওয়াটারমার্ক লোগো) প্রদর্শিত হবে। এটি পরিবর্তন করতে <strong>ব্র্যান্ড ও লোগো</strong> ট্যাব ব্যবহার করুন।</span>
                                    </div>
                                    <input type="hidden" id="modal_brand_title_input" value="{{ $cardSettings['brand_title'] ?? 'দৈনিক ভোলা জার্নাল' }}">
                                    <input type="hidden" id="modal_brand_tagline_input" value="{{ $cardSettings['brand_tagline'] ?? 'সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর' }}">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small mb-1 fw-bold"><i class="fa-solid fa-globe text-info me-1"></i> ওয়েবসাইট ইউআরএল</label>
                                            <input type="text" id="modal_brand_web_input" class="studio-input" value="{{ $cardSettings['brand_web'] ?? 'dailybholajournal.com' }}" placeholder="dailybholajournal.com" oninput="updateBrandFooterWeb(this.value)">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small mb-1 fw-bold"><i class="fa-brands fa-facebook text-primary me-1"></i> সোশ্যাল হ্যান্ডেল</label>
                                            <input type="text" id="modal_brand_social_input" class="studio-input" value="{{ $cardSettings['brand_social'] ?? '/dailybholajournalBN' }}" placeholder="/dailybholajournalBN" oninput="updateBrandFooterSocial(this.value)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Themes & Colors Default -->
                    <div class="tab-pane fade" id="tab-theme" role="tabpanel">
                        <div class="row g-3">
                            <!-- 1. Default Theme Presets Card -->
                            <div class="col-md-7">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <span class="settings-card-title"><i class="fa-solid fa-palette text-danger me-1"></i> ডিফল্ট কালার থিম প্রিসেট</span>
                                        <span class="badge bg-danger-subtle text-danger" style="font-size: 0.72rem;">৬টি প্রিসেট</span>
                                    </div>
                                    <div class="settings-card-body">
                                        <label class="studio-label mb-2">ডিফল্ট থিম নির্বাচন করুন (Click to Select & Apply)</label>
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <button type="button" class="modal-theme-btn w-100 {{ ($cardSettings['theme_key'] ?? 'royal') === 'royal' ? 'active' : '' }}" data-modal-theme="royal" onclick="applyModalTheme('royal')">
                                                    <span class="theme-color-bullet" style="background: #1e3a8a;"></span>
                                                    <div class="text-start">
                                                        <span class="d-block fw-bold text-dark" style="font-size: 0.8rem;">রয়েল ব্লু</span>
                                                        <span class="text-muted" style="font-size: 0.68rem;">Royal #1E3A8A</span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="modal-theme-btn w-100 {{ ($cardSettings['theme_key'] ?? '') === 'crimson' ? 'active' : '' }}" data-modal-theme="crimson" onclick="applyModalTheme('crimson')">
                                                    <span class="theme-color-bullet" style="background: #dc2626;"></span>
                                                    <div class="text-start">
                                                        <span class="d-block fw-bold text-dark" style="font-size: 0.8rem;">ক্রিমসন রেড</span>
                                                        <span class="text-muted" style="font-size: 0.68rem;">Crimson #DC2626</span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="modal-theme-btn w-100 {{ ($cardSettings['theme_key'] ?? '') === 'midnight' ? 'active' : '' }}" data-modal-theme="midnight" onclick="applyModalTheme('midnight')">
                                                    <span class="theme-color-bullet" style="background: #0f172a;"></span>
                                                    <div class="text-start">
                                                        <span class="d-block fw-bold text-dark" style="font-size: 0.8rem;">মিডনাইট স্লেট</span>
                                                        <span class="text-muted" style="font-size: 0.68rem;">Slate #0F172A</span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="modal-theme-btn w-100 {{ ($cardSettings['theme_key'] ?? '') === 'navy' ? 'active' : '' }}" data-modal-theme="navy" onclick="applyModalTheme('navy')">
                                                    <span class="theme-color-bullet" style="background: #0369a1;"></span>
                                                    <div class="text-start">
                                                        <span class="d-block fw-bold text-dark" style="font-size: 0.8rem;">ডিপ নেভি</span>
                                                        <span class="text-muted" style="font-size: 0.68rem;">Navy #0369A1</span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="modal-theme-btn w-100 {{ ($cardSettings['theme_key'] ?? '') === 'emerald' ? 'active' : '' }}" data-modal-theme="emerald" onclick="applyModalTheme('emerald')">
                                                    <span class="theme-color-bullet" style="background: #047857;"></span>
                                                    <div class="text-start">
                                                        <span class="d-block fw-bold text-dark" style="font-size: 0.8rem;">ফরেস্ট এমারেল্ড</span>
                                                        <span class="text-muted" style="font-size: 0.68rem;">Emerald #047857</span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="modal-theme-btn w-100 {{ ($cardSettings['theme_key'] ?? '') === 'maroon' ? 'active' : '' }}" data-modal-theme="maroon" onclick="applyModalTheme('maroon')">
                                                    <span class="theme-color-bullet" style="background: #881337;"></span>
                                                    <div class="text-start">
                                                        <span class="d-block fw-bold text-dark" style="font-size: 0.8rem;">লাক্সারি মেরুন</span>
                                                        <span class="text-muted" style="font-size: 0.68rem;">Maroon #881337</span>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="text-muted small" style="font-size: 0.72rem;">
                                            <i class="fa-solid fa-circle-info text-primary me-1"></i> নির্বাচিত থিমটি সব নতুন কার্ডে ডিফল্ট হিসেবে প্রযোজ্য থাকবে।
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Custom Colors & Accents Card -->
                            <div class="col-md-5">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <span class="settings-card-title"><i class="fa-solid fa-eye-dropper text-danger me-1"></i> কাস্টম কালার ও অ্যাকসেন্ট</span>
                                    </div>
                                    <div class="settings-card-body d-flex flex-column gap-3">
                                        <div>
                                            <label class="studio-label">কাস্টম ব্যাকগ্রাউন্ড কালার</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="color" class="color-picker-studio" id="modalCustomBgColor" value="{{ $cardSettings['custom_bg_color'] ?? '#1e3a8a' }}" oninput="syncCustomBg(this.value)">
                                                <span class="text-muted small font-monospace" id="modalCustomBgHex">{{ $cardSettings['custom_bg_color'] ?? '#1e3a8a' }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="studio-label">কার্ড বর্ডার ও অ্যাকসেন্ট কালার</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="color" class="color-picker-studio" id="modalBorderColorPicker" value="{{ $cardSettings['border_color'] ?? '#38bdf8' }}" oninput="syncBorderColor(this.value)">
                                                <span class="text-muted small font-monospace" id="modalBorderHex">{{ $cardSettings['border_color'] ?? '#38bdf8' }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="studio-label">তারিখ ও মেটা টেক্সট কালার</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="color" class="color-picker-studio" id="modalDateColorPicker" value="{{ $cardSettings['date_color'] ?? '#38bdf8' }}" oninput="syncDateColor(this.value)">
                                                <span class="text-muted small font-monospace" id="modalDateHex">{{ $cardSettings['date_color'] ?? '#38bdf8' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Typography Default -->
                    <div class="tab-pane fade" id="tab-typo" role="tabpanel">
                        <div class="row g-3">
                            <!-- 1. Font Family & Alignment -->
                            <div class="col-md-6">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <span class="settings-card-title"><i class="fa-solid fa-font text-danger me-1"></i> ডিফল্ট ফন্ট ও টেক্সট অ্যালাইনমেন্ট</span>
                                    </div>
                                    <div class="settings-card-body d-flex flex-column gap-3">
                                        <div>
                                            <label class="studio-label">ডিফল্ট বাংলা ফন্ট ফ্যামিলি</label>
                                            <select class="studio-select" id="modal_font_switcher" onchange="syncFontFamily(this.value)">
                                                <option value="'Noto Sans Bengali', sans-serif" {{ ($cardSettings['font_family'] ?? '') === "'Noto Sans Bengali', sans-serif" ? 'selected' : '' }}>নোটো সান্স বেঙ্গলি (Noto Sans) — আদর্শ ও স্পষ্ট</option>
                                                <option value="'Hind Siliguri', sans-serif" {{ ($cardSettings['font_family'] ?? '') === "'Hind Siliguri', sans-serif" ? 'selected' : '' }}>হিন্দ শিলিগুড়ি (Hind Siliguri) — জনপ্রিয় সংবাদ ফন্ট</option>
                                                <option value="'Anek Bangla', sans-serif" {{ ($cardSettings['font_family'] ?? '') === "'Anek Bangla', sans-serif" ? 'selected' : '' }}>অনেক বাংলা (Anek Bangla) — আধুনিক জ্যামিতিক</option>
                                                <option value="'Baloo Da 2', cursive" {{ ($cardSettings['font_family'] ?? '') === "'Baloo Da 2', cursive" ? 'selected' : '' }}>বালু দা ২ (Baloo Da 2) — বোল্ড ও গোলগাল</option>
                                                <option value="'Mina', sans-serif" {{ ($cardSettings['font_family'] ?? '') === "'Mina', sans-serif" ? 'selected' : '' }}>মিনা (Mina) — স্লিম ও পরিচ্ছন্ন</option>
                                                <option value="'Tiro Bangla', serif" {{ ($cardSettings['font_family'] ?? '') === "'Tiro Bangla', serif" ? 'selected' : '' }}>তিরো বাংলা (Tiro Bangla) — ঐতিহ্যবাহী সেরিফ</option>
                                                <option value="'Galada', cursive" {{ ($cardSettings['font_family'] ?? '') === "'Galada', cursive" ? 'selected' : '' }}>গালাদা (Galada) — আকর্ষণীয় ক্যালিগ্রাফি</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="studio-label">শিরোনামের ডিফল্ট অ্যালাইনমেন্ট</label>
                                            <div class="btn-group w-100" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary {{ ($cardSettings['headline_align'] ?? 'center') === 'left' ? 'active' : '' }}" id="modalAlignLeftBtn" onclick="syncHeadlineAlign('left')">
                                                    <i class="fa-solid fa-align-left me-1"></i> বামে সাজান (Left)
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary {{ ($cardSettings['headline_align'] ?? 'center') !== 'left' ? 'active' : '' }}" id="modalAlignCenterBtn" onclick="syncHeadlineAlign('center')">
                                                    <i class="fa-solid fa-align-center me-1"></i> মাঝে সাজান (Center)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Font Size & Line Height -->
                            <div class="col-md-6">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <span class="settings-card-title"><i class="fa-solid fa-text-height text-danger me-1"></i> শিরোনাম সাইজ ও লাইন উচ্চতা</span>
                                    </div>
                                    <div class="settings-card-body d-flex flex-column gap-3">
                                        <div>
                                            <label class="studio-label">ডিফল্ট শিরোনাম ফন্ট সাইজ (৩৬px - ৭২px)</label>
                                            <div class="slider-wrapper">
                                                <input type="range" class="studio-range" id="modalFontSizeSlider" min="36" max="72" value="{{ $cardSettings['font_size'] ?? 52 }}" oninput="syncFontSize(this.value)">
                                                <span class="slider-val-badge" id="modalFontSizeBadge">{{ $cardSettings['font_size'] ?? 52 }}px</span>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="studio-label">ডিফল্ট লাইন উচ্চতা (Line Height: ১.১ - ১.৮)</label>
                                            <div class="slider-wrapper">
                                                <input type="range" class="studio-range" id="modalLineHeightSlider" min="1.1" max="1.8" step="0.05" value="{{ $cardSettings['line_height'] ?? 1.3 }}" oninput="syncLineHeight(this.value)">
                                                <span class="slider-val-badge" id="modalLineHeightBadge">{{ $cardSettings['line_height'] ?? 1.3 }}</span>
                                            </div>
                                        </div>
                                        <div class="text-muted small" style="font-size: 0.72rem;">
                                            <i class="fa-solid fa-circle-info text-primary me-1"></i> যেকোনো পোস্টে কাজের সময় সাইডবার থেকেও তাৎক্ষণিক ফন্ট পরিবর্তন করা যায়।
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 5: Layout & Badges -->
                    <div class="tab-pane fade" id="tab-layout" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="settings-card-title"><i class="fa-solid fa-user-pen text-danger me-1"></i> প্রতিবেদক ব্যাজ (Reporter Pill)</span>
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" id="toggleCategoryBadge" {{ !empty($cardSettings['category_badge_visible']) || !isset($cardSettings['category_badge_visible']) ? 'checked' : '' }} onchange="toggleCategoryBadgeVisibility(this.checked)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="settings-card-body">
                                        <label class="studio-label">ব্যাজের ব্যাকগ্রাউন্ড কালার</label>
                                        <div class="color-swatch-wrapper">
                                            <div class="color-swatch" style="background: #dc2626;" onclick="setCategoryBadgeColor('#dc2626')" title="লাল"></div>
                                            <div class="color-swatch" style="background: #1e3a8a;" onclick="setCategoryBadgeColor('#1e3a8a')" title="রয়েল ব্লু"></div>
                                            <div class="color-swatch" style="background: #059669;" onclick="setCategoryBadgeColor('#059669')" title="সবুজ"></div>
                                            <div class="color-swatch" style="background: #d97706;" onclick="setCategoryBadgeColor('#d97706')" title="অরেঞ্জ"></div>
                                            <div class="color-swatch" style="background: #7c3aed;" onclick="setCategoryBadgeColor('#7c3aed')" title="পার্পল"></div>
                                            <input type="color" class="color-picker-studio" id="badgeColorPicker" oninput="setCategoryBadgeColor(this.value)" value="{{ $cardSettings['category_badge_color'] ?? '#dc2626' }}">
                                        </div>

                                        <div class="mt-3 pt-2 border-top">
                                            <label class="studio-label">ইমেজ থেকে উপরে উচ্চতা (Bottom Offset)</label>
                                            <div class="slider-wrapper">
                                                <input type="range" class="studio-range" id="modalReporterBottomSlider" min="0" max="80" value="{{ $cardSettings['reporter_badge_bottom'] ?? 25 }}" oninput="setReporterBadgeBottom(this.value)">
                                                <span class="slider-val-badge" id="modalReporterBottomBadge">{{ $cardSettings['reporter_badge_bottom'] ?? 25 }}px</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="settings-card h-100">
                                    <div class="settings-card-header">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="settings-card-title"><i class="fa-solid fa-comment-dots text-danger me-1"></i> বিস্তারিত কমেন্টে হিন্ট</span>
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" id="toggleDetailsHint" checked onchange="toggleDetailsHintVisibility(this.checked)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="settings-card-body">
                                        <div class="mb-3">
                                            <label class="studio-label">কাস্টম হিন্ট টেক্সট</label>
                                            <input type="text" id="customHintInput" class="studio-input" value="{{ $cardSettings['details_hint_text'] ?? 'বিস্তারিত কমেন্টে......' }}" oninput="updateCustomHint(this.value)">
                                        </div>
                                        <div class="border-top pt-2">
                                            <label class="studio-label">উক্তি/ব্রেকিং ফটো ডিফল্ট মোড</label>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-secondary flex-grow-1 {{ empty($cardSettings['quote_cutout_mode']) ? 'active' : '' }}" onclick="syncQuoteMode('normal')" id="modalQuoteModeNormal">
                                                    <i class="fa-regular fa-image me-1"></i> নরমাল ফ্রেম
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary flex-grow-1 {{ !empty($cardSettings['quote_cutout_mode']) ? 'active' : '' }}" onclick="syncQuoteMode('cutout')" id="modalQuoteModeCutout">
                                                    <i class="fa-solid fa-user-ninja me-1"></i> ফুল কাটআউট
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light d-flex justify-content-between align-items-center w-100">
                <button type="button" class="btn btn-outline-secondary font-bangla btn-sm" onclick="resetAllCardSettings()">
                    <i class="fa-solid fa-rotate-left me-1"></i> ডিফল্ট রিসেট
                </button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-dark font-bangla" data-bs-dismiss="modal">
                        বন্ধ করুন
                    </button>
                    <button type="button" id="saveCardSettingsBtn" class="btn btn-danger font-bangla px-4 shadow-sm" onclick="savePersistentCardSettings()">
                        <i class="fa-solid fa-floppy-disk me-1"></i> সেটিংস স্থায়ীভাবে সেভ করুন
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
