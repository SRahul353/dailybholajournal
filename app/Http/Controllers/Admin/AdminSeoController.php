<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;

class AdminSeoController extends Controller
{
    /**
     * Display the SEO Manager dashboard and configuration page.
     */
    public function index()
    {
        Gate::authorize('admin-or-super');

        $settings = SeoService::getSettings();
        $stats = SeoService::getStats();
        $robotsContent = SeoService::getRobotsTxt();

        return view('admin.seo.index', compact('settings', 'stats', 'robotsContent'));
    }

    /**
     * Save/update SEO configuration.
     */
    public function update(Request $request)
    {
        Gate::authorize('admin-or-super');

        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_title' => 'required|string|max:255',
            'title_separator' => 'nullable|string|max:10',
            'meta_tagline' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'meta_author' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'robots_indexing' => 'required|string|in:index, follow,noindex, nofollow,index, nofollow,noindex, follow',

            'og_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'og_image' => 'nullable|string',
            'og_type' => 'nullable|string|max:50',
            'og_locale' => 'nullable|string|max:20',
            'facebook_app_id' => 'nullable|string|max:100',
            'facebook_page_url' => 'nullable|string|max:255',
            'twitter_site' => 'nullable|string|max:100',
            'twitter_creator' => 'nullable|string|max:100',
            'twitter_card' => 'nullable|string|in:summary_large_image,summary',

            'google_site_verification' => 'nullable|string|max:255',
            'bing_site_verification' => 'nullable|string|max:255',
            'yandex_verification' => 'nullable|string|max:255',
            'google_analytics_id' => 'nullable|string|max:50',
            'google_tag_manager_id' => 'nullable|string|max:50',
            'facebook_pixel_id' => 'nullable|string|max:50',

            'header_scripts' => 'nullable|string',
            'footer_scripts' => 'nullable|string',

            'enable_custom_robots' => 'nullable',
            'custom_robots_txt' => 'nullable|string',

            'schema_org_type' => 'nullable|string|max:100',
            'schema_org_name' => 'nullable|string|max:255',
            'schema_org_url' => 'nullable|string|max:255',
            'schema_org_logo' => 'nullable|string|max:255',
            'social_profiles' => 'nullable|string',
        ]);

        $data = $request->except(['_token', 'og_image_file']);
        $ogImageFile = $request->file('og_image_file');

        SeoService::saveSettings($data, $ogImageFile);

        try {
            Artisan::call('view:clear');
        } catch (\Exception $e) {}

        return redirect()->route('admin.seo.index')->with('success', 'এসইও সেটিংস সফলভাবে সংরক্ষিত ও আপডেট হয়েছে!');
    }

    /**
     * Ping search engines to trigger sitemap re-indexing.
     */
    public function ping(Request $request)
    {
        Gate::authorize('admin-or-super');

        $results = SeoService::pingSearchEngines();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'results' => $results,
                'message' => 'সার্চ ইঞ্জিনে সাইটম্যাপ পিং প্রক্রিয়া সম্পন্ন হয়েছে।'
            ]);
        }

        return redirect()->route('admin.seo.index')->with('success', 'সার্চ ইঞ্জিনে সাইটম্যাপ পিং সফলভাবে পাঠানো হয়েছে!');
    }
}
