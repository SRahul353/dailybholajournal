@extends('layouts.admin')

@section('title', 'বার্তা ইনবক্স | এডমিন প্যানেল')

@section('content')

    <!-- Page Header -->
    <div class="content-header">
        <div>
            <h1 class="page-title">বার্তা ইনবক্স (যোগাযোগ ও অভিযোগ)</h1>
            <p class="page-subtitle">পাঠক ও শুভানুধ্যায়ীদের পাঠানো বার্তা ও ফিডব্যাক পড়ুন ও পরিচালনা করুন।</p>
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
            <!-- Filter Tabs -->
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.messages.index') }}" class="btn btn-sm {{ $status === 'all' ? 'btn-primary' : 'btn-secondary' }}" style="{{ $status === 'all' ? 'background: #0f172a; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                    সকল বার্তা ({{ $messages->total() }})
                </a>
                <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="btn btn-sm {{ $status === 'unread' ? 'btn-primary' : 'btn-secondary' }}" style="{{ $status === 'unread' ? 'background: #dc2626; color: #fff;' : 'background: #fee2e2; color: #dc2626;' }}">
                    অপঠিত ({{ $unreadCount }})
                </a>
                <a href="{{ route('admin.messages.index', ['status' => 'read']) }}" class="btn btn-sm {{ $status === 'read' ? 'btn-primary' : 'btn-secondary' }}" style="{{ $status === 'read' ? 'background: #16a34a; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                    পঠিত
                </a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('admin.messages.index') }}" method="GET" style="display: flex; gap: 8px;">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="নাম, ফোন, বিষয় খুঁজুন..." class="form-control" style="padding: 6px 14px; font-size: 0.88rem; width: 220px;">
                <button type="submit" class="btn btn-secondary btn-sm" style="background: #0f172a; color: #fff;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                @if(!empty($search))
                    <a href="{{ route('admin.messages.index', ['status' => $status]) }}" class="btn btn-light btn-sm" title="রিসেট">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">অবস্থা</th>
                        <th>প্রেরকের নাম ও ফোন</th>
                        <th>বিষয় ও সারসংক্ষেপ</th>
                        <th>তারিখ ও সময়</th>
                        <th style="width: 120px; text-align: right;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                        <tr style="{{ !$msg->is_read ? 'background-color: #fef2f2; font-weight: 600;' : '' }}">
                            <td>
                                @if(!$msg->is_read)
                                    <span class="badge" style="background: #dc2626; color: #fff; font-size: 0.7rem; border-radius: 12px; padding: 2px 8px;">নতুন</span>
                                @else
                                    <span class="badge" style="background: #e2e8f0; color: #64748b; font-size: 0.7rem; border-radius: 12px; padding: 2px 8px;">পঠিত</span>
                                @endif
                            </td>
                            <td>
                                <div style="color: var(--text-dark); font-weight: 700;">{{ $msg->name }}</div>
                                <div style="font-size: 0.82rem; color: #475569;">
                                    <i class="fa-solid fa-phone me-1 text-muted"></i>{{ $msg->phone }}
                                    @if($msg->email)
                                        <span class="ms-2"><i class="fa-solid fa-envelope me-1 text-muted"></i>{{ $msg->email }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.messages.show', $msg->id) }}" style="color: #0f172a; text-decoration: none; font-weight: 700;">
                                    {{ $msg->subject }}
                                </a>
                                <div style="font-size: 0.82rem; color: #64748b; margin-top: 3px; font-weight: normal;">
                                    {{ Str::limit($msg->message, 80) }}
                                </div>
                            </td>
                            <td style="font-size: 0.85rem; color: #64748b; white-space: nowrap;">
                                {{ $msg->created_at->format('d M, Y h:i A') }}
                            </td>
                            <td style="text-align: right;">
                                <div class="action-flex" style="justify-content: flex-end;">
                                    <a href="{{ route('admin.messages.show', $msg->id) }}" class="action-btn" style="color: #2563eb; background: #eff6ff; border: 1px solid #bfdbfe;" title="বার্তা পড়ুন">
                                        <i class="fa-solid fa-envelope-open"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই বার্তাটি মুছে ফেলতে চান?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn action-delete" title="মুছে ফেলুন">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-sub); padding: 36px;">
                                <i class="fa-regular fa-folder-open" style="font-size: 2rem; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                কোনো বার্তা পাওয়া যায়নি।
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 24px;">
            {{ $messages->withQueryString()->links() }}
        </div>
    </div>

@endsection
