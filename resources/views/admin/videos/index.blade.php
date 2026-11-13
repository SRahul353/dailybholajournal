@extends('layouts.admin')

@section('title', 'ভিডিও গ্যালারি | দৈনিক ভোলা জার্নাল অ্যাডমিন প্যানেল')
@section('header_title', 'ভিডিও গ্যালারি ম্যানেজমেন্ট')

@section('styles')
<style>
    .video-manager-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
    }

    .video-item-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .video-item-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    }

    .video-thumb-box {
        width: 140px;
        height: 78px;
        border-radius: 6px;
        overflow: hidden;
        background: #0f172a;
        flex-shrink: 0;
        position: relative;
        cursor: pointer;
    }

    .video-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.2s ease;
    }

    .video-thumb-box:hover img {
        transform: scale(1.05);
    }

    .video-thumb-play {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.35);
        color: #ffffff;
        font-size: 1.4rem;
        transition: background 0.2s ease;
    }

    .video-thumb-box:hover .video-thumb-play {
        background: rgba(220, 38, 38, 0.7);
    }

    .video-badge-yt {
        position: absolute;
        bottom: 4px;
        right: 4px;
        background: rgba(15, 23, 42, 0.85);
        color: #ffffff;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .video-info-col {
        flex-grow: 1;
        min-width: 0;
    }

    .video-title-text {
        font-weight: 700;
        font-size: 1rem;
        color: var(--text-dark);
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .video-meta-row {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        font-size: 0.82rem;
        color: var(--text-sub);
    }

    .video-meta-link {
        color: #2563eb;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .video-meta-link:hover {
        text-decoration: underline;
    }

    .video-actions-col {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    /* Live Add Preview Card */
    .add-preview-box {
        display: none;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: var(--radius-sm);
        padding: 12px;
        margin-top: 12px;
    }

    @media (max-width: 768px) {
        .video-item-card {
            flex-direction: column;
            align-items: flex-start;
        }
        .video-thumb-box {
            width: 100%;
            height: 160px;
        }
        .video-actions-col {
            width: 100%;
            justify-content: flex-end;
            border-top: 1px solid var(--border-color);
            padding-top: 10px;
            margin-top: 4px;
        }
    }
</style>
@endsection

@section('content')

    <!-- Flash Alerts -->
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4" style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 18px; border-radius: var(--radius-sm);">
            <i class="fa-solid fa-circle-check text-success fs-5"></i>
            <span class="fw-semibold">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 18px; border-radius: var(--radius-sm);">
            <i class="fa-solid fa-triangle-exclamation text-danger fs-5"></i>
            <span class="fw-semibold">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Header & Info -->
    <div class="admin-card">
        <div class="video-manager-header">
            <div>
                <h3 class="card-title mb-1">
                    <i class="fa-brands fa-youtube text-danger me-2"></i>
                    <span>হোমপেজ ভিডিও গ্যালারি ম্যানেজমেন্ট</span>
                </h3>
                <p class="mb-0 text-muted" style="font-size: 0.88rem;">
                    হোমপেজের ভিডিও গ্যালারিতে যেকোনো ইউটিউব ভিডিওর লিংক দিন। এখান থেকে পরিবর্তন করলে হোমপেজে অবিলম্বে স্বয়ংক্রিয়ভাবে আপডেট হবে।
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('home') }}#videoGallerySection" target="_blank" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>হোমপেজে দেখুন</span>
                </a>
                <span class="badge bg-danger px-3 py-2" style="font-size: 0.82rem;">
                    মোট {{ count($videos) }}টি ভিডিও
                </span>
            </div>
        </div>

        <!-- Add New Video Form -->
        <div class="p-4 mb-4 border rounded" style="background: #f8fafc; border-color: var(--border-color) !important;">
            <h5 class="fw-bold text-dark mb-3" style="font-size: 1.02rem;">
                <i class="fa-solid fa-circle-plus text-danger me-2"></i>নতুন ভিডিও যুক্ত করুন
            </h5>

            <form action="{{ route('admin.videos.add') }}" method="POST" id="addVideoForm">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-lg-5 col-md-6">
                        <label class="form-label fw-semibold small mb-1" for="new_title">
                            ভিডিওর শিরোনাম (Video Title)
                        </label>
                        <input type="text" name="title" id="new_title" class="form-control" placeholder="যেমন: ভোলা-বরিশাল সেতু নির্মাণ প্রকল্পের অগ্রগতি" required>
                    </div>

                    <div class="col-lg-5 col-md-6">
                        <label class="form-label fw-semibold small mb-1" for="new_url">
                            ইউটিউব লিংক বা আইডি (YouTube URL / ID) <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="youtube_url" id="new_url" class="form-control" placeholder="যেমন: https://www.youtube.com/watch?v=... বা https://youtu.be/..." required oninput="handleUrlInput(this.value)">
                        <span class="form-text" style="font-size: 0.76rem;">সাধারণ ভিডিও, শর্টস (Shorts), মোবাইল লিংক বা ১১ অক্ষরের আইডি সবই সাপোর্ট করে।</span>
                    </div>

                    <div class="col-lg-2 col-md-12">
                        <button type="submit" class="btn btn-danger w-100 fw-bold d-flex align-items-center justify-content-center gap-1 py-2">
                            <i class="fa-solid fa-plus"></i>
                            <span>ভিডিও যুক্ত করুন</span>
                        </button>
                    </div>
                </div>

                <!-- Real-time Live Preview Box for Add Form -->
                <div id="addPreviewBox" class="add-preview-box">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 100px; height: 56px; border-radius: 4px; overflow: hidden; background: #000; flex-shrink: 0; position: relative;">
                            <img id="addPreviewImg" src="" alt="Thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                            <span class="position-absolute bottom-0 end-0 bg-dark text-white px-1 font-monospace" style="font-size: 9px;">Live</span>
                        </div>
                        <div>
                            <span class="badge bg-success mb-1" style="font-size: 0.7rem;"><i class="fa-solid fa-check me-1"></i>সঠিক ইউটিউব ভিডিও শনাক্ত হয়েছে</span>
                            <div class="small text-muted font-monospace" id="addPreviewMeta">ID: --</div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Video List -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark m-0" style="font-size: 1.02rem;">
                <i class="fa-solid fa-list-check text-primary me-2"></i>বর্তমান ভিডিও গ্যালারি তালিকা
            </h5>
            <span class="text-muted small">
                <i class="fa-solid fa-info-circle me-1"></i>প্রথম ভিডিওটি হোমপেজে প্রধান আকর্ষণ হিসেবে প্রদর্শিত হয়।
            </span>
        </div>

        <div id="videoListContainer" class="d-flex flex-column gap-3">
            @forelse($videos as $index => $vid)
                @php
                    $vId = $vid['video_id'] ?? '';
                    if (empty($vId) && !empty($vid['youtube_url'])) {
                        $vId = \App\Http\Controllers\Admin\AdminVideoGalleryController::extractYouTubeId($vid['youtube_url']) ?: '';
                    }
                    $thumb = $vid['thumbnail'] ?? (!empty($vId) ? "https://img.youtube.com/vi/{$vId}/hqdefault.jpg" : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400');
                    $title = $vid['title'] ?? 'ভিডিও সংবাদ';
                    $url = $vid['youtube_url'] ?? (!empty($vId) ? "https://www.youtube.com/watch?v={$vId}" : '#');
                @endphp

                <div class="video-item-card" data-index="{{ $index }}">
                    <!-- Thumbnail with play button -->
                    <div class="video-thumb-box" onclick="previewPlayVideo('{{ $vId }}', '{{ addslashes($title) }}')" title="ক্লিক করে ভিডিও প্লে করুন">
                        <img src="{{ $thumb }}" alt="{{ $title }}">
                        <div class="video-thumb-play">
                            <i class="fa-solid fa-play"></i>
                        </div>
                        <span class="video-badge-yt">YouTube</span>
                    </div>

                    <!-- Title & Details -->
                    <div class="video-info-col">
                        <h4 class="video-title-text" title="{{ $title }}">{{ $title }}</h4>
                        <div class="video-meta-row">
                            <a href="{{ $url }}" target="_blank" class="video-meta-link">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                <span class="text-truncate" style="max-width: 320px;">{{ $url }}</span>
                            </a>
                            <span>
                                <i class="fa-solid fa-hashtag me-1"></i>আইডি: <code>{{ $vId }}</code>
                            </span>
                            @if($index === 0)
                                <span class="badge bg-success" style="font-size: 0.7rem;">
                                    <i class="fa-solid fa-star me-1"></i>হোমপেজ প্রধান ভিডিও
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="video-actions-col">
                        <!-- Play Preview Button -->
                        <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2" title="ভিডিও প্লে করে দেখুন" onclick="previewPlayVideo('{{ $vId }}', '{{ addslashes($title) }}')">
                            <i class="fa-solid fa-play"></i>
                        </button>

                        <!-- Edit Button -->
                        <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2" title="ভিডিও পরিবর্তন / সম্পাদনা করুন" onclick="openEditModal({{ $index }}, '{{ addslashes($title) }}', '{{ addslashes($url) }}', '{{ $vId }}')">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>

                        <!-- Move Up -->
                        <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2" title="উপরে তুলুন" onclick="reorderVideo({{ $index }}, -1)" {{ $index === 0 ? 'disabled' : '' }}>
                            <i class="fa-solid fa-arrow-up"></i>
                        </button>

                        <!-- Move Down -->
                        <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2" title="নিচে নামান" onclick="reorderVideo({{ $index }}, 1)" {{ $index === count($videos) - 1 ? 'disabled' : '' }}>
                            <i class="fa-solid fa-arrow-down"></i>
                        </button>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.videos.delete') }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই ভিডিওটি গ্যালারি থেকে মুছে ফেলতে চান?');">
                            @csrf
                            <input type="hidden" name="index" value="{{ $index }}">
                            <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2 ms-1" title="মুছে ফেলুন">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-5 text-center bg-light rounded border">
                    <i class="fa-brands fa-youtube text-danger mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                    <h5 class="fw-bold text-dark">বর্তমানে কোনো ভিডিও যুক্ত নেই</h5>
                    <p class="text-muted small mb-0">ওপরের ফর্ম থেকে যেকোনো ইউটিউব লিংক দিয়ে ভিডিও যোগ করুন।</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Edit Video Modal -->
    <div class="modal fade" id="editVideoModal" tabindex="-1" aria-labelledby="editVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border shadow-lg">
                <form action="{{ route('admin.videos.updateItem') }}" method="POST">
                    @csrf
                    <input type="hidden" name="index" id="edit_index" value="">
                    
                    <div class="modal-header py-3 px-4 border-bottom">
                        <h5 class="modal-title fw-bold text-dark" id="editVideoModalLabel">
                            <i class="fa-solid fa-pen-to-square text-primary me-2"></i>ভিডিও পরিবর্তন ও সম্পাদনা
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold small" for="edit_title">ভিডিওর শিরোনাম (Video Title)</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold small" for="edit_url">ইউটিউব লিংক বা আইডি (YouTube URL / ID)</label>
                            <input type="text" name="youtube_url" id="edit_url" class="form-control" required oninput="handleEditUrlInput(this.value)">
                            <span class="form-text" style="font-size: 0.78rem;">নতুন লিংক দিলে থাম্বনেইল স্বয়ংক্রিয়ভাবে পরিবর্তিত হবে।</span>
                        </div>

                        <!-- Live Modal Thumbnail Preview -->
                        <div class="p-2 bg-light border rounded d-flex align-items-center gap-3">
                            <div style="width: 120px; height: 68px; border-radius: 4px; overflow: hidden; background: #000; flex-shrink: 0; position: relative;">
                                <img id="editThumbPreview" src="" alt="Thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="small">
                                <span class="fw-bold d-block text-dark mb-1">প্রিভিউ থাম্বনেইল</span>
                                <span class="text-muted font-monospace" id="editIdPreview">ID: --</span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer py-2 px-4 border-top">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                        <button type="submit" class="btn btn-primary fw-semibold">
                            <i class="fa-solid fa-floppy-disk me-1"></i>পরিবর্তন সংরক্ষণ করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Play Video Modal -->
    <div class="modal fade" id="playVideoModal" tabindex="-1" aria-labelledby="playVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-secondary shadow-lg">
                <div class="modal-header border-secondary py-2 px-3">
                    <h5 class="modal-title fs-6 text-truncate" id="playVideoModalLabel">
                        <i class="fa-brands fa-youtube text-danger me-2"></i>ভিডিও প্লেয়ার
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="stopPreviewVideo()"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9 bg-black">
                        <iframe id="previewVideoIframe" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // YouTube ID extractor in Javascript (supports standard, shorts, live, mobile, embed, bare ID)
    function extractYouTubeId(url) {
        if (!url) return null;
        url = url.trim();
        if (/^[a-zA-Z0-9_-]{11}$/.test(url)) return url;
        const regExp = /(?:youtu\.be\/|(?:m\.|www\.)?youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=|shorts\/|live\/))([\w-]{11})/i;
        const match = url.match(regExp);
        return match ? match[1] : null;
    }

    // Handle Add Form Live URL Preview
    function handleUrlInput(val) {
        const previewBox = document.getElementById('addPreviewBox');
        const previewImg = document.getElementById('addPreviewImg');
        const previewMeta = document.getElementById('addPreviewMeta');
        const id = extractYouTubeId(val);

        if (id) {
            previewBox.style.display = 'block';
            previewImg.src = `https://img.youtube.com/vi/${id}/hqdefault.jpg`;
            previewMeta.innerText = `YouTube ID: ${id}`;
        } else {
            previewBox.style.display = 'none';
        }
    }

    // Handle Edit Modal Live URL Preview
    function handleEditUrlInput(val) {
        const previewImg = document.getElementById('editThumbPreview');
        const previewMeta = document.getElementById('editIdPreview');
        const id = extractYouTubeId(val);

        if (id) {
            previewImg.src = `https://img.youtube.com/vi/${id}/hqdefault.jpg`;
            previewMeta.innerText = `YouTube ID: ${id}`;
        }
    }

    // Open Edit Modal
    function openEditModal(index, title, url, videoId) {
        document.getElementById('edit_index').value = index;
        document.getElementById('edit_title').value = title;
        document.getElementById('edit_url').value = url;
        
        const previewImg = document.getElementById('editThumbPreview');
        const previewMeta = document.getElementById('editIdPreview');
        const finalId = videoId || extractYouTubeId(url);
        
        if (finalId) {
            previewImg.src = `https://img.youtube.com/vi/${finalId}/hqdefault.jpg`;
            previewMeta.innerText = `YouTube ID: ${finalId}`;
        }

        const modalEl = document.getElementById('editVideoModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }

    // Play/Preview Video in Modal
    function previewPlayVideo(videoId, title) {
        if (!videoId) return;
        const modalEl = document.getElementById('playVideoModal');
        const iframe = document.getElementById('previewVideoIframe');
        const titleEl = document.getElementById('playVideoModalLabel');

        if (titleEl) {
            titleEl.innerHTML = `<i class="fa-brands fa-youtube text-danger me-2"></i>` + (title || 'ভিডিও প্লেয়ার');
        }
        if (iframe) {
            iframe.src = `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&rel=0`;
        }
        if (modalEl) {
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }
    }

    function stopPreviewVideo() {
        const iframe = document.getElementById('previewVideoIframe');
        if (iframe) {
            iframe.src = '';
        }
    }

    // Reorder videos via JSON POST
    const currentVideos = @json($videos);

    function reorderVideo(index, direction) {
        const targetIndex = index + direction;
        if (targetIndex < 0 || targetIndex >= currentVideos.length) return;

        // Swap in array
        const temp = currentVideos[index];
        currentVideos[index] = currentVideos[targetIndex];
        currentVideos[targetIndex] = temp;

        // Submit to backend via form or fetch
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('admin.videos.save') }}";
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        const dataInput = document.createElement('input');
        dataInput.type = 'hidden';
        dataInput.name = 'videos';
        dataInput.value = JSON.stringify(currentVideos);
        form.appendChild(dataInput);

        document.body.appendChild(form);
        form.submit();
    }

    // Stop video on modal dismiss
    document.addEventListener('DOMContentLoaded', function() {
        const playModalEl = document.getElementById('playVideoModal');
        if (playModalEl) {
            playModalEl.addEventListener('hidden.bs.modal', function() {
                stopPreviewVideo();
            });
        }
    });
</script>
@endsection
