<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\EPaper;
use App\Models\Poll;
use App\Models\PollVote;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewspaperController extends Controller
{
    /**
     * Display the newspaper homepage.
     */
    public function index()
    {
        // 1. Fetch Lead Post (with 'শীর্ষ খবর' tag if available, otherwise latest post)
        $topNewsTag = Tag::where('name', 'শীর্ষ খবর')->first();
        $leadPost = null;
        if ($topNewsTag) {
            $leadPost = Post::with(['categories', 'user'])
                ->where('status', 'publish')
                ->whereHas('tags', function($query) use ($topNewsTag) {
                    $query->where('tags.id', $topNewsTag->id);
                })
                ->latest()
                ->first();
        }

        if (!$leadPost) {
            $leadPost = Post::with(['categories', 'user'])
                ->where('status', 'publish')
                ->latest()
                ->first();
        }

        $leadPostId = $leadPost ? $leadPost->id : 0;

        // 2. Fetch Column 2 Sub Lead Posts (with 'শীর্ষ খবর' tag, excluding lead post)
        $subLeadPosts = collect();
        if ($topNewsTag && $leadPostId) {
            $subLeadPosts = Post::with('categories')
                ->where('status', 'publish')
                ->where('id', '!=', $leadPostId)
                ->whereHas('tags', function($query) use ($topNewsTag) {
                    $query->where('tags.id', $topNewsTag->id);
                })
                ->latest()
                ->limit(4)
                ->get();
        }

        // Fill remaining side leads if fewer than 4 are found
        $needed = 4 - $subLeadPosts->count();
        if ($needed > 0) {
            $excludeIds = $subLeadPosts->pluck('id')->push($leadPostId)->toArray();
            $fillPosts = Post::with('categories')
                ->where('status', 'publish')
                ->whereNotIn('id', $excludeIds)
                ->latest()
                ->limit($needed)
                ->get();
            $subLeadPosts = $subLeadPosts->merge($fillPosts);
        }

        // 3. Latest News Sidebar (10 latest posts, excluding lead)
        $latestPosts = Post::with('categories')
            ->where('status', 'publish')
            ->where('id', '!=', $leadPostId)
            ->latest()
            ->limit(10)
            ->get();

        // 4. Popular News (Top 8 read posts for feed & sidebar)
        $popularPosts = Post::where('status', 'publish')
            ->orderBy('views_count', 'desc')
            ->latest()
            ->limit(8)
            ->get();

        // 5. Categorized News Blocks (load from settings layout list if set, or fallback to categories with posts)
        $themeSettingsPath = storage_path('app/theme_settings.json');
        $homepageCategoryIds = [];
        $categoryNamesMap = [];
        $categoryLayoutsMap = [];
        if (file_exists($themeSettingsPath)) {
            $themeSettings = json_decode(file_get_contents($themeSettingsPath), true);
            $homepageCategories = $themeSettings['homepage_categories'] ?? [];
            $homepageCategoryIds = collect($homepageCategories)->pluck('id')->map(fn($id) => (int)$id)->toArray();
            $categoryNamesMap = collect($homepageCategories)->pluck('name', 'id')->toArray();
            $categoryLayoutsMap = collect($homepageCategories)->pluck('layout', 'id')->toArray();
        }

        if (!empty($homepageCategoryIds)) {
            $categoriesWithPosts = Category::whereIn('id', $homepageCategoryIds)
                ->with(['posts' => function($query) {
                    $query->where('status', 'publish')
                        ->latest()
                        ->limit(6);
                }])
                ->get()
                ->map(function($category) use ($leadPostId, $categoryNamesMap, $categoryLayoutsMap) {
                    // Attach custom display name and grid layout from theme settings if defined
                    $category->display_name = $categoryNamesMap[$category->id] ?? $category->name;
                    $category->layout = $categoryLayoutsMap[$category->id] ?? 'style_a';

                    // If category has multiple posts, exclude leadPostId to avoid duplicating the lead story
                    if ($category->posts->count() > 1 && $leadPostId) {
                        $filtered = $category->posts->where('id', '!=', $leadPostId)->values()->take(5);
                        $category->setRelation('posts', $filtered);
                    }
                    return $category;
                })
                ->sortBy(function($category) use ($homepageCategoryIds) {
                    return array_search((int)$category->id, $homepageCategoryIds);
                })
                ->values();
        } else {
            $categoriesWithPosts = Category::has('posts')->with(['posts' => function($query) {
                    $query->where('status', 'publish')
                        ->latest()
                        ->limit(5);
                }])
                ->limit(8)
                ->get()
                ->map(function($category) {
                    $category->layout = 'style_a';
                    return $category;
                });
        }

        // 6. YouTube Video Gallery (load from settings, with fallback demo videos)
        $videoGallery = $themeSettings['video_gallery'] ?? [];
        if (empty($videoGallery)) {
            $videoGallery = [
                [
                    'title' => 'ভোলা-বরিশাল সেতু নির্মাণ প্রকল্প ও নদীভাঙন রোধে মেঘনার তীরে আধুনিক ব্লক বাঁধ',
                    'youtube_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
                    'video_id' => 'ScMzIvxBSi4'
                ],
                [
                    'title' => 'ইলিশের মৌসুমে ভোলার মেঘনা ও তেঁতুলিয়া নদীতে জেলেদের ব্যস্ততা ও মাছের বাজার',
                    'youtube_url' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
                    'video_id' => 'kJQP7kiw5Fk'
                ],
                [
                    'title' => 'উপকূলীয় চরাঞ্চলে আধুনিক কৃষি বিপ্লব ও মহিষের বাথানে খামারিদের সাফল্য',
                    'youtube_url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                    'video_id' => '9bZkp7q19f0'
                ],
                [
                    'title' => 'দ্বীপজেলা ভোলার গ্যাস পাইপলাইনের বিস্তার ও স্থানীয় অর্থনীতিতে নতুন সম্ভাবনা',
                    'youtube_url' => 'https://www.youtube.com/watch?v=JGwWNGJdvx8',
                    'video_id' => 'JGwWNGJdvx8'
                ]
            ];
        }

        return view('home', compact('leadPost', 'subLeadPosts', 'latestPosts', 'popularPosts', 'categoriesWithPosts', 'videoGallery'));
    }

    /**
     * Display a single news post.
     */
    public function show($slug)
    {
        $decoded = urldecode($slug);
        $encoded = urlencode($slug);
        $rawencoded = rawurlencode($slug);

        $post = Post::with(['categories', 'tags', 'user'])
            ->where(function($query) use ($slug, $decoded, $encoded, $rawencoded) {
                $query->where('slug', $slug)
                      ->orWhere('slug', $decoded)
                      ->orWhere('slug', $encoded)
                      ->orWhere('slug', $rawencoded);
            })
            ->where('status', 'publish')
            ->firstOrFail();

        // Increment views count safely
        $post->increment('views_count');

        // Fetch related posts (same category, excluding current post)
        $categoryIds = $post->categories->pluck('id')->toArray();
        $relatedPosts = Post::where('status', 'publish')
            ->where('id', '!=', $post->id)
            ->whereHas('categories', function($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->latest()
            ->limit(4)
            ->get();

        // If fewer than 4 related posts, pad with latest news
        if ($relatedPosts->count() < 4) {
            $fallbackPosts = Post::where('status', 'publish')
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->latest()
                ->limit(4 - $relatedPosts->count())
                ->get();
            $relatedPosts = $relatedPosts->merge($fallbackPosts);
        }

        // Previous and Next Articles for reading flow
        $prevPost = Post::where('status', 'publish')->where('id', '<', $post->id)->orderBy('id', 'desc')->first();
        $nextPost = Post::where('status', 'publish')->where('id', '>', $post->id)->orderBy('id', 'asc')->first();

        // Top 5 popular posts for sidebar
        $popularPosts = Post::where('status', 'publish')
            ->where('id', '!=', $post->id)
            ->orderBy('views_count', 'desc')
            ->latest()
            ->limit(5)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts', 'popularPosts', 'prevPost', 'nextPost'));
    }

    /**
     * Display posts by category.
     */
    public function category($slug)
    {
        $decoded = urldecode($slug);
        $encoded = urlencode($slug);
        $rawencoded = rawurlencode($slug);

        $category = Category::where(function($query) use ($slug, $decoded, $encoded, $rawencoded) {
                $query->where('slug', $slug)
                      ->orWhere('slug', $decoded)
                      ->orWhere('slug', $encoded)
                      ->orWhere('slug', $rawencoded)
                      ->orWhere('name', $slug)
                      ->orWhere('name', $decoded);
            })
            ->firstOrFail();

        $posts = $category->posts()
            ->with(['categories', 'user'])
            ->where('status', 'publish')
            ->latest()
            ->paginate(12);

        // Fetch sidebar trending posts
        $popularPosts = Post::where('status', 'publish')
            ->orderBy('views_count', 'desc')
            ->latest()
            ->limit(5)
            ->get();

        return view('posts.category', compact('category', 'posts', 'popularPosts'));
    }

    /**
     * Display posts by tag.
     */
    public function tag($slug)
    {
        $decoded = urldecode($slug);
        $encoded = urlencode($slug);
        $rawencoded = rawurlencode($slug);

        $tag = Tag::where(function($query) use ($slug, $decoded, $encoded, $rawencoded) {
                $query->where('slug', $slug)
                      ->orWhere('slug', $decoded)
                      ->orWhere('slug', $encoded)
                      ->orWhere('slug', $rawencoded)
                      ->orWhere('name', $slug)
                      ->orWhere('name', $decoded);
            })
            ->firstOrFail();

        $posts = $tag->posts()
            ->with(['categories', 'user'])
            ->where('status', 'publish')
            ->latest()
            ->paginate(12);

        // Fetch sidebar trending posts
        $popularPosts = Post::where('status', 'publish')
            ->orderBy('views_count', 'desc')
            ->latest()
            ->limit(5)
            ->get();

        return view('posts.tag', compact('tag', 'posts', 'popularPosts'));
    }

    /**
     * Search for news articles.
     */
    public function search(Request $request)
    {
        $query = trim($request->input('query') ?: $request->input('q', ''));
        
        $postsQuery = Post::with(['categories', 'user'])
            ->where('status', 'publish');

        if (!empty($query)) {
            $postsQuery->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhereHas('tags', function($tq) use ($query) {
                      $tq->where('name', 'like', "%{$query}%");
                  });
            });
        }

        $posts = $postsQuery->latest()->paginate(12);

        $popularPosts = Post::where('status', 'publish')
            ->orderBy('views_count', 'desc')
            ->latest()
            ->limit(5)
            ->get();

        return view('posts.search', compact('posts', 'query', 'popularPosts'));
    }

    /**
     * Display the digital E-Paper broadsheet.
     */
    public function epaper(Request $request)
    {
        $dateString = $request->input('date');
        
        // If no explicit date requested, try loading today's date
        if (!$dateString) {
            $dateString = Carbon::today()->format('Y-m-d');
        }

        try {
            $date = Carbon::parse($dateString);
        } catch (\Exception $e) {
            $date = Carbon::today();
            $dateString = $date->format('Y-m-d');
        }

        // Find saved E-Paper for the chosen date
        $epaper = EPaper::whereDate('publish_date', $date)->first();

        // Fallback logic for when there is no saved E-Paper for the selected date
        if (!$epaper && !$request->has('date')) {
            // User just visited the /epaper homepage, load the LATEST saved E-Paper in the database!
            $latestEpaper = EPaper::orderBy('publish_date', 'desc')->first();
            if ($latestEpaper) {
                $epaper = $latestEpaper;
                $date = $latestEpaper->publish_date;
                $dateString = $date->format('Y-m-d');
            }
        }

        $pagesData = [
            '1' => [], '2' => [], '3' => [], '4' => []
        ];
        $hasSavedEPaper = false;

        if ($epaper) {
            $hasSavedEPaper = true;
            if (!empty($epaper->pages_data)) {
                $pagesData = $epaper->pages_data;
            } elseif (!empty($epaper->layout_data)) {
                // Legacy fallback
                $postIds = $epaper->layout_data;
                $postsMap = Post::with(['user'])->whereIn('id', $postIds)->get()->keyBy('id');
                $page1 = [];
                foreach ($postIds as $idx => $id) {
                    if ($id && isset($postsMap[$id])) {
                        $p = $postsMap[$id];
                        $page1[] = [
                            'slot_id' => $idx + 1,
                            'post_id' => $p->id,
                            'title' => $p->title,
                            'excerpt' => strip_tags($p->content),
                            'image' => $p->featured_image_url,
                            'style' => ['font_size' => 14, 'columns' => 2, 'char_limit' => 1200]
                        ];
                    }
                }
                $pagesData['1'] = $page1;
            }
        }

        $selectedDate = $date;

        $days = ['Sunday'=>'রবিবার','Monday'=>'সোমবার','Tuesday'=>'মঙ্গলবার','Wednesday'=>'বুধবার','Thursday'=>'বৃহস্পতিবার','Friday'=>'শুক্রবার','Saturday'=>'শনিবার'];
        $months = ['Jan'=>'জানুয়ারি','Feb'=>'ফেব্রুয়ারি','Mar'=>'মার্চ','Apr'=>'এপ্রিল','May'=>'মে','Jun'=>'জুন','Jul'=>'জুলাই','Aug'=>'আগস্ট','Sep'=>'সেপ্টেম্বর','Oct'=>'অক্টোবর','Nov'=>'নভেম্বর','Dec'=>'ডিসেম্বর'];
        $enNumbers = ['0','1','2','3','4','5','6','7','8','9'];
        $bnNumbers = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];

        $dayNum = str_replace($enNumbers, $bnNumbers, $selectedDate->format('d'));
        $yearNum = str_replace($enNumbers, $bnNumbers, $selectedDate->format('Y'));
        $monthName = $months[$selectedDate->format('M')] ?? $selectedDate->format('M');
        $dayName = $days[$selectedDate->format('l')] ?? $selectedDate->format('l');
        $formattedDate = "{$dayNum} {$monthName} {$yearNum} ({$dayName})";
        $formattedEPaperHeaderDate = \App\Helpers\BanglaDateHelper::getFormattedEPaperDate($selectedDate);

        return view('epaper.show', compact('pagesData', 'selectedDate', 'hasSavedEPaper', 'formattedDate', 'formattedEPaperHeaderDate'));
    }

    /**
     * Display the Privacy Policy page (Bilingual: Bangla & English).
     */
    public function privacyPolicy()
    {
        $themeSettingsPath = storage_path('app/theme_settings.json');
        $themeSettings = file_exists($themeSettingsPath) ? json_decode(file_get_contents($themeSettingsPath), true) : [];

        return view('pages.privacy-policy', compact('themeSettings'));
    }

    /**
     * Display the About Us page (Bilingual: Bangla & English).
     */
    public function aboutUs()
    {
        $themeSettingsPath = storage_path('app/theme_settings.json');
        $themeSettings = file_exists($themeSettingsPath) ? json_decode(file_get_contents($themeSettingsPath), true) : [];

        return view('pages.about-us', compact('themeSettings'));
    }

    /**
     * Display the Terms of Use / Terms and Conditions page (Bilingual).
     */
    public function termsOfUse()
    {
        $themeSettingsPath = storage_path('app/theme_settings.json');
        $themeSettings = file_exists($themeSettingsPath) ? json_decode(file_get_contents($themeSettingsPath), true) : [];

        return view('pages.terms-of-use', compact('themeSettings'));
    }

    /**
     * Display the Comment Policy page (Bilingual).
     */
    public function commentPolicy()
    {
        $themeSettingsPath = storage_path('app/theme_settings.json');
        $themeSettings = file_exists($themeSettingsPath) ? json_decode(file_get_contents($themeSettingsPath), true) : [];

        return view('pages.comment-policy', compact('themeSettings'));
    }

    /**
     * Display the Editorial Policy & Disclaimer page (Bilingual).
     */
    public function editorialPolicy()
    {
        $themeSettingsPath = storage_path('app/theme_settings.json');
        $themeSettings = file_exists($themeSettingsPath) ? json_decode(file_get_contents($themeSettingsPath), true) : [];

        return view('pages.editorial-policy', compact('themeSettings'));
    }

    /**
     * Display the Contact & Our Family page.
     */
    public function contact()
    {
        $themeSettingsPath = storage_path('app/theme_settings.json');
        $themeSettings = file_exists($themeSettingsPath) ? json_decode(file_get_contents($themeSettingsPath), true) : [];

        return view('pages.contact', compact('themeSettings'));
    }

    /**
     * Handle Contact Form Submission.
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:5000',
        ], [
            'name.required' => 'আপনার নাম প্রদান করুন।',
            'phone.required' => 'আপনার মোবাইল নম্বর প্রদান করুন।',
            'subject.required' => 'বার্তা পাঠানোর বিষয়টি নির্বাচন করুন।',
            'message.required' => 'আপনার বার্তা বা অভিযোগের বিস্তারিত লিখুন।',
        ]);

        $contactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'is_read' => false,
        ]);

        $successText = 'আপনার বার্তাটি সফলভাবে পাঠানো হয়েছে। আমাদের প্রতিনিধি দ্রুত আপনার সাথে যোগাযোগ করবেন।';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $successText,
            ]);
        }

        return redirect()->back()->with('success', $successText);
    }

    /**
     * Handle Public Poll Vote Submission.
     */
    public function votePoll(Request $request)
    {
        $request->validate([
            'poll_id' => 'required|exists:polls,id',
            'vote' => 'required|in:yes,no,neutral',
        ]);

        $poll = Poll::findOrFail($request->poll_id);

        if (!$poll->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'এই জরিপটি বর্তমানে বন্ধ রয়েছে।',
            ], 403);
        }

        $ip = $request->ip();

        // Check if this IP voted in the last 24 hours for this poll
        $alreadyVoted = PollVote::where('poll_id', $poll->id)
            ->where('ip_address', $ip)
            ->where('created_at', '>=', Carbon::now()->subHours(24))
            ->exists();

        if ($alreadyVoted) {
            return response()->json([
                'success' => false,
                'already_voted' => true,
                'message' => 'আপনি ইতিমধ্যে এই জরিপে ভোট প্রদান করেছেন। মতামত প্রদানের জন্য ধন্যবাদ!',
                'poll' => [
                    'total_votes' => $poll->total_votes,
                    'yes_votes' => $poll->yes_votes,
                    'no_votes' => $poll->no_votes,
                    'neutral_votes' => $poll->neutral_votes,
                    'yes_percent' => $poll->yes_percent,
                    'no_percent' => $poll->no_percent,
                    'neutral_percent' => $poll->neutral_percent,
                ]
            ]);
        }

        // Increment vote count on poll
        if ($request->vote === 'yes') {
            $poll->increment('yes_votes');
        } elseif ($request->vote === 'no') {
            $poll->increment('no_votes');
        } else {
            $poll->increment('neutral_votes');
        }

        // Record vote entry
        PollVote::create([
            'poll_id' => $poll->id,
            'ip_address' => $ip,
            'selected_option' => $request->vote,
            'user_agent' => substr($request->userAgent() ?? '', 0, 255),
        ]);

        $poll->refresh();

        return response()->json([
            'success' => true,
            'message' => 'আপনার মূল্যবান ভোটটি সফলভাবে গৃহীত হয়েছে।',
            'poll' => [
                'total_votes' => $poll->total_votes,
                'yes_votes' => $poll->yes_votes,
                'no_votes' => $poll->no_votes,
                'neutral_votes' => $poll->neutral_votes,
                'yes_percent' => $poll->yes_percent,
                'no_percent' => $poll->no_percent,
                'neutral_percent' => $poll->neutral_percent,
            ]
        ]);
    }

    /**
     * Handle Newsletter Subscription.
     */
    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:191',
        ], [
            'email.required' => 'অনুগ্রহ করে আপনার ইমেইল প্রদান করুন।',
            'email.email' => 'সঠিক ইমেইল ঠিকানা প্রদান করুন।',
        ]);

        $subscriber = Subscriber::firstOrCreate(
            ['email' => strtolower(trim($request->email))],
            [
                'ip_address' => $request->ip(),
                'is_active' => true,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'ধন্যবাদ! আমাদের নিউজলেটার তালিকায় আপনার ইমেইল সফলভাবে যুক্ত করা হয়েছে।',
        ]);
    }
}
