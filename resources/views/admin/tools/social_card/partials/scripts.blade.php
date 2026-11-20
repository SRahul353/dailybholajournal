<!-- html2canvas Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    // Saved settings from server
    const serverCardSettings = @json($cardSettings);
    const saveSettingsRoute = "{{ route('admin.tools.social-card.settings') }}";
    const csrfToken = "{{ csrf_token() }}";

    // Pre-populate background image sources from database values
    let featuredImageSrc = '{{ $post->featured_image ? $post->featured_image_url : "" }}';
    let socialCardImageSrc = '{{ $post->social_card_image ? $post->social_card_image_url : "" }}';

    // Convert date numbers to Bengali numerals
    function toBengaliDigits(num) {
        const bnDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return num.toString().replace(/[0-9]/g, w => bnDigits[+w]);
    }

    // Format and inject dynamic Bengali Date
    function updateBengaliDate() {
        const monthNames = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
        const dayNames = ['রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'শনিবার'];
        const d = new Date('{{ $post->created_at ? $post->created_at->toIso8601String() : "" }}' || new Date());
        const bnDayName = dayNames[d.getDay()];
        const bnDay = toBengaliDigits(d.getDate());
        const bnMonth = monthNames[d.getMonth()];
        const bnYear = toBengaliDigits(d.getFullYear());
        const formattedDate = `${bnDayName}, ${bnDay} ${bnMonth}, ${bnYear}`;
        
        const dateEl = document.getElementById('cardDatePreview');
        if (dateEl) {
            dateEl.innerText = formattedDate;
        }
        const dateStackEl = document.getElementById('cardDatePreviewStack');
        if (dateStackEl) {
            dateStackEl.innerText = formattedDate;
        }
    }

    // Font selection logic
    function changeFontFamily(fontName) {
        const selection = window.getSelection();
        if (selection.rangeCount > 0 && selection.toString().length > 0) {
            document.execCommand("fontName", false, fontName);
        } else {
            const target = document.getElementById('editable_headline');
            if (target) {
                target.style.fontFamily = fontName;
            }
            const quoteTarget = document.getElementById('editable_quote_text');
            if (quoteTarget) {
                quoteTarget.style.fontFamily = fontName;
            }
            const breakingExcerptTarget = document.getElementById('editable_breaking_excerpt');
            if (breakingExcerptTarget) {
                breakingExcerptTarget.style.fontFamily = fontName;
            }
            const switcher = document.getElementById('font_switcher');
            if (switcher) switcher.value = fontName;
            const modalSwitcher = document.getElementById('modal_font_switcher');
            if (modalSwitcher && modalSwitcher.value !== fontName) modalSwitcher.value = fontName;
        }
    }

    // Font color logic
    function changeSelectedColor(color) {
        document.execCommand('styleWithCSS', false, true); 
        document.execCommand('foreColor', false, color);
        const picker = document.getElementById('colorPicker');
        if (picker) picker.value = color;
    }

    // Apply quick brand color swatches
    function applyQuickColor(color) {
        changeSelectedColor(color);
    }

    // Font size logic (called by range slider)
    function updateFontSize(size) {
        const badge = document.getElementById('fontSizeBadge');
        if (badge) badge.innerText = size + 'px';
        
        const slider = document.getElementById('fontSizeSlider');
        if (slider) slider.value = size;

        const modalSlider = document.getElementById('modalFontSizeSlider');
        const modalBadge = document.getElementById('modalFontSizeBadge');
        if (modalSlider && modalSlider.value != size) modalSlider.value = size;
        if (modalBadge) modalBadge.innerText = size + 'px';

        const selection = window.getSelection();
        if (selection.rangeCount > 0 && selection.toString().length > 0) {
            document.execCommand("fontSize", false, "7"); 
            const fontElements = document.querySelectorAll("font[size='7']");
            fontElements.forEach(el => {
                el.removeAttribute("size");
                el.style.fontSize = size + "px";
            });
        } else {
            const target = document.getElementById('editable_headline');
            if (target) target.style.fontSize = size + 'px';
            const quoteTarget = document.getElementById('editable_quote_text');
            if (quoteTarget) {
                const quoteSize = Math.max(24, parseInt(size) - 14);
                quoteTarget.style.fontSize = quoteSize + 'px';
            }
            const breakingExcerptTarget = document.getElementById('editable_breaking_excerpt');
            if (breakingExcerptTarget) {
                const excerptSize = Math.max(18, Math.round(parseInt(size) * 0.52));
                breakingExcerptTarget.style.fontSize = excerptSize + 'px';
            }
        }
    }

    // Base font size logic (for back-compatibility)
    function changeFontSize(size) {
        updateFontSize(size);
    }

    // Line height logic
    function updateLineHeight(val) {
        const badge = document.getElementById('lineHeightBadge');
        if (badge) badge.innerText = val;
        
        const slider = document.getElementById('lineHeightSlider');
        if (slider) slider.value = val;

        const modalSlider = document.getElementById('modalLineHeightSlider');
        const modalBadge = document.getElementById('modalLineHeightBadge');
        if (modalSlider && modalSlider.value != val) modalSlider.value = val;
        if (modalBadge) modalBadge.innerText = val;

        const target = document.getElementById('editable_headline');
        if (target) target.style.lineHeight = val;
        const quoteTarget = document.getElementById('editable_quote_text');
        if (quoteTarget) quoteTarget.style.lineHeight = (parseFloat(val) + 0.25);
    }

    // Base line height logic (for back-compatibility)
    function changeLineHeight(val) {
        updateLineHeight(val);
    }

    // Card Theme Color Presets & Management
    const cardThemes = {
        crimson: {
            bg: 'linear-gradient(160deg, #990000 0%, #3a0000 100%)',
            posterBg: 'linear-gradient(to top, rgba(58, 0, 0, 0.98) 0%, rgba(58, 0, 0, 0.92) 10%, rgba(153, 0, 0, 0.65) 18%, rgba(153, 0, 0, 0.20) 25%, transparent 30%)',
            breakingBg: 'linear-gradient(160deg, #450a0a 0%, #1c0505 100%)',
            dateColor: '#ffd700',
            borderColor: '#ffd700',
            headlineColor: '#ffffff'
        },
        midnight: {
            bg: 'linear-gradient(160deg, #18181b 0%, #09090b 100%)',
            posterBg: 'linear-gradient(to top, rgba(9, 9, 11, 0.98) 0%, rgba(9, 9, 11, 0.92) 10%, rgba(24, 24, 27, 0.65) 18%, rgba(24, 24, 27, 0.20) 25%, transparent 30%)',
            breakingBg: 'linear-gradient(160deg, #27272a 0%, #09090b 100%)',
            dateColor: '#ef4444',
            borderColor: '#dc2626',
            headlineColor: '#ffffff'
        },
        navy: {
            bg: 'linear-gradient(160deg, #1e293b 0%, #0a0f1d 100%)',
            posterBg: 'linear-gradient(to top, rgba(10, 15, 29, 0.98) 0%, rgba(10, 15, 29, 0.92) 10%, rgba(30, 41, 59, 0.65) 18%, rgba(30, 41, 59, 0.20) 25%, transparent 30%)',
            breakingBg: 'linear-gradient(160deg, #1e293b 0%, #050a14 100%)',
            dateColor: '#f59e0b',
            borderColor: '#ef4444',
            headlineColor: '#ffffff'
        },
        royal: {
            bg: 'linear-gradient(160deg, #1e3a8a 0%, #0f172a 100%)',
            posterBg: 'linear-gradient(to top, rgba(15, 23, 42, 0.98) 0%, rgba(15, 23, 42, 0.92) 10%, rgba(30, 58, 138, 0.65) 18%, rgba(30, 58, 138, 0.20) 25%, transparent 30%)',
            breakingBg: 'linear-gradient(160deg, #1e3a8a 0%, #091024 100%)',
            dateColor: '#38bdf8',
            borderColor: '#38bdf8',
            headlineColor: '#ffffff'
        },
        emerald: {
            bg: 'linear-gradient(160deg, #064e3b 0%, #022c22 100%)',
            posterBg: 'linear-gradient(to top, rgba(2, 44, 34, 0.98) 0%, rgba(2, 44, 34, 0.92) 10%, rgba(6, 78, 59, 0.65) 18%, rgba(6, 78, 59, 0.20) 25%, transparent 30%)',
            breakingBg: 'linear-gradient(160deg, #064e3b 0%, #021a14 100%)',
            dateColor: '#34d399',
            borderColor: '#10b981',
            headlineColor: '#ffffff'
        },
        maroon: {
            bg: 'linear-gradient(160deg, #581c87 0%, #2e1065 100%)',
            posterBg: 'linear-gradient(to top, rgba(46, 16, 101, 0.98) 0%, rgba(46, 16, 101, 0.92) 10%, rgba(88, 28, 135, 0.65) 18%, rgba(88, 28, 135, 0.20) 25%, transparent 30%)',
            breakingBg: 'linear-gradient(160deg, #581c87 0%, #1e0538 100%)',
            dateColor: '#f472b6',
            borderColor: '#e11d48',
            headlineColor: '#ffffff'
        }
    };

    let currentCardStyle = '{{ $cardSettings["card_style"] ?? "classic" }}';
    let currentThemeKey = '{{ $cardSettings["theme_key"] ?? "royal" }}';

    // Per-style settings and state
    const defaultStyleSettings = {
        classic: { logo_visible: true, logo_image: '', logo_position: 'right', logo_size: 135, watermark_visible: true, badge_visible: true, date_visible: true, hint_visible: true, footer_visible: true },
        poster: { logo_visible: true, logo_image: '', logo_position: 'right', logo_size: 120, watermark_visible: false, badge_visible: false, date_visible: true, hint_visible: false, footer_visible: false },
        quote: { logo_visible: true, logo_image: '', logo_position: 'right', logo_size: 120, watermark_visible: true, badge_visible: false, date_visible: true, hint_visible: true, footer_visible: false, quote_symbol_visible: true, speaker_visible: true },
        breaking: { logo_visible: true, logo_image: '', logo_position: 'right', logo_size: 120, watermark_visible: true, badge_visible: false, date_visible: true, hint_visible: true, footer_visible: false, excerpt_visible: true }
    };
    let currentStyleSettings = @json($cardSettings['style_settings'] ?? []);
    if (!currentStyleSettings || typeof currentStyleSettings !== 'object' || Array.isArray(currentStyleSettings)) {
        currentStyleSettings = {};
    }
    for (const k of ['classic', 'poster', 'quote', 'breaking']) {
        currentStyleSettings[k] = Object.assign({}, defaultStyleSettings[k], currentStyleSettings[k] || {});
    }
    const styleLogoFiles = {};
    const resetStyleLogoFlags = {};

    function toggleStyleObject(sKey, objKey, isChecked) {
        if (!currentStyleSettings[sKey]) currentStyleSettings[sKey] = {};
        currentStyleSettings[sKey][objKey] = isChecked;
        if (currentCardStyle === sKey) {
            applyStyleObjectSettings(sKey);
            if (objKey === 'logo_visible') {
                const masterToggle = document.getElementById('toggleCornerLogo');
                if (masterToggle) masterToggle.checked = isChecked;
            }
            if (objKey === 'watermark_visible') {
                const masterToggle = document.getElementById('toggleWatermark');
                if (masterToggle) masterToggle.checked = isChecked;
            }
            if (objKey === 'badge_visible') {
                const masterToggle = document.getElementById('toggleCategoryBadge');
                if (masterToggle) masterToggle.checked = isChecked;
            }
            if (objKey === 'hint_visible') {
                const masterToggle = document.getElementById('toggleDetailsHint');
                if (masterToggle) masterToggle.checked = isChecked;
            }
        }
    }

    function setStyleLogoPosition(sKey, pos) {
        if (!currentStyleSettings[sKey]) currentStyleSettings[sKey] = {};
        currentStyleSettings[sKey]['logo_position'] = pos;
        if (currentCardStyle === sKey) {
            applyStyleObjectSettings(sKey);
            const lRadio = document.getElementById('logoPosLeft');
            const rRadio = document.getElementById('logoPosRight');
            if (pos === 'left' && lRadio) lRadio.checked = true;
            if (pos === 'right' && rRadio) rRadio.checked = true;
            if (sKey === 'poster') {
                const metaRow = document.getElementById('cardMetaRow');
                if (metaRow) {
                    metaRow.style.setProperty('justify-content', pos === 'left' ? 'flex-end' : 'flex-start', 'important');
                }
            }
        }
    }

    function setStyleLogoSize(sKey, size) {
        size = parseInt(size, 10) || 135;
        if (!currentStyleSettings[sKey]) currentStyleSettings[sKey] = {};
        currentStyleSettings[sKey]['logo_size'] = size;

        const badge = document.getElementById('style_logo_size_badge_' + sKey);
        if (badge) badge.innerText = size + 'px';

        const slider = document.getElementById('style_logo_size_slider_' + sKey);
        if (slider) slider.value = size;

        if (currentCardStyle === sKey) {
            const img = document.getElementById('cornerLogoImg');
            if (img) {
                img.style.width = size + 'px';
                img.style.height = size + 'px';
            }
            const masterSlider = document.getElementById('cornerLogoSizeSlider');
            const masterBadge = document.getElementById('cornerLogoSizeBadge');
            if (masterSlider) masterSlider.value = size;
            if (masterBadge) masterBadge.innerText = size + 'px';
        }
    }

    function previewStyleLogo(sKey, input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            styleLogoFiles[sKey] = file;
            delete resetStyleLogoFlags[sKey];
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('styleLogoPreview_' + sKey);
                if (previewImg) previewImg.src = e.target.result;
                const logoBox = document.getElementById('styleLogoBox_' + sKey);
                const noLogoBox = document.getElementById('styleNoLogoBox_' + sKey);
                if (logoBox) logoBox.style.display = '';
                if (noLogoBox) noLogoBox.style.display = 'none';
                if (!currentStyleSettings[sKey]) currentStyleSettings[sKey] = {};
                currentStyleSettings[sKey].logo_image_preview = e.target.result;
                if (currentCardStyle === sKey) {
                    applyStyleObjectSettings(sKey);
                }
            };
            reader.readAsDataURL(file);
        }
    }

    function resetStyleLogo(sKey) {
        delete styleLogoFiles[sKey];
        resetStyleLogoFlags[sKey] = true;
        if (currentStyleSettings[sKey]) {
            currentStyleSettings[sKey].logo_image = '';
            delete currentStyleSettings[sKey].logo_image_preview;
        }
        if (sKey === 'poster') {
            const logoBox = document.getElementById('styleLogoBox_' + sKey);
            const noLogoBox = document.getElementById('styleNoLogoBox_' + sKey);
            if (logoBox) logoBox.style.display = 'none';
            if (noLogoBox) noLogoBox.style.display = 'flex';
        } else {
            const defaultCornerLogo = "{{ !empty($cardSettings['corner_logo_image']) ? asset($cardSettings['corner_logo_image']) : asset('BJ_Content/Profile Pic b.png') }}";
            const previewImg = document.getElementById('styleLogoPreview_' + sKey);
            if (previewImg) previewImg.src = defaultCornerLogo;
            const logoBox = document.getElementById('styleLogoBox_' + sKey);
            const noLogoBox = document.getElementById('styleNoLogoBox_' + sKey);
            if (logoBox) logoBox.style.display = '';
            if (noLogoBox) noLogoBox.style.display = 'none';
        }
        const fileInput = document.getElementById('style_logo_input_' + sKey);
        if (fileInput) fileInput.value = '';
        if (currentCardStyle === sKey) {
            applyStyleObjectSettings(sKey);
        }
    }

    function applyStyleObjectSettings(styleKey) {
        if (!styleKey) styleKey = currentCardStyle || 'classic';
        const cfg = currentStyleSettings[styleKey] || defaultStyleSettings[styleKey] || {};
        const cardNode = document.getElementById('social_card_node');
        if (!cardNode) return;

        // 1. Logo & Brand-Date Stack
        const cardBrandDateStack = document.getElementById('cardBrandDateStack');
        const cardTopLogo = document.getElementById('cardTopLogo');
        const cornerLogoImg = document.getElementById('cornerLogoImg');
        const metaRowStack = document.getElementById('cardMetaRowStack');

        const isLogoVis = cfg.hasOwnProperty('logo_visible') ? !!cfg.logo_visible : true;
        const isDateVis = cfg.hasOwnProperty('date_visible') ? !!cfg.date_visible : true;

        if (cardBrandDateStack) {
            if (styleKey === 'poster' || styleKey === 'quote' || styleKey === 'breaking') {
                const showStack = isLogoVis || isDateVis;
                cardBrandDateStack.style.setProperty('display', showStack ? 'flex' : 'none', 'important');
                if (metaRowStack) {
                    metaRowStack.style.setProperty('display', isDateVis ? 'flex' : 'none', 'important');
                }
            } else {
                cardBrandDateStack.style.setProperty('display', 'contents', 'important');
                if (metaRowStack) {
                    metaRowStack.style.setProperty('display', 'none', 'important');
                }
            }
        }

        if (cardTopLogo) {
            cardTopLogo.style.setProperty('display', isLogoVis ? 'flex' : 'none', 'important');
            if (styleKey === 'classic') {
                const pos = cfg.logo_position || 'right';
                if (pos === 'left') {
                    cardTopLogo.style.setProperty('left', '45px', 'important');
                    cardTopLogo.style.setProperty('right', 'auto', 'important');
                } else {
                    cardTopLogo.style.setProperty('right', '45px', 'important');
                    cardTopLogo.style.setProperty('left', 'auto', 'important');
                }
            }
        }
        if (cornerLogoImg) {
            const defaultLogo = "{{ !empty($cardSettings['corner_logo_image']) ? asset($cardSettings['corner_logo_image']) : asset('BJ_Content/Profile Pic b.png') }}";
            if (cfg.logo_image_preview) {
                cornerLogoImg.src = cfg.logo_image_preview;
            } else if (cfg.logo_image) {
                const src = (cfg.logo_image.startsWith('http') || cfg.logo_image.startsWith('/')) ? cfg.logo_image : ('/' + cfg.logo_image);
                cornerLogoImg.src = src;
            } else {
                if (cornerLogoImg.dataset.masterSrc) {
                    cornerLogoImg.src = cornerLogoImg.dataset.masterSrc;
                } else {
                    cornerLogoImg.src = defaultLogo;
                }
            }

            // Apply style logo size: 120px width for poster, quote & breaking
            if (styleKey === 'poster' || styleKey === 'quote' || styleKey === 'breaking') {
                cornerLogoImg.style.width = '120px';
                cornerLogoImg.style.height = 'auto';
            } else {
                const logoSize = cfg.logo_size || (serverCardSettings && serverCardSettings.corner_logo_size) || 135;
                cornerLogoImg.style.width = logoSize + 'px';
                cornerLogoImg.style.height = logoSize + 'px';
            }

            const masterSizeSlider = document.getElementById('cornerLogoSizeSlider');
            const masterSizeBadge = document.getElementById('cornerLogoSizeBadge');
            if (masterSizeSlider) masterSizeSlider.value = (styleKey === 'classic') ? (cfg.logo_size || 135) : 120;
            if (masterSizeBadge) masterSizeBadge.innerText = ((styleKey === 'classic') ? (cfg.logo_size || 135) : 120) + 'px';

            const styleSlider = document.getElementById('style_logo_size_slider_' + styleKey);
            const styleBadge = document.getElementById('style_logo_size_badge_' + styleKey);
            if (styleSlider) styleSlider.value = (styleKey === 'classic') ? (cfg.logo_size || 135) : 120;
            if (styleBadge) styleBadge.innerText = ((styleKey === 'classic') ? (cfg.logo_size || 135) : 120) + 'px';
        }

        // 2. Watermark
        const watermark = document.getElementById('cardWatermarkImg');
        if (watermark) {
            const isWatermarkVis = cfg.hasOwnProperty('watermark_visible') ? !!cfg.watermark_visible : (styleKey !== 'poster');
            watermark.style.setProperty('display', isWatermarkVis ? 'block' : 'none', 'important');
        }

        // 3. Reporter Badge
        const badgeWrapper = document.getElementById('reporterBadgeWrapper');
        if (badgeWrapper) {
            const isBadgeVis = cfg.hasOwnProperty('badge_visible') ? !!cfg.badge_visible : false;
            badgeWrapper.style.setProperty('display', isBadgeVis ? 'flex' : 'none', 'important');
        }

        // 4. Date bar
        const metaRow = document.getElementById('cardMetaRow');
        if (metaRow) {
            const isDateVis = cfg.hasOwnProperty('date_visible') ? !!cfg.date_visible : true;
            metaRow.style.setProperty('display', isDateVis ? 'flex' : 'none', 'important');

            if (styleKey === 'poster') {
                const pos = cfg.logo_position || 'right';
                metaRow.style.setProperty('justify-content', pos === 'left' ? 'flex-end' : 'flex-start', 'important');
            } else if (styleKey === 'classic') {
                metaRow.style.setProperty('justify-content', 'flex-start', 'important');
            } else if (styleKey === 'quote' || styleKey === 'breaking') {
                metaRow.style.setProperty('justify-content', 'flex-end', 'important');
            }
        }

        // 5. Details hint
        const detailsHint = document.getElementById('cardDetailsHint');
        if (detailsHint) {
            const isHintVis = cfg.hasOwnProperty('hint_visible') ? !!cfg.hint_visible : true;
            const displayType = (styleKey === 'quote' || styleKey === 'breaking') ? 'inline-block' : 'block';
            detailsHint.style.setProperty('display', isHintVis ? displayType : 'none', 'important');
        }

        // 6. Footer bar (Ad / Official Brand)
        const adBar = document.getElementById('main_ad_bar');
        const brandBar = document.getElementById('official_brand_footer');
        const isFooterVis = cfg.hasOwnProperty('footer_visible') ? !!cfg.footer_visible : true;
        if (!isFooterVis) {
            if (adBar) adBar.style.setProperty('display', 'none', 'important');
            if (brandBar) brandBar.style.setProperty('display', 'none', 'important');
            cardNode.classList.add('footer-none');
        } else {
            cardNode.classList.toggle('footer-none', currentFooterMode === 'none');
            if (adBar) adBar.style.removeProperty('display');
            if (brandBar) brandBar.style.removeProperty('display');
            if (typeof setFooterMode === 'function') {
                setFooterMode(currentFooterMode);
            }
        }

        // 7. Quote style specifics
        const quoteSymbol = document.getElementById('quoteSymbolBadge');
        if (quoteSymbol) {
            if (styleKey === 'quote') {
                const isSymVis = cfg.quote_symbol_visible !== false;
                quoteSymbol.style.setProperty('display', isSymVis ? 'inline-flex' : 'none', 'important');
            }
        }
        const quoteSpeaker = document.getElementById('quoteSpeakerWrapper');
        if (quoteSpeaker) {
            if (styleKey === 'quote') {
                const isSpkVis = cfg.speaker_visible !== false;
                quoteSpeaker.style.setProperty('display', isSpkVis ? 'flex' : 'none', 'important');
            }
        }

        // 8. Breaking style specifics
        const breakingExcerpt = document.getElementById('editable_breaking_excerpt');
        if (breakingExcerpt) {
            if (styleKey === 'breaking') {
                const isExcVis = cfg.excerpt_visible !== false;
                breakingExcerpt.style.setProperty('display', isExcVis ? 'block' : 'none', 'important');
            }
        }
    }

    function hexToRgb(hex) {
        if (!hex) return { r: 30, g: 58, b: 138 };
        hex = hex.replace('#', '').trim();
        if (hex.length === 3) {
            hex = hex.split('').map(c => c + c).join('');
        }
        const num = parseInt(hex, 16);
        if (isNaN(num)) return { r: 30, g: 58, b: 138 };
        return {
            r: (num >> 16) & 255,
            g: (num >> 8) & 255,
            b: num & 255
        };
    }

    function updateCardBackgroundTheme() {
        const cardNode = document.getElementById('social_card_node');
        const bottomWrapper = document.getElementById('bottomContentWrapper');
        if (!bottomWrapper) return;
        const quoteSymbol = document.getElementById('quoteSymbolBadge');

        if (currentThemeKey !== 'custom' && cardThemes[currentThemeKey]) {
            const theme = cardThemes[currentThemeKey];
            if (currentCardStyle === 'poster') {
                if (cardNode) cardNode.style.removeProperty('background');
                bottomWrapper.style.setProperty('background', theme.posterBg || theme.bg, 'important');
                bottomWrapper.style.borderTopColor = 'transparent';
            } else if (currentCardStyle === 'quote' || currentCardStyle === 'breaking') {
                if (cardNode) cardNode.style.setProperty('background', currentCardStyle === 'breaking' ? (theme.breakingBg || theme.bg) : theme.bg, 'important');
                bottomWrapper.style.setProperty('background', 'transparent', 'important');
                bottomWrapper.style.borderTopColor = 'transparent';
            } else {
                if (cardNode) cardNode.style.removeProperty('background');
                bottomWrapper.style.setProperty('background', theme.bg, 'important');
                bottomWrapper.style.borderTopColor = 'transparent';
            }

            if (quoteSymbol) {
                quoteSymbol.style.color = theme.borderColor || theme.dateColor;
            }
        } else {
            const customHex = document.getElementById('customBgColor') ? document.getElementById('customBgColor').value : '#1e3a8a';
            if (currentCardStyle === 'poster') {
                if (cardNode) cardNode.style.removeProperty('background');
                try {
                    const rgb = hexToRgb(customHex);
                    const posterGrad = `linear-gradient(to top, rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, 0.98) 0%, rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, 0.90) 10%, rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, 0.60) 18%, rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, 0.20) 25%, transparent 30%)`;
                    bottomWrapper.style.setProperty('background', posterGrad, 'important');
                } catch(e) {
                    bottomWrapper.style.setProperty('background', customHex, 'important');
                }
                bottomWrapper.style.borderTopColor = 'transparent';
            } else if (currentCardStyle === 'quote' || currentCardStyle === 'breaking') {
                if (cardNode) cardNode.style.setProperty('background', customHex, 'important');
                bottomWrapper.style.setProperty('background', 'transparent', 'important');
                bottomWrapper.style.borderTopColor = 'transparent';
            } else {
                if (cardNode) cardNode.style.removeProperty('background');
                bottomWrapper.style.setProperty('background', customHex, 'important');
                const borderPicker = document.getElementById('borderColorPicker');
                const bColor = borderPicker ? borderPicker.value : '#38bdf8';
                bottomWrapper.style.borderTopColor = 'transparent';
            }

            const borderPicker = document.getElementById('borderColorPicker');
            const bColor = borderPicker ? borderPicker.value : '#38bdf8';
            if (quoteSymbol) {
                quoteSymbol.style.color = bColor;
            }
        }
    }

    function setCardStyle(styleKey) {
        if (!styleKey) return;
        currentCardStyle = styleKey;
        const cardNode = document.getElementById('social_card_node');
        if (!cardNode) return;

        // Remove previous style classes
        cardNode.classList.remove('style-classic', 'style-poster', 'style-quote', 'style-breaking');
        cardNode.classList.add('style-' + styleKey);

        // Update all style selector buttons / cards active state
        document.querySelectorAll('.style-select-card').forEach(el => {
            el.classList.toggle('active', el.getAttribute('data-style') === styleKey);
        });
        document.querySelectorAll('.modal-style-card').forEach(el => {
            el.classList.toggle('active', el.getAttribute('data-style') === styleKey);
        });
        document.querySelectorAll('.btn-style-pill').forEach(el => {
            el.classList.toggle('active', el.getAttribute('data-style') === styleKey);
        });

        // Activate matching sub-tab in Modal Settings if open or when opened
        const subTabBtn = document.getElementById('subtab-btn-' + styleKey);
        if (subTabBtn && typeof bootstrap !== 'undefined') {
            try {
                const tabTrigger = new bootstrap.Tab(subTabBtn);
                tabTrigger.show();
            } catch(e) {}
        }

        // Date row and watermark logo alignment according to style requirements
        const metaRow = document.getElementById('cardMetaRow');
        const watermark = document.getElementById('cardWatermarkImg');
        if (metaRow) {
            if (styleKey === 'classic') {
                metaRow.style.setProperty('justify-content', 'flex-start', 'important');
            } else if (styleKey === 'quote' || styleKey === 'breaking') {
                metaRow.style.setProperty('justify-content', 'flex-end', 'important');
            } else if (styleKey === 'poster') {
                const sCfg = (currentStyleSettings && currentStyleSettings['poster']) || {};
                const logoPos = sCfg.logo_position || (document.getElementById('style_pos_left_poster') && document.getElementById('style_pos_left_poster').checked ? 'left' : (document.getElementById('logoPosLeft') && document.getElementById('logoPosLeft').checked ? 'left' : 'right'));
                metaRow.style.setProperty('justify-content', logoPos === 'left' ? 'flex-end' : 'flex-start', 'important');
            } else {
                const isLeft = document.getElementById('alignLeftBtn') && document.getElementById('alignLeftBtn').classList.contains('active');
                metaRow.style.justifyContent = isLeft ? 'flex-start' : 'center';
            }
        }
        if (watermark) {
            if (styleKey === 'poster') {
                const isLeft = document.getElementById('logoPosLeft') && document.getElementById('logoPosLeft').checked;
                watermark.style.setProperty('align-self', isLeft ? 'flex-start' : 'flex-end', 'important');
            } else {
                watermark.style.removeProperty('align-self');
            }
        }

        // Adjust wrapper sizing
        const bottomWrapper = document.getElementById('bottomContentWrapper');
        if (bottomWrapper) {
            if (styleKey === 'poster' || styleKey === 'quote' || styleKey === 'breaking') {
                bottomWrapper.style.removeProperty('height');
                bottomWrapper.style.removeProperty('flex');
            } else {
                if (typeof setFooterMode === 'function') {
                    setFooterMode(currentFooterMode);
                }
            }
        }

        // Dynamically update card background for the active style
        updateCardBackgroundTheme();

        // Toggle inspector headline vs quote vs breaking input panels
        const headlineGroup = document.getElementById('headlineControlGroup');
        const breakingExcerptGroup = document.getElementById('breakingExcerptControlGroup');
        const quoteGroup = document.getElementById('quoteSidebarControls');
        const quoteSpeakerFields = document.getElementById('quoteSpeakerFields');
        const photoModeLabel = document.getElementById('photoModeLabel');
        const photoUploadSubtext = document.getElementById('photoUploadSubtext');

        if (headlineGroup) {
            headlineGroup.style.display = (styleKey === 'quote') ? 'none' : 'block';
        }
        if (breakingExcerptGroup) {
            breakingExcerptGroup.style.display = (styleKey === 'breaking') ? 'block' : 'none';
        }
        if (quoteGroup) {
            quoteGroup.style.display = (styleKey === 'quote' || styleKey === 'breaking') ? 'block' : 'none';
        }
        if (quoteSpeakerFields) {
            quoteSpeakerFields.style.display = (styleKey === 'quote') ? 'block' : 'none';
        }
        if (photoModeLabel) {
            photoModeLabel.innerText = (styleKey === 'breaking') ? 'নিউজ ছবির মোড (Display Mode)' : 'বক্তার ছবির মোড (Display Mode)';
        }
        if (photoUploadSubtext) {
            photoUploadSubtext.innerText = (styleKey === 'breaking') ? 'সংবাদের সাধারণ ছবি বা স্বচ্ছ কাটআউট PNG ফাইল' : 'সাধারণ ছবি বা স্বচ্ছ কাটআউট PNG ফাইল';
        }

        const imgSecTitle = document.getElementById('imageSectionTitle');
        const bgUploadLabel = document.getElementById('bgUploadLabel');
        const bgUploadPrompt = document.getElementById('bgUploadPrompt');
        if (imgSecTitle) imgSecTitle.innerHTML = `<i class="fa-regular fa-image"></i> ${(styleKey === 'quote' || styleKey === 'breaking') ? 'ছবির মোড ও পজিশন' : 'ছবির ফ্রেম ও পজিশন'}`;
        if (bgUploadLabel) bgUploadLabel.innerText = (styleKey === 'quote' || styleKey === 'breaking') ? 'ছবি পরিবর্তন (PNG Cutout বা সাধারণ)' : 'ব্যাকগ্রাউন্ড ছবি পরিবর্তন';
        if (bgUploadPrompt) bgUploadPrompt.innerText = (styleKey === 'quote' || styleKey === 'breaking') ? 'ছবি / পিএনজি আপলোড করুন' : 'নতুন ব্যাকগ্রাউন্ড আপলোড করুন';

        // Apply quote cutout transform or reset for other styles
        if (typeof updateQuoteImgTransform === 'function') {
            updateQuoteImgTransform();
        }

        if (styleKey === 'quote' || styleKey === 'breaking') {
            const wrapper = document.getElementById('newsImageWrapper');
            if (wrapper) {
                if (typeof isQuoteCutout !== 'undefined' && isQuoteCutout) {
                    wrapper.classList.add('quote-cutout-mode');
                } else {
                    wrapper.classList.remove('quote-cutout-mode');
                }
            }
        } else {
            const wrapper = document.getElementById('newsImageWrapper');
            if (wrapper) {
                wrapper.classList.remove('quote-cutout-mode');
            }
        }

        // Apply per-style custom logo & object visibility settings
        applyStyleObjectSettings(styleKey);

        // Trigger canvas auto-fit resize
        if (typeof resizeCanvasWorkspace === 'function') {
            resizeCanvasWorkspace();
        }
    }

    function applyCardTheme(themeKey) {
        currentThemeKey = themeKey;
        const theme = cardThemes[themeKey];
        if (!theme) return;

        // Update background & style-specific accents
        updateCardBackgroundTheme();

        setCardDateColor(theme.dateColor);
        setCardBorderColor(theme.borderColor);

        // Update active button state
        document.querySelectorAll('.btn-theme-preset').forEach(btn => {
            btn.classList.toggle('active', btn.getAttribute('data-theme') === themeKey);
        });
        document.querySelectorAll('.modal-theme-btn').forEach(btn => {
            btn.classList.toggle('active', btn.getAttribute('data-modal-theme') === themeKey);
        });

        // Update color inputs
        const bgPicker = document.getElementById('customBgColor');
        const bgHex = document.getElementById('customBgHex');
        const modalBg = document.getElementById('modalCustomBgColor');
        const modalBgHex = document.getElementById('modalCustomBgHex');
        const defaultHexes = {
            crimson: '#990000',
            midnight: '#18181b',
            navy: '#1e293b',
            royal: '#1e3a8a',
            emerald: '#064e3b',
            maroon: '#581c87'
        };
        if (defaultHexes[themeKey]) {
            if (bgPicker) bgPicker.value = defaultHexes[themeKey];
            if (bgHex) bgHex.value = defaultHexes[themeKey];
            if (modalBg) modalBg.value = defaultHexes[themeKey];
            if (modalBgHex) modalBgHex.innerText = defaultHexes[themeKey];
        }
    }

    function setCustomCardBg(color) {
        if (!color) return;
        currentThemeKey = 'custom';
        const bgPicker = document.getElementById('customBgColor');
        const bgHex = document.getElementById('customBgHex');
        const modalBg = document.getElementById('modalCustomBgColor');
        const modalBgHex = document.getElementById('modalCustomBgHex');
        if (bgPicker && bgPicker.value !== color && color.startsWith('#')) bgPicker.value = color;
        if (bgHex && bgHex.value !== color) bgHex.value = color;
        if (modalBg && modalBg.value !== color && color.startsWith('#')) modalBg.value = color;
        if (modalBgHex && modalBgHex.innerText !== color) modalBgHex.innerText = color;

        // Apply background dynamically
        updateCardBackgroundTheme();

        // remove active class from presets
        document.querySelectorAll('.btn-theme-preset').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.modal-theme-btn').forEach(btn => btn.classList.remove('active'));
    }

    function setCardDateColor(color) {
        if (!color) return;
        const dateEl = document.getElementById('cardDatePreview');
        const hintEl = document.getElementById('cardDetailsHint');
        const dateIcon = document.getElementById('cardDateIcon');
        if (dateEl) dateEl.style.color = color;
        if (hintEl) hintEl.style.color = color;
        if (dateIcon) dateIcon.style.color = color;
        const dateStackEl = document.getElementById('cardDatePreviewStack');
        const dateStackIcon = document.getElementById('cardDateIconStack');
        if (dateStackEl) dateStackEl.style.color = color;
        if (dateStackIcon) dateStackIcon.style.color = color;

        const datePicker = document.getElementById('dateColorPicker');
        if (datePicker && color.startsWith('#')) datePicker.value = color;
        const modalDatePicker = document.getElementById('modalDateColorPicker');
        const modalDateHex = document.getElementById('modalDateHex');
        if (modalDatePicker && color.startsWith('#') && modalDatePicker.value !== color) modalDatePicker.value = color;
        if (modalDateHex) modalDateHex.innerText = color;
    }

    function setCardBorderColor(color) {
        if (!color) return;
        const adBar = document.getElementById('main_ad_bar');
        const brandBar = document.getElementById('official_brand_footer');
        const bottomWrapper = document.getElementById('bottomContentWrapper');
        const quoteSymbol = document.getElementById('quoteSymbolBadge');

        if (adBar) adBar.style.borderTopColor = color;
        if (brandBar) brandBar.style.borderTopColor = color;
        if (bottomWrapper && (currentCardStyle === 'quote' || currentCardStyle === 'breaking')) {
            bottomWrapper.style.borderTopColor = color;
        }
        if (quoteSymbol) quoteSymbol.style.color = color;

        const borderPicker = document.getElementById('borderColorPicker');
        if (borderPicker && color.startsWith('#')) borderPicker.value = color;
        const modalBorderPicker = document.getElementById('modalBorderColorPicker');
        const modalBorderHex = document.getElementById('modalBorderHex');
        if (modalBorderPicker && color.startsWith('#') && modalBorderPicker.value !== color) modalBorderPicker.value = color;
        if (modalBorderHex) modalBorderHex.innerText = color;
    }

    // Modal Synchronization Helpers
    function applyModalTheme(themeKey) {
        applyCardTheme(themeKey);
    }

    function syncCustomBg(color) {
        setCustomCardBg(color);
        const hex = document.getElementById('modalCustomBgHex');
        if (hex) hex.innerText = color;
    }

    function syncBorderColor(color) {
        setCardBorderColor(color);
        const hex = document.getElementById('modalBorderHex');
        if (hex) hex.innerText = color;
    }

    function syncDateColor(color) {
        setCardDateColor(color);
        const hex = document.getElementById('modalDateHex');
        if (hex) hex.innerText = color;
    }

    function syncFontFamily(font) {
        changeFontFamily(font);
        const ins = document.getElementById('font_switcher');
        if (ins && ins.value !== font) ins.value = font;
    }

    function syncFontSize(val) {
        updateFontSize(val);
        const ins = document.getElementById('fontSizeSlider');
        const badge = document.getElementById('modalFontSizeBadge');
        if (ins && ins.value != val) ins.value = val;
        if (badge) badge.innerText = val + 'px';
    }

    function syncLineHeight(val) {
        updateLineHeight(val);
        const ins = document.getElementById('lineHeightSlider');
        const badge = document.getElementById('modalLineHeightBadge');
        if (ins && ins.value != val) ins.value = val;
        if (badge) badge.innerText = val;
    }

    function syncHeadlineAlign(align) {
        setHeadlineAlignment(align);
        const btnL = document.getElementById('modalAlignLeftBtn');
        const btnC = document.getElementById('modalAlignCenterBtn');
        if (btnL) btnL.classList.toggle('active', align === 'left');
        if (btnC) btnC.classList.toggle('active', align === 'center');
    }

    function syncQuoteMode(mode) {
        if (typeof setQuotePhotoMode === 'function') {
            setQuotePhotoMode(mode);
        }
        const btnN = document.getElementById('modalQuoteModeNormal');
        const btnC = document.getElementById('modalQuoteModeCutout');
        if (btnN) btnN.classList.toggle('active', mode === 'normal');
        if (btnC) btnC.classList.toggle('active', mode === 'cutout');
    }

    // ----------------------------------------------------
    // Settings Modal Functions: Logo, Ads, Footer & Layout
    // ----------------------------------------------------

    let resetCornerLogoFlag = false;
    let resetWatermarkFlag = false;
    let resetAdFlag = false;

    // 1. Corner Profile Logo Controls
    const defaultCornerLogoSrc = "{{ asset('BJ_Content/Profile Pic b.png') }}";

    function toggleCornerLogoVisibility(visible) {
        const logo = document.getElementById('cardTopLogo');
        if (logo) logo.style.display = visible ? 'flex' : 'none';
    }

    function setCornerLogoPosition(pos) {
        const logo = document.getElementById('cardTopLogo');
        if (logo) {
            if (pos === 'left') {
                logo.style.right = 'auto';
                logo.style.left = '50px';
            } else {
                logo.style.left = 'auto';
                logo.style.right = '50px';
            }
        }
        if (currentCardStyle && currentStyleSettings[currentCardStyle]) {
            currentStyleSettings[currentCardStyle]['logo_position'] = pos;
            const subLeft = document.getElementById('style_pos_left_' + currentCardStyle);
            const subRight = document.getElementById('style_pos_right_' + currentCardStyle);
            if (pos === 'left' && subLeft) subLeft.checked = true;
            if (pos === 'right' && subRight) subRight.checked = true;
        }
        const metaRow = document.getElementById('cardMetaRow');
        const watermark = document.getElementById('cardWatermarkImg');
        if (currentCardStyle === 'poster') {
            if (metaRow) {
                metaRow.style.setProperty('justify-content', pos === 'left' ? 'flex-end' : 'flex-start', 'important');
            }
            if (watermark) {
                watermark.style.setProperty('align-self', pos === 'left' ? 'flex-start' : 'flex-end', 'important');
            }
        }
    }

    function setCornerLogoSize(size) {
        size = parseInt(size, 10) || 135;
        const img = document.getElementById('cornerLogoImg');
        const badge = document.getElementById('cornerLogoSizeBadge');
        if (img) {
            img.style.width = size + 'px';
            img.style.height = size + 'px';
        }
        if (badge) badge.innerText = size + 'px';

        // Keep current style's slider and badge in sync
        if (currentStyleSettings[currentCardStyle]) {
            currentStyleSettings[currentCardStyle].logo_size = size;
            const styleSlider = document.getElementById('style_logo_size_slider_' + currentCardStyle);
            const styleBadge = document.getElementById('style_logo_size_badge_' + currentCardStyle);
            if (styleSlider) styleSlider.value = size;
            if (styleBadge) styleBadge.innerText = size + 'px';
        }
    }

    function toggleCornerLogoShadow(enable) {
        const img = document.getElementById('cornerLogoImg');
        if (img) {
            img.classList.toggle('logo-shadow-effect', !!enable);
            img.classList.toggle('no-shadow', !enable);
        }
    }

    function toggleCornerLogo3DBorder(enable) {
        toggleCornerLogoShadow(enable);
    }

    function previewCornerLogo(input) {
        if (input.files && input.files[0]) {
            resetCornerLogoFlag = false;
            const reader = new FileReader();
            reader.onload = function(e) {
                const cornerImg = document.getElementById('cornerLogoImg');
                const previewImg = document.getElementById('cornerLogoPreviewImg');
                const brandFooterImg = document.getElementById('brandFooterLogoImg');
                if (cornerImg) cornerImg.src = e.target.result;
                if (previewImg) previewImg.src = e.target.result;
                if (brandFooterImg) brandFooterImg.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetCornerLogo() {
        const cornerImg = document.getElementById('cornerLogoImg');
        const previewImg = document.getElementById('cornerLogoPreviewImg');
        const brandFooterImg = document.getElementById('brandFooterLogoImg');
        if (cornerImg) cornerImg.src = defaultCornerLogoSrc;
        if (previewImg) previewImg.src = defaultCornerLogoSrc;
        if (brandFooterImg) brandFooterImg.src = defaultCornerLogoSrc;
        const input = document.getElementById('customCornerLogoInput');
        if (input) input.value = '';
        resetCornerLogoFlag = true;
    }

    // 2. Watermark Logo Controls
    const defaultWatermarkSrc = "{{ !empty($themeSettings['logo_image']) ? asset($themeSettings['logo_image']) : (file_exists(public_path('BJ_Content/Text Logo.png')) ? asset('BJ_Content/Text Logo.png') : '') }}";

    function toggleWatermarkVisibility(visible) {
        const watermark = document.getElementById('cardWatermarkImg');
        if (watermark) watermark.style.display = visible ? 'block' : 'none';
    }

    function setWatermarkOpacity(val) {
        const watermark = document.getElementById('cardWatermarkImg');
        const badge = document.getElementById('watermarkOpacityBadge');
        if (watermark) watermark.style.opacity = (val / 100);
        if (badge) badge.innerText = val + '%';
    }

    function previewWatermark(input) {
        if (input.files && input.files[0]) {
            resetWatermarkFlag = false;
            const reader = new FileReader();
            reader.onload = function(e) {
                const watermark = document.getElementById('cardWatermarkImg');
                const preview = document.getElementById('watermarkPreviewImg');
                if (watermark) watermark.src = e.target.result;
                if (preview) preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetWatermark() {
        const watermark = document.getElementById('cardWatermarkImg');
        const preview = document.getElementById('watermarkPreviewImg');
        if (watermark) watermark.src = defaultWatermarkSrc;
        if (preview) preview.src = defaultWatermarkSrc;
        const input = document.getElementById('customWatermarkInput');
        if (input) input.value = '';
        resetWatermarkFlag = true;
    }

    // 3. Footer & Ads Controls
    const defaultAdSrc = "{{ asset('BJ_Content/ads.png') }}";
    let currentFooterMode = 'ad';

    function setFooterMode(mode) {
        currentFooterMode = mode;
        const cardNode = document.getElementById('social_card_node');
        if (cardNode) {
            cardNode.classList.toggle('footer-none', mode === 'none');
        }
        const adBar = document.getElementById('main_ad_bar');
        const brandBar = document.getElementById('official_brand_footer');
        const bottomWrapper = document.getElementById('bottomContentWrapper');
        const adControls = document.getElementById('footerAdControls');
        const brandControls = document.getElementById('footerBrandControls');

        const btnAd = document.getElementById('fModeAd');
        const btnBrand = document.getElementById('fModeBrand');
        const btnNone = document.getElementById('fModeNone');

        if (btnAd) btnAd.classList.toggle('active', mode === 'ad');
        if (btnBrand) btnBrand.classList.toggle('active', mode === 'brand');
        if (btnNone) btnNone.classList.toggle('active', mode === 'none');

        if (adControls) {
            adControls.style.display = mode === 'ad' ? 'block' : 'none';
        }
        if (brandControls) {
            brandControls.style.display = mode === 'brand' ? 'block' : 'none';
        }

        if (mode === 'ad') {
            if (adBar) adBar.style.display = 'flex';
            if (brandBar) brandBar.style.display = 'none';
            if (bottomWrapper && currentCardStyle !== 'poster') {
                bottomWrapper.style.flex = '0 0 332px';
                bottomWrapper.style.height = '332px';
            }
        } else if (mode === 'brand') {
            if (adBar) adBar.style.display = 'none';
            if (brandBar) brandBar.style.display = 'flex';
            if (bottomWrapper && currentCardStyle !== 'poster') {
                bottomWrapper.style.flex = '0 0 332px';
                bottomWrapper.style.height = '332px';
            }
        } else { // 'none'
            if (adBar) adBar.style.display = 'none';
            if (brandBar) brandBar.style.display = 'none';
            if (bottomWrapper && currentCardStyle !== 'poster') {
                bottomWrapper.style.flex = '0 0 432px';
                bottomWrapper.style.height = '432px';
            }
        }
    }

    function updateBrandFooterTitle(val) {
        const titleEl = document.getElementById('brandFooterTitleText');
        if (titleEl) titleEl.innerText = val.trim() || 'দৈনিক ভোলা জার্নাল';
    }

    function updateBrandFooterTagline(val) {
        const taglineEl = document.getElementById('brandFooterTaglineText');
        if (taglineEl) taglineEl.innerText = val.trim() || 'সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর';
    }

    function updateBrandFooterWeb(val) {
        const webEl = document.getElementById('brandFooterWebText');
        if (webEl) webEl.innerText = val.trim() || 'dailybholajournal.com';
    }

    function updateBrandFooterSocial(val) {
        const socialEl = document.getElementById('brandFooterFbText');
        if (socialEl) socialEl.innerText = val.trim() || '/dailybholajournalBN';
    }

    function previewCustomAdFile(input) {
        if (input.files && input.files[0]) {
            resetAdFlag = false;
            const reader = new FileReader();
            reader.onload = function(e) {
                const adImg = document.getElementById('mainAdImage');
                if (adImg) adImg.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function updateModalAdUrl(url) {
        resetAdFlag = false;
        const adImg = document.getElementById('mainAdImage');
        if (adImg) {
            adImg.src = url.trim() || defaultAdSrc;
        }
    }

    function resetToDefaultAd() {
        const adImg = document.getElementById('mainAdImage');
        if (adImg) adImg.src = defaultAdSrc;
        const fileInput = document.getElementById('custom_ad_file_input');
        const urlInput = document.getElementById('modal_ad_url_input');
        if (fileInput) fileInput.value = '';
        if (urlInput) urlInput.value = '';
        resetAdFlag = true;
    }

    // 4. Reporter Badge & Hint Controls
    function toggleCategoryBadgeVisibility(visible) {
        const wrapper = document.getElementById('reporterBadgeWrapper');
        const badge = document.getElementById('cardCategoryPreview');
        if (wrapper) wrapper.style.display = visible ? 'flex' : 'none';
        else if (badge) badge.style.display = visible ? 'inline-flex' : 'none';
    }

    function setCategoryBadgeColor(color) {
        const badge = document.getElementById('cardCategoryPreview');
        if (badge) badge.style.background = color;
        const picker = document.getElementById('badgeColorPicker');
        if (picker && color.startsWith('#')) picker.value = color;
    }

    function setReporterBadgeBottom(val) {
        const wrapper = document.getElementById('reporterBadgeWrapper');
        const badge1 = document.getElementById('reporterBottomBadge');
        const badge2 = document.getElementById('modalReporterBottomBadge');
        const slider1 = document.getElementById('reporterBottomSlider');
        const slider2 = document.getElementById('modalReporterBottomSlider');

        if (wrapper) wrapper.style.bottom = val + 'px';
        if (badge1) badge1.innerText = val + 'px';
        if (badge2) badge2.innerText = val + 'px';
        if (slider1 && slider1.value != val) slider1.value = val;
        if (slider2 && slider2.value != val) slider2.value = val;
    }

    function toggleDetailsHintVisibility(visible) {
        const hint = document.getElementById('cardDetailsHint');
        if (hint) hint.style.display = visible ? 'inline-block' : 'none';
    }

    function updateCustomHint(text) {
        const hint = document.getElementById('cardDetailsHint');
        if (hint) hint.innerText = text;
    }

    // 5. Headline Alignment
    function setHeadlineAlignment(align) {
        const headline = document.getElementById('editable_headline');
        const wrapper = document.getElementById('cardHeadlineWrapper');
        const metaRow = document.getElementById('cardMetaRow');
        if (headline) headline.style.textAlign = align;
        if (wrapper) wrapper.style.alignItems = align === 'left' ? 'flex-start' : 'center';
        if (metaRow) {
            if (currentCardStyle === 'classic') {
                metaRow.style.setProperty('justify-content', 'flex-start', 'important');
            } else if (currentCardStyle === 'poster') {
                const sCfg = (currentStyleSettings && currentStyleSettings['poster']) || {};
                const logoPos = sCfg.logo_position || (document.getElementById('style_pos_left_poster') && document.getElementById('style_pos_left_poster').checked ? 'left' : (document.getElementById('logoPosLeft') && document.getElementById('logoPosLeft').checked ? 'left' : 'right'));
                metaRow.style.setProperty('justify-content', logoPos === 'left' ? 'flex-end' : 'flex-start', 'important');
            } else {
                metaRow.style.justifyContent = align === 'left' ? 'flex-start' : 'center';
            }
        }

        const btnLeft = document.getElementById('alignLeftBtn');
        const btnCenter = document.getElementById('alignCenterBtn');
        if (btnLeft) btnLeft.classList.toggle('active', align === 'left');
        if (btnCenter) btnCenter.classList.toggle('active', align === 'center');
        const modalBtnLeft = document.getElementById('modalAlignLeftBtn');
        const modalBtnCenter = document.getElementById('modalAlignCenterBtn');
        if (modalBtnLeft) modalBtnLeft.classList.toggle('active', align === 'left');
        if (modalBtnCenter) modalBtnCenter.classList.toggle('active', align === 'center');
    }

    // 6. Image Pan (Vertical Object Position)
    function setImagePan(val) {
        const img = document.getElementById('cardImagePreview');
        const badge = document.getElementById('imgPanBadge');
        if (img) img.style.objectPosition = `center ${val}%`;
        if (badge) badge.innerText = `${val}%`;
    }

    // ----------------------------------------------------
    // Permanent Settings Persistence (Save & Apply)
    // ----------------------------------------------------

    function savePersistentCardSettings() {
        const saveBtn = document.getElementById('saveCardSettingsBtn');
        const quickSaveBtn = document.getElementById('quickSaveDefaultBtn');
        const originalText = saveBtn ? saveBtn.innerHTML : '';
        const originalQuickText = quickSaveBtn ? quickSaveBtn.innerHTML : '';

        if (saveBtn) {
            saveBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-1"></i> সংরক্ষণ হচ্ছে...';
            saveBtn.disabled = true;
        }
        if (quickSaveBtn) {
            quickSaveBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-1"></i> সেভ হচ্ছে...';
            quickSaveBtn.disabled = true;
        }

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('card_style', currentCardStyle);

        // 1. Theme and colors
        const activeThemeBtn = document.querySelector('.btn-theme-preset.active') || document.querySelector('.modal-theme-btn.active');
        const themeKey = currentThemeKey || (activeThemeBtn ? (activeThemeBtn.getAttribute('data-theme') || activeThemeBtn.getAttribute('data-modal-theme')) : 'royal');
        formData.append('theme_key', themeKey);

        const customBg = document.getElementById('customBgColor') ? document.getElementById('customBgColor').value : '#1e3a8a';
        formData.append('custom_bg_color', customBg);

        const dateColor = document.getElementById('dateColorPicker') ? document.getElementById('dateColorPicker').value : '#38bdf8';
        formData.append('date_color', dateColor);

        const borderColor = document.getElementById('borderColorPicker') ? document.getElementById('borderColorPicker').value : '#38bdf8';
        formData.append('border_color', borderColor);

        // 2. Typography
        const fontSwitcher = document.getElementById('font_switcher') || document.getElementById('modal_font_switcher');
        formData.append('font_family', fontSwitcher ? fontSwitcher.value : "'Noto Sans Bengali', sans-serif");

        const fontSizeSlider = document.getElementById('fontSizeSlider') || document.getElementById('modalFontSizeSlider');
        formData.append('font_size', fontSizeSlider ? fontSizeSlider.value : 52);

        const lineHeightSlider = document.getElementById('lineHeightSlider') || document.getElementById('modalLineHeightSlider');
        formData.append('line_height', lineHeightSlider ? lineHeightSlider.value : 1.3);

        const isAlignLeft = document.getElementById('alignLeftBtn') && document.getElementById('alignLeftBtn').classList.contains('active');
        formData.append('headline_align', isAlignLeft ? 'left' : 'center');

        // 3. Corner Logo
        const cornerVisible = document.getElementById('toggleCornerLogo') ? document.getElementById('toggleCornerLogo').checked : true;
        formData.append('corner_logo_visible', cornerVisible ? 1 : 0);

        const logoPosLeft = document.getElementById('logoPosLeft') && document.getElementById('logoPosLeft').checked;
        formData.append('corner_logo_position', logoPosLeft ? 'left' : 'right');

        const cornerSize = document.getElementById('cornerLogoSizeSlider') ? document.getElementById('cornerLogoSizeSlider').value : 135;
        formData.append('corner_logo_size', cornerSize);

        const shadowCheckbox = document.getElementById('toggleCornerLogoShadow') || document.getElementById('toggleCornerLogo3DBorder');
        const cornerShadow = shadowCheckbox ? shadowCheckbox.checked : true;
        formData.append('corner_logo_shadow', cornerShadow ? 1 : 0);
        formData.append('corner_logo_3d_border', 0);

        const cornerFileInput = document.getElementById('customCornerLogoInput');
        if (cornerFileInput && cornerFileInput.files && cornerFileInput.files[0]) {
            formData.append('corner_logo_file', cornerFileInput.files[0]);
        }
        if (resetCornerLogoFlag) {
            formData.append('reset_corner_logo', 1);
        }

        // 4. Watermark
        const watermarkVisible = document.getElementById('toggleWatermark') ? document.getElementById('toggleWatermark').checked : true;
        formData.append('watermark_visible', watermarkVisible ? 1 : 0);

        const watermarkOpacity = document.getElementById('watermarkOpacitySlider') ? document.getElementById('watermarkOpacitySlider').value : 12;
        formData.append('watermark_opacity', watermarkOpacity);

        const watermarkFileInput = document.getElementById('customWatermarkInput');
        if (watermarkFileInput && watermarkFileInput.files && watermarkFileInput.files[0]) {
            formData.append('watermark_file', watermarkFileInput.files[0]);
        }
        if (resetWatermarkFlag) {
            formData.append('reset_watermark', 1);
        }

        // 5. Footer mode, ad & branding
        formData.append('footer_mode', currentFooterMode);

        const brandTitle = document.getElementById('brandFooterTitleText') ? document.getElementById('brandFooterTitleText').innerText.trim() : 'দৈনিক ভোলা জার্নাল';
        formData.append('brand_title', brandTitle);

        const brandTagline = document.getElementById('brandFooterTaglineText') ? document.getElementById('brandFooterTaglineText').innerText.trim() : 'সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর';
        formData.append('brand_tagline', brandTagline);

        const brandWeb = document.getElementById('brandFooterWebText') ? document.getElementById('brandFooterWebText').innerText.trim() : 'dailybholajournal.com';
        formData.append('brand_web', brandWeb);

        const brandSocial = document.getElementById('brandFooterFbText') ? document.getElementById('brandFooterFbText').innerText.trim() : '/dailybholajournalBN';
        formData.append('brand_social', brandSocial);

        const adFileInput = document.getElementById('custom_ad_file_input');
        if (adFileInput && adFileInput.files && adFileInput.files[0]) {
            formData.append('ad_file', adFileInput.files[0]);
        }
        const adUrlInput = document.getElementById('modal_ad_url_input');
        if (adUrlInput && adUrlInput.value.trim()) {
            formData.append('ad_url', adUrlInput.value.trim());
        }
        if (resetAdFlag) {
            formData.append('reset_ad', 1);
        }

        // 6. Reporter badge & hint
        const catBadgeVisible = document.getElementById('toggleCategoryBadge') ? document.getElementById('toggleCategoryBadge').checked : true;
        formData.append('category_badge_visible', catBadgeVisible ? 1 : 0);

        const badgeColor = document.getElementById('badgeColorPicker') ? document.getElementById('badgeColorPicker').value : '#dc2626';
        formData.append('category_badge_color', badgeColor);

        const repBottom = document.getElementById('reporterBottomSlider') ? document.getElementById('reporterBottomSlider').value : 25;
        formData.append('reporter_badge_bottom', repBottom);

        const hintVisible = document.getElementById('toggleDetailsHint') ? document.getElementById('toggleDetailsHint').checked : true;
        formData.append('details_hint_visible', hintVisible ? 1 : 0);

        const hintText = document.getElementById('customHintInput') ? document.getElementById('customHintInput').value : 'বিস্তারিত কমেন্টে......';
        formData.append('details_hint_text', hintText);

        // 7. Quote style photo mode & positioning
        formData.append('quote_cutout_mode', (typeof isQuoteCutout !== 'undefined' && isQuoteCutout) ? 1 : 0);
        formData.append('quote_img_scale', quoteImgScale || 100);
        formData.append('quote_img_y', quoteImgY || 0);
        formData.append('quote_img_x', quoteImgX || 0);

        // 8. Per-style configurations & custom style logos
        const cleanStyleSettings = JSON.parse(JSON.stringify(currentStyleSettings));
        for (const sKey of ['classic', 'poster', 'quote', 'breaking']) {
            if (cleanStyleSettings[sKey]) {
                delete cleanStyleSettings[sKey].logo_image_preview;
            }
        }
        formData.append('style_settings', JSON.stringify(cleanStyleSettings));
        for (const sKey of ['classic', 'poster', 'quote', 'breaking']) {
            if (styleLogoFiles[sKey]) {
                formData.append('style_logo_file_' + sKey, styleLogoFiles[sKey]);
            }
            if (resetStyleLogoFlags[sKey]) {
                formData.append('reset_style_logo_' + sKey, 1);
            }
        }

        fetch(saveSettingsRoute, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (saveBtn) {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            }
            if (quickSaveBtn) {
                quickSaveBtn.innerHTML = originalQuickText;
                quickSaveBtn.disabled = false;
            }
            if (data.success) {
                resetCornerLogoFlag = false;
                resetWatermarkFlag = false;
                resetAdFlag = false;
                for (const sKey of ['classic', 'poster', 'quote', 'breaking']) {
                    delete styleLogoFiles[sKey];
                    delete resetStyleLogoFlags[sKey];
                }

                if (data.settings) {
                    Object.assign(serverCardSettings, data.settings);
                    if (data.settings.style_settings) {
                        for (const sKey of ['classic', 'poster', 'quote', 'breaking']) {
                            if (data.settings.style_settings[sKey]) {
                                currentStyleSettings[sKey] = Object.assign({}, defaultStyleSettings[sKey], data.settings.style_settings[sKey]);
                            }
                        }
                    }
                }

                try {
                    localStorage.setItem('dailybhola_social_card_settings', JSON.stringify(data.settings));
                } catch(e) {}

                showToast(
                    'সেটিংস সংরক্ষিত! 💾',
                    'কার্ডের এই সেটিংস স্থায়ীভাবে সেভ করা হয়েছে। সব পোস্টে এই ডিফল্ট কার্যকর থাকবে।'
                );

                const modalEl = document.getElementById('cardSettingsModal');
                if (modalEl && typeof bootstrap !== 'undefined') {
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) {
                        setTimeout(() => modalInstance.hide(), 600);
                    }
                }
            } else {
                alert('সেটিংস সেভ করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
            }
        })
        .catch(err => {
            console.error('Save settings failed:', err);
            if (saveBtn) {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            }
            if (quickSaveBtn) {
                quickSaveBtn.innerHTML = originalQuickText;
                quickSaveBtn.disabled = false;
            }
            alert('সার্ভারে রিকোয়েস্ট পাঠাতে সমস্যা হয়েছে।');
        });
    }

    function applySavedSettings(settings) {
        if (!settings || typeof settings !== 'object') return;

        // 0. Card Style
        if (settings.card_style) {
            setCardStyle(settings.card_style);
        }

        // 1. Theme
        if (settings.theme_key && settings.theme_key !== 'custom' && cardThemes[settings.theme_key]) {
            applyCardTheme(settings.theme_key);
        } else if (settings.custom_bg_color) {
            setCustomCardBg(settings.custom_bg_color);
        }
        if (settings.date_color) {
            setCardDateColor(settings.date_color);
        }
        if (settings.border_color) {
            setCardBorderColor(settings.border_color);
        }

        // 2. Typography
        if (settings.font_family) {
            changeFontFamily(settings.font_family);
        }
        if (settings.font_size) {
            updateFontSize(settings.font_size);
        }
        if (settings.line_height) {
            updateLineHeight(settings.line_height);
        }
        if (settings.headline_align) {
            setHeadlineAlignment(settings.headline_align);
        }

        // 3. Corner Logo
        if (settings.hasOwnProperty('corner_logo_visible')) {
            const toggle = document.getElementById('toggleCornerLogo');
            if (toggle) toggle.checked = !!settings.corner_logo_visible;
            toggleCornerLogoVisibility(!!settings.corner_logo_visible);
        }
        if (settings.corner_logo_position) {
            const rRadio = document.getElementById('logoPosRight');
            const lRadio = document.getElementById('logoPosLeft');
            if (settings.corner_logo_position === 'left') {
                if (lRadio) lRadio.checked = true;
            } else {
                if (rRadio) rRadio.checked = true;
            }
            setCornerLogoPosition(settings.corner_logo_position);
        }
        if (settings.corner_logo_size) {
            const sizeSlider = document.getElementById('cornerLogoSizeSlider');
            if (sizeSlider) sizeSlider.value = settings.corner_logo_size;
            setCornerLogoSize(settings.corner_logo_size);
        }
        if (settings.hasOwnProperty('corner_logo_shadow') || settings.hasOwnProperty('corner_logo_3d_border')) {
            const shadowVal = settings.hasOwnProperty('corner_logo_shadow') ? !!settings.corner_logo_shadow : true;
            const toggleShadow = document.getElementById('toggleCornerLogoShadow') || document.getElementById('toggleCornerLogo3DBorder');
            if (toggleShadow) toggleShadow.checked = shadowVal;
            toggleCornerLogoShadow(shadowVal);
        }
        if (settings.corner_logo_image) {
            const fullUrl = settings.corner_logo_image.startsWith('http') ? settings.corner_logo_image : '{{ url("/") }}/' + settings.corner_logo_image;
            const cImg = document.getElementById('cornerLogoImg');
            const pImg = document.getElementById('cornerLogoPreviewImg');
            const bImg = document.getElementById('brandFooterLogoImg');
            if (cImg) cImg.src = fullUrl;
            if (pImg) pImg.src = fullUrl;
            if (bImg) bImg.src = fullUrl;
        }

        // 4. Watermark
        if (settings.hasOwnProperty('watermark_visible')) {
            const toggle = document.getElementById('toggleWatermark');
            if (toggle) toggle.checked = !!settings.watermark_visible;
            toggleWatermarkVisibility(!!settings.watermark_visible);
        }
        if (settings.watermark_opacity !== undefined) {
            const slider = document.getElementById('watermarkOpacitySlider');
            if (slider) slider.value = settings.watermark_opacity;
            setWatermarkOpacity(settings.watermark_opacity);
        }
        if (settings.watermark_image) {
            const fullUrl = settings.watermark_image.startsWith('http') ? settings.watermark_image : '{{ url("/") }}/' + settings.watermark_image;
            const wImg = document.getElementById('cardWatermarkImg');
            const pImg = document.getElementById('watermarkPreviewImg');
            if (wImg) wImg.src = fullUrl;
            if (pImg) pImg.src = fullUrl;
        }

        // 5. Footer Mode, Ads & Branding
        if (settings.footer_mode) {
            setFooterMode(settings.footer_mode);
        }
        if (settings.brand_title) {
            const el = document.getElementById('brandFooterTitleText');
            const inp = document.getElementById('modal_brand_title_input');
            if (el) el.innerText = settings.brand_title;
            if (inp) inp.value = settings.brand_title;
        }
        if (settings.brand_tagline) {
            const el = document.getElementById('brandFooterTaglineText');
            const inp = document.getElementById('modal_brand_tagline_input');
            if (el) el.innerText = settings.brand_tagline;
            if (inp) inp.value = settings.brand_tagline;
        }
        if (settings.brand_web) {
            const el = document.getElementById('brandFooterWebText');
            const inp = document.getElementById('modal_brand_web_input');
            if (el) el.innerText = settings.brand_web;
            if (inp) inp.value = settings.brand_web;
        }
        if (settings.brand_social) {
            const el = document.getElementById('brandFooterFbText');
            const inp = document.getElementById('modal_brand_social_input');
            if (el) el.innerText = settings.brand_social;
            if (inp) inp.value = settings.brand_social;
        }
        if (settings.ad_image) {
            const fullUrl = settings.ad_image.startsWith('http') ? settings.ad_image : '{{ url("/") }}/' + settings.ad_image;
            const adImg = document.getElementById('mainAdImage');
            if (adImg) adImg.src = fullUrl;
            const adUrlInput = document.getElementById('modal_ad_url_input');
            if (adUrlInput && settings.ad_image.startsWith('http')) {
                adUrlInput.value = settings.ad_image;
            }
        }

        // 6. Reporter Badge
        if (settings.hasOwnProperty('category_badge_visible')) {
            const toggle = document.getElementById('toggleCategoryBadge');
            if (toggle) toggle.checked = !!settings.category_badge_visible;
            toggleCategoryBadgeVisibility(!!settings.category_badge_visible);
        }
        if (settings.category_badge_color) {
            setCategoryBadgeColor(settings.category_badge_color);
        }
        if (settings.reporter_badge_bottom !== undefined) {
            setReporterBadgeBottom(settings.reporter_badge_bottom);
        }

        // 7. Details Hint
        if (settings.hasOwnProperty('details_hint_visible')) {
            const toggle = document.getElementById('toggleDetailsHint');
            if (toggle) toggle.checked = !!settings.details_hint_visible;
            toggleDetailsHintVisibility(!!settings.details_hint_visible);
        }
        if (settings.details_hint_text) {
            const hintInput = document.getElementById('customHintInput');
            if (hintInput) hintInput.value = settings.details_hint_text;
            updateCustomHint(settings.details_hint_text);
        }

        // 8. Quote Photo Mode & Transform
        if (settings.hasOwnProperty('quote_cutout_mode')) {
            if (typeof setQuotePhotoMode === 'function') {
                setQuotePhotoMode(settings.quote_cutout_mode ? 'cutout' : 'normal');
            }
        }
        if (settings.quote_img_scale !== undefined && settings.quote_img_scale !== false) {
            setQuoteImgScale(settings.quote_img_scale);
            const slider = document.getElementById('quoteScaleSlider');
            if (slider) slider.value = settings.quote_img_scale;
        }
        if (settings.quote_img_y !== undefined && settings.quote_img_y !== false) {
            setQuoteImgY(settings.quote_img_y);
            const slider = document.getElementById('quoteYSlider');
            if (slider) slider.value = settings.quote_img_y;
        }
        if (settings.quote_img_x !== undefined && settings.quote_img_x !== false) {
            setQuoteImgX(settings.quote_img_x);
            const slider = document.getElementById('quoteXSlider');
            if (slider) slider.value = settings.quote_img_x;
        }

        // 9. Sync Modal-specific typography & theme controls
        if (settings.theme_key) {
            document.querySelectorAll('.modal-theme-btn').forEach(btn => {
                btn.classList.toggle('active', btn.getAttribute('data-modal-theme') === settings.theme_key);
            });
        }
        if (settings.custom_bg_color) {
            const mBg = document.getElementById('modalCustomBgColor');
            const mHex = document.getElementById('modalCustomBgHex');
            if (mBg) mBg.value = settings.custom_bg_color;
            if (mHex) mHex.innerText = settings.custom_bg_color;
        }
        if (settings.border_color) {
            const mBorder = document.getElementById('modalBorderColorPicker');
            const mHex = document.getElementById('modalBorderHex');
            if (mBorder) mBorder.value = settings.border_color;
            if (mHex) mHex.innerText = settings.border_color;
        }
        if (settings.date_color) {
            const mDate = document.getElementById('modalDateColorPicker');
            const mHex = document.getElementById('modalDateHex');
            if (mDate) mDate.value = settings.date_color;
            if (mHex) mHex.innerText = settings.date_color;
        }
        if (settings.font_family) {
            const mFont = document.getElementById('modal_font_switcher');
            if (mFont) mFont.value = settings.font_family;
        }
        if (settings.font_size) {
            const mSize = document.getElementById('modalFontSizeSlider');
            const mBadge = document.getElementById('modalFontSizeBadge');
            if (mSize) mSize.value = settings.font_size;
            if (mBadge) mBadge.innerText = settings.font_size + 'px';
        }
        if (settings.line_height) {
            const mLine = document.getElementById('modalLineHeightSlider');
            const mBadge = document.getElementById('modalLineHeightBadge');
            if (mLine) mLine.value = settings.line_height;
            if (mBadge) mBadge.innerText = settings.line_height;
        }
        if (settings.headline_align) {
            const btnL = document.getElementById('modalAlignLeftBtn');
            const btnC = document.getElementById('modalAlignCenterBtn');
            if (btnL) btnL.classList.toggle('active', settings.headline_align === 'left');
            if (btnC) btnC.classList.toggle('active', settings.headline_align === 'center');
        }
        if (settings.hasOwnProperty('quote_cutout_mode')) {
            const mBtnN = document.getElementById('modalQuoteModeNormal');
            const mBtnC = document.getElementById('modalQuoteModeCutout');
            if (mBtnN) mBtnN.classList.toggle('active', !settings.quote_cutout_mode);
            if (mBtnC) mBtnC.classList.toggle('active', !!settings.quote_cutout_mode);
        }

        // 10. Per-style configurations & show/hide objects
        if (settings.style_settings && typeof settings.style_settings === 'object') {
            for (const sKey of ['classic', 'poster', 'quote', 'breaking']) {
                if (settings.style_settings[sKey]) {
                    currentStyleSettings[sKey] = Object.assign({}, defaultStyleSettings[sKey], settings.style_settings[sKey]);
                    const cfg = currentStyleSettings[sKey];

                    const logoSw = document.getElementById('style_obj_' + sKey + '_logo');
                    if (logoSw) logoSw.checked = !!cfg.logo_visible;
                    const wmSw = document.getElementById('style_obj_' + sKey + '_watermark');
                    if (wmSw) wmSw.checked = !!cfg.watermark_visible;
                    const bdgSw = document.getElementById('style_obj_' + sKey + '_badge');
                    if (bdgSw) bdgSw.checked = !!cfg.badge_visible;
                    const dtSw = document.getElementById('style_obj_' + sKey + '_date');
                    if (dtSw) dtSw.checked = !!cfg.date_visible;
                    const hntSw = document.getElementById('style_obj_' + sKey + '_hint');
                    if (hntSw) hntSw.checked = !!cfg.hint_visible;
                    const ftrSw = document.getElementById('style_obj_' + sKey + '_footer');
                    if (ftrSw) ftrSw.checked = !!cfg.footer_visible;

                    if (sKey === 'quote') {
                        const qSymSw = document.getElementById('style_obj_quote_quote_symbol');
                        if (qSymSw) qSymSw.checked = cfg.quote_symbol_visible !== false;
                        const spkSw = document.getElementById('style_obj_quote_speaker');
                        if (spkSw) spkSw.checked = cfg.speaker_visible !== false;
                    }
                    if (sKey === 'breaking') {
                        const excSw = document.getElementById('style_obj_breaking_excerpt');
                        if (excSw) excSw.checked = cfg.excerpt_visible !== false;
                    }

                    const rRadio = document.getElementById('style_pos_right_' + sKey);
                    const lRadio = document.getElementById('style_pos_left_' + sKey);
                    if (cfg.logo_position === 'left') {
                        if (lRadio) lRadio.checked = true;
                    } else {
                        if (rRadio) rRadio.checked = true;
                    }

                    if (cfg.logo_size) {
                        const styleSlider = document.getElementById('style_logo_size_slider_' + sKey);
                        const styleBadge = document.getElementById('style_logo_size_badge_' + sKey);
                        if (styleSlider) styleSlider.value = cfg.logo_size;
                        if (styleBadge) styleBadge.innerText = cfg.logo_size + 'px';
                    }

                    const previewImg = document.getElementById('styleLogoPreview_' + sKey);
                    const logoBox = document.getElementById('styleLogoBox_' + sKey);
                    const noLogoBox = document.getElementById('styleNoLogoBox_' + sKey);
                    if (previewImg) {
                        const fallbackLogo = (sKey === 'poster') ? '' : (settings.corner_logo_image ? (settings.corner_logo_image.startsWith('http') || settings.corner_logo_image.startsWith('/') ? settings.corner_logo_image : ('/' + settings.corner_logo_image)) : "{{ asset('BJ_Content/Profile Pic b.png') }}");
                        const sLogo = cfg.logo_image ? (cfg.logo_image.startsWith('http') || cfg.logo_image.startsWith('/') ? cfg.logo_image : ('/' + cfg.logo_image)) : fallbackLogo;
                        if (sLogo) {
                            previewImg.src = sLogo;
                            if (logoBox) logoBox.style.display = '';
                            if (noLogoBox) noLogoBox.style.display = 'none';
                        } else {
                            if (logoBox) logoBox.style.display = 'none';
                            if (noLogoBox) noLogoBox.style.display = 'flex';
                        }
                    }
                }
            }
        }
        applyStyleObjectSettings(currentCardStyle);
    }

    function resetAllCardSettings() {
        if (!confirm('আপনি কি সব কার্ড সেটিংস ডিফল্টে রিসেট করতে চান?')) return;
        const defaultSettings = {
            card_style: 'classic',
            theme_key: 'royal',
            custom_bg_color: '#1e3a8a',
            date_color: '#38bdf8',
            border_color: '#38bdf8',
            font_family: "'Noto Sans Bengali', sans-serif",
            font_size: 52,
            line_height: 1.3,
            headline_align: 'center',
            corner_logo_visible: true,
            corner_logo_position: 'right',
            corner_logo_size: 135,
            corner_logo_shadow: true,
            corner_logo_3d_border: false,
            corner_logo_image: '',
            watermark_visible: true,
            watermark_opacity: 12,
            watermark_image: '',
            footer_mode: 'ad',
            ad_image: '',
            brand_title: 'দৈনিক ভোলা জার্নাল',
            brand_tagline: 'সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর',
            brand_web: 'dailybholajournal.com',
            brand_social: '/dailybholajournalBN',
            category_badge_visible: true,
            category_badge_color: '#dc2626',
            reporter_badge_bottom: 25,
            details_hint_visible: true,
            details_hint_text: 'বিস্তারিত কমেন্টে......',
            style_settings: defaultStyleSettings
        };
        resetCornerLogo();
        resetWatermark();
        resetToDefaultAd();
        applySavedSettings(defaultSettings);
        savePersistentCardSettings();
    }

    // Toggle left inspector panel collapse/expand
    function toggleInspectorPanel() {
        const panel = document.getElementById('inspectorPanel');
        const btn = document.getElementById('togglePanelBtn');
        const icon = document.getElementById('togglePanelIcon');
        
        if (panel.classList.contains('collapsed')) {
            panel.classList.remove('collapsed');
            panel.classList.add('open');
            icon.className = 'fa-solid fa-sliders';
            btn.title = 'প্যানেল লুকান';
        } else {
            panel.classList.add('collapsed');
            panel.classList.remove('open');
            icon.className = 'fa-solid fa-chevron-right';
            btn.title = 'প্যানেল দেখান';
        }
        
        // Wait for CSS transition then trigger canvas resizing
        setTimeout(resizeCanvasWorkspace, 305);
    }

    // Toggle bottom control bar (back-compatibility/no-op)
    function toggleBottomBar() {
        toggleInspectorPanel();
    }

    // Background Image updater
    function updateCardBackground() {
        const cardImg = document.getElementById('cardImagePreview');
        const placeholder = document.getElementById('cardImagePlaceholder');
        const src = socialCardImageSrc || featuredImageSrc;
        const thumb = document.getElementById('bg_thumb_preview');
        const qThumb = document.getElementById('quote_speaker_thumb');

        if (src) {
            if (cardImg) {
                cardImg.src = src;
                cardImg.style.display = 'block';
            }
            if (placeholder) placeholder.style.display = 'none';
            if (thumb) {
                thumb.src = src;
                thumb.style.display = 'block';
            }
            if (qThumb) {
                qThumb.src = src;
                qThumb.style.display = 'block';
            }
        } else {
            if (cardImg) {
                cardImg.src = '';
                cardImg.style.display = 'none';
            }
            if (placeholder) placeholder.style.display = 'flex';
            if (thumb) {
                thumb.src = '';
                thumb.style.display = 'none';
            }
            if (qThumb) {
                qThumb.src = '';
                qThumb.style.display = 'none';
            }
        }
    }

    // Sync Custom Social Card Image upload
    function previewSocialCardImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                socialCardImageSrc = e.target.result;
                updateCardBackground();
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            socialCardImageSrc = '{{ $post->social_card_image ? $post->social_card_image_url : "" }}';
            updateCardBackground();
        }
    }

    // Quote Photo Mode (Normal Frame vs Full-Width Cutout) & Transformation
    let isQuoteCutout = @json(!empty($cardSettings['quote_cutout_mode']));
    let quoteImgScale = @json(is_numeric($cardSettings['quote_img_scale'] ?? null) ? (float)$cardSettings['quote_img_scale'] : 100);
    let quoteImgY = @json(is_numeric($cardSettings['quote_img_y'] ?? null) ? (int)$cardSettings['quote_img_y'] : 0);
    let quoteImgX = @json(is_numeric($cardSettings['quote_img_x'] ?? null) ? (int)$cardSettings['quote_img_x'] : 0);

    function setQuotePhotoMode(mode) {
        isQuoteCutout = (mode === 'cutout');
        const wrapper = document.getElementById('newsImageWrapper');
        const normalBtn = document.getElementById('modeNormalBtn');
        const cutoutBtn = document.getElementById('modeCutoutBtn');
        const slidersBox = document.getElementById('cutoutSlidersBox');
        if (wrapper) {
            if (isQuoteCutout) {
                wrapper.classList.add('quote-cutout-mode');
            } else {
                wrapper.classList.remove('quote-cutout-mode');
            }
        }
        if (normalBtn) normalBtn.classList.toggle('active', !isQuoteCutout);
        if (cutoutBtn) cutoutBtn.classList.toggle('active', isQuoteCutout);
        if (slidersBox) slidersBox.style.display = isQuoteCutout ? 'block' : 'none';
        updateQuoteImgTransform();
    }

    function updateQuoteImgTransform() {
        const cardImg = document.getElementById('cardImagePreview');
        if (!cardImg) return;
        if ((currentCardStyle === 'quote' || currentCardStyle === 'breaking') && isQuoteCutout) {
            cardImg.style.transform = `scale(${quoteImgScale / 100}) translate(${quoteImgX}px, ${quoteImgY}px)`;
        } else {
            cardImg.style.removeProperty('transform');
        }
    }

    function setQuoteImgScale(val) {
        quoteImgScale = parseFloat(val) || 100;
        const badge = document.getElementById('quoteScaleBadge');
        if (badge) badge.innerText = quoteImgScale + '%';
        updateQuoteImgTransform();
    }

    function setQuoteImgY(val) {
        quoteImgY = parseInt(val) || 0;
        const badge = document.getElementById('quoteYBadge');
        if (badge) badge.innerText = quoteImgY + 'px';
        updateQuoteImgTransform();
    }

    function setQuoteImgX(val) {
        quoteImgX = parseInt(val) || 0;
        const badge = document.getElementById('quoteXBadge');
        if (badge) badge.innerText = quoteImgX + 'px';
        updateQuoteImgTransform();
    }

    // Sync Speaker Photo upload (auto detects PNG for cutout mode)
    function previewQuoteSpeakerImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const isPng = file.type === 'image/png' || file.name.toLowerCase().endsWith('.png');
            const reader = new FileReader();
            reader.onload = function(e) {
                socialCardImageSrc = e.target.result;
                updateCardBackground();
                if (isPng) {
                    setQuotePhotoMode('cutout');
                }
            }
            reader.readAsDataURL(file);
        }
    }

    // Custom Toast Notification Controller
    function showToast(title, desc) {
        const toast = document.getElementById('studioToast');
        const tTitle = document.getElementById('toastTitle');
        const tDesc = document.getElementById('toastDesc');
        
        if (toast && tTitle && tDesc) {
            tTitle.innerText = title;
            tDesc.innerText = desc;
            
            toast.classList.add('show');
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                toast.classList.remove('show');
            }, 5000);
        }
    }

    // Share & Copy to Clipboard Workflow for Facebook
    async function shareOnFacebook(e) {
        e.preventDefault();
        const node = document.getElementById('social_card_node');
        const scaleContainer = document.getElementById('scaleContainer');
        const btn = e.currentTarget;
        const originalText = btn.innerHTML;

        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i> পোস্ট প্রসেস হচ্ছে...';
        btn.style.pointerEvents = 'none';

        // 1. Remove text cursor caret by blurring active editable element
        const activeEl = document.activeElement;
        if (activeEl && activeEl.isContentEditable) {
            activeEl.blur();
        }

        // Wait for all web fonts to load completely
        if (document.fonts && document.fonts.ready) {
            try { await document.fonts.ready; } catch(err) {}
        }

        // 2. Temporarily save and reset scaling transform to 1 (natural 1080x1080 size) to avoid html2canvas crop bugs
        const originalTransform = scaleContainer ? scaleContainer.style.transform : '';
        if (scaleContainer) {
            scaleContainer.style.transform = 'none';
        }

        // 3. Add exporting class to strip borders, outlines, hover tooltips, and revert padding
        node.classList.add('exporting');

        // 4. Capture Canvas image and download it
        setTimeout(() => {
            html2canvas(node, {
                useCORS: true,
                allowTaint: false,
                width: 1080,
                height: 1080,
                scale: 2,
                x: 0,
                y: 0,
                scrollX: 0,
                scrollY: 0,
                windowWidth: 1080,
                windowHeight: 1080,
                backgroundColor: '#000000',
                logging: false
            }).then(canvas => {
                // Restore exporting class and scale transform immediately
                node.classList.remove('exporting');
                if (scaleContainer) {
                    scaleContainer.style.transform = originalTransform;
                }

                // Download JPG card
                const link = document.createElement('a');
                link.download = 'NewsCard-DailyBholaJournal-{{ $post->id }}.jpg';
                link.href = canvas.toDataURL("image/jpeg", 0.95);
                link.click();

                // 5. Copy Headline and Public URL to Clipboard as Caption
                const headlineText = document.getElementById('editable_headline').innerText.trim();
                const postLink = '{{ route("post", $post->slug) }}';
                const clipboardText = `${headlineText}\n\nবিস্তারিত পড়তে ক্লিক করুন: ${postLink}`;

                navigator.clipboard.writeText(clipboardText).then(() => {
                    // Show a stunning premium success toast
                    showToast(
                        'ক্যাপশন ও লিংক কপিড! 📥',
                        'নিউজ ইমেজ ডাউনলোড হয়েছে। ফেসবুকে ছবিটি আপলোড করে ক্যাপশনটি পেস্ট (Ctrl+V) করুন।'
                    );
                    
                    // 6. Open Facebook in a new tab after 1.5 seconds
                    setTimeout(() => {
                        window.open('https://www.facebook.com/', '_blank');
                    }, 1500);
                }).catch(err => {
                    console.error("Clipboard copy failed:", err);
                    showToast('ডাউনলোড সম্পূর্ণ! 📥', 'ছবিটি ডাউনলোড হয়েছে। ফেসবুকে আপলোড করুন।');
                });
                
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            }).catch(err => {
                node.classList.remove('exporting');
                if (scaleContainer) {
                    scaleContainer.style.transform = originalTransform;
                }
                console.error("html2canvas render failed:", err);
                alert("ছবি প্রস্তুত করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।");
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            });
        }, 150);
    }

    // Save as Image Function
    async function download_SocialCard(e) {
        e.preventDefault();
        const node = document.getElementById('social_card_node');
        const scaleContainer = document.getElementById('scaleContainer');
        const btn = e.currentTarget;
        const originalText = btn.innerHTML;

        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i> ক্যানভাস প্রস্তুত হচ্ছে...';
        btn.style.pointerEvents = 'none';

        // 1. Remove text cursor caret by blurring active editable element
        const activeEl = document.activeElement;
        if (activeEl && activeEl.isContentEditable) {
            activeEl.blur();
        }

        // Wait for all web fonts to load completely
        if (document.fonts && document.fonts.ready) {
            try { await document.fonts.ready; } catch(err) {}
        }

        // 2. Temporarily save and reset scaling transform to 1 (natural 1080x1080 size) to avoid html2canvas crop bugs
        const originalTransform = scaleContainer ? scaleContainer.style.transform : '';
        if (scaleContainer) {
            scaleContainer.style.transform = 'none';
        }

        // 3. Add exporting class to strip borders, outlines, hover tooltips, and revert padding
        node.classList.add('exporting');

        // Brief delay to ensure browser layout adjusts and styles propagate
        setTimeout(() => {
            html2canvas(node, {
                useCORS: true,
                allowTaint: false,
                width: 1080,
                height: 1080,
                scale: 2,
                x: 0,
                y: 0,
                scrollX: 0,
                scrollY: 0,
                windowWidth: 1080,
                windowHeight: 1080,
                backgroundColor: '#000000',
                logging: false
            }).then(canvas => {
                // 4. Restore exporting class and scale transform immediately
                node.classList.remove('exporting');
                if (scaleContainer) {
                    scaleContainer.style.transform = originalTransform;
                }

                const link = document.createElement('a');
                link.download = 'NewsCard-DailyBholaJournal-{{ $post->id }}.jpg';
                link.href = canvas.toDataURL("image/jpeg", 0.95);
                link.click();
                
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            }).catch(err => {
                node.classList.remove('exporting');
                if (scaleContainer) {
                    scaleContainer.style.transform = originalTransform;
                }
                console.error("html2canvas render failed:", err);
                alert("ছবি সেভ করতে সমস্যা হয়েছে। কনসোল লগ চেক করুন বা ইমেজ লিংকগুলো ঠিক আছে কিনা দেখুন।");
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            });
        }, 150);
    }

    // Dynamic Auto-scaling for the 1080x1080 canvas workspace
    function resizeCanvasWorkspace() {
        const workspace = document.getElementById('canvasWorkspace');
        const scaleContainer = document.getElementById('scaleContainer');
        if (!workspace || !scaleContainer) return;

        const isMobile = window.innerWidth <= 768;

        if (isMobile) {
            // Mobile: scale canvas to fit viewport width
            const padding = 20;
            const availableWidth = workspace.clientWidth || (window.innerWidth - padding * 2);
            const scale = Math.min((availableWidth - padding) / 1080, 0.32);
            scaleContainer.style.transform = `scale(${scale})`;
            // Set workspace min-height so the canvas is fully visible
            const scaledHeight = 1080 * scale + 30;
            workspace.style.minHeight = scaledHeight + 'px';
        } else {
            const wWidth = workspace.clientWidth;
            const wHeight = workspace.clientHeight;
            // Fit 1080x1080 canvas inside workspace with dynamic margin padding
            const targetSize = 1080;
            const padding = 70; // 35px padding on each side
            const scale = Math.min((wWidth - padding) / targetSize, (wHeight - padding) / targetSize);
            scaleContainer.style.transform = `scale(${scale})`;
        }
    }

    // Mobile Inspector Panel Toggle
    function toggleMobileInspector() {
        const panel = document.getElementById('inspectorPanel');
        const btn = document.getElementById('mobileInspectorToggle');
        if (!panel) return;

        const isOpen = panel.classList.toggle('mobile-open');
        if (btn) {
            btn.innerHTML = isOpen
                ? '<i class="fa-solid fa-xmark me-1"></i> বন্ধ করুন'
                : '<i class="fa-solid fa-sliders me-1"></i> কাস্টমাইজ';
        }
    }

    // Character length counter function
    function updateCharCount(text) {
        const countBadge = document.getElementById('charCount');
        if (countBadge) {
            countBadge.innerText = text.length;
            if (text.length > 80) {
                countBadge.style.color = '#dc2626';
            } else {
                countBadge.style.color = '#475569';
            }
        }
    }

    // Event Listeners for real-time form bindings and auto-resizing
    document.addEventListener('DOMContentLoaded', function() {
        const headlineInput = document.getElementById('live_headline_input');
        const headlinePreview = document.getElementById('editable_headline');

        if (headlineInput && headlinePreview) {
            headlineInput.addEventListener('input', function() {
                headlinePreview.innerText = this.value || 'সংবাদের শিরোনাম এখানে লিখুন...';
                updateCharCount(this.value);
            });
            updateCharCount(headlineInput.value);
        }

        const catInput = document.getElementById('live_category_input');
        const catPreview = document.getElementById('cardCategoryPreview');
        if (catInput && catPreview) {
            catInput.addEventListener('input', function() {
                catPreview.innerText = this.value || 'নিজস্ব প্রতিবেদক';
            });
            catPreview.addEventListener('input', function() {
                catInput.value = this.innerText;
            });
        }

        // Quote style (Style 3) input two-way synchronization
        const quoteInput = document.getElementById('live_quote_input');
        const quotePreview = document.getElementById('editable_quote_text');
        if (quoteInput && quotePreview) {
            quoteInput.addEventListener('input', function() {
                quotePreview.innerText = this.value || 'উক্তি বা বক্তব্য এখানে লিখুন...';
            });
            quotePreview.addEventListener('input', function() {
                quoteInput.value = this.innerText;
            });
        }

        const speakerNameInput = document.getElementById('live_speaker_name_input');
        const speakerNamePreview = document.getElementById('quoteSpeakerName');
        if (speakerNameInput && speakerNamePreview) {
            speakerNameInput.addEventListener('input', function() {
                speakerNamePreview.innerText = this.value || '— বক্তার নাম';
            });
            speakerNamePreview.addEventListener('input', function() {
                speakerNameInput.value = this.innerText;
            });
        }

        const speakerTitleInput = document.getElementById('live_speaker_title_input');
        const speakerTitlePreview = document.getElementById('quoteSpeakerTitle');
        if (speakerTitleInput && speakerTitlePreview) {
            speakerTitleInput.addEventListener('input', function() {
                speakerTitlePreview.innerText = this.value || 'পদবি / পরিচয়';
            });
            speakerTitlePreview.addEventListener('input', function() {
                speakerTitleInput.value = this.innerText;
            });
        }

        // Breaking News (Style 4) Sub-Excerpt two-way synchronization
        const breakingExcerptInput = document.getElementById('live_breaking_excerpt_input');
        const breakingExcerptPreview = document.getElementById('editable_breaking_excerpt');
        if (breakingExcerptInput && breakingExcerptPreview) {
            breakingExcerptInput.addEventListener('input', function() {
                breakingExcerptPreview.innerText = this.value || '';
            });
            breakingExcerptPreview.addEventListener('input', function() {
                breakingExcerptInput.value = this.innerText;
            });
        }

        // Official Brand Footer two-way synchronization
        const brandTitleInput = document.getElementById('modal_brand_title_input');
        const brandTitlePreview = document.getElementById('brandFooterTitleText');
        if (brandTitleInput && brandTitlePreview) {
            brandTitleInput.addEventListener('input', function() {
                brandTitlePreview.innerText = this.value || 'দৈনিক ভোলা জার্নাল';
            });
            brandTitlePreview.addEventListener('input', function() {
                brandTitleInput.value = this.innerText;
            });
        }

        const brandTaglineInput = document.getElementById('modal_brand_tagline_input');
        const brandTaglinePreview = document.getElementById('brandFooterTaglineText');
        if (brandTaglineInput && brandTaglinePreview) {
            brandTaglineInput.addEventListener('input', function() {
                brandTaglinePreview.innerText = this.value || 'সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর';
            });
            brandTaglinePreview.addEventListener('input', function() {
                brandTaglineInput.value = this.innerText;
            });
        }

        const brandWebInput = document.getElementById('modal_brand_web_input');
        const brandWebPreview = document.getElementById('brandFooterWebText');
        if (brandWebInput && brandWebPreview) {
            brandWebInput.addEventListener('input', function() {
                brandWebPreview.innerText = this.value || 'dailybholajournal.com';
            });
            brandWebPreview.addEventListener('input', function() {
                brandWebInput.value = this.innerText;
            });
        }

        const brandSocialInput = document.getElementById('modal_brand_social_input');
        const brandSocialPreview = document.getElementById('brandFooterFbText');
        if (brandSocialInput && brandSocialPreview) {
            brandSocialInput.addEventListener('input', function() {
                brandSocialPreview.innerText = this.value || '/dailybholajournalBN';
            });
            brandSocialPreview.addEventListener('input', function() {
                brandSocialInput.value = this.innerText;
            });
        }

        // Apply saved permanent card settings
        try {
            applySavedSettings(serverCardSettings);
        } catch(e) {
            console.error('applySavedSettings error:', e);
        }

        // Ensure quote photo mode is initialized
        try {
            if (typeof setQuotePhotoMode === 'function') {
                setQuotePhotoMode(isQuoteCutout ? 'cutout' : 'normal');
            }
        } catch(e) {
            console.error('setQuotePhotoMode error:', e);
        }

        // Generate Bengali dynamic date for first load
        try {
            updateBengaliDate();
        } catch(e) {
            console.error('updateBengaliDate error:', e);
        }

        // Perform initial canvas scaling fit
        try {
            resizeCanvasWorkspace();
        } catch(e) {
            console.error('resizeCanvasWorkspace error:', e);
        }
        
        // Initialize background upload thumbnail if any exists on load
        try {
            updateCardBackground();
        } catch(e) {
            console.error('updateCardBackground error:', e);
        }

        // Apply quote cutout transform
        try {
            updateQuoteImgTransform();
        } catch(e) {
            console.error('updateQuoteImgTransform error:', e);
        }

        // Bind sidebar toggling buttons to resize layout with transition delay
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');
        if (openBtn) openBtn.addEventListener('click', () => setTimeout(resizeCanvasWorkspace, 280));
        if (closeBtn) closeBtn.addEventListener('click', () => setTimeout(resizeCanvasWorkspace, 280));

        // Bind window resize event
        window.addEventListener('resize', resizeCanvasWorkspace);
    });
</script>
