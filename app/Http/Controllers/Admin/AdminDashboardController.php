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

class AdminDashboardController extends Controller
{
    /**
     * Display the admin panel dashboard main hub.
     */
    public function index()
    {
        // 1. Core Metrics
        $totalPosts = Post::count();
        $totalViews = Post::sum('views_count');
        $totalCategories = Category::count();
        $totalTags = Tag::count();
        $pendingOpinionsCount = OpinionSubmission::where('status', 'pending')->count();
        $unreadMessagesCount = ContactMessage::unread()->count();
        $totalSubscribers = Subscriber::count();
        $activePoll = Poll::where('is_active', true)->first();

        // 2. Recent Posts Activity
        $recentPosts = Post::with('categories')
            ->latest()
            ->limit(5)
            ->get();

        // 3. Recent Opinions Activity
        $recentOpinions = OpinionSubmission::latest()
            ->limit(5)
            ->get();

        // 4. Category Breakdown (Category names with their post count)
        $categoriesBreakdown = Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPosts', 
            'totalViews', 
            'totalCategories', 
            'totalTags', 
            'pendingOpinionsCount',
            'unreadMessagesCount',
            'totalSubscribers',
            'activePoll',
            'recentPosts',
            'recentOpinions',
            'categoriesBreakdown'
        ));
    }
}
