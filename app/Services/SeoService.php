<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SeoService
{
    protected static ?array $settings = null;

    /**
     * Get the file path where SEO settings are stored.
     */
    public static function getFilePath(): string
    {
        return storage_path('app/seo_settings.json');
    }

    /**
     * Default SEO Settings
     */
    public static function defaults(): array
    {
        return [
            // General Meta
            'site_name' => 'দৈনিক ভোলা জার্নাল',
            'site_title' => 'দৈনিক ভোলা জার্নাল | সত্য ও ন্যায়ের সন্ধানে সার্বক্ষণিক',
            'title_separator' => '|',
            'meta_tagline' => 'সত্য ও তথ্যের সমন্বয়ে উপকূলের দিনলিপি',
            'meta_description' => 'দৈনিক ভোলা জার্নাল - ভোলা জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র। আমরা অত্যন্ত সততা, নিষ্ঠা ও নিরপেক্ষতার সাথে সব ধরণের স্থানীয় ও জাতীয় সংবাদ সবার আগে প্রকাশ করি।',
            'meta_keywords' => 'দৈনিক ভোলা জার্নাল, ভোলা জার্নাল, ভোলা নিউজ, daily bhola journal, bhola journal, bhola news, dainik bholajournal, bholajournal, bhola newspaper',
            'meta_author' => 'দৈনিক ভোলা জার্নাল',
            'canonical_url' => '',
            'robots_indexing' => 'index, follow',

            // Social & Open Graph
            'og_image' => '',
            'og_type' => 'website',
            'og_locale' => 'bn_BD',
            'facebook_app_id' => '',
            'facebook_page_url' => 'https://facebook.com/',
            'twitter_site' => '@dailybholajournal',
            'twitter_creator' => '@dailybholajournal',
            'twitter_card' => 'summary_large_image',

            // Verification & Analytics
            'google_site_verification' => '',
            'bing_site_verification' => '',
            'yandex_verification' => '',
            'google_analytics_id' => '',
            'google_tag_manager_id' => '',
            'facebook_pixel_id' => '',

            // Custom Code Injection
            'header_scripts' => '',
            'footer_scripts' => '',

            // Robots.txt
            'enable_custom_robots' => false,
            'custom_robots_txt' => '',

            // Schema.org Structured Data
            'schema_org_type' => 'NewsMediaOrganization',
            'schema_org_name' => 'দৈনিক ভোলা জার্নাল',
            'schema_org_url' => '',
            'schema_org_logo' => '',
            'social_profiles' => "https://www.facebook.com/\nhttps://twitter.com/\nhttps://www.youtube.com/",
        ];
    }

    /**
     * Retrieve all SEO settings (cached in memory and application cache).
     */
    public static function getSettings(): array
    {
        if (self::$settings !== null) {
            return self::$settings;
        }

        self::$settings = Cache::remember('seo_settings_cache', 3600, function () {
            $path = self::getFilePath();
            $defaults = self::defaults();

            if (file_exists($path)) {
                $saved = json_decode(file_get_contents($path), true);
                if (is_array($saved)) {
                    return array_merge($defaults, $saved);
                }
            }

            return $defaults;
        });

        return self::$settings;
    }

    /**
     * Get a specific setting value with fallback.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = self::getSettings();
        return $settings[$key] ?? $default;
    }

    /**
     * Save SEO settings to storage and clear cache.
     */
    public static function saveSettings(array $data, $ogImageFile = null): array
    {
        $path = self::getFilePath();
        $current = self::getSettings();

        // Handle OG Image upload
        if ($ogImageFile && $ogImageFile->isValid()) {
            $fileName = 'og_default_' . time() . '.' . $ogImageFile->getClientOriginalExtension();
            $uploadsDir = public_path('uploads');

            if (!file_exists($uploadsDir)) {
                mkdir($uploadsDir, 0755, true);
            }

            // Remove old uploaded OG image if it was in uploads/
            if (!empty($current['og_image']) && str_starts_with($current['og_image'], 'uploads/') && file_exists(public_path($current['og_image']))) {
                @unlink(public_path($current['og_image']));
            }

            $ogImageFile->move($uploadsDir, $fileName);
            $data['og_image'] = 'uploads/' . $fileName;
        } elseif (!isset($data['og_image'])) {
            $data['og_image'] = $current['og_image'] ?? '';
        }

        // Checkbox boolean handling
        $data['enable_custom_robots'] = !empty($data['enable_custom_robots']);

        $merged = array_merge($current, $data);

        // Ensure storage directory exists
        $dir = dirname($path);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($path, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Clear cache and static property
        self::$settings = null;
        Cache::forget('seo_settings_cache');

        return $merged;
    }

    /**
     * Return formatted robots.txt content (either customized or standard dynamic).
     */
    public static function getRobotsTxt(): string
    {
        $settings = self::getSettings();

        if (!empty($settings['enable_custom_robots']) && !empty(trim($settings['custom_robots_txt']))) {
            return $settings['custom_robots_txt'];
        }

        $sitemapUrl = route('seo.sitemap');

        $content = "User-agent: *\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /epaper/clear-cache\n";
        $content .= "Disallow: /epaper/migrate\n";
        $content .= "Allow: /\n\n";
        $content .= "Sitemap: " . $sitemapUrl . "\n";

        return $content;
    }

    /**
     * Collect summary statistics for SEO Dashboard
     */
    public static function getStats(): array
    {
        $publishedPosts = Post::where('status', 'publish')->count();
        $categoriesCount = Category::count();
        $tagsCount = Tag::count();

        $lastPost = Post::where('status', 'publish')->latest('updated_at')->first(['updated_at', 'created_at']);
        $lastUpdated = $lastPost ? ($lastPost->updated_at ?? $lastPost->created_at) : null;

        return [
            'published_posts' => $publishedPosts,
            'categories_count' => $categoriesCount,
            'tags_count' => $tagsCount,
            'last_updated' => $lastUpdated,
            'sitemap_url' => route('seo.sitemap'),
            'rss_url' => route('seo.rss'),
            'robots_url' => route('seo.robots'),
        ];
    }

    /**
     * Ping Bing / Search Engines for Sitemap Indexing
     */
    public static function pingSearchEngines(): array
    {
        $sitemapUrl = urlencode(route('seo.sitemap'));
        $results = [];

        // Ping Bing
        try {
            $bingResponse = Http::timeout(6)->get("https://www.bing.com/ping?sitemap={$sitemapUrl}");
            $results['bing'] = [
                'success' => $bingResponse->successful(),
                'status' => $bingResponse->status(),
                'message' => $bingResponse->successful() ? 'বিং সার্চ ইঞ্জিনে সাইটম্যাপ সফলভাবে পিং হয়েছে।' : 'বিং রেসপন্স কোড: ' . $bingResponse->status()
            ];
        } catch (\Exception $e) {
            $results['bing'] = [
                'success' => false,
                'status' => 500,
                'message' => 'বিং পিং সংযোগ ত্রুটি: ' . $e->getMessage()
            ];
        }

        // Google discontinued public anonymous ping in late 2023 in favor of Search Console API / direct submission.
        // We provide a direct link & note for Google Search Console.
        $results['google'] = [
            'success' => true,
            'status' => 200,
            'message' => 'গুগল সার্চ কনসোলে সাইটম্যাপ ইনডেক্স যাচাই করার জন্য প্রস্তুত।'
        ];

        return $results;
    }
}
