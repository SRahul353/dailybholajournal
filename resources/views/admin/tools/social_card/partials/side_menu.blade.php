    <!-- Inspector Panel (Left side) -->
    <div class="inspector-panel" id="inspectorPanel">
        <div class="inspector-header">
            <span class="inspector-title">
                <i class="fa-solid fa-palette text-danger"></i> ক্যানভাস স্টুডিও
            </span>
            <div class="d-flex align-items-center gap-1">
                <button type="button" class="btn-studio-quicksave" id="quickSaveDefaultBtn" onclick="savePersistentCardSettings()" title="বর্তমান সব স্টাইল, ফন্ট ও কালার ডিফল্ট হিসেবে সেভ করুন">
                    <i class="fa-solid fa-floppy-disk text-primary"></i>
                    <span>ডিফল্ট সেভ</span>
                </button>
                <button type="button" class="btn-studio-gear" data-bs-toggle="modal" data-bs-target="#cardSettingsModal" title="মাস্টার কার্ড সেটিংস (৫টি ট্যাব)">
                    <i class="fa-solid fa-gear"></i>
                    <span>সেটিংস</span>
                </button>
            </div>
        </div>

        <div class="inspector-content">
            <!-- Section 0: কার্ড ডিজাইন স্টাইল নির্বাচন (Select Card Style) -->
            <div class="inspector-section pt-1">
                <span class="section-title">
                    <i class="fa-solid fa-shapes text-danger"></i> কার্ড ডিজাইন স্টাইল (Style)
                </span>
                
                <div class="card-style-grid">
                    <!-- Style 1: Classic Split -->
                    <div class="style-select-card {{ ($cardSettings['card_style'] ?? 'classic') === 'classic' ? 'active' : '' }}" data-style="classic" onclick="setCardStyle('classic')">
                        <div class="style-thumb-box thumb-classic">
                            <div class="thumb-top-img"></div>
                            <div class="thumb-bottom-card">
                                <div class="thumb-line-sm"></div>
                                <div class="thumb-line-lg"></div>
                            </div>
                        </div>
                        <span class="style-title">ক্লাসিক স্প্লিট</span>
                        <span class="style-badge-tag tag-blue">ডিফল্ট</span>
                    </div>

                    <!-- Style 2: Full Poster Overlay -->
                    <div class="style-select-card {{ ($cardSettings['card_style'] ?? '') === 'poster' ? 'active' : '' }}" data-style="poster" onclick="setCardStyle('poster')">
                        <div class="style-thumb-box thumb-poster">
                            <div class="thumb-full-img"></div>
                            <div class="thumb-scrim">
                                <div class="thumb-line-lg"></div>
                            </div>
                        </div>
                        <span class="style-title">ফুল পোস্টার</span>
                        <span class="style-badge-tag tag-purple">সিনেমাটিক</span>
                    </div>

                    <!-- Style 3: Quote / Statement -->
                    <div class="style-select-card {{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'active' : '' }}" data-style="quote" onclick="setCardStyle('quote')">
                        <div class="style-thumb-box thumb-quote">
                            <div class="thumb-quote-img"></div>
                            <div class="thumb-quote-card">
                                <i class="fa-solid fa-quote-left thumb-quote-icon"></i>
                                <div class="thumb-line-lg"></div>
                            </div>
                        </div>
                        <span class="style-title">উক্তি / বক্তব্য</span>
                        <span class="style-badge-tag tag-amber">কোটেশন</span>
                    </div>

                    <!-- Style 4: Breaking News Flash -->
                    <div class="style-select-card {{ ($cardSettings['card_style'] ?? '') === 'breaking' ? 'active' : '' }}" data-style="breaking" onclick="setCardStyle('breaking')">
                        <div class="style-thumb-box thumb-breaking">
                            <div class="thumb-break-bar"></div>
                            <div class="thumb-break-img"></div>
                            <div class="thumb-break-card">
                                <div class="thumb-line-lg"></div>
                            </div>
                        </div>
                        <span class="style-title">ব্রেকিং নিউজ</span>
                        <span class="style-badge-tag tag-red">জরুরি</span>
                    </div>
                </div>
            </div>

            <!-- Section 1: পোস্ট ও শিরোনাম -->
            <div class="inspector-section">
                <span class="section-title">
                    <i class="fa-solid fa-newspaper"></i> পোস্ট ও শিরোনাম
                </span>
                
                <div>
                    <label class="studio-label"><i class="fa-solid fa-shuffle text-danger me-1"></i> পোস্ট পরিবর্তন করুন</label>
                    <select id="post_switcher" class="studio-select" onchange="window.location.href = '{{ url('admin/tools/social-card') }}/' + this.value">
                        @foreach($recentPosts as $p)
                            <option value="{{ $p->id }}" {{ $p->id == $post->id ? 'selected' : '' }}>
                                {{ Str::limit($p->title, 25) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="studio-label"><i class="fa-solid fa-user-pen text-danger me-1"></i> প্রতিবেদক (Reporter / Author)</label>
                    <input type="text" id="live_category_input" class="studio-input" value="{{ !empty($post->reporter_name) ? $post->reporter_name : ($post->author_name ?? 'নিজস্ব প্রতিবেদক') }}" placeholder="প্রতিবেদকের নাম লিখুন...">
                </div>

                <div>
                    <label class="studio-label">ইমেজ থেকে উপরে উচ্চতা (Bottom Offset)</label>
                    <div class="slider-wrapper">
                        <input type="range" class="studio-range" id="reporterBottomSlider" min="0" max="80" value="{{ $cardSettings['reporter_badge_bottom'] ?? 25 }}" oninput="setReporterBadgeBottom(this.value)">
                        <span class="slider-val-badge" id="reporterBottomBadge">{{ $cardSettings['reporter_badge_bottom'] ?? 25 }}px</span>
                    </div>
                </div>

                <div id="headlineControlGroup" style="display: {{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'none' : 'block' }};">
                    <label class="studio-label"><i class="fa-solid fa-heading text-danger me-1"></i> কাস্টম শিরোনাম (News Caption)</label>
                    <textarea id="live_headline_input" class="studio-input" rows="3" style="resize: none;" placeholder="শিরোনাম টাইপ করুন...">{{ $post->title }}</textarea>
                    <div class="char-count-wrapper">
                        <span>অক্ষর সংখ্যা: <span id="charCount" class="char-count-badge">0</span></span>
                    </div>

                    <!-- Breaking News Sub-excerpt (only for Breaking style) -->
                    <div id="breakingExcerptControlGroup" class="mt-2" style="display: {{ ($cardSettings['card_style'] ?? '') === 'breaking' ? 'block' : 'none' }};">
                        <label class="studio-label"><i class="fa-solid fa-align-left text-danger me-1"></i> সাব-শিরোনাম / পোস্ট এক্সার্প্ট (Sub-Excerpt)</label>
                        <textarea id="live_breaking_excerpt_input" class="studio-input" rows="3" style="resize: none;" placeholder="পোস্টের বিবরণ বা সারসংক্ষেপ...">{{ !empty($post->excerpt) ? trim($post->excerpt) : (!empty($post->content) ? Str::limit(strip_tags($post->content), 180) : '') }}</textarea>
                    </div>
                </div>

                <!-- Quote & Breaking Photo/Speaker Controls -->
                <div id="quoteSidebarControls" style="display: {{ in_array($cardSettings['card_style'] ?? '', ['quote', 'breaking']) ? 'block' : 'none' }};">
                    <!-- Speaker fields only for Quote style -->
                    <div id="quoteSpeakerFields" style="display: {{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'block' : 'none' }};">
                        <div>
                            <label class="studio-label"><i class="fa-solid fa-quote-left text-danger me-1"></i> উক্তি / বক্তব্য (News Excerpt)</label>
                            <textarea id="live_quote_input" class="studio-input" rows="4" style="resize: none;" placeholder="উক্তি বা বক্তব্য টাইপ করুন...">{{ !empty($post->excerpt) ? trim($post->excerpt) : (!empty($post->content) ? Str::limit(strip_tags($post->content), 180) : $post->title) }}</textarea>
                        </div>

                        <div class="row g-2 mt-2">
                            <div class="col-6">
                                <label class="studio-label mb-1" style="font-size: 11px;"><i class="fa-solid fa-user me-1 text-danger"></i> বক্তার নাম</label>
                                <input type="text" id="live_speaker_name_input" class="studio-input" style="height: 34px; font-size: 12px;" value="— {{ !empty($post->reporter_name) ? $post->reporter_name : ($post->author_name ?? 'বক্তার নাম') }}">
                            </div>
                            <div class="col-6">
                                <label class="studio-label mb-1" style="font-size: 11px;"><i class="fa-solid fa-id-badge me-1 text-danger"></i> পদবি / পরিচয়</label>
                                <input type="text" id="live_speaker_title_input" class="studio-input" style="height: 34px; font-size: 12px;" value="পদবি / পরিচয় এখানে লিখুন">
                            </div>
                        </div>
                    </div>

                    <!-- Photo Display Mode (Normal vs Cutout) for Quote & Breaking -->
                    <div id="photoModeGroup" class="mt-3 pt-2" style="border-top: 1px dashed #334155;">
                        <label class="studio-label mb-1" style="font-size: 11px;">
                            <i class="fa-regular fa-image text-danger me-1"></i> <span id="photoModeLabel">{{ ($cardSettings['card_style'] ?? '') === 'breaking' ? 'নিউজ ছবির মোড (Display Mode)' : 'বক্তার ছবির মোড (Display Mode)' }}</span>
                        </label>
                        <div class="btn-group w-100 mb-2" role="group">
                            <button type="button" class="btn btn-sm btn-outline-secondary {{ empty($cardSettings['quote_cutout_mode']) ? 'active' : '' }}" id="modeNormalBtn" onclick="setQuotePhotoMode('normal')">
                                <i class="fa-regular fa-square me-1"></i> নরমাল মোড (আগের মতো)
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary {{ !empty($cardSettings['quote_cutout_mode']) ? 'active' : '' }}" id="modeCutoutBtn" onclick="setQuotePhotoMode('cutout')">
                                <i class="fa-solid fa-wand-magic-sparkles me-1 text-warning"></i> কাটআউট মোড (ফুল উইথ)
                            </button>
                        </div>

                        <label for="quote_speaker_file_input" class="bg-upload-zone py-2 px-3 mt-1" style="cursor: pointer; background: #0f172a; border: 1.5px dashed #475569; border-radius: 8px;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-cloud-arrow-up text-warning" style="font-size: 1.3rem;"></i>
                                <div class="text-start">
                                    <div style="font-size: 0.8rem; font-weight: 700; color: #f1f5f9;">ছবি আপলোড করুন</div>
                                    <div id="photoUploadSubtext" style="font-size: 0.68rem; color: #94a3b8;">{{ ($cardSettings['card_style'] ?? '') === 'breaking' ? 'সংবাদের সাধারণ ছবি বা স্বচ্ছ কাটআউট PNG ফাইল' : 'সাধারণ ছবি বা স্বচ্ছ কাটআউট PNG ফাইল' }}</div>
                                </div>
                            </div>
                            <img id="quote_speaker_thumb" class="bg-upload-preview mt-2" src="" style="display: none; height: 50px; object-fit: contain;">
                        </label>
                        <input type="file" id="quote_speaker_file_input" accept="image/*" style="display: none;" onchange="previewQuoteSpeakerImage(this)">

                        <!-- Cutout Adjustment Controls -->
                        <div id="cutoutSlidersBox" class="mt-2 p-2 rounded" style="display: {{ !empty($cardSettings['quote_cutout_mode']) ? 'block' : 'none' }}; background: rgba(15, 23, 42, 0.6); border: 1px solid #1e293b;">
                            <div class="row g-2">
                                <div class="col-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="studio-label mb-0" style="font-size: 10px;">সাইজ (জুম)</label>
                                        <span class="slider-val-badge" id="quoteScaleBadge" style="font-size: 9px; padding: 1px 3px;">{{ $cardSettings['quote_img_scale'] ?? 100 }}%</span>
                                    </div>
                                    <input type="range" class="studio-range" id="quoteScaleSlider" min="50" max="180" value="{{ $cardSettings['quote_img_scale'] ?? 100 }}" oninput="setQuoteImgScale(this.value)">
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="studio-label mb-0" style="font-size: 10px;">উপরে/নিচে</label>
                                        <span class="slider-val-badge" id="quoteYBadge" style="font-size: 9px; padding: 1px 3px;">{{ $cardSettings['quote_img_y'] ?? 0 }}px</span>
                                    </div>
                                    <input type="range" class="studio-range" id="quoteYSlider" min="-180" max="180" value="{{ $cardSettings['quote_img_y'] ?? 0 }}" oninput="setQuoteImgY(this.value)">
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="studio-label mb-0" style="font-size: 10px;">ডানে/বামে</label>
                                        <span class="slider-val-badge" id="quoteXBadge" style="font-size: 9px; padding: 1px 3px;">{{ $cardSettings['quote_img_x'] ?? 0 }}px</span>
                                    </div>
                                    <input type="range" class="studio-range" id="quoteXSlider" min="-300" max="300" value="{{ $cardSettings['quote_img_x'] ?? 0 }}" oninput="setQuoteImgX(this.value)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: ফন্ট ও টেক্সট স্টাইল -->
            <div class="inspector-section">
                <span class="section-title">
                    <i class="fa-solid fa-font"></i> ফন্ট ও টেক্সট স্টাইল
                </span>

                <div>
                    <label class="studio-label">ফন্ট ফ্যামিলি</label>
                    <select class="studio-select" id="font_switcher" onchange="changeFontFamily(this.value)">
                        <option value="'Noto Sans Bengali', sans-serif" selected>Noto Sans (ক্লিন)</option>
                        <option value="'Baloo Da 2', sans-serif">Baloo Da 2 (রাউন্ডেড)</option>
                        <option value="'Anek Bangla', sans-serif">Anek Bangla (মডার্ন)</option>
                        <option value="'Tiro Bangla', serif">Tiro Bangla (পত্রিকা স্টাইল)</option>
                        <option value="'Hind Siliguri', sans-serif">Hind Siliguri</option>
                        <option value="'Mina', sans-serif">Mina</option>
                        <option value="'Galada', cursive">Galada (স্টাইলিশ)</option>
                    </select>
                </div>

                <div>
                    <label class="studio-label">ফন্ট সাইজ</label>
                    <div class="slider-wrapper">
                        <input type="range" class="studio-range" id="fontSizeSlider" min="40" max="80" value="52" step="1" oninput="updateFontSize(this.value)">
                        <span class="slider-val-badge" id="fontSizeBadge">52px</span>
                    </div>
                </div>

                <div>
                    <label class="studio-label">লাইন হাইট (স্পেসিং)</label>
                    <div class="slider-wrapper">
                        <input type="range" class="studio-range" id="lineHeightSlider" min="1.0" max="1.6" value="1.3" step="0.05" oninput="updateLineHeight(this.value)">
                        <span class="slider-val-badge" id="lineHeightBadge">1.3</span>
                    </div>
                </div>

                <div>
                    <label class="studio-label">শিরোনামের অ্যালাইনমেন্ট</label>
                    <div class="btn-group w-100" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="alignLeftBtn" onclick="setHeadlineAlignment('left')">
                            <i class="fa-solid fa-align-left me-1"></i> বামে
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary active" id="alignCenterBtn" onclick="setHeadlineAlignment('center')">
                            <i class="fa-solid fa-align-center me-1"></i> মাঝে (সেন্টার)
                        </button>
                    </div>
                </div>

                <div>
                    <label class="studio-label">টেক্সট কালার (সিলেক্টেড অংশ)</label>
                    <div class="color-swatch-wrapper">
                        <div class="color-swatch" style="background: #ffffff;" onclick="applyQuickColor('#ffffff')" title="সাদা"></div>
                        <div class="color-swatch" style="background: #f39c12;" onclick="applyQuickColor('#f39c12')" title="সোনালী"></div>
                        <div class="color-swatch" style="background: #ef4444;" onclick="applyQuickColor('#ef4444')" title="লাল"></div>
                        <div class="color-swatch" style="background: #10b981;" onclick="applyQuickColor('#10b981')" title="সবুজ"></div>
                        <div class="color-swatch" style="background: #0ea5e9;" onclick="applyQuickColor('#0ea5e9')" title="আকাশী"></div>
                        <input type="color" class="color-picker-studio" id="colorPicker" oninput="changeSelectedColor(this.value)" value="#ffffff" title="কাস্টম কালার">
                    </div>
                </div>
            </div>

            <!-- Section 3: কার্ড কালার ও থিম (Card Color Themes) -->
            <div class="inspector-section">
                <span class="section-title">
                    <i class="fa-solid fa-palette"></i> কার্ড কালার ও থিম
                </span>

                <div>
                    <label class="studio-label"><i class="fa-solid fa-swatchbook text-danger me-1"></i> ব্যাকগ্রাউন্ড কালার থিম</label>
                    <div class="card-theme-grid">
                        <button type="button" class="btn-theme-preset active" data-theme="royal" onclick="applyCardTheme('royal')">
                            <span class="theme-dot" style="background: linear-gradient(135deg, #1e3a8a, #0f172a);"></span>
                            <span>রয়েল ব্লু</span>
                        </button>
                        <button type="button" class="btn-theme-preset" data-theme="crimson" onclick="applyCardTheme('crimson')">
                            <span class="theme-dot" style="background: linear-gradient(135deg, #990000, #3a0000);"></span>
                            <span>জার্নাল রেড</span>
                        </button>
                        <button type="button" class="btn-theme-preset" data-theme="midnight" onclick="applyCardTheme('midnight')">
                            <span class="theme-dot" style="background: linear-gradient(135deg, #18181b, #09090b);"></span>
                            <span>মিডনাইট ব্ল্যাক</span>
                        </button>
                        <button type="button" class="btn-theme-preset" data-theme="navy" onclick="applyCardTheme('navy')">
                            <span class="theme-dot" style="background: linear-gradient(135deg, #1e293b, #0a0f1d);"></span>
                            <span>নেভি ব্লু</span>
                        </button>
                        <button type="button" class="btn-theme-preset" data-theme="emerald" onclick="applyCardTheme('emerald')">
                            <span class="theme-dot" style="background: linear-gradient(135deg, #064e3b, #022c22);"></span>
                            <span>গাঢ় সবুজ</span>
                        </button>
                        <button type="button" class="btn-theme-preset" data-theme="maroon" onclick="applyCardTheme('maroon')">
                            <span class="theme-dot" style="background: linear-gradient(135deg, #581c87, #2e1065);"></span>
                            <span>ডিপ মেরুন</span>
                        </button>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="studio-label">কাস্টম ব্যাকগ্রাউন্ড কালার</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="color" class="color-picker-studio" id="customBgColor" value="#1e3a8a" oninput="setCustomCardBg(this.value)">
                        <input type="text" class="studio-input py-1 px-2" id="customBgHex" value="#1e3a8a" style="font-size: 0.8rem; height: 32px;" onchange="setCustomCardBg(this.value)">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="studio-label">তারিখ ও ডিটেইলস কালার</label>
                    <div class="color-swatch-wrapper">
                        <div class="color-swatch" style="background: #38bdf8;" onclick="setCardDateColor('#38bdf8')" title="রয়েল স্কাই"></div>
                        <div class="color-swatch" style="background: #ffd700;" onclick="setCardDateColor('#ffd700')" title="সোনালী"></div>
                        <div class="color-swatch" style="background: #ffffff;" onclick="setCardDateColor('#ffffff')" title="সাদা"></div>
                        <div class="color-swatch" style="background: #ef4444;" onclick="setCardDateColor('#ef4444')" title="লাল"></div>
                        <div class="color-swatch" style="background: #34d399;" onclick="setCardDateColor('#34d399')" title="হালকা সবুজ"></div>
                        <input type="color" class="color-picker-studio" id="dateColorPicker" oninput="setCardDateColor(this.value)" value="#38bdf8" title="কাস্টম কালার">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="studio-label">ডিভাইডার বর্ডার কালার</label>
                    <div class="color-swatch-wrapper">
                        <div class="color-swatch" style="background: #38bdf8;" onclick="setCardBorderColor('#38bdf8')" title="রয়েল স্কাই"></div>
                        <div class="color-swatch" style="background: #ffd700;" onclick="setCardBorderColor('#ffd700')" title="সোনালী"></div>
                        <div class="color-swatch" style="background: #ef4444;" onclick="setCardBorderColor('#ef4444')" title="লাল"></div>
                        <div class="color-swatch" style="background: #ffffff;" onclick="setCardBorderColor('#ffffff')" title="সাদা"></div>
                        <div class="color-swatch" style="background: #0ea5e9;" onclick="setCardBorderColor('#0ea5e9')" title="নীল"></div>
                        <input type="color" class="color-picker-studio" id="borderColorPicker" oninput="setCardBorderColor(this.value)" value="#38bdf8" title="কাস্টম কালার">
                    </div>
                </div>
            </div>

            <!-- Section 4: ছবির ফ্রেম ও পজিশনিং -->
            <div class="inspector-section">
                <span class="section-title" id="imageSectionTitle">
                    <i class="fa-regular fa-image"></i> {{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'বক্তার ছবি ও পজিশন' : 'ছবির ফ্রেম ও পজিশন' }}
                </span>

                <div>
                    <label class="studio-label" id="bgUploadLabel">{{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'বক্তার ছবি পরিবর্তন (PNG Cutout)' : 'ব্যাকগ্রাউন্ড ছবি পরিবর্তন' }}</label>
                    <label for="social_card_image" class="bg-upload-zone">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span id="bgUploadPrompt" style="font-size: 0.8rem; font-weight: 700;">{{ ($cardSettings['card_style'] ?? '') === 'quote' ? 'বক্তার পিএনজি আপলোড করুন' : 'নতুন ব্যাকগ্রাউন্ড আপলোড করুন' }}</span>
                        <span style="font-size: 0.7rem; color:#64748b;">(JPG, PNG, WebP supported)</span>
                        <img id="bg_thumb_preview" class="bg-upload-preview" src="" style="display: none;">
                    </label>
                    <input type="file" id="social_card_image" accept="image/*" style="display: none;" onchange="previewSocialCardImage(this)">
                </div>

                <div class="mt-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="studio-label mb-0"><i class="fa-solid fa-arrows-up-down text-danger me-1"></i> ছবির ভার্টিক্যাল পজিশন (প্যান)</label>
                        <span class="slider-val-badge" id="imgPanBadge">50%</span>
                    </div>
                    <div class="slider-wrapper">
                        <input type="range" class="studio-range" id="imgPanSlider" min="0" max="100" value="50" oninput="setImagePan(this.value)">
                    </div>
                    <div class="d-flex justify-content-between text-muted mt-1" style="font-size: 10px;">
                        <span>শীর্ষ (Top)</span>
                        <span>মধ্য (Center)</span>
                        <span>নিচ (Bottom)</span>
                    </div>
                </div>
            </div>

            <!-- Section 5: কুইক ডাউনলোড ও ফেসবুক পোস্ট -->
            <div class="inspector-section" style="background: transparent; border: none; padding: 0;">
                <button type="button" onclick="download_SocialCard(event)" class="download-gradient-btn">
                    <i class="fa-solid fa-download" style="font-size: 1.1rem;"></i>  কার্ডটি সেভ করুন
                </button>

                <button type="button" onclick="shareOnFacebook(event)" class="btn-facebook-share mt-2">
                    <i class="fa-brands fa-facebook" style="font-size: 1.15rem;"></i> ফেসবুকে পোস্ট করুন
                </button>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-secondary w-100 justify-content-center" style="border-radius: 8px; font-size: 0.85rem; font-weight: 600;">
                        <i class="fa-solid fa-pen-to-square"></i> সংবাদ সম্পাদনা
                    </a>
                </div>
            </div>
        </div>
    </div>
