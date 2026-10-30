@extends('layouts.admin')

@section('title', 'ক্যাটাগরি সমূহ | এডমিন প্যানেল')

@section('content')

    <!-- Page Header -->
    <div class="content-header">
        <div>
            <h1 class="page-title">সংবাদ ক্যাটাগরি সমূহ</h1>
            <p class="page-subtitle">সংবাদের ক্যাটাগরি তৈরি, সম্পাদনা ও ব্যবস্থাপনা করুন।</p>
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

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Left Table Column -->
        <div class="admin-card">
            <h3 class="card-title" style="margin-bottom: 20px;">
                <i class="fa-solid fa-list"></i>
                <span>বিদ্যমান ক্যাটাগরি তালিকা ({{ $categories->count() }}টি)</span>
            </h3>

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
                        @forelse($categories as $cat)
                            <tr>
                                <td style="font-weight: 700; color: var(--text-dark);">
                                    {{ $cat->name }}
                                    @if($cat->description)
                                        <div style="font-size: 0.78rem; color: #64748b; font-weight: normal; margin-top: 2px;">
                                            {{ Str::limit($cat->description, 60) }}
                                        </div>
                                    @endif
                                </td>
                                <td style="font-family: 'Outfit', sans-serif; font-size: 0.85rem; color: var(--text-sub);">
                                    {{ $cat->slug }}
                                </td>
                                <td>
                                    <span class="badge badge-success">{{ $cat->posts_count }}টি পোস্ট</span>
                                </td>
                                <td style="text-align: right;">
                                    <div class="action-flex" style="justify-content: flex-end;">
                                        <!-- Edit Category Button -->
                                        <button type="button" 
                                                class="action-btn" 
                                                style="color: #2563eb; background: #eff6ff; border: 1px solid #bfdbfe;" 
                                                onclick='openEditCategoryModal(@json($cat))' 
                                                title="ক্যাটাগরি সম্পাদনা করুন">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <!-- Public Link -->
                                        <a href="{{ route('category', $cat->slug) }}" target="_blank" class="action-btn action-view" title="ভিজিট ক্যাটাগরি"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                        
                                        <!-- Delete -->
                                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে ক্যাটাগরিটি মুছে ফেলতে চান? এর অধীনস্থ পোস্টগুলো মুছে যাবে না, শুধু ক্যাটাগরি সম্পর্ক বিচ্ছিন্ন হবে।');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn action-delete" title="মুছে ফেলুন"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 32px; color: var(--text-sub);">
                                    কোনো ক্যাটাগরি পাওয়া যায়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Add Form Column -->
        <div class="admin-card" style="height: fit-content;">
            <h3 class="card-title" style="margin-bottom: 20px;">
                <i class="fa-solid fa-folder-plus"></i>
                <span>নতুন ক্যাটাগরি তৈরি</span>
            </h3>

            @if($errors->any())
                <div class="alert alert-danger" style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #b91c1c; padding: 10px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 20px;">
                    <i class="fa-solid fa-circle-exclamation me-1"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">ক্যাটাগরির নাম</label>
                    <input type="text" name="name" id="name" required placeholder="যেমন: বিনোদন, খেলাধুলা..." class="form-control">
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="form-label">সংক্ষিপ্ত বিবরণ (ঐচ্ছিক)</label>
                    <textarea name="description" id="description" rows="4" placeholder="ক্যাটাগরি সম্পর্কিত সংক্ষিপ্ত বিবরণ..." class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 10px;">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>ক্যাটাগরি সেভ করুন</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 10px; border: 1px solid var(--border-color);">
                <form id="editCategoryForm" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="modal-header" style="border-bottom: 1px solid var(--border-color); padding: 16px 20px;">
                        <h5 class="modal-title fs-6 fw-bold" id="editCategoryModalLabel">
                            <i class="fa-solid fa-pen-to-square text-danger me-2"></i>ক্যাটাগরি সম্পাদনা করুন
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" style="padding: 20px;">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">ক্যাটাগরির নাম <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="editCatName" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">স্লাগ (URL Slug)</label>
                            <input type="text" name="slug" id="editCatSlug" class="form-control" placeholder="যেমন: sports, entertainment">
                            <small class="form-text text-muted">স্লাগ পরিবর্তন করলে ইউআরএল পরিবর্তিত হবে। ফাঁকা রাখলে স্বয়ংক্রিয়ভাবে তৈরি হবে।</small>
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label fw-bold">সংক্ষিপ্ত বিবরণ (ঐচ্ছিক)</label>
                            <textarea name="description" id="editCatDescription" rows="3" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer" style="border-top: 1px solid var(--border-color); padding: 12px 20px;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #16a34a; border-color: #16a34a;">
                            <i class="fa-solid fa-check me-1"></i> হালনাগাদ সংরক্ষণ করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openEditCategoryModal(cat) {
        const form = document.getElementById('editCategoryForm');
        form.action = `/admin/categories/${cat.id}`;
        
        document.getElementById('editCatName').value = cat.name || '';
        document.getElementById('editCatSlug').value = cat.slug || '';
        document.getElementById('editCatDescription').value = cat.description || '';
        
        const modal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        modal.show();
    }
</script>
@endsection
