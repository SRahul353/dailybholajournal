@php
    if (!isset($popularPosts) || $popularPosts->isEmpty()) {
        $popularPosts = \App\Models\Post::where('status', 'publish')
            ->orderBy('views_count', 'desc')
            ->latest()
            ->limit(8)
            ->get();
    }
    if (!isset($latestPosts) || $latestPosts->isEmpty()) {
        $latestPosts = \App\Models\Post::where('status', 'publish')
            ->latest()
            ->limit(8)
            ->get();
    }
    $bnNumbers = ['1'=>'১', '2'=>'২', '3'=>'৩', '4'=>'৪', '5'=>'৫', '6'=>'৬', '7'=>'৭', '8'=>'৮'];
@endphp

<div class="sidebar-sticky" style="position: sticky; top: 76px;">
    <!-- Daily Star Signature Tabbed Live Feed Widget (সর্বশেষ / সর্বাধিক পঠিত) -->
    <div class="sidebar-tabbed-widget mb-4" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
        <div class="sidebar-tabs d-flex border-bottom" style="border-color: #e5e7eb !important; background-color: #f8fafc;">
            <button class="sidebar-tab-btn active flex-fill py-3 border-0 bg-transparent fw-bold text-center" onclick="switchSidebarTab(event, 'sidebar-tab-latest')" style="font-size: 0.98rem; cursor: pointer; color: var(--accent, #c90000); border-bottom: 3px solid var(--accent, #c90000) !important; font-family: 'Noto Sans Bengali', sans-serif;">
                <i class="fa-solid fa-bolt-lightning me-1 text-danger"></i>সর্বশেষ
            </button>
            <button class="sidebar-tab-btn flex-fill py-3 border-0 bg-transparent fw-bold text-center" onclick="switchSidebarTab(event, 'sidebar-tab-popular')" style="font-size: 0.98rem; cursor: pointer; color: #64748b; border-bottom: 3px solid transparent !important; font-family: 'Noto Sans Bengali', sans-serif;">
                <i class="fa-solid fa-fire-flame-curved me-1 text-danger"></i>সর্বাধিক পঠিত
            </button>
        </div>

        <!-- Latest News Tab Pane -->
        <div id="sidebar-tab-latest" class="sidebar-tab-pane p-3" style="display: block;">
            <ul class="list-unstyled m-0 p-0 d-flex flex-column gap-2">
                @foreach($latestPosts->take(7) as $index => $post)
                    <li class="d-flex align-items-start gap-2 py-2 border-bottom" style="border-color: #f1f5f9 !important;">
                        <span style="font-family: 'Outfit', sans-serif; font-size: 1.15rem; font-weight: 800; color: #cbd5e1; min-width: 22px; line-height: 1.2;">
                            {{ $bnNumbers[$index + 1] ?? ($index + 1) }}
                        </span>
                        <div class="flex-grow-1">
                            <h4 class="m-0" style="font-size: 0.94rem; font-weight: 700; line-height: 1.45;">
                                <a href="{{ route('post', $post->slug) }}" class="text-dark hover-danger">{{ $post->title }}</a>
                            </h4>
                            <small class="text-muted d-block mt-1" style="font-size: 0.76rem;">
                                <i class="fa-regular fa-clock me-1"></i>{{ $post->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Popular News Tab Pane -->
        <div id="sidebar-tab-popular" class="sidebar-tab-pane p-3" style="display: none;">
            <ul class="list-unstyled m-0 p-0 d-flex flex-column gap-2">
                @foreach($popularPosts->take(7) as $index => $post)
                    <li class="d-flex align-items-start gap-2 py-2 border-bottom" style="border-color: #f1f5f9 !important;">
                        <span style="font-family: 'Outfit', sans-serif; font-size: 1.15rem; font-weight: 800; color: var(--accent, #c90000); min-width: 22px; line-height: 1.2;">
                            {{ $bnNumbers[$index + 1] ?? ($index + 1) }}
                        </span>
                        <div class="flex-grow-1">
                            <h4 class="m-0" style="font-size: 0.94rem; font-weight: 700; line-height: 1.45;">
                                <a href="{{ route('post', $post->slug) }}" class="text-dark hover-danger">{{ $post->title }}</a>
                            </h4>
                            <small class="text-muted d-block mt-1" style="font-size: 0.76rem;">
                                <i class="fa-regular fa-eye me-1"></i>{{ $post->views_count }} বার পঠিত
                            </small>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Square Advertisement (300x250) -->
    <div class="homepage-ad-banner mb-4">
        <span class="homepage-ad-label" style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; display: block; text-align: center; margin-bottom: 4px;">বিজ্ঞাপন</span>
        <div class="homepage-ad-box-300" style="width: 100%; height: 250px; background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 6px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8;">
            <i class="fa-solid fa-rectangle-ad text-muted mb-2" style="font-size: 2.2rem;"></i>
            <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">Square Banner Ad (300x250)</span>
            <span style="font-size: 0.75rem; color: #94a3b8; margin-top: 4px;">বিজ্ঞাপনের জন্য যোগাযোগ করুন</span>
        </div>
    </div>

    <!-- E-Paper Widget Box (Daily Star Signature Digital Edition Link) -->
    <div class="sidebar-card mb-4" style="background: linear-gradient(135deg, #111827 0%, #1e293b 100%); color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width: 44px; height: 44px; border-radius: 8px; background-color: var(--accent, #c90000); display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                <i class="fa-solid fa-newspaper text-white"></i>
            </div>
            <div>
                <h4 style="font-size: 1.15rem; font-weight: 800; margin: 0; color: #ffffff; font-family: 'Noto Serif Bengali', serif;">ডিজিটাল ই-পেপার</h4>
                <small style="color: #94a3b8; font-size: 0.8rem;">দৈনিক ভোলা জার্নাল প্রিন্ট সংস্করণ</small>
            </div>
        </div>
        <p style="font-size: 0.86rem; color: #cbd5e1; margin-bottom: 16px; line-height: 1.55;">
            আজকের ছাপা কাগজের প্রতিটি পাতার হুবহু রূপ ডিজিটাল ব্রাউজারে পড়ুন।
        </p>
        <a href="/epaper" class="btn w-100 text-white fw-bold d-flex align-items-center justify-content-center gap-2" style="background-color: var(--accent, #c90000); border-radius: 6px; padding: 10px; font-size: 0.94rem; transition: all 0.25s;">
            <span>আজকের ই-পেপার পড়ুন</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <!-- Social Connect Box -->
    <div class="sidebar-card mb-4 text-center p-3" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px;">
        <h4 style="font-size: 1rem; font-weight: 800; margin-bottom: 12px; color: #111827;">সামাজিক মাধ্যমে ভোলা জার্নাল</h4>
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ $themeSettings['social_facebook'] ?? '#' }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="{{ $themeSettings['social_youtube'] ?? '#' }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-circle" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
            <a href="{{ $themeSettings['social_twitter'] ?? '#' }}" target="_blank" class="btn btn-outline-dark btn-sm rounded-circle" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;" title="Twitter / X"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="{{ $themeSettings['social_instagram'] ?? '#' }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-circle" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
        </div>
    </div>
</div>

<script>
    function switchSidebarTab(event, tabId) {
        event.preventDefault();
        const widget = event.currentTarget.closest('.sidebar-tabbed-widget');
        const tabs = widget.querySelectorAll('.sidebar-tab-btn');
        const panes = widget.querySelectorAll('.sidebar-tab-pane');

        tabs.forEach(tab => {
            tab.style.color = '#64748b';
            tab.style.borderBottomColor = 'transparent';
        });
        panes.forEach(pane => pane.style.display = 'none');

        event.currentTarget.style.color = 'var(--accent, #c90000)';
        event.currentTarget.style.borderBottomColor = 'var(--accent, #c90000)';
        const targetPane = widget.querySelector(`#${tabId}`);
        if (targetPane) {
            targetPane.style.display = 'block';
        }
    }
</script>
