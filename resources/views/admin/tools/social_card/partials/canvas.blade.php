    <!-- Studio Canvas Workspace (Right side) -->
    <div class="canvas-workspace" id="canvasWorkspace">
        <!-- Toggle button to open/close inspector panel on mobile or desktop -->
        <button class="toggle-studio-panel-btn" id="togglePanelBtn" onclick="toggleInspectorPanel()" title="প্যানেল লুকান/দেখান">
            <i class="fa-solid fa-sliders" id="togglePanelIcon"></i>
        </button>



        <!-- 1080x1080 Canvas Scaled Box -->
        <div class="scale-container" id="scaleContainer">
            <!-- Figma-like crop marks and guidelines -->
            <div class="canvas-guide guide-tl"></div>
            <div class="canvas-guide guide-tr"></div>
            <div class="canvas-guide guide-bl"></div>
            <div class="canvas-guide guide-br"></div>
            <div class="canvas-resolution-badge"><i class="fa-solid fa-vector-square text-danger me-1"></i> ১০৮০ × ১০৮০ পিক্সেল (১:১)</div>

            <div id="social_card_node" class="news-card-1080 style-{{ $cardSettings['card_style'] ?? 'classic' }}">
                <!-- Quote Style Background Texture (Style 3) -->
                <div class="quote-card-texture" id="quoteCardTexture"></div>

                <!-- Quote Style Vertical Side Column (Style 3) -->
                <div class="quote-side-column" id="quoteSideColumn"></div>

                <!-- Top Corner Profile/Emblem Logo (Unified across all styles - same as Classic) -->
                <div class="card-top-right-logo" id="cardTopLogo">
                    <img id="cornerLogoImg" src="{{ !empty($cardSettings['corner_logo_image']) ? asset($cardSettings['corner_logo_image']) : asset('BJ_Content/Profile Pic b.png') }}" alt="Daily Bhola Journal" crossorigin="anonymous" class="{{ !empty($cardSettings['corner_logo_shadow']) || !isset($cardSettings['corner_logo_shadow']) ? 'logo-shadow-effect' : 'no-shadow' }}">
                </div>

                <!-- Breaking News Header Strip (Style 4) -->
                <div class="breaking-news-header" id="breakingNewsHeader">
                    <div class="breaking-tag">
                        <span class="live-dot"></span>
                        <span>ব্রেকিং নিউজ</span>
                    </div>
                    <div class="breaking-bar-marquee">
                        <span>দৈনিক ভোলা জার্নাল • জরুরি সংবাদ বুলেটিন</span>
                    </div>
                </div>

                <!-- News Image Section -->
                <div class="news-image-wrapper {{ !empty($cardSettings['quote_cutout_mode']) ? 'quote-cutout-mode' : '' }}" id="newsImageWrapper">
                    @if($post->social_card_image)
                        <img src="{{ $post->social_card_image_url }}" class="news-image" id="cardImagePreview" crossorigin="anonymous" style="object-position: center 50%;">
                    @elseif($post->featured_image)
                        <img src="{{ $post->featured_image_url }}" class="news-image" id="cardImagePreview" crossorigin="anonymous" style="object-position: center 50%;">
                    @else
                        <img src="" class="news-image" id="cardImagePreview" crossorigin="anonymous" style="display: none; object-position: center 50%;">
                        <div id="cardImagePlaceholder" style="width:100%; height:100%; background:#1e293b; display: flex; flex-direction: column; align-items: center; justify-content: center; color: rgba(255,255,255,0.4); gap: 10px;">
                            <i class="fa-regular fa-image" style="font-size: 50px;"></i>
                            <span style="font-family:'Noto Sans Bengali',sans-serif; font-size: 18px; font-weight:700;">ইমেজ পাওয়া যায়নি</span>
                        </div>
                    @endif

                    <!-- Reporter Badge on News Image (Left Bottom) -->
                    <div class="card-reporter-badge-wrapper" id="reporterBadgeWrapper" style="bottom: {{ $cardSettings['reporter_badge_bottom'] ?? 25 }}px; display: {{ !empty($cardSettings['category_badge_visible']) || !isset($cardSettings['category_badge_visible']) ? 'flex' : 'none' }};">
                        <span class="card-category-badge card-reporter-badge" id="cardCategoryPreview" contenteditable="true" spellcheck="false" style="background: {{ $cardSettings['category_badge_color'] ?? '#dc2626' }};">{{ !empty($post->reporter_name) ? $post->reporter_name : ($post->author_name ?? 'নিজস্ব প্রতিবেদক') }}</span>
                    </div>
                </div>

                <!-- Bottom Content Section -->
                <div class="bottom-content-wrapper" id="bottomContentWrapper">
                    <!-- Watermark Logo positioned down behind text -->
                    @if(!empty($themeSettings['logo_image']))
                        <img src="{{ asset($themeSettings['logo_image']) }}" alt="Watermark" class="text-area-watermark" id="cardWatermarkImg" crossorigin="anonymous">
                    @elseif(file_exists(public_path('BJ_Content/Text Logo.png')))
                        <img src="{{ asset('BJ_Content/Text Logo.png') }}" alt="Watermark" class="text-area-watermark" id="cardWatermarkImg" crossorigin="anonymous">
                    @endif

                    <!-- Quote Symbol Badge (Style 3) -->
                    <div class="quote-symbol-badge" id="quoteSymbolBadge">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>

                    <!-- Breaking News Live Pill Badge (Style 4) -->
                    <div class="breaking-badge-pill" id="breakingBadgePill">
                        <span class="live-dot"></span>
                        <span>ব্রেকিং নিউজ</span>
                    </div>

                    <!-- Meta Row: Bengali Date (Unified across all styles - same as Classic) -->
                    <div class="meta-row" id="cardMetaRow" style="justify-content: flex-start;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-regular fa-calendar-days" id="cardDateIcon" style="color: {{ $cardSettings['date_color'] ?? '#38bdf8' }}; font-size: 20px;"></i>
                            <div class="news-date" id="cardDatePreview" contenteditable="true" spellcheck="false">
                                তারিখ...
                            </div>
                        </div>
                    </div>

                    <div class="headline-wrapper" id="cardHeadlineWrapper">
                        <div class="news-headline" id="editable_headline" contenteditable="true" spellcheck="false">
                            {{ $post->title }}
                        </div>

                        <!-- Breaking News Sub-Excerpt (Style 4: "sub kore post expict thakbe niche") -->
                        <div class="breaking-excerpt-text" id="editable_breaking_excerpt" contenteditable="true" spellcheck="false">
                            {{ !empty($post->excerpt) ? trim($post->excerpt) : (!empty($post->content) ? Str::limit(strip_tags($post->content), 180) : '') }}
                        </div>

                        <!-- Quote Excerpt Text (Style 3) -->
                        <div class="quote-excerpt-text" id="editable_quote_text" contenteditable="true" spellcheck="false">
                            {{ !empty($post->excerpt) ? trim($post->excerpt) : (!empty($post->content) ? Str::limit(strip_tags($post->content), 180) : $post->title) }}
                        </div>

                        <!-- Quote Speaker Name & Title (Style 3) -->
                        <div class="quote-speaker-wrapper" id="quoteSpeakerWrapper">
                            <div class="quote-speaker-name" id="quoteSpeakerName" contenteditable="true" spellcheck="false">
                                — {{ !empty($post->reporter_name) ? $post->reporter_name : ($post->author_name ?? 'বক্তার নাম') }}
                            </div>
                            <div class="quote-speaker-title" id="quoteSpeakerTitle" contenteditable="true" spellcheck="false">
                                পদবি / পরিচয় এখানে লিখুন
                            </div>
                        </div>
                    </div>

                    <div class="details-hint" id="cardDetailsHint" contenteditable="true" spellcheck="false">
                        বিস্তারিত কমেন্টে......
                    </div>
                </div>

                <!-- Advertisement bottom bar (Default) -->
                <div class="full-width-ad-bar" id="main_ad_bar">
                    <img id="mainAdImage" src="{{ asset('BJ_Content/ads.png') }}" alt="Default Ad" crossorigin="anonymous">
                </div>

                <!-- Official Brand Website Strip (Alternative to Ad Bar) -->
                <div class="official-brand-footer" id="official_brand_footer" style="display: none;">
                    <div class="brand-footer-left">
                        <img id="brandFooterLogoImg" src="{{ !empty($themeSettings['logo_image']) ? asset($themeSettings['logo_image']) : asset('BJ_Content/Text Logo.png') }}" class="brand-footer-watermark-logo" alt="Daily Bhola Journal" crossorigin="anonymous">
                    </div>
                    <div class="brand-footer-center">
                        <div class="brand-pill-badge website-pill">
                            <div class="pill-icon-box web-icon"><i class="fa-solid fa-globe"></i></div>
                            <span class="brand-pill-text" id="brandFooterWebText" contenteditable="true" spellcheck="false" title="ক্লিক করে ওয়েবসাইট লিংক পরিবর্তন করুন">{{ $cardSettings['brand_web'] ?? 'dailybholajournal.com' }}</span>
                        </div>
                    </div>
                    <div class="brand-footer-right">
                        <div class="brand-pill-badge social-pill">
                            <div class="d-flex align-items-center gap-1">
                                <div class="pill-icon-box fb-icon" title="ফেসবুক"><i class="fa-brands fa-facebook-f"></i></div>
                                <div class="pill-icon-box yt-icon" title="ইউটিউব"><i class="fa-brands fa-youtube"></i></div>
                            </div>
                            <span class="brand-pill-text" id="brandFooterFbText" contenteditable="true" spellcheck="false" title="ক্লিক করে সোশ্যাল হ্যান্ডেল পরিবর্তন করুন">{{ $cardSettings['brand_social'] ?? '/dailybholajournalBN' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
