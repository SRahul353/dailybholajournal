@extends('layouts.admin')

@section('title', 'মতামত ও কলাম সাবমিশন | এডমিন প্যানেল')

@section('content')

    <!-- Page Header -->
    <div class="content-header">
        <div>
            <h1 class="page-title">
                <i class="fa-solid fa-pen-nib text-danger me-2"></i>মতামত ও কলাম সাবমিশন
            </h1>
            <p class="page-subtitle">পাঠক ও লেখকদের পাঠানো মতামত ও কলামসমূহ পর্যালোচনা, অনুমোদন ও সংবাদ হিসেবে প্রকাশ করুন।</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('opinion.submit') }}" target="_blank" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>পাবলিক সাবমিশন ফর্ম দেখুন</span>
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <i class="fa-solid fa-circle-check me-2 text-success"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="background-color: #fef9c3; border: 1px solid #fde047; color: #854d0e; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <i class="fa-solid fa-triangle-exclamation me-2 text-warning"></i>
                <strong>{{ session('warning') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Status Tabs & Search Filter -->
    <div class="admin-card" style="margin-bottom: 24px;">
        <div class="card-body" style="padding: 16px 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                
                <!-- Status Filter Pills -->
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <a href="{{ route('admin.opinions.index', ['status' => 'all', 'search' => $search]) }}" 
                       class="btn {{ $status === 'all' ? 'btn-primary' : 'btn-secondary' }}" 
                       style="padding: 6px 14px; font-size: 0.88rem; border-radius: 20px;">
                        <span>সকল মতামত</span>
                        <span class="badge {{ $status === 'all' ? 'bg-white text-dark' : 'bg-secondary text-white' }} ms-1">{{ $countAll }}</span>
                    </a>

                    <a href="{{ route('admin.opinions.index', ['status' => 'pending', 'search' => $search]) }}" 
                       class="btn {{ $status === 'pending' ? 'btn-primary' : 'btn-secondary' }}" 
                       style="padding: 6px 14px; font-size: 0.88rem; border-radius: 20px; {{ $countPending > 0 && $status !== 'pending' ? 'border-color: #ef4444; color: #ef4444;' : '' }}">
                        <i class="fa-solid fa-clock me-1"></i>
                        <span>অপেক্ষমাণ (Pending)</span>
                        <span class="badge {{ $status === 'pending' ? 'bg-white text-danger' : 'bg-danger text-white' }} ms-1">{{ $countPending }}</span>
                    </a>

                    <a href="{{ route('admin.opinions.index', ['status' => 'approved', 'search' => $search]) }}" 
                       class="btn {{ $status === 'approved' ? 'btn-primary' : 'btn-secondary' }}" 
                       style="padding: 6px 14px; font-size: 0.88rem; border-radius: 20px;">
                        <i class="fa-solid fa-circle-check me-1"></i>
                        <span>অনুমোদিত ও প্রকাশিত</span>
                        <span class="badge {{ $status === 'approved' ? 'bg-white text-success' : 'bg-success text-white' }} ms-1">{{ $countApproved }}</span>
                    </a>

                    <a href="{{ route('admin.opinions.index', ['status' => 'rejected', 'search' => $search]) }}" 
                       class="btn {{ $status === 'rejected' ? 'btn-primary' : 'btn-secondary' }}" 
                       style="padding: 6px 14px; font-size: 0.88rem; border-radius: 20px;">
                        <i class="fa-solid fa-circle-xmark me-1"></i>
                        <span>বাতিলকৃত</span>
                        <span class="badge {{ $status === 'rejected' ? 'bg-white text-muted' : 'bg-secondary text-white' }} ms-1">{{ $countRejected }}</span>
                    </a>
                </div>

                <!-- Search Input Form -->
                <form action="{{ route('admin.opinions.index') }}" method="GET" style="display: flex; gap: 8px;">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <div style="position: relative; width: 260px;">
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}" 
                               class="form-control" 
                               placeholder="লেখক বা শিরোনাম খুঁজুন..." 
                               style="padding-left: 36px; padding-top: 7px; padding-bottom: 7px;">
                        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                    </div>
                    <button type="submit" class="btn btn-secondary" style="padding: 7px 14px;">খুঁজুন</button>
                    @if(!empty($search))
                        <a href="{{ route('admin.opinions.index', ['status' => $status]) }}" class="btn btn-secondary" title="রিসেট"><i class="fa-solid fa-rotate-left"></i></a>
                    @endif
                </form>

            </div>
        </div>
    </div>

    <!-- Submissions Table -->
    <div class="admin-card">
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#আইডি</th>
                        <th style="width: 220px;">লেখক ও যোগাযোগ</th>
                        <th>শিরোনাম ও বিষয়</th>
                        <th style="width: 140px;">জমা দেওয়ার তারিখ</th>
                        <th style="width: 120px;">স্ট্যাটাস</th>
                        <th style="width: 180px; text-align: right;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $sub)
                        <tr>
                            <td>
                                <strong class="text-muted">#{{ $sub->id }}</strong>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <img src="{{ $sub->author_photo_url }}" 
                                         alt="{{ $sub->author_name }}" 
                                         style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 1px solid #cbd5e1; flex-shrink: 0;">
                                    <div>
                                        <div style="font-weight: 700; color: var(--text-dark); font-size: 0.95rem;">
                                            {{ $sub->author_name }}
                                        </div>
                                        <div style="font-size: 0.80rem; color: #64748b;">
                                            {{ $sub->author_designation ?? 'কলাম লেখক' }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: #94a3b8;">
                                            <i class="fa-solid fa-phone me-1"></i>{{ $sub->author_phone }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <a href="{{ route('admin.opinions.show', $sub->id) }}" style="font-weight: 700; color: var(--text-dark); font-size: 1rem; line-height: 1.4; display: block; margin-bottom: 4px;">
                                        {{ $sub->title }}
                                    </a>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span class="badge" style="background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;">
                                            <i class="fa-solid fa-tag me-1 text-danger"></i>{{ $sub->topic ?? 'সাধারণ' }}
                                        </span>
                                        <span style="font-size: 0.80rem; color: #94a3b8;">
                                            {{ Str::limit(strip_tags($sub->content), 80) }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 0.88rem; color: var(--text-main);">
                                    {{ $sub->created_at->format('d M, Y') }}
                                </div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">
                                    {{ $sub->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td>
                                @if($sub->status === 'approved')
                                    <span class="badge badge-success" style="font-size: 0.82rem;">
                                        <i class="fa-solid fa-circle-check me-1"></i>অনুমোদিত
                                    </span>
                                    @if($sub->post)
                                        <a href="{{ route('post', $sub->post->slug) }}" target="_blank" class="d-block mt-1 small text-danger text-decoration-none" style="font-size: 0.75rem; font-weight: 600;">
                                            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i>লাইভ দেখুন
                                        </a>
                                    @endif
                                @elseif($sub->status === 'rejected')
                                    <span class="badge badge-danger" style="font-size: 0.82rem;">
                                        <i class="fa-solid fa-circle-xmark me-1"></i>বাতিল
                                    </span>
                                @else
                                    <span class="badge badge-warning" style="font-size: 0.82rem;">
                                        <i class="fa-solid fa-clock me-1"></i>অপেক্ষমাণ
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <div class="action-flex" style="justify-content: flex-end;">
                                    <!-- View/Review Details Button -->
                                    <a href="{{ route('admin.opinions.show', $sub->id) }}" 
                                       class="btn btn-secondary" 
                                       style="padding: 6px 10px; font-size: 0.82rem;" 
                                       title="সম্পূর্ণ লেখা দেখুন ও রিভিউ করুন">
                                        <i class="fa-solid fa-eye me-1"></i>
                                        <span>রিভিউ</span>
                                    </a>

                                    @if($sub->status === 'pending')
                                        <!-- Quick Approve Button -->
                                        <form action="{{ route('admin.opinions.approve', $sub->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('আপনি কি এই মতামতটি অনুমোদন করে ওয়েবসাইটে প্রকাশ করতে চান?');">
                                            @csrf
                                            <button type="submit" class="btn btn-primary" style="padding: 6px 10px; font-size: 0.82rem; background-color: #16a34a; border-color: #16a34a;" title="অনুমোদন ও প্রকাশ করুন">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.opinions.destroy', $sub->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই সাবমিশনটি মুছে ফেলতে চান?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete-btn" title="মুছে ফেলুন">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 48px 16px;">
                                <i class="fa-solid fa-pen-nib text-muted mb-2" style="font-size: 2.5rem;"></i>
                                <h4 style="font-size: 1.1rem; color: var(--text-dark); margin-bottom: 6px;">কোনো মতামত সাবমিশন পাওয়া যায়নি</h4>
                                <p style="font-size: 0.88rem; color: var(--text-sub); margin-bottom: 0;">
                                    @if(!empty($search))
                                        "{{ $search }}" এর সাথে মিল পাওয়া যায়নি। ভিন্ন শব্দ দিয়ে চেষ্টা করুন।
                                    @else
                                        এই মুহূর্তে পর্যালোচনার জন্য কোনো নতুন মতামত বা কলাম নেই।
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($submissions->hasPages())
        <div style="margin-top: 24px; display: flex; justify-content: center;">
            {{ $submissions->appends(request()->query())->links() }}
        </div>
    @endif

@endsection
