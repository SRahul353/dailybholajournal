<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\OpinionSubmission;
use App\Models\Poll;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin panel dashboard main hub.
     */
    public function index()
    {
        // 1. Core Metrics
        $totalPosts = Post::where('status', 'publish')->count();
        $todayPosts = Post::where('status', 'publish')->whereDate('created_at', Carbon::today())->count();
        $draftPosts = Post::where('status', 'draft')->count();
        $totalViews = Post::sum('views_count');
        $totalCategories = Category::count();
        $totalTags = Tag::count();
        $totalUsers = User::count();
        $totalSubscribers = Subscriber::count();

        $pendingOpinionsCount = OpinionSubmission::where('status', 'pending')->count();
        $unreadMessagesCount = ContactMessage::unread()->count();
        $activePoll = Poll::where('is_active', true)->first();

        // 2. 7-Day Publishing Trend
        $bengaliDays = [
            'Sat' => 'শনি',
            'Sun' => 'রবি',
            'Mon' => 'সোম',
            'Tue' => 'মঙ্গল',
            'Wed' => 'বুধ',
            'Thu' => 'বৃহস্পতি',
            'Fri' => 'শুক্র',
        ];

        $chartLabels = [];
        $chartPostCounts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dayName = $bengaliDays[$date->format('D')] ?? $date->format('D');
            $label = $dayName . ' (' . $date->format('d/m') . ')';
            if ($i === 0) {
                $label = 'আজ (' . $dayName . ')';
            }
            $chartLabels[] = $label;

            $count = Post::where('status', 'publish')->whereDate('created_at', $date)->count();
            $chartPostCounts[] = $count;
        }

        // 3. Recent Posts Activity (7 posts with relations)
        $recentPosts = Post::with(['categories', 'user'])
            ->latest()
            ->limit(7)
            ->get();

        // 4. Top 5 Most Viewed Posts
        $topViewedPosts = Post::with(['categories', 'user'])
            ->where('status', 'publish')
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        // 5. Recent Opinions Activity
        $recentOpinions = OpinionSubmission::latest()
            ->limit(5)
            ->get();

        // 6. Recent Contact Messages
        $recentMessages = ContactMessage::latest()
            ->limit(5)
            ->get();

        // 7. Category Breakdown with Posts Count
        $categoriesBreakdown = Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(6)
            ->get();

        $maxCategoryPosts = $categoriesBreakdown->max('posts_count') ?: 1;

        return view('admin.dashboard', compact(
            'totalPosts',
            'todayPosts',
            'draftPosts',
            'totalViews',
            'totalCategories',
            'totalTags',
            'totalUsers',
            'totalSubscribers',
            'pendingOpinionsCount',
            'unreadMessagesCount',
            'activePoll',
            'chartLabels',
            'chartPostCounts',
            'recentPosts',
            'topViewedPosts',
            'recentOpinions',
            'recentMessages',
            'categoriesBreakdown',
            'maxCategoryPosts'
        ));
    }
}

