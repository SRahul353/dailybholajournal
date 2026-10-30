@extends('layouts.admin')

@section('title', 'ট্যাগ সমূহ | এডমিন প্যানেল')

@section('content')

    <!-- Page Header -->
    <div class="content-header">
        <div>
            <h1 class="page-title">সংবাদ ট্যাগ সমূহ</h1>
            <p class="page-subtitle">সংবাদের ট্যাগ তৈরি, অনুসন্ধান, সম্পাদনা ও ব্যবস্থাপনা করুন।</p>
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
        <!-- Left Table Column -->
        <div class="admin-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
                <h3 class="card-title" style="margin-bottom: 0;">
                    <i class="fa-solid fa-tags"></i>
                    <span>বিদ্যমান ট্যাগ তালিকা ({{ $tags->total() }}টি)</span>
                </h3>
                
                <!-- Search Form -->
                <form action="{{ route('admin.tags.index') }}" method="GET" style="display: flex; gap: 8px;">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="ট্যাগ বা স্লাগ খুঁজুন..." class="form-control" style="padding: 6px 12px; font-size: 0.88rem; width: 200px;">
                    <button type="submit" class="btn btn-secondary btn-sm" style="background: #0f172a; color: #fff;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    @if(!empty($search))
                        <a href="{{ route('admin.tags.index') }}" class="btn btn-light btn-sm" title="রিসেট">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </form>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>নাম</th>
                            <th>স্লাগ</th>
                            <th>পোস্ট সংখ্যা</th>
                            <th style="width: 120px; text-align: right;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tags as $tag)
                            <tr>
                                <td style="font-weight: 700; color: var(--text-dark);">
                                    #{{ $tag->name }}
                                </td>
                                <td style="font-family: 'Outfit', sans-serif; font-size: 0.85rem; color: var(--text-sub);">
                                    {{ $tag->slug }}
                                </td>
                                <td>
                                    <span class="badge badge-success">{{ $tag->posts_count }}টি পোস্ট</span>
                                </td>
                                <td style="text-align: right;">
                                    <div class="action-flex" style="justify-content: flex-end;">
                                        <!-- Edit Tag Button -->
                                        <button type="button" 
                                                class="action-btn" 
                                                style="color: #2563eb; background: #eff6ff; border: 1px solid #bfdbfe;" 
                                                onclick='openEditTagModal(@json($tag))' 
                                                title="ট্যাগ সম্পাদনা করুন">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <!-- Public Link -->
                                        <a href="{{ route('tag', $tag->slug) }}" target="_blank" class="action-btn action-view" title="ভিজিট ট্যাগ পেজ"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                        
                                        <!-- Delete -->
                                        <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে ট্যাগটি মুছে ফেলতে চান? পোস্টগুলো অক্ষত থাকবে কিন্তু এই ট্যাগ সম্পর্ক বিচ্ছিন্ন হবে।');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn action-delete" title="মুছে ফেলুন"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-sub); padding: 32px;">
                                    কোনো ট্যাগ পাওয়া যায়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 20px;">
                {{ $tags->withQueryString()->links() }}
            </div>
        </div>

        <!-- Right Create Form Column -->
        <div class="admin-card" style="height: fit-content;">
            <h3 class="card-title" style="margin-bottom: 20px;">
                <i class="fa-solid fa-circle-plus"></i>
                <span>নতুন ট্যাগ যোগ করুন</span>
            </h3>

            <form action="{{ route('admin.tags.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">ট্যাগের নাম <span style="color: var(--accent);">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="যেমন: ভোলা_সংবাদ, নির্বাচন" required value="{{ old('name') }}">
                    <span class="form-text">সংবাদের মূল কি-ওয়ার্ড বা বিষয়ের নাম লিখুন।</span>
                </div>

                <div class="form-group">
                    <label class="form-label">স্লাগ (ঐচ্ছিক)</label>
                    <input type="text" name="slug" class="form-control" placeholder="স্বয়ংক্রিয়ভাবে তৈরি হবে" value="{{ old('slug') }}">
                    <span class="form-text">ইংরেজি বা ইউনিক URL পাথ। খালি রাখলে স্বয়ংক্রিয় তৈরি হবে।</span>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
                    <i class="fa-solid fa-plus me-1"></i> ট্যাগ সংরক্ষণ করুন
                </button>
            </form>
        </div>
    </div>

    <!-- Edit Tag Modal -->
    <div id="editTagModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); z-index: 9999; backdrop-filter: blur(4px); align-items: center; justify-content: center;">
        <div class="admin-card" style="width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto; margin: 20px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                <h3 class="card-title" style="margin-bottom: 0;">
                    <i class="fa-solid fa-pen-to-square" style="color: #2563eb;"></i>
                    <span>ট্যাগ সম্পাদনা করুন</span>
                </h3>
                <button type="button" onclick="closeEditTagModal()" style="background: none; border: none; font-size: 1.25rem; color: #64748b; cursor: pointer;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="editTagForm" method="POST" action="">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">ট্যাগের নাম <span style="color: var(--accent);">*</span></label>
                    <input type="text" id="editTagName" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">ট্যাগ স্লাগ</label>
                    <input type="text" id="editTagSlug" name="slug" class="form-control" required>
                    <span class="form-text">ইউনিক URL ফ্রেন্ডলি স্লাগ।</span>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                    <button type="button" class="btn btn-secondary" onclick="closeEditTagModal()" style="background: #e2e8f0; color: #334155;">বাতিল</button>
                    <button type="submit" class="btn btn-primary" style="background: #2563eb;">
                        <i class="fa-solid fa-floppy-disk me-1"></i> আপডেট করুন
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openEditTagModal(tag) {
        const modal = document.getElementById('editTagModal');
        const form = document.getElementById('editTagForm');
        
        // Construct action route dynamically
        form.action = "{{ url('admin/tags') }}/" + tag.id;
        
        document.getElementById('editTagName').value = tag.name || '';
        document.getElementById('editTagSlug').value = tag.slug || '';

        modal.style.display = 'flex';
    }

    function closeEditTagModal() {
        document.getElementById('editTagModal').style.display = 'none';
    }

    // Close modal on click outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('editTagModal');
        if (event.target === modal) {
            closeEditTagModal();
        }
    });
</script>
@endsection
