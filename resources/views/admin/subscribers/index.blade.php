@extends('layouts.admin')

@section('title', 'নিউজলেটার সাবস্ক্রাইবারগণ | এডমিন প্যানেল')

@section('content')

    <!-- Page Header -->
    <div class="content-header">
        <div>
            <h1 class="page-title">নিউজলেটার সাবস্ক্রাইবার তালিকা</h1>
            <p class="page-subtitle">প্রতিদিনের তাজা খবর পেতে ইমেইল সাবস্ক্রাইব করা পাঠকদের তালিকা।</p>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success" style="background-color: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 12px 18px; border-radius: 6px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <i class="fa-solid fa-circle-check me-2 text-success"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
            <div style="font-weight: 700; color: #0f172a; font-size: 1.1rem;">
                <i class="fa-solid fa-envelope-open-text me-2 text-danger"></i>
                <span>মোট সাবস্ক্রাইবার: {{ $totalSubscribers }} জন</span>
            </div>

            <!-- Search Form -->
            <form action="{{ route('admin.subscribers.index') }}" method="GET" style="display: flex; gap: 8px;">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="ইমেইল দিয়ে খুঁজুন..." class="form-control" style="padding: 6px 14px; font-size: 0.88rem; width: 240px;">
                <button type="submit" class="btn btn-secondary btn-sm" style="background: #0f172a; color: #fff;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                @if(!empty($search))
                    <a href="{{ route('admin.subscribers.index') }}" class="btn btn-light btn-sm" title="রিসেট">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>ইমেইল ঠিকানা</th>
                        <th>সাবস্ক্রিপশনের তারিখ ও সময়</th>
                        <th>আইপি অ্যাড্রেস</th>
                        <th style="width: 100px; text-align: right;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $index => $sub)
                        <tr>
                            <td style="color: #64748b; font-size: 0.85rem;">{{ $subscribers->firstItem() + $index }}</td>
                            <td style="font-weight: 700; color: #0f172a;">
                                <i class="fa-regular fa-envelope me-2 text-muted"></i>{{ $sub->email }}
                            </td>
                            <td style="font-size: 0.85rem; color: #64748b;">
                                {{ $sub->created_at->format('d M, Y h:i A') }}
                            </td>
                            <td style="font-size: 0.85rem; color: #64748b; font-family: monospace;">
                                {{ $sub->ip_address ?? 'N/A' }}
                            </td>
                            <td style="text-align: right;">
                                <form action="{{ route('admin.subscribers.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই সাবস্ক্রাইবারকে তালিকা থেকে মুছে ফেলতে চান?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-delete" title="মুছে ফেলুন">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-sub); padding: 36px;">
                                <i class="fa-solid fa-users-slash" style="font-size: 2rem; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                কোনো সাবস্ক্রাইবার পাওয়া যায়নি।
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 24px;">
            {{ $subscribers->withQueryString()->links() }}
        </div>
    </div>

@endsection
