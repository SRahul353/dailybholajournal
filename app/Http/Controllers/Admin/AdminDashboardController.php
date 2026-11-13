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
use App\Models\VisitorLog;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin panel dashboard main hub with visitor intelligence.
     */
    public function index()
    {
        // 1. Core Editorial Metrics
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

        // 2. Visitor Analytics Metrics
        $today = Carbon::today();
        $todayVisitorsCount = VisitorLog::whereDate('created_at', $today)->distinct('ip_address')->count('ip_address');
        if ($todayVisitorsCount === 0) {
            $todayVisitorsCount = VisitorLog::whereDate('created_at', $today)->count();
        }
        $todayViewsCount = VisitorLog::whereDate('created_at', $today)->count();
        $weekVisitorsCount = VisitorLog::where('created_at', '>=', Carbon::now()->subDays(7))->distinct('ip_address')->count('ip_address');
        $monthVisitorsCount = VisitorLog::where('created_at', '>=', Carbon::now()->subDays(30))->distinct('ip_address')->count('ip_address');

        // 3. 7-Day Visitor & Traffic Trend Chart
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
        $chartVisitors = [];
        $chartViews = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dayName = $bengaliDays[$date->format('D')] ?? $date->format('D');
            $label = ($i === 0) ? 'আজ (' . $dayName . ')' : $dayName . ' (' . $date->format('d/m') . ')';
            $chartLabels[] = $label;

            $dailyVisitors = VisitorLog::whereDate('created_at', $date)->distinct('ip_address')->count('ip_address');
            $dailyViews = VisitorLog::whereDate('created_at', $date)->count();

            $chartVisitors[] = $dailyVisitors;
            $chartViews[] = $dailyViews;
        }

        // 4. Technology & Platform Breakdowns
        $totalLogRecords = VisitorLog::count() ?: 1;

        $deviceStats = VisitorLog::selectRaw('device, count(*) as count')
            ->groupBy('device')
            ->orderByDesc('count')
            ->get()
            ->map(function ($item) use ($totalLogRecords) {
                $item->percent = round(($item->count / $totalLogRecords) * 100);
                return $item;
            });

        $sourceStats = VisitorLog::selectRaw('referer_source, count(*) as count')
            ->groupBy('referer_source')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->map(function ($item) use ($totalLogRecords) {
                $item->percent = round(($item->count / $totalLogRecords) * 100);
                return $item;
            });

        $browserStats = VisitorLog::selectRaw('browser, count(*) as count')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(4)
            ->get()
            ->map(function ($item) use ($totalLogRecords) {
                $item->percent = round(($item->count / $totalLogRecords) * 100);
                return $item;
            });

        // 5. Recent Live Visitors (Latest 8 records)
        $recentVisitors = VisitorLog::with('post')
            ->latest()
            ->limit(8)
            ->get();

        // 6. Recent Posts Activity (7 posts with relations)
        $recentPosts = Post::with(['categories', 'user'])
            ->latest()
            ->limit(7)
            ->get();

        // 7. Top 5 Most Viewed Posts
        $topViewedPosts = Post::with(['categories', 'user'])
            ->where('status', 'publish')
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        // 8. Recent Opinions Activity
        $recentOpinions = OpinionSubmission::latest()
            ->limit(5)
            ->get();

        // 9. Recent Contact Messages
        $recentMessages = ContactMessage::latest()
            ->limit(5)
            ->get();

        // 10. Category Breakdown with Posts Count
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
            'todayVisitorsCount',
            'todayViewsCount',
            'weekVisitorsCount',
            'monthVisitorsCount',
            'chartLabels',
            'chartVisitors',
            'chartViews',
            'deviceStats',
            'sourceStats',
            'browserStats',
            'recentVisitors',
            'recentPosts',
            'topViewedPosts',
            'recentOpinions',
            'recentMessages',
            'categoriesBreakdown',
            'maxCategoryPosts'
        ));
    }
}


