{{-- Mobile-only top bar: title + inspector toggle + settings gear --}}
<div class="d-flex d-md-none align-items-center justify-content-between px-3 py-2 border-bottom bg-white"
     style="position: sticky; top: 70px; z-index: 50; box-shadow: 0 2px 6px rgba(0,0,0,0.07);">
    <span style="font-size: 0.88rem; font-weight: 700; color: #0f172a;">
        <i class="fa-solid fa-wand-magic-sparkles text-danger me-2"></i>সোশ্যাল কার্ড স্টুডিও
    </span>
    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="savePersistentCardSettings()" title="ডিফল্ট হিসেবে সেভ করুন" style="border-radius: 6px; font-weight: 700; font-size: 0.82rem;">
            <i class="fa-solid fa-floppy-disk me-1"></i> সেভ
        </button>
        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cardSettingsModal" style="border-radius: 6px; font-weight: 600; font-size: 0.82rem;">
            <i class="fa-solid fa-gear me-1"></i> সেটিংস
        </button>
        <button type="button" id="mobileInspectorToggle"
                onclick="toggleMobileInspector()"
                class="btn btn-sm"
                style="background:#f1f5f9; border:1px solid #e2e8f0; color:#334155; font-size:0.82rem; border-radius:6px; padding:6px 12px;">
            <i class="fa-solid fa-sliders me-1"></i> কাস্টমাইজ
        </button>
    </div>
</div>
