@extends('layouts.admin')

@section('title', 'অনলাইন জরিপ ব্যবস্থাপনা | এডমিন প্যানেল')

@section('content')

    <!-- Page Header -->
    <div class="content-header">
        <div>
            <h1 class="page-title">অনলাইন জরিপ ব্যবস্থাপনা (Live Poll Engine)</h1>
            <p class="page-subtitle">পাঠকদের মতামতের জন্য সাইটবারের অনলাইন জরিপ প্রশ্ন তৈরি ও ভোট পরিচালনা করুন।</p>
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

    @if($errors->any())
        <div class="alert alert-danger" style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 12px 18px; border-radius: 6px; margin-bottom: 24px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Left: Polls List -->
        <div class="admin-card">
            <h3 class="card-title" style="margin-bottom: 20px;">
                <i class="fa-solid fa-square-poll-vertical"></i>
                <span>বিদ্যমান জরিপ তালিকা ({{ $polls->total() }}টি)</span>
            </h3>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>অবস্থা</th>
                            <th>জরিপের প্রশ্ন</th>
                            <th style="min-width: 140px;">ফলাফল পরিসংখ্যান</th>
                            <th style="width: 130px; text-align: right;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($polls as $poll)
                            <tr style="{{ $poll->is_active ? 'background-color: #f0fdf4;' : '' }}">
                                <td>
                                    @if($poll->is_active)
                                        <span class="badge" style="background: #16a34a; color: #fff; border-radius: 12px; padding: 3px 8px;">সক্রিয়</span>
                                    @else
                                        <span class="badge" style="background: #e2e8f0; color: #64748b; border-radius: 12px; padding: 3px 8px;">নিষ্ক্রিয়</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--text-dark); font-size: 0.98rem; margin-bottom: 4px;">
                                        {{ $poll->question }}
                                    </div>
                                    <div style="font-size: 0.8rem; color: #64748b;">
                                        তৈরি: {{ $poll->created_at->format('d M, Y h:i A') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 0.82rem; font-weight: 600; margin-bottom: 4px;">
                                        মোট ভোট: <span style="color: #0f172a; font-weight: 700;">{{ number_format($poll->total_votes) }}</span>টি
                                    </div>
                                    <div style="display: flex; gap: 6px; font-size: 0.75rem;">
                                        <span style="color: #16a34a;">হ্যাঁ: {{ $poll->yes_percent }}% ({{ $poll->yes_votes }})</span>
                                        <span style="color: #dc2626;">না: {{ $poll->no_percent }}% ({{ $poll->no_votes }})</span>
                                        <span style="color: #64748b;">মন্তব্য নেই: {{ $poll->neutral_percent }}%</span>
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <div class="action-flex" style="justify-content: flex-end;">
                                        <!-- Toggle Status -->
                                        <form action="{{ route('admin.polls.toggle', $poll->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="action-btn" style="{{ $poll->is_active ? 'color: #16a34a; background: #dcfce7;' : 'color: #64748b; background: #f1f5f9;' }}" title="{{ $poll->is_active ? 'নিষ্ক্রিয় করুন' : 'সক্রিয় করুন' }}">
                                                <i class="fa-solid {{ $poll->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}" style="font-size: 1.1rem;"></i>
                                            </button>
                                        </form>

                                        <!-- Reset Votes -->
                                        <form action="{{ route('admin.polls.reset', $poll->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই জরিপের সকল ভোট শূন্যে রিসেট করতে চান?');" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="action-btn" style="color: #d97706; background: #fef3c7;" title="ভোট রিসেট করুন">
                                                <i class="fa-solid fa-rotate-left"></i>
                                            </button>
                                        </form>

                                        <!-- Delete -->
                                        <form action="{{ route('admin.polls.destroy', $poll->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে জরিপটি মুছে ফেলতে চান?');" style="display: inline;">
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
                                <td colspan="4" style="text-align: center; color: var(--text-sub); padding: 36px;">
                                    কোনো জরিপ প্রশ্ন পাওয়া যায়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px;">
                {{ $polls->links() }}
            </div>
        </div>

        <!-- Right: Create New Poll -->
        <div class="admin-card" style="height: fit-content;">
            <h3 class="card-title" style="margin-bottom: 20px;">
                <i class="fa-solid fa-circle-plus"></i>
                <span>নতুন জরিপ প্রশ্ন তৈরি করুন</span>
            </h3>

            <form action="{{ route('admin.polls.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">জরিপের প্রশ্ন <span style="color: var(--accent);">*</span></label>
                    <textarea name="question" class="form-control" rows="4" placeholder="যেমন: ভোলা-বরিশাল সেতু নির্মাণ প্রকল্প কি দ্রুত শুরু করা উচিত?" required>{{ old('question') }}</textarea>
                    <span class="form-text">প্রশ্নটি স্পষ্ট ও সংক্ষিপ্ত রাখুন যাতে পাঠকরা সহজেই বুঝতে পারেন।</span>
                </div>

                <div class="form-group" style="margin-top: 16px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.95rem; font-weight: 600; color: #0f172a;">
                        <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: var(--accent);">
                        <span>সাইটবারে এখনই সক্রিয় করুন</span>
                    </label>
                    <span class="form-text" style="display: block; margin-left: 26px;">এটি সক্রিয় করলে পূর্বের সক্রিয় জরিপটি স্বয়ংক্রিয়ভাবে বন্ধ হয়ে যাবে।</span>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 14px;">
                    <i class="fa-solid fa-paper-plane me-1"></i> জরিপ প্রকাশ করুন
                </button>
            </form>
        </div>
    </div>

@endsection
