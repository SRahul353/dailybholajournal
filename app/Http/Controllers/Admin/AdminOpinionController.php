<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OpinionSubmission;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class AdminOpinionController extends Controller
{
    /**
     * Display a listing of submitted opinions & columns.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search', '');

        $query = OpinionSubmission::latest();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhere('author_email', 'like', "%{$search}%")
                  ->orWhere('author_phone', 'like', "%{$search}%");
            });
        }

        $submissions = $query->paginate(15);

        // Status counts for tabs
        $countAll = OpinionSubmission::count();
        $countPending = OpinionSubmission::where('status', 'pending')->count();
        $countApproved = OpinionSubmission::where('status', 'approved')->count();
        $countRejected = OpinionSubmission::where('status', 'rejected')->count();

        return view('admin.opinions.index', compact(
            'submissions', 
            'status', 
            'search',
            'countAll', 
            'countPending', 
            'countApproved', 
            'countRejected'
        ));
    }

    /**
     * Display the specified submission for review.
     */
    public function show($id)
    {
        $submission = OpinionSubmission::with('post')->findOrFail($id);
        return view('admin.opinions.show', compact('submission'));
    }

    /**
     * Approve the submission and publish it as a live news article.
     */
    public function approve(Request $request, $id)
    {
        Gate::authorize('admin-or-super');

        $submission = OpinionSubmission::findOrFail($id);

        // Find or create 'মতামত' Category
        $category = Category::where('slug', 'opinion')
            ->orWhere('name', 'মতামত')
            ->first();

        if (!$category) {
            $category = Category::create([
                'name' => 'মতামত',
                'slug' => 'opinion',
                'description' => 'পাঠক ও লেখকদের নিয়মিত মতামত ও কলাম'
            ]);
        }

        // Generate safe unique slug
        $slug = Str::slug($submission->title);
        if (empty($slug)) {
            $slug = 'opinion-' . time();
        }
        $originalSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        // Prepare rich author bio box appended to content
        $authorSignature = '<div class="opinion-author-credit mt-4 p-3 border rounded bg-light d-flex align-items-center gap-3">'
            . '<img src="' . $submission->author_photo_url . '" alt="' . htmlspecialchars($submission->author_name) . '" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #dc2626;">'
            . '<div>'
            . '<h5 class="mb-1 fw-bold text-dark" style="font-size: 1rem;">' . htmlspecialchars($submission->author_name) . '</h5>'
            . '<p class="text-muted mb-0 small">' . htmlspecialchars($submission->author_designation ?? 'কলাম লেখক') . '</p>'
            . ($submission->author_bio ? '<p class="text-secondary small mt-1 mb-0">' . htmlspecialchars($submission->author_bio) . '</p>' : '')
            . '</div>'
            . '</div>';

        $fullContent = $submission->content . "\n\n" . $authorSignature;

        // Create the Post
        $post = Post::create([
            'title' => $submission->title,
            'slug' => $slug,
            'content' => $fullContent,
            'excerpt' => Str::limit(strip_tags($submission->content), 200),
            'featured_image' => $submission->featured_image ?: $submission->author_photo,
            'status' => 'publish',
            'user_id' => Auth::id(),
            'views_count' => 0,
        ]);

        // Attach category 'মতামত'
        $post->categories()->sync([$category->id]);

        // Find or create tag 'মতামত' & 'কলাম'
        $opinionTag = Tag::firstOrCreate(['name' => 'মতামত'], ['slug' => 'opinion']);
        $columnTag = Tag::firstOrCreate(['name' => 'কলাম'], ['slug' => 'column']);
        $post->tags()->sync([$opinionTag->id, $columnTag->id]);

        // Update submission status
        $submission->update([
            'status' => 'approved',
            'approved_post_id' => $post->id,
            'approved_at' => now(),
            'admin_notes' => $request->input('admin_notes') ?: 'সম্পাদকীয় পর্ষদ কর্তৃক অনুমোদিত ও প্রকাশিত।',
        ]);

        return redirect()->route('admin.opinions.show', $submission->id)
            ->with('success', 'মতামতটি সফলভাবে অনুমোদিত এবং "মতামত" ক্যাটাগরিতে সংবাদ হিসেবে প্রকাশিত হয়েছে!');
    }

    /**
     * Reject the submission with an optional reason.
     */
    public function reject(Request $request, $id)
    {
        Gate::authorize('admin-or-super');

        $submission = OpinionSubmission::findOrFail($id);

        $submission->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('admin_notes') ?: 'সম্পাদকীয় নীতিমালা ও নির্দেশিকার সাথে সামঞ্জস্যপূর্ণ না হওয়ায় প্রকাশ করা সম্ভব হয়নি।',
        ]);

        return redirect()->route('admin.opinions.show', $submission->id)
            ->with('warning', 'মতামতটি বাতিল (Rejected) হিসেবে চিহ্নিত করা হয়েছে।');
    }

    /**
     * Delete the submission permanently.
     */
    public function destroy($id)
    {
        Gate::authorize('admin-or-super');

        $submission = OpinionSubmission::findOrFail($id);

        // Delete uploaded files if any
        if ($submission->author_photo && file_exists(public_path($submission->author_photo))) {
            @unlink(public_path($submission->author_photo));
        }
        if ($submission->featured_image && file_exists(public_path($submission->featured_image))) {
            @unlink(public_path($submission->featured_image));
        }

        $submission->delete();

        return redirect()->route('admin.opinions.index')
            ->with('success', 'মতামত সাবমিশন সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
