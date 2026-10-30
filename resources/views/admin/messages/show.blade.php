@extends('layouts.admin')

@section('title', 'বার্তার বিবরণ | এডমিন প্যানেল')

@section('content')

    <!-- Page Header -->
    <div class="content-header">
        <div>
            <h1 class="page-title">বার্তার বিবরণ</h1>
            <p class="page-subtitle">পাঠকের পাঠানো বিস্তারিত বার্তা।</p>
        </div>
        <div>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> ইনবক্সে ফিরে যান
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Left: Message Content -->
        <div class="admin-card">
            <div style="border-bottom: 1px solid var(--border-color); padding-bottom: 16px; margin-bottom: 20px;">
                <h2 style="font-size: 1.4rem; font-weight: 700; color: var(--text-dark); margin-bottom: 8px;">
                    {{ $message->subject }}
                </h2>
                <div style="font-size: 0.88rem; color: #64748b; display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
                    <span><i class="fa-regular fa-clock me-1"></i>{{ $message->created_at->format('d F, Y - h:i A') }}</span>
                    <span><i class="fa-solid fa-network-wired me-1"></i>IP: {{ $message->ip_address ?? 'N/A' }}</span>
                </div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; min-height: 250px; font-size: 1.05rem; line-height: 1.8; color: #1e293b; white-space: pre-wrap; font-family: 'Noto Sans Bengali', sans-serif;">{{ $message->message }}</div>

            <div style="margin-top: 24px; display: flex; gap: 12px; justify-content: flex-end;">
                @if($message->email)
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}" class="btn btn-primary" style="background: #2563eb;">
                        <i class="fa-solid fa-reply me-1"></i> ইমেইলে উত্তর দিন
                    </a>
                @endif
                <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই বার্তাটি মুছে ফেলতে চান?');" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash-can me-1"></i> বার্তা মুছুন
                    </button>
                </form>
            </div>
        </div>

        <!-- Right: Sender Details -->
        <div class="admin-card" style="height: fit-content;">
            <h3 class="card-title" style="margin-bottom: 16px; font-size: 1.1rem;">
                <i class="fa-solid fa-user"></i>
                <span>প্রেরকের তথ্য</span>
            </h3>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                <div>
                    <label style="font-size: 0.8rem; color: #64748b; font-weight: 600; display: block; margin-bottom: 2px;">নাম</label>
                    <div style="font-weight: 700; color: #0f172a; font-size: 1.05rem;">{{ $message->name }}</div>
                </div>

                <div>
                    <label style="font-size: 0.8rem; color: #64748b; font-weight: 600; display: block; margin-bottom: 2px;">মোবাইল নম্বর</label>
                    <div style="font-weight: 600; color: #0f172a;">
                        <a href="tel:{{ $message->phone }}" style="color: #2563eb; text-decoration: none;">
                            <i class="fa-solid fa-phone me-1"></i>{{ $message->phone }}
                        </a>
                    </div>
                </div>

                @if($message->email)
                    <div>
                        <label style="font-size: 0.8rem; color: #64748b; font-weight: 600; display: block; margin-bottom: 2px;">ইমেইল ঠিকানা</label>
                        <div style="font-weight: 600; color: #0f172a; word-break: break-all;">
                            <a href="mailto:{{ $message->email }}" style="color: #2563eb; text-decoration: none;">
                                <i class="fa-solid fa-envelope me-1"></i>{{ $message->email }}
                            </a>
                        </div>
                    </div>
                @endif

                <div>
                    <label style="font-size: 0.8rem; color: #64748b; font-weight: 600; display: block; margin-bottom: 2px;">পাঠানোর তারিখ</label>
                    <div style="font-size: 0.9rem; color: #334155;">{{ $message->created_at->format('d M, Y') }} ({{ $message->created_at->diffForHumans() }})</div>
                </div>
            </div>
        </div>
    </div>

@endsection
