<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Generate dynamic XML sitemap for search engines and Google News.
     */
    public function sitemap()
    {
        $posts = Post::where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->limit(1000)
            ->get(['slug', 'title', 'created_at', 'updated_at']);

        $categories = Category::all(['slug', 'updated_at']);

        $staticPages = [
            ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'always', 'lastmod' => now()->toAtomString()],
            ['url' => route('epaper'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => now()->toAtomString()],
            ['url' => route('opinion.submit'), 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => now()->toAtomString()],
            ['url' => route('contact'), 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => now()->toAtomString()],
            ['url' => route('about.us'), 'priority' => '0.6', 'changefreq' => 'monthly', 'lastmod' => now()->toAtomString()],
            ['url' => route('privacy.policy'), 'priority' => '0.5', 'changefreq' => 'yearly', 'lastmod' => now()->toAtomString()],
            ['url' => route('terms.of.use'), 'priority' => '0.5', 'changefreq' => 'yearly', 'lastmod' => now()->toAtomString()],
            ['url' => route('editorial.policy'), 'priority' => '0.5', 'changefreq' => 'yearly', 'lastmod' => now()->toAtomString()],
            ['url' => route('comment.policy'), 'priority' => '0.5', 'changefreq' => 'yearly', 'lastmod' => now()->toAtomString()],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">' . "\n";

        // 1. Static Pages
        foreach ($staticPages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($page['url']) . "</loc>\n";
            $xml .= "    <lastmod>" . $page['lastmod'] . "</lastmod>\n";
            $xml .= "    <changefreq>" . $page['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $page['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        // 2. Categories
        foreach ($categories as $cat) {
            $catUrl = route('category', $cat->slug);
            $lastmod = ($cat->updated_at ?? now())->toAtomString();
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($catUrl) . "</loc>\n";
            $xml .= "    <lastmod>" . $lastmod . "</lastmod>\n";
            $xml .= "    <changefreq>daily</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        // 3. News Posts
        $twoDaysAgo = Carbon::now()->subDays(2);
        foreach ($posts as $post) {
            $postUrl = route('post', $post->slug);
            $lastmod = ($post->updated_at ?? $post->created_at)->toAtomString();
            $pubDate = ($post->created_at ?? now())->toAtomString();

            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($postUrl) . "</loc>\n";
            $xml .= "    <lastmod>" . $lastmod . "</lastmod>\n";
            $xml .= "    <changefreq>never</changefreq>\n";
            $xml .= "    <priority>0.9</priority>\n";

            // If published in the last 48 hours, include Google News tags
            if ($post->created_at && $post->created_at->greaterThanOrEqualTo($twoDaysAgo)) {
                $xml .= "    <news:news>\n";
                $xml .= "      <news:publication>\n";
                $xml .= "        <news:name>দৈনিক ভোলা জার্নাল</news:name>\n";
                $xml .= "        <news:language>bn</news:language>\n";
                $xml .= "      </news:publication>\n";
                $xml .= "      <news:publication_date>" . $pubDate . "</news:publication_date>\n";
                $xml .= "      <news:title>" . htmlspecialchars($post->title) . "</news:title>\n";
                $xml .= "    </news:news>\n";
            }

            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    /**
     * Generate robots.txt
     */
    public function robots()
    {
        $sitemapUrl = route('seo.sitemap');

        $content = "User-agent: *\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /epaper/clear-cache\n";
        $content .= "Disallow: /epaper/migrate\n";
        $content .= "Allow: /\n\n";
        $content .= "Sitemap: " . $sitemapUrl . "\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }

    /**
     * Generate standard RSS 2.0 feed for news readers, aggregators, and Google News.
     */
    public function rss()
    {
        $posts = Post::with(['categories', 'user'])
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        $themeSettingsPath = storage_path('app/theme_settings.json');
        $siteTitle = 'দৈনিক ভোলা জার্নাল';
        $siteDesc = 'সত্য ও তথ্যের সমন্বয়ে উপকূলের দিনলিপি';
        if (file_exists($themeSettingsPath)) {
            $settings = json_decode(file_get_contents($themeSettingsPath), true);
            $siteDesc = $settings['footer_text'] ?? $siteDesc;
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
        $xml .= '  <channel>' . "\n";
        $xml .= '    <title>' . htmlspecialchars($siteTitle) . '</title>' . "\n";
        $xml .= '    <link>' . route('home') . '</link>' . "\n";
        $xml .= '    <description>' . htmlspecialchars($siteDesc) . '</description>' . "\n";
        $xml .= '    <language>bn</language>' . "\n";
        $xml .= '    <atom:link href="' . route('seo.rss') . '" rel="self" type="application/rss+xml" />' . "\n";
        $xml .= '    <lastBuildDate>' . now()->toRfc2822String() . '</lastBuildDate>' . "\n";

        foreach ($posts as $post) {
            $postUrl = route('post', $post->slug);
            $pubDate = ($post->created_at ?? now())->toRfc2822String();
            $author = $post->user ? $post->user->name : 'দৈনিক ভোলা জার্নাল ডেস্ক';
            $category = $post->categories->first() ? $post->categories->first()->name : 'জাতীয়';
            $excerpt = htmlspecialchars(strip_tags($post->excerpt ?: mb_substr($post->content, 0, 250)));

            $xml .= "    <item>\n";
            $xml .= "      <title>" . htmlspecialchars($post->title) . "</title>\n";
            $xml .= "      <link>" . htmlspecialchars($postUrl) . "</link>\n";
            $xml .= "      <guid isPermaLink=\"true\">" . htmlspecialchars($postUrl) . "</guid>\n";
            $xml .= "      <pubDate>" . $pubDate . "</pubDate>\n";
            $xml .= "      <dc:creator><![CDATA[" . $author . "]]></dc:creator>\n";
            $xml .= "      <category><![CDATA[" . $category . "]]></category>\n";
            $xml .= "      <description><![CDATA[" . $excerpt . "]]></description>\n";
            if ($post->featured_image_url) {
                $xml .= "      <enclosure url=\"" . htmlspecialchars($post->featured_image_url) . "\" type=\"image/jpeg\" />\n";
            }
            $xml .= "    </item>\n";
        }

        $xml .= '  </channel>' . "\n";
        $xml .= '</rss>';

        return response($xml, 200, [
            'Content-Type' => 'application/rss+xml; charset=utf-8',
        ]);
    }
}
