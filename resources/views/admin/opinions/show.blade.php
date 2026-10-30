@extends('layouts.admin')

@section('title', 'মতামত পর্যালোচনা: ' . $submission->title . ' | এডমিন প্যানেল')

@section('content')

    <!-- Breadcrumb & Back Link -->
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.opinions.index') }}" class="btn btn-secondary" style="padding: 6px 14px; font-size: 0.88rem;">
            <i class="fa-solid fa-arrow-left me-1"></i> সকল মতামতের তালিকায় ফিরে যান
        </a>
    </div>

    <!-- Page Header -->
    <div class="content-header" style="margin-bottom: 24px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                <span class="badge" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-size: 0.82rem;">
                    ট্র্যাকিং আইডি: #{{ $submission->id }}
                </span>
                <span class="badge" style="background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; font-size: 0.82rem;">
                    <i class="fa-solid fa-tag me-1"></i>{{ $submission->topic ?? 'সমসাময়িক' }}
                </span>
            </div>
            <h1 class="page-title" style="font-size: 1.65rem;">
                {{ $submission->title }}
            </h1>
        </div>

        <div class="header-actions">
            @if($submission->status === 'approved' && $submission->post)
                <a href="{{ route('post', $submission->post->slug) }}" target="_blank" class="btn btn-primary" style="background-color: #16a34a; border-color: #16a34a;">
                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i>
                    <span>লাইভ পোস্টটি দেখুন</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px;">
            <i class="fa-solid fa-circle-check me-2 text-success"></i>
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="background-color: #fef9c3; border: 1px solid #fde047; color: #854d0e; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px;">
            <i class="fa-solid fa-triangle-exclamation me-2 text-warning"></i>
            <strong>{{ session('warning') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Status Banner -->
    <div style="border-radius: 8px; padding: 16px 20px; margin-bottom: 28px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;
        @if($submission->status === 'approved') background: #f0fdf4; border: 1px solid #86efac; color: #166534;
        @elseif($submission->status === 'rejected') background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;
        @else background: #fffbeb; border: 1px solid #fde68a; color: #92400e; @endif">
        
        <div style="display: flex; align-items: center; gap: 12px;">
            <i class="fa-solid {{ $submission->status === 'approved' ? 'fa-circle-check' : ($submission->status === 'rejected' ? 'fa-circle-xmark' : 'fa-clock') }} fs-4"></i>
            <div>
                <strong style="font-size: 1.05rem;">
                    @if($submission->status === 'approved') স্ট্যাটাস: অনুমোদিত ও প্রকাশিত
                    @elseif($submission->status === 'rejected') স্ট্যাটাস: বাতিলকৃত (Rejected)
                    @else স্ট্যাটাস: পর্যালোচনার অপেক্ষায় রয়েছে (Pending)
                    @endif
                </strong>
                <div style="font-size: 0.85rem; opacity: 0.9;">
                    জমা দেওয়ার সময়: {{ $submission->created_at->format('d M, Y — h:i A') }} ({{ $submission->created_at->diffForHumans() }})
                    @if($submission->approved_at)
                        | অনুমোদন হয়েছে: {{ $submission->approved_at->format('d M, Y — h:i A') }}
                    @endif
                </div>
            </div>
        </div>

        @if($submission->admin_notes)
            <div style="font-size: 0.88rem; background: rgba(255, 255, 255, 0.6); padding: 6px 14px; border-radius: 6px;">
                <strong>এডমিন নোট:</strong> {{ $submission->admin_notes }}
            </div>
        @endif
    </div>

    <!-- Content & Author Grid -->
    <div style="display: grid; grid-template-columns: 1fr; gap: 24px;">
        @media (min-width: 992px) {
            <div style="display: grid; grid-template-columns: 320px 1fr; gap: 28px; align-items: start;">
        }

        <div class="row g-4">
            <!-- Left Column: Writer Profile -->
            <div class="col-lg-4">
                <div class="admin-card" style="margin-bottom: 24px;">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa-solid fa-user-pen me-2 text-danger"></i>লেখকের পরিচিতি</h3>
                    </div>
                    <div class="card-body" style="text-align: center; padding: 24px 20px;">
                        <img src="{{ $submission->author_photo_url }}" 
                             alt="{{ $submission->author_name }}" 
                             style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #dc2626; margin-bottom: 14px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                        
                        <h4 style="font-weight: 800; font-size: 1.15rem; color: var(--text-dark); margin-bottom: 4px;">
                            {{ $submission->author_name }}
                        </h4>
                        
                        <div style="font-size: 0.90rem; color: #64748b; font-weight: 600; margin-bottom: 16px;">
                            {{ $submission->author_designation ?? 'কলাম লেখক' }}
                        </div>

                        <div style="text-align: left; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; font-size: 0.88rem; margin-bottom: 16px;">
                            <div style="margin-bottom: 8px;">
                                <i class="fa-solid fa-phone me-2 text-danger"></i>
                                <strong>মোবাইল:</strong> 
                                <a href="tel:{{ $submission->author_phone }}" class="text-dark">{{ $submission->author_phone }}</a>
                            </div>
                            <div style="margin-bottom: 8px;">
                                <i class="fa-solid fa-envelope me-2 text-danger"></i>
                                <strong>ইমেইল:</strong> 
                                <a href="mailto:{{ $submission->author_email }}" class="text-dark">{{ $submission->author_email }}</a>
                            </div>
                            @if($submission->author_bio)
                                <div style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed #cbd5e1; font-size: 0.84rem; color: #475569;">
                                    <strong>সংক্ষিপ্ত বায়ো:</strong>
                                    <p style="margin-top: 4px; margin-bottom: 0;">{{ $submission->author_bio }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Direct WhatsApp / Call Buttons -->
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $submission->author_phone) }}" target="_blank" class="btn btn-secondary" style="font-size: 0.82rem; padding: 6px 12px; color: #16a34a;">
                                <i class="fa-brands fa-whatsapp me-1"></i> হোয়াটসঅ্যাপ
                            </a>
                            <a href="mailto:{{ $submission->author_email }}" class="btn btn-secondary" style="font-size: 0.82rem; padding: 6px 12px;">
                                <i class="fa-solid fa-envelope me-1"></i> ইমেইল
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Review Actions Card -->
                <div class="admin-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa-solid fa-sliders me-2 text-danger"></i>সম্পাদকীয় সিদ্ধান্ত</h3>
                    </div>
                    <div class="card-body">
                        
                        <!-- Approve Form -->
                        @if($submission->status !== 'approved')
                            <form action="{{ route('admin.opinions.approve', $submission->id) }}" method="POST" style="margin-bottom: 16px;">
                                @csrf
                                <div class="form-group" style="margin-bottom: 12px;">
                                    <label class="form-label" style="font-size: 0.85rem;">অনুমোদনের নোট (ঐচ্ছিক):</label>
                                    <input type="text" name="admin_notes" class="form-control" placeholder="যেমন: সম্পাদকীয় পর্ষদ কর্তৃক অনুমোদিত...">
                                </div>
                                <button type="submit" class="btn btn-primary w-100" style="background-color: #16a34a; border-color: #16a34a; padding: 10px; font-weight: 700;" onclick="return confirm('আপনি কি নিশ্চিত যে এই মতামতটি ওয়েবসাইটে প্রকাশ করতে চান?');">
                                    <i class="fa-solid fa-check-circle me-1"></i> অনুমোদন ও প্রকাশ করুন
                                </button>
                            </form>
                        @else
                            <div class="alert alert-success p-3 text-center mb-3" style="background: #dcfce7; border-color: #86efac; color: #166534; font-size: 0.88rem;">
                                <i class="fa-solid fa-circle-check fs-5 d-block mb-1"></i>
                                লেখাটি ইতোমধ্যে ওয়েবসাইটে প্রকাশ করা হয়েছে।
                            </div>
                        @endif

                        <!-- Reject Form -->
                        @if($submission->status !== 'rejected')
                            <form action="{{ route('admin.opinions.reject', $submission->id) }}" method="POST" style="margin-bottom: 16px;">
                                @csrf
                                <div class="form-group" style="margin-bottom: 12px;">
                                    <label class="form-label" style="font-size: 0.85rem;">বাতিলের কারণ / নোট:</label>
                                    <input type="text" name="admin_notes" class="form-control" placeholder="যেমন: নীতিমালার সাথে সাংঘর্ষিক...">
                                </div>
                                <button type="submit" class="btn btn-secondary w-100" style="color: #b91c1c; border-color: #fecaca; padding: 8px;" onclick="return confirm('আপনি কি এই মতামতটি বাতিল (Reject) করতে চান?');">
                                    <i class="fa-solid fa-ban me-1"></i> লেখাটি বাতিল করুন
                                </button>
                            </form>
                        @endif

                        <!-- Permanent Delete Form -->
                        <div style="border-top: 1px solid var(--border-color); padding-top: 14px; text-align: center;">
                            <form action="{{ route('admin.opinions.destroy', $submission->id) }}" method="POST" onsubmit="return confirm('এই সাবমিশনটি স্থায়ীভাবে মুছে ফেলতে চান?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #94a3b8; font-size: 0.82rem; cursor: pointer; text-decoration: underline;">
                                    <i class="fa-solid fa-trash-can me-1"></i> সাবমিশনটি সম্পূর্ণ মুছে ফেলুন
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Right Column: Article Text & Content -->
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 class="card-title">
                            <i class="fa-solid fa-newspaper me-2 text-danger"></i>মূল লেখার বিষয়বস্তু
                        </h3>
                        <span style="font-size: 0.84rem; color: #64748b;">
                            শব্দ সংখ্যা: {{ count(explode(' ', strip_tags($submission->content))) }} শব্দ
                        </span>
                    </div>

                    <div class="card-body" style="padding: 28px;">
                        
                        <!-- Featured Image if provided -->
                        @if($submission->featured_image)
                            <div style="margin-bottom: 24px; border-radius: 8px; overflow: hidden; max-height: 380px;">
                                <img src="{{ $submission->featured_image_url }}" alt="{{ $submission->title }}" style="width: 100%; height: auto; object-fit: cover;">
                            </div>
                        @endif

                        <h2 style="font-family: 'Noto Serif Bengali', serif; font-size: 1.75rem; font-weight: 800; color: #0f172a; line-height: 1.4; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 2px solid #f1f5f9;">
                            {{ $submission->title }}
                        </h2>

                        <!-- Full Content Body -->
                        <div style="font-size: 1.05rem; line-height: 1.8; color: #1e293b; font-family: 'Noto Serif Bengali', serif; white-space: pre-line;">
                            {{ $submission->content }}
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
