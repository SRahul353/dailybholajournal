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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin panel dashboard with selectable range filter (today, 7days, 30days, 90days).
     */
    public function index(Request $request)
    {
        // 1. Validate and resolve Date Range Filter
        $validRanges = ['today', '7days', '30days', '90days'];
        $range = $request->query('range', '7days');
        if (!in_array($range, $validRanges)) {
            $range = '7days';
        }

        $now = Carbon::now();
        $bengaliDays = [
            'Sat' => 'শনি', 'Sun' => 'রবি', 'Mon' => 'সোম',
            'Tue' => 'মঙ্গল', 'Wed' => 'বুধ', 'Thu' => 'বৃহস্পতি', 'Fri' => 'শুক্র'
        ];
        $bengaliMonths = [
            'Jan' => 'জানু', 'Feb' => 'ফেব্রু', 'Mar' => 'মার্চ', 'Apr' => 'এপ্রিল',
            'May' => 'মে', 'Jun' => 'জুন', 'Jul' => 'জুলাই', 'Aug' => 'আগস্ট',
            'Sep' => 'সেপ্টে', 'Oct' => 'অক্টো', 'Nov' => 'নভে', 'Dec' => 'ডিসে'
        ];

        $chartLabels = [];
        $chartVisitors = [];
        $chartViews = [];

        if ($range === 'today') {
            $startDate = Carbon::today()->startOfDay();
            $endDate = $now;
            $rangeTitle = 'আজকের ভিজিটর ও পেজ ভিউ';
            $rangeLabelBn = 'আজকে';

            // 12 2-hour slots for today
            for ($h = 0; $h < 24; $h += 2) {
                $slotStart = Carbon::today()->setTime($h, 0, 0);
                $slotEnd = Carbon::today()->setTime($h + 1, 59, 59);
                $chartLabels[] = sprintf('%02d:00', $h);

                $chartVisitors[] = VisitorLog::whereBetween('created_at', [$slotStart, $slotEnd])->distinct('ip_address')->count('ip_address');
                $chartViews[] = VisitorLog::whereBetween('created_at', [$slotStart, $slotEnd])->count();
            }
        } elseif ($range === '30days') {
            $startDate = Carbon::today()->subDays(29)->startOfDay();
            $endDate = $now;
            $rangeTitle = 'গত ৩০ দিনের ভিজিটর ট্রেন্ড';
            $rangeLabelBn = 'গত ৩০ দিন';

            // 30 daily data points
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $monthBn = $bengaliMonths[$date->format('M')] ?? $date->format('M');
                $chartLabels[] = $date->format('d') . ' ' . $monthBn;

                $chartVisitors[] = VisitorLog::whereDate('created_at', $date)->distinct('ip_address')->count('ip_address');
                $chartViews[] = VisitorLog::whereDate('created_at', $date)->count();
            }
        } elseif ($range === '90days') {
            $startDate = Carbon::today()->subDays(89)->startOfDay();
            $endDate = $now;
            $rangeTitle = 'গত ৯০ দিনের ভিজিটর ট্রেন্ড';
            $rangeLabelBn = 'গত ৯০ দিন';

            // 13 weekly buckets
            for ($w = 12; $w >= 0; $w--) {
                $wStart = Carbon::today()->subDays(($w * 7) + 6)->startOfDay();
                $wEnd = Carbon::today()->subDays($w * 7)->endOfDay();
                $startMonth = $bengaliMonths[$wStart->format('M')] ?? $wStart->format('M');
                $endMonth = $bengaliMonths[$wEnd->format('M')] ?? $wEnd->format('M');
                $chartLabels[] = $wStart->format('d') . ' ' . $startMonth . ' - ' . $wEnd->format('d') . ' ' . $endMonth;

                $chartVisitors[] = VisitorLog::whereBetween('created_at', [$wStart, $wEnd])->distinct('ip_address')->count('ip_address');
                $chartViews[] = VisitorLog::whereBetween('created_at', [$wStart, $wEnd])->count();
            }
        } else { // 7days (default)
            $startDate = Carbon::today()->subDays(6)->startOfDay();
            $endDate = $now;
            $rangeTitle = 'গত ৭ দিনের ভিজিটর ট্রেন্ড';
            $rangeLabelBn = 'গত ৭ দিন';

            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $dayName = $bengaliDays[$date->format('D')] ?? $date->format('D');
                $chartLabels[] = ($i === 0) ? 'আজ (' . $dayName . ')' : $dayName . ' (' . $date->format('d/m') . ')';

                $chartVisitors[] = VisitorLog::whereDate('created_at', $date)->distinct('ip_address')->count('ip_address');
                $chartViews[] = VisitorLog::whereDate('created_at', $date)->count();
            }
        }

        // 2. Metrics calculated for the selected Range
        $rangeVisitorsCount = VisitorLog::whereBetween('created_at', [$startDate, $endDate])->distinct('ip_address')->count('ip_address');
        $rangeViewsCount = VisitorLog::whereBetween('created_at', [$startDate, $endDate])->count();
        $rangePostsCount = Post::where('status', 'publish')->whereBetween('created_at', [$startDate, $endDate])->count();

        // 3. Core All-time Editorial Metrics
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

        // 4. Technology & Platform Breakdown (Filtered by selected range)
        $rangeTotalLogs = $rangeViewsCount ?: 1;

        $deviceStats = VisitorLog::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('device, count(*) as count')
            ->groupBy('device')
            ->orderByDesc('count')
            ->get()
            ->map(function ($item) use ($rangeTotalLogs) {
                $item->percent = round(($item->count / $rangeTotalLogs) * 100);
                return $item;
            });

        $sourceStats = VisitorLog::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('referer_source, count(*) as count')
            ->groupBy('referer_source')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->map(function ($item) use ($rangeTotalLogs) {
                $item->percent = round(($item->count / $rangeTotalLogs) * 100);
                return $item;
            });

        $browserStats = VisitorLog::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('browser, count(*) as count')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(4)
            ->get()
            ->map(function ($item) use ($rangeTotalLogs) {
                $item->percent = round(($item->count / $rangeTotalLogs) * 100);
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

        // 11. Logged-in user name for greeting card
        $userName = Auth::user()->name ?? 'অ্যাডমিন';

        return view('admin.dashboard', compact(
            'range',
            'rangeTitle',
            'rangeLabelBn',
            'rangeVisitorsCount',
            'rangeViewsCount',
            'rangePostsCount',
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
            'maxCategoryPosts',
            'userName'
        ));
    }
}



