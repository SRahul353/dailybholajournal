@php
    if (!isset($categories)) {
        $categories = \App\Models\Category::has('posts')->limit(8)->get();
    }
@endphp

@php
    if (!isset($categories)) {
        $categories = \App\Models\Category::has('posts')->limit(8)->get();
    }
@endphp

<!-- Kalbela Style Clean & Modern Footer -->
<footer class="kalbela-footer">
    <div class="container">
        <!-- Tier 1: Logo, Slogan & Quick Navigation Links -->
        <div class="k-footer-top py-4 border-bottom">
            <div class="row align-items-center g-3">
                <div class="col-lg-3 col-md-12">
                    <div class="k-footer-brand text-center text-lg-start">
                        @if(!empty($themeSettings['footer_logo_image']) && file_exists(public_path($themeSettings['footer_logo_image'])))
                            <a href="{{ url('/') }}">
                                <img src="{{ asset($themeSettings['footer_logo_image']) }}?v={{ filemtime(public_path($themeSettings['footer_logo_image'])) }}" alt="দৈনিক ভোলা জার্নাল" style="max-height: 48px; width: auto; object-fit: contain;">
                            </a>
                        @elseif(!empty($themeSettings['logo_image']) && file_exists(public_path($themeSettings['logo_image'])))
                            <a href="{{ url('/') }}">
                                <img src="{{ asset($themeSettings['logo_image']) }}?v={{ filemtime(public_path($themeSettings['logo_image'])) }}" alt="দৈনিক ভোলা জার্নাল" style="max-height: 48px; width: auto; object-fit: contain;">
                            </a>
                        @else
                            <h2 class="k-footer-title m-0"><a href="{{ url('/') }}" class="text-decoration-none">{!! $themeSettings['logo_text'] ?? 'দৈনিক ভোলা<span>জার্নাল</span>' !!}</a></h2>
                        @endif
                        <p class="k-footer-tagline mt-1 mb-0">সত্য ও তথ্যের সমন্বয়ে উপকূলের দিনলিপি</p>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="k-footer-nav text-center text-lg-end">
                        <div class="k-nav-row mb-2">
                            <a href="{{ url('/') }}">প্রথম পাতা</a>
                            <span class="sep">•</span>
                            @foreach($categories->take(7) as $cat)
                                <a href="{{ route('category', $cat->slug) }}">{{ $cat->name }}</a>
                                <span class="sep">•</span>
                            @endforeach
                            <a href="{{ route('epaper') }}">ই-পেপার</a>
                        </div>
                        <div class="k-nav-row k-nav-secondary">
                            <a href="{{ route('about.us') }}">আমাদের সম্পর্কে</a>
                            <span class="sep">•</span>
                            <a href="{{ route('privacy.policy') }}">গোপনীয়তা নীতি</a>
                            <span class="sep">•</span>
                            <a href="{{ route('terms.of.use') }}">ব্যবহারের শর্তাবলী</a>
                            <span class="sep">•</span>
                            <a href="{{ route('comment.policy') }}">মন্তব্য নীতিমালা</a>
                            <span class="sep">•</span>
                            <a href="{{ route('editorial.policy') }}">সম্পাদকীয় নীতিমালা</a>
                            <span class="sep">•</span>
                            <a href="{{ route('contact') }}">যোগাযোগ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tier 2: Editorial Board & Office Contact Information -->
        <div class="k-footer-mid py-4 border-bottom">
            <div class="row g-4">
                <div class="col-lg-7 col-md-12">
                    <div class="k-editorial-box text-center text-lg-start">
                        <div class="k-editorial-line mb-2">
                            <span class="k-label">প্রকাশক:</span>
                            <span class="k-val">{{ $themeSettings['editorial_publisher'] ?? 'সামিয়া তালুকদার' }}</span>
                            <span class="mx-2 d-none d-md-inline text-muted">|</span>
                            <span class="k-label">নির্বাহী সম্পাদক:</span>
                            <span class="k-val">{{ $themeSettings['editorial_executive_editor'] ?? 'ইসমাইল হোসেন আরিফ' }}</span>
                        </div>
                        <div class="k-editorial-line">
                            <span class="k-label"><i class="fa-solid fa-location-dot text-danger me-1"></i>বার্তা ও বাণিজ্যিক কার্যালয়:</span>
                            <span class="k-val">{{ $themeSettings['contact_address'] ?? 'ভোলা সদর, ভোলা-৮৩০০।' }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-12">
                    <div class="k-contact-box text-center text-lg-start">
                        <div class="k-editorial-line mb-2">
                            <span class="k-label"><i class="fa-solid fa-phone text-danger me-1"></i>ফোন / মোবাইল:</span>
                            <a href="tel:{{ $themeSettings['contact_phone'] ?? '01716-674375' }}" class="k-val text-decoration-none">{{ $themeSettings['contact_phone'] ?? '01716-674375' }}</a>
                        </div>
                        <div class="k-editorial-line mb-2">
                            <span class="k-label"><i class="fa-solid fa-envelope text-danger me-1"></i>ইমেইল:</span>
                            <a href="mailto:{{ $themeSettings['contact_email'] ?? 'news.dailybholajournal@gmail.com' }}" class="k-val text-decoration-none">{{ $themeSettings['contact_email'] ?? 'news.dailybholajournal@gmail.com' }}</a>
                        </div>
                        <div class="k-editorial-line">
                            <span class="k-label"><i class="fa-solid fa-bullhorn text-danger me-1"></i>বিজ্ঞাপন:</span>
                            <span class="k-val">{{ $themeSettings['contact_email'] ?? 'news.dailybholajournal@gmail.com' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tier 3: Social Connect, Newsletter & E-Paper Quick Action -->
        <div class="k-footer-connect py-3 border-bottom">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <span class="fw-bold text-dark" style="font-size: 0.95rem;">আমাদের সাথে যুক্ত থাকুন:</span>
                    <div class="k-social-buttons d-flex align-items-center gap-2">
                        <a href="{{ $themeSettings['social_facebook'] ?? '#' }}" target="_blank" class="k-social-btn fb" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="{{ $themeSettings['social_youtube'] ?? '#' }}" target="_blank" class="k-social-btn yt" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        <a href="{{ $themeSettings['social_twitter'] ?? '#' }}" target="_blank" class="k-social-btn tw" title="X / Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="{{ $themeSettings['social_instagram'] ?? '#' }}" target="_blank" class="k-social-btn ig" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="{{ $themeSettings['social_whatsapp'] ?? 'https://wa.me/8801716674375' }}" target="_blank" class="k-social-btn wa" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('epaper') }}" class="btn btn-sm btn-outline-danger px-3 py-1 fw-bold rounded-pill">
                        <i class="fa-solid fa-newspaper me-1"></i>আজকের ই-পেপার
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-sm btn-danger px-3 py-1 fw-bold rounded-pill text-white">
                        <i class="fa-solid fa-paper-plane me-1"></i>লেখা বা মতামত পাঠান
                    </a>
                </div>
            </div>
        </div>

        <!-- Tier 4: Bottom Copyright & Anti-Piracy Warning -->
        <div class="k-footer-bottom py-3">
            <div class="row align-items-center g-2 text-center text-md-start">
                <div class="col-md-6">
                    <p class="k-copyright mb-0">
                        স্বত্ব &copy; {{ date('Y') }} {{ $themeSettings['copyright_text'] ?? 'দৈনিক ভোলা জার্নাল। সর্বস্বত্ব সংরক্ষিত।' }}
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="k-warning mb-0">
                        এই ওয়েবসাইটের কোনো লেখা, ছবি বা ভিডিও অনুমতি ছাড়া কপি বা বাণিজ্যিক উদ্দেশ্যে ব্যবহার আইনত দণ্ডনীয় অপরাধ।
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Interactive Logic Scripts -->
<script>
    // Set formatted date in Bengali
    document.addEventListener('DOMContentLoaded', function() {
        const dateSpans = document.querySelectorAll('#currentDate, .currentDateText');
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const banglaDateFormatter = new Intl.DateTimeFormat('bn-BD', options);
        const formattedDate = banglaDateFormatter.format(new Date());
        dateSpans.forEach(el => { el.textContent = formattedDate; });

        // Premium Bengali Calendar Date display (Revised Bangladeshi Calendar 2019)
        const banglaDateSpans = document.querySelectorAll('#banglaDate, .banglaDateText');
        if (banglaDateSpans.length > 0) {
            function getBanglaDate(date) {
                const d = date ? new Date(date) : new Date();
                const day = d.getDate();
                const month = d.getMonth() + 1;
                const year = d.getFullYear();
                const isLeapYear = (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
                const banglaMonths = [
                    "বৈশাখ", "জ্যৈষ্ঠ", "আষাঢ়", "শ্রাবণ", "ভাদ্র", "আশ্বিন",
                    "কার্তিক", "অগ্রহায়ণ", "পৌষ", "মাঘ", "ফাল্গুন", "চৈত্র"
                ];
                const toBanglaNumber = num => {
                    const bnNums = ["০", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"];
                    return num.toString().split("").map(d => bnNums[d] || d).join("");
                };
                let bnDay, bnMonth, bnYear;
                const gregDays = [0, 31, isLeapYear ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
                let dayOfYear = 0;
                for (let i = 1; i < month; i++) {
                    dayOfYear += gregDays[i];
                }
                dayOfYear += day;
                const boishakhDayOfYear = 31 + (isLeapYear ? 29 : 28) + 31 + 14;
                if (dayOfYear >= boishakhDayOfYear) {
                    bnYear = year - 593;
                    dayOfYear -= boishakhDayOfYear;
                } else {
                    bnYear = year - 594;
                    const prevLeapYear = ((year - 1) % 4 === 0 && (year - 1) % 100 !== 0) || ((year - 1) % 400 === 0);
                    const prevYearDays = 365 + (prevLeapYear ? 1 : 0);
                    const lastBoishakhDayOfYear = 31 + (prevLeapYear ? 29 : 28) + 31 + 14;
                    dayOfYear = dayOfYear + prevYearDays - lastBoishakhDayOfYear;
                }
                const monthDays = [31, 31, 31, 31, 31, 30, 30, 30, 30, 30, isLeapYear ? 31 : 30, 30];
                let accum = 0;
                for (let i = 0; i < 12; i++) {
                    if (dayOfYear < accum + monthDays[i]) {
                        bnDay = dayOfYear - accum + 1;
                        bnMonth = i;
                        break;
                    }
                    accum += monthDays[i];
                }
                return `${toBanglaNumber(bnDay)} ${banglaMonths[bnMonth]} ${toBanglaNumber(bnYear)} বঙ্গাব্দ`;
            }
            const bnCalendarFormatted = getBanglaDate(new Date());
            banglaDateSpans.forEach(el => { el.textContent = bnCalendarFormatted; });
        }

        // Drawer Toggle Logic
        const drawer = document.getElementById('mobileDrawer');
        const overlay = document.getElementById('siteOverlay');

        function toggleDrawer() {
            drawer.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        // Attach event listener to mobile hamburger buttons
        const openButtons = document.querySelectorAll('.mobile-menu-toggle, #openDrawerMobile');
        openButtons.forEach(btn => {
            btn.addEventListener('click', toggleDrawer);
        });

        const closeBtn = document.getElementById('closeDrawer');
        if(closeBtn) closeBtn.addEventListener('click', toggleDrawer);
        if(overlay) overlay.addEventListener('click', toggleDrawer);
    });
</script>

<!-- Bootstrap 5.3.3 JS Bundle CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
