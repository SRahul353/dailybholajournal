@extends('layouts.admin')

@section('title', 'সংবাদ সম্পাদনা | অ্যাডমিন প্যানেল')
@section('header_title', 'সংবাদ সম্পাদনা')

@section('styles')
<style>
    /* Split form layout for media and options */
    .form-split {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }

    @media (min-width: 1024px) {
        .form-split {
            grid-template-columns: 2.2fr 1fr;
        }
    }

    /* Checklist card */
    .checklist-box {
        max-height: 240px;
        overflow-y: auto;
        border: 1px solid var(--border-color);
        padding: 12px 16px;
        border-radius: var(--radius-sm);
        background-color: #f8fafc;
    }

    .check-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.95rem;
        color: var(--text-dark);
        margin-bottom: 8px;
        cursor: pointer;
    }

    .check-label input {
        cursor: pointer;
        accent-color: var(--accent);
    }

    /* Featured Image preview box */
    .image-preview-box {
        width: 100%;
        height: 180px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        margin-bottom: 12px;
        position: relative;
        background-color: rgba(0, 0, 0, 0.15);
    }

    .image-preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-preview-placeholder {
        color: var(--text-sub);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
    }

    .image-preview-placeholder i {
        font-size: 2rem;
    }

    /* Premium CKEditor Custom Styles */
    .ck-editor__editable_inline {
        min-height: 400px;
        background-color: #ffffff !important;
        color: var(--text-dark) !important;
        border: 1px solid var(--border-color) !important;
        font-family: inherit !important;
    }
    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
        border-color: var(--border-color) !important;
    }
    .ck.ck-editor__main>.ck-editor__editable.ck-focused {
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15) !important;
    }
    .ck.ck-toolbar {
        background-color: #f8fafc !important;
        border-color: var(--border-color) !important;
    }
    .ck.ck-button {
        color: var(--text-main) !important;
        cursor: pointer !important;
    }
    .ck.ck-button:hover {
        background-color: #f1f5f9 !important;
        color: var(--text-dark) !important;
    }
    .ck.ck-button.ck-on {
        background-color: #e2e8f0 !important;
        color: var(--text-dark) !important;
    }

    /* Draft alert banner */
    .draft-alert {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #bfdbfe;
        border-radius: var(--radius-sm);
        padding: 12px 18px;
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.08);
    }
    .draft-alert-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .draft-alert-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .draft-alert-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-restore {
        background-color: #2563eb;
        color: #ffffff;
        border: none;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }
    .btn-restore:hover {
        background-color: #1d4ed8;
    }
    .btn-discard {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }
    .btn-discard:hover {
        background-color: #e2e8f0;
        color: #1e293b;
    }

    /* Autosave badge */
    .autosave-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.82rem;
        color: var(--text-sub);
        background: #f1f5f9;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }
    .autosave-badge.saving {
        background: #fef3c7;
        color: #b45309;
        border-color: #fde68a;
    }
    .autosave-badge.saved {
        background: #ecfdf5;
        color: #047857;
        border-color: #a7f3d0;
    }
</style>
@endsection

@section('content')

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-split">
            <!-- Left main writing card -->
            <div class="admin-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 10px;">
                    <h3 class="card-title" style="margin-bottom: 0;">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>সংবাদ বিবরণ সম্পাদন</span>
                    </h3>
                    <div id="autoSaveIndicator" class="autosave-badge" title="স্বয়ংক্রিয় খসড়া সংরক্ষণ">
                        <i class="fa-solid fa-cloud"></i>
                        <span id="autoSaveText">অটো-সেভ সক্রিয়</span>
                    </div>
                </div>

                <!-- Draft Recovery Alert -->
                <div id="draftRecoveryAlert" class="draft-alert" style="display: none;">
                    <div class="draft-alert-left">
                        <div class="draft-alert-icon">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <div>
                            <strong style="color: #1e3a8a; font-size: 0.95rem;">এই সংবাদের একটি অসংরক্ষিত খসড়া পাওয়া গেছে!</strong>
                            <p id="draftSavedTime" style="margin: 2px 0 0; font-size: 0.82rem; color: #475569;">সর্বশেষ সংরক্ষিত: --</p>
                        </div>
                    </div>
                    <div class="draft-alert-actions">
                        <button type="button" id="btnRestoreDraft" class="btn-restore">
                            <i class="fa-solid fa-rotate-left"></i> ফিরিয়ে আনুন
                        </button>
                        <button type="button" id="btnDiscardDraft" class="btn-discard">
                            <i class="fa-solid fa-trash-can"></i> বাতিল করুন
                        </button>
                    </div>
                </div>

                <!-- Title -->
                <div class="form-group">
                    <label for="title" class="form-label">শিরোনাম (Headline)</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required placeholder="এখানে সংবাদের শিরোনাম লিখুন..." class="form-control">
                </div>

                <!-- Reporter / Author Name (Manual) -->
                <div class="form-group">
                    <label for="reporter_name" class="form-label" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 4px;">
                        <span><i class="fa-solid fa-user-pen text-danger me-1"></i> প্রতিবেদক / রিপোর্টারের নাম (ঐচ্ছিক)</span>
                        <span style="font-size: 0.8rem; color: var(--text-sub); font-weight: normal;">খালি রাখলে স্বয়ংক্রিয়ভাবে অনলাইন ডেস্কের নাম দেখাবে</span>
                    </label>
                    <input type="text" name="reporter_name" id="reporter_name" list="reporter_presets" value="{{ old('reporter_name', $post->reporter_name) }}" placeholder="যেমন: নিজস্ব প্রতিবেদক, ভোলা প্রতিনিধি, বিশেষ প্রতিনিধি বা সাংবাদিকের নাম..." class="form-control">
                    <datalist id="reporter_presets">
                        <option value="নিজস্ব প্রতিবেদক">
                        <option value="ভোলা প্রতিনিধি">
                        <option value="বিশেষ প্রতিনিধি">
                        <option value="অনলাইন ডেস্ক">
                        <option value="বোরহানউদ্দিন প্রতিনিধি">
                        <option value="চরফ্যাশন প্রতিনিধি">
                        <option value="দৌলতখান প্রতিনিধি">
                        <option value="লালমোহন প্রতিনিধি">
                        <option value="মনপুরা প্রতিনিধি">
                        <option value="তজুমদ্দিন প্রতিনিধি">
                    </datalist>
                </div>

                <!-- Excerpt -->
                <div class="form-group">
                    <label for="excerpt" class="form-label">সারসংক্ষেপ (Excerpt - সংক্ষিপ্ত বিবরণ)</label>
                    <textarea name="excerpt" id="excerpt" rows="3" placeholder="সংবাদের সংক্ষিপ্ত বিবরণ লিখুন..." class="form-control">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <!-- Content -->
                <div class="form-group">
                    <label for="content" class="form-label">মূল সংবাদ কন্টেন্ট (Main Content) <span class="text-danger">*</span></label>
                    <textarea name="content" id="content" rows="18" placeholder="এখানে মূল খবরটি লিখুন..." class="form-control" style="line-height: 1.7; font-size: 1.05rem;">{{ old('content', $post->content) }}</textarea>
                </div>
            </div>

            <!-- Right options panelpanel -->
            <div>
                <!-- Publish status card -->
                <div class="admin-card">
                    <h3 class="card-title" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>প্রকাশের অবস্থা</span>
                    </h3>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="status" class="form-label">স্ট্যাটাস</label>
                        <select name="status" id="status" class="form-control">
                            <option value="publish" {{ old('status', $post->status) === 'publish' ? 'selected' : '' }}>প্রকাশিত (Publish)</option>
                            <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>খসড়া (Draft)</option>
                        </select>
                    </div>

                    <!-- Publish Date & Time -->
                    <div class="form-group" style="margin-top: 14px;">
                        <label for="published_at" class="form-label">
                            <i class="fa-regular fa-calendar-days text-danger me-1"></i> প্রকাশের তারিখ ও সময়
                        </label>
                        <input type="datetime-local" 
                               name="published_at" 
                               id="published_at" 
                               class="form-control" 
                               value="{{ old('published_at', $post->created_at ? $post->created_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
                        <span class="form-text">সংবাদ প্রকাশের পেছনের বা বর্তমান তারিখ ও সময় পরিবর্তন করতে পারেন।</span>
                    </div>

                    <div style="display: flex; gap: 12px; margin-top: 24px;">
                        <button type="submit" class="btn btn-primary" style="flex-grow: 1; justify-content: center;">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>হালনাগাদ করুন</span>
                        </button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">বাতিল</a>
                    </div>
                </div>

                <!-- Featured Image upload card -->
                <div class="admin-card">
                    <h3 class="card-title" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-image"></i>
                        <span>ফিচার্ড ইমেজ</span>
                    </h3>

                    <div class="image-preview-box" id="previewContainer">
                        @if($post->featured_image)
                            <img src="{{ $post->featured_image_url }}" alt="Featured Image Preview" class="image-preview-img" id="previewImg">
                            <div class="image-preview-placeholder" id="previewPlaceholder" style="display: none;">
                                <i class="fa-regular fa-image"></i>
                                <span>ছবি নির্বাচন করা হয়নি</span>
                            </div>
                        @else
                            <img src="" alt="Featured Image Preview" class="image-preview-img" id="previewImg" style="display: none;">
                            <div class="image-preview-placeholder" id="previewPlaceholder">
                                <i class="fa-regular fa-image"></i>
                                <span>ছবি নির্বাচন করা হয়নি</span>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <input type="file" name="featured_image" id="featured_image" accept="image/*" class="form-control" onchange="previewImage(this)">
                        <span class="form-text">নতুন ছবি আপলোড করতে পারেন। ছবির সাইজ ৫ মেগাবাইটের কম হতে হবে।</span>
                    </div>
                </div>

                <!-- Categories Checklist -->
                <div class="admin-card">
                    <h3 class="card-title" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-folder-open"></i>
                        <span>ক্যাটাগরি সমূহ</span>
                    </h3>

                    <div class="checklist-box">
                        @php
                            $selectedCats = old('categories', $post->categories->pluck('id')->toArray());
                        @endphp
                        @forelse($categories as $cat)
                            <label class="check-label">
                                <input type="checkbox" name="categories[]" value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCats) ? 'checked' : '' }}>
                                <span>{{ $cat->name }}</span>
                            </label>
                        @empty
                            <p style="color: var(--text-sub); font-size: 0.9rem;">কোনো ক্যাটাগরি পাওয়া যায়নি।</p>
                        @endforelse
                    </div>
                </div>

                <!-- Tags Checklist -->
                <div class="admin-card">
                    <h3 class="card-title" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-tags"></i>
                        <span>ট্যাগসমূহ</span>
                    </h3>

                    <div class="checklist-box" style="margin-bottom: 16px;">
                        @php
                            $selectedTags = old('tags', $post->tags->pluck('id')->toArray());
                        @endphp
                        @forelse($tags as $tag)
                            <label class="check-label">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}>
                                <span>{{ $tag->name }}</span>
                            </label>
                        @empty
                            <p style="color: var(--text-sub); font-size: 0.9rem; margin-bottom: 0;">কোনো ট্যাগ পাওয়া যায়নি।</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>


    </form>

@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    class Base64UploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }
        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = () => {
                        resolve({ default: reader.result });
                    };
                    reader.onerror = error => {
                        reject(error);
                    };
                    reader.readAsDataURL(file);
                }));
        }
        abort() {}
    }

    function Base64UploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new Base64UploadAdapter(loader);
        };
    }

    let postEditorInstance = null;
    let isEditorReady = false;
    let isDirty = false;
    let isSubmitting = false;
    let autoSaveTimeout = null;
    const DRAFT_STORAGE_KEY = 'dailybholajournal_news_draft_edit_{{ $post->id }}';

    function markDirtyAndScheduleSave() {
        if (!isEditorReady) return;
        isDirty = true;
        if (autoSaveTimeout) clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(executeAutoSave, 1500);
    }

    function executeAutoSave() {
        if (isSubmitting) return;

        const titleEl = document.getElementById('title');
        const reporterNameEl = document.getElementById('reporter_name');
        const excerptEl = document.getElementById('excerpt');
        const contentEl = document.getElementById('content');
        const statusEl = document.getElementById('status');
        const publishedAtEl = document.getElementById('published_at');

        const titleVal = titleEl ? titleEl.value.trim() : '';
        const reporterNameVal = reporterNameEl ? reporterNameEl.value.trim() : '';
        const excerptVal = excerptEl ? excerptEl.value.trim() : '';
        const contentVal = postEditorInstance ? postEditorInstance.getData() : (contentEl ? contentEl.value : '');
        const statusVal = statusEl ? statusEl.value : 'publish';
        const publishedAtVal = publishedAtEl ? publishedAtEl.value : '';

        const selectedCategories = Array.from(document.querySelectorAll('input[name="categories[]"]:checked')).map(cb => cb.value);
        const selectedTags = Array.from(document.querySelectorAll('input[name="tags[]"]:checked')).map(cb => cb.value);

        const stripped = contentVal.replace(/<[^>]*>/g, '').trim();
        // If empty, do not save
        if (!titleVal && !stripped && !excerptVal) {
            return;
        }

        const indicator = document.getElementById('autoSaveIndicator');
        if (indicator) {
            indicator.className = 'autosave-badge saving';
            indicator.innerHTML = '<i class="fa-solid fa-arrows-rotate fa-spin"></i> <span>সংরক্ষণ হচ্ছে...</span>';
        }

        const draftData = {
            title: titleVal,
            reporter_name: reporterNameVal,
            excerpt: excerptVal,
            content: contentVal,
            status: statusVal,
            published_at: publishedAtVal,
            categories: selectedCategories,
            tags: selectedTags,
            savedAt: new Date().toISOString()
        };

        try {
            localStorage.setItem(DRAFT_STORAGE_KEY, JSON.stringify(draftData));
            const timeStr = new Date().toLocaleTimeString('bn-BD', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            if (indicator) {
                indicator.className = 'autosave-badge saved';
                indicator.innerHTML = `<i class="fa-solid fa-circle-check"></i> <span>খসড়া সংরক্ষিত: ${timeStr}</span>`;
                setTimeout(() => {
                    if (indicator.classList.contains('saved')) {
                        indicator.className = 'autosave-badge';
                        indicator.innerHTML = `<i class="fa-solid fa-cloud"></i> <span>সংরক্ষিত: ${timeStr}</span>`;
                    }
                }, 4000);
            }
        } catch (e) {
            console.warn('LocalStorage draft error:', e);
            if (indicator) {
                indicator.className = 'autosave-badge';
                indicator.innerHTML = '<i class="fa-solid fa-cloud"></i> <span>অটো-সেভ সক্রিয়</span>';
            }
        }
    }

    function checkDraftOnLoad() {
        try {
            const raw = localStorage.getItem(DRAFT_STORAGE_KEY);
            if (!raw) return;
            const draft = JSON.parse(raw);
            if (!draft) return;

            const initialTitle = document.getElementById('title')?.value || '';
            const initialReporter = document.getElementById('reporter_name')?.value || '';
            const initialExcerpt = document.getElementById('excerpt')?.value || '';
            const initialContent = postEditorInstance ? postEditorInstance.getData() : (document.getElementById('content')?.value || '');

            // Compare stored draft against current database values
            const isDifferent = (draft.title && draft.title.trim() !== initialTitle.trim()) ||
                                (draft.reporter_name !== undefined && draft.reporter_name.trim() !== initialReporter.trim()) ||
                                (draft.excerpt && draft.excerpt.trim() !== initialExcerpt.trim()) ||
                                (draft.content && draft.content.trim() !== initialContent.trim());

            if (!isDifferent) {
                // Draft matches DB, clear obsolete local draft
                localStorage.removeItem(DRAFT_STORAGE_KEY);
                return;
            }

            let savedDateText = '';
            if (draft.savedAt) {
                const d = new Date(draft.savedAt);
                savedDateText = d.toLocaleDateString('bn-BD', { day: 'numeric', month: 'short', year: 'numeric' }) + ' ' +
                                d.toLocaleTimeString('bn-BD', { hour: '2-digit', minute: '2-digit' });
            }

            const alertBox = document.getElementById('draftRecoveryAlert');
            const timeBox = document.getElementById('draftSavedTime');
            if (alertBox) {
                if (timeBox && savedDateText) {
                    timeBox.textContent = 'সর্বশেষ সংরক্ষিত: ' + savedDateText;
                }
                alertBox.style.display = 'flex';
            }

            const btnRestore = document.getElementById('btnRestoreDraft');
            if (btnRestore) {
                btnRestore.onclick = function() {
                    if (draft.title) document.getElementById('title').value = draft.title;
                    if (draft.reporter_name !== undefined) {
                        const rn = document.getElementById('reporter_name');
                        if (rn) rn.value = draft.reporter_name;
                    }
                    if (draft.excerpt) document.getElementById('excerpt').value = draft.excerpt;
                    if (draft.content) {
                        if (postEditorInstance) {
                            postEditorInstance.setData(draft.content);
                        }
                        const contentEl = document.getElementById('content');
                        if (contentEl) contentEl.value = draft.content;
                    }
                    if (draft.status) document.getElementById('status').value = draft.status;
                    if (draft.published_at) document.getElementById('published_at').value = draft.published_at;

                    if (Array.isArray(draft.categories)) {
                        document.querySelectorAll('input[name="categories[]"]').forEach(cb => {
                            cb.checked = draft.categories.includes(cb.value);
                        });
                    }

                    if (Array.isArray(draft.tags)) {
                        document.querySelectorAll('input[name="tags[]"]').forEach(cb => {
                            cb.checked = draft.tags.includes(cb.value);
                        });
                    }

                    isDirty = true;
                    if (alertBox) {
                        alertBox.style.background = '#f0fdf4';
                        alertBox.style.borderColor = '#bbf7d0';
                        alertBox.innerHTML = `
                            <div style="display: flex; align-items: center; gap: 10px; color: #166534; font-weight: 600; padding: 4px 0;">
                                <i class="fa-solid fa-circle-check" style="font-size: 1.2rem; color: #16a34a;"></i>
                                <span>পূর্বের খসড়া সফলভাবে ফিরিয়ে আনা হয়েছে!</span>
                            </div>
                        `;
                        setTimeout(() => {
                            alertBox.style.display = 'none';
                        }, 3500);
                    }
                };
            }

            const btnDiscard = document.getElementById('btnDiscardDraft');
            if (btnDiscard) {
                btnDiscard.onclick = function() {
                    try {
                        localStorage.removeItem(DRAFT_STORAGE_KEY);
                    } catch (e) {}
                    if (alertBox) {
                        alertBox.style.display = 'none';
                    }
                };
            }
        } catch (e) {
            console.warn('Draft check error:', e);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const contentEl = document.querySelector('#content');
        if (typeof ClassicEditor !== 'undefined' && contentEl) {
            ClassicEditor
                .create(contentEl, {
                    extraPlugins: [Base64UploadAdapterPlugin],
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', '|',
                            'bulletedList', 'numberedList', 'blockQuote', '|',
                            'imageUpload', 'link', '|',
                            'undo', 'redo'
                        ]
                    }
                })
                .then(editor => {
                    postEditorInstance = editor;
                    editor.model.document.on('change:data', () => {
                        contentEl.value = editor.getData();
                        markDirtyAndScheduleSave();
                    });

                    setTimeout(() => {
                        isEditorReady = true;
                        checkDraftOnLoad();
                    }, 300);
                })
                .catch(error => {
                    console.error('CKEditor init error:', error);
                    isEditorReady = true;
                    checkDraftOnLoad();
                });
        } else {
            isEditorReady = true;
            checkDraftOnLoad();
        }

        // Form inputs change listeners
        const listenInputs = [
            document.getElementById('title'),
            document.getElementById('reporter_name'),
            document.getElementById('excerpt'),
            document.getElementById('status'),
            document.getElementById('published_at')
        ];
        listenInputs.forEach(el => {
            if (el) {
                el.addEventListener('input', markDirtyAndScheduleSave);
                el.addEventListener('change', markDirtyAndScheduleSave);
            }
        });

        document.querySelectorAll('input[name="categories[]"], input[name="tags[]"]').forEach(cb => {
            cb.addEventListener('change', markDirtyAndScheduleSave);
        });

        // Form submit safety & validation
        const formEl = document.querySelector('form');
        if (formEl) {
            formEl.addEventListener('submit', function(e) {
                let contentVal = '';
                if (postEditorInstance) {
                    contentVal = postEditorInstance.getData();
                    contentEl.value = contentVal;
                } else {
                    contentVal = contentEl.value;
                }

                const stripped = contentVal.replace(/<[^>]*>/g, '').trim();
                if (!stripped && !contentVal.includes('<img')) {
                    e.preventDefault();
                    alert('অনুগ্রহ করে সংবাদের মূল কন্টেন্ট লিখুন।');
                    if (postEditorInstance) {
                        postEditorInstance.editing.view.focus();
                    } else {
                        contentEl.focus();
                    }
                    return false;
                }

                // Legitimate submission: allow leaving and purge local draft
                isSubmitting = true;
                isDirty = false;
                try {
                    localStorage.removeItem(DRAFT_STORAGE_KEY);
                } catch(err) {}
            });
        }

        // Warning when closing tab or navigating away with unsaved changes
        window.addEventListener('beforeunload', function(e) {
            if (isDirty && !isSubmitting) {
                e.preventDefault();
                e.returnValue = '';
                return '';
            }
        });

        // Periodic auto-save every 25 seconds if changes occurred
        setInterval(function() {
            if (isDirty && !isSubmitting) {
                executeAutoSave();
            }
        }, 25000);
    });

    // Sync Featured Image upload local preview
    function previewImage(input) {
        const previewImg = document.getElementById('previewImg');
        const placeholder = document.getElementById('previewPlaceholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                }
                if (placeholder) placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            @if($post->featured_image)
                if (previewImg) {
                    previewImg.src = '{{ $post->featured_image_url }}';
                    previewImg.style.display = 'block';
                }
                if (placeholder) placeholder.style.display = 'none';
            @else
                if (previewImg) {
                    previewImg.src = '';
                    previewImg.style.display = 'none';
                }
                if (placeholder) placeholder.style.display = 'flex';
            @endif
        }
    }
</script>
@endsection
