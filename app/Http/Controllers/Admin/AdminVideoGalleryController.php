<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;

class AdminVideoGalleryController extends Controller
{
    /**
     * Get the theme settings file path.
     */
    protected function getSettingsPath(): string
    {
        return storage_path('app/theme_settings.json');
    }

    /**
     * Extract 11-character YouTube Video ID from any YouTube URL format.
     */
    public static function extractYouTubeId(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        // Bare 11-char ID
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        // Standard, Shorts, Embed, Live, Mobile, etc.
        $pattern = '/(?:youtu\.be\/|(?:m\.|www\.)?youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=|shorts\/|live\/))([\w-]{11})/i';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Load current video gallery list from settings.
     */
    protected function getVideos(): array
    {
        $path = $this->getSettingsPath();
        if (file_exists($path)) {
            $settings = json_decode(file_get_contents($path), true);
            if (isset($settings['video_gallery']) && is_array($settings['video_gallery'])) {
                return $settings['video_gallery'];
            }
        }

        // Default fallback videos if none exist
        return [
            [
                'title' => 'ভোলা-বরিশাল সেতু নির্মাণ প্রকল্প ও নদীভাঙন রোধে মেঘনার তীরে আধুনিক ব্লক বাঁধ',
                'youtube_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
                'video_id' => 'ScMzIvxBSi4',
                'thumbnail' => 'https://img.youtube.com/vi/ScMzIvxBSi4/hqdefault.jpg'
            ],
            [
                'title' => 'ইলিশের মৌসুমে ভোলার মেঘনা ও তেঁতুলিয়া নদীতে জেলেদের ব্যস্ততা ও মাছের বাজার',
                'youtube_url' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
                'video_id' => 'kJQP7kiw5Fk',
                'thumbnail' => 'https://img.youtube.com/vi/kJQP7kiw5Fk/hqdefault.jpg'
            ],
            [
                'title' => 'উপকূলীয় চরাঞ্চলে আধুনিক কৃষি বিপ্লব ও মহিষের বাথানে খামারিদের সাফল্য',
                'youtube_url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                'video_id' => '9bZkp7q19f0',
                'thumbnail' => 'https://img.youtube.com/vi/9bZkp7q19f0/hqdefault.jpg'
            ],
            [
                'title' => 'দ্বীপজেলা ভোলার গ্যাস পাইপলাইনের বিস্তার ও স্থানীয় অর্থনীতিতে নতুন সম্ভাবনা',
                'youtube_url' => 'https://www.youtube.com/watch?v=JGwWNGJdvx8',
                'video_id' => 'JGwWNGJdvx8',
                'thumbnail' => 'https://img.youtube.com/vi/JGwWNGJdvx8/hqdefault.jpg'
            ]
        ];
    }

    /**
     * Persist video gallery list into settings and purge cache.
     */
    protected function saveVideos(array $videos): void
    {
        $path = $this->getSettingsPath();
        $settings = [];

        if (file_exists($path)) {
            $settings = json_decode(file_get_contents($path), true) ?: [];
        }

        $settings['video_gallery'] = array_values($videos);

        // Ensure storage directory exists
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        file_put_contents($path, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Clear view and application cache immediately so changes take effect instantly
        try {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
        } catch (\Exception $e) {}
    }

    /**
     * Display the dedicated Video Gallery management page.
     */
    public function index()
    {
        Gate::authorize('admin-or-super');

        $videos = $this->getVideos();

        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Add a new video to the gallery.
     */
    public function add(Request $request)
    {
        Gate::authorize('admin-or-super');

        $request->validate([
            'title' => 'nullable|string|max:255',
            'youtube_url' => 'required|string|max:500',
        ]);

        $url = trim($request->youtube_url);
        $videoId = self::extractYouTubeId($url);

        if (!$videoId) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'সঠিক ইউটিউব ভিডিও লিংক বা আইডি দিন (যেমন: https://www.youtube.com/watch?v=... বা https://youtu.be/...)'], 422);
            }
            return redirect()->back()->with('error', 'সঠিক ইউটিউব ভিডিও লিংক বা আইডি দিন।');
        }

        $videos = $this->getVideos();
        $newVideo = [
            'title' => trim($request->title) ?: 'ভিডিও সংবাদ',
            'youtube_url' => str_starts_with($url, 'http') ? $url : "https://www.youtube.com/watch?v={$videoId}",
            'video_id' => $videoId,
            'thumbnail' => "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg"
        ];

        // Insert at beginning (newest video first)
        array_unshift($videos, $newVideo);
        $this->saveVideos($videos);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'ভিডিও সফলভাবে যুক্ত ও হোমপেজে প্রকাশিত হয়েছে!', 'videos' => $videos]);
        }

        return redirect()->route('admin.videos.index')->with('success', 'ভিডিও সফলভাবে যুক্ত ও হোমপেজে প্রকাশিত হয়েছে!');
    }

    /**
     * Update an existing video in the gallery.
     */
    public function updateItem(Request $request)
    {
        Gate::authorize('admin-or-super');

        $request->validate([
            'index' => 'required|integer|min:0',
            'title' => 'nullable|string|max:255',
            'youtube_url' => 'required|string|max:500',
        ]);

        $index = (int)$request->index;
        $url = trim($request->youtube_url);
        $videoId = self::extractYouTubeId($url);

        if (!$videoId) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'সঠিক ইউটিউব ভিডিও লিংক বা আইডি দিন।'], 422);
            }
            return redirect()->back()->with('error', 'সঠিক ইউটিউব ভিডিও লিংক বা আইডি দিন।');
        }

        $videos = $this->getVideos();

        if (!isset($videos[$index])) {
            return redirect()->back()->with('error', 'ভিডিওটি পাওয়া যায়নি।');
        }

        $videos[$index] = [
            'title' => trim($request->title) ?: 'ভিডিও সংবাদ',
            'youtube_url' => str_starts_with($url, 'http') ? $url : "https://www.youtube.com/watch?v={$videoId}",
            'video_id' => $videoId,
            'thumbnail' => "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg"
        ];

        $this->saveVideos($videos);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'ভিডিওটি সফলভাবে হালনাগাদ করা হয়েছে!', 'videos' => $videos]);
        }

        return redirect()->route('admin.videos.index')->with('success', 'ভিডিওটি সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Remove a video from the gallery.
     */
    public function delete(Request $request)
    {
        Gate::authorize('admin-or-super');

        $request->validate([
            'index' => 'required|integer|min:0',
        ]);

        $index = (int)$request->index;
        $videos = $this->getVideos();

        if (isset($videos[$index])) {
            array_splice($videos, $index, 1);
            $this->saveVideos($videos);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'ভিডিওটি সফলভাবে মুছে ফেলা হয়েছে!', 'videos' => $videos]);
        }

        return redirect()->route('admin.videos.index')->with('success', 'ভিডিওটি সফলভাবে মুছে ফেলা হয়েছে!');
    }

    /**
     * Bulk reorder/save entire video gallery list.
     */
    public function save(Request $request)
    {
        Gate::authorize('admin-or-super');

        $rawVideos = $request->input('videos');
        if (is_string($rawVideos)) {
            $rawVideos = json_decode($rawVideos, true);
        }

        if (!is_array($rawVideos)) {
            $rawVideos = [];
        }

        $sanitized = [];
        foreach ($rawVideos as $vid) {
            $url = trim($vid['youtube_url'] ?? '');
            $videoId = $vid['video_id'] ?? self::extractYouTubeId($url);

            if ($videoId) {
                $sanitized[] = [
                    'title' => trim($vid['title'] ?? 'ভিডিও সংবাদ') ?: 'ভিডিও সংবাদ',
                    'youtube_url' => str_starts_with($url, 'http') ? $url : "https://www.youtube.com/watch?v={$videoId}",
                    'video_id' => $videoId,
                    'thumbnail' => "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg"
                ];
            }
        }

        $this->saveVideos($sanitized);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'ভিডিও গ্যালারি সফলভাবে সংরক্ষিত হয়েছে!', 'videos' => $sanitized]);
        }

        return redirect()->back()->with('success', 'ভিডিও গ্যালারি সফলভাবে সংরক্ষিত হয়েছে!');
    }
}
