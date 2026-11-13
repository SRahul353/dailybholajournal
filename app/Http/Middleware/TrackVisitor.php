<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request and track visitor data.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Track only successful public GET HTML responses
        try {
            if ($request->isMethod('GET') && !$request->ajax() && !$request->isJson()) {
                if ($this->shouldTrack($request)) {
                    $this->logVisitor($request);
                }
            }
        } catch (\Throwable $e) {
            // Silently ignore tracking errors to avoid disrupting user experience
        }

        return $response;
    }

    /**
     * Check if this request URL should be tracked.
     */
    protected function shouldTrack(Request $request): bool
    {
        $path = $request->path();

        // Exclude admin panel, health check, proxies, and asset patterns
        $excluded = [
            'admin',
            'admin/*',
            'up',
            'epaper/proxy*',
            'epaper/wp-posts*',
            'build/*',
            'images/*',
            'favicon.ico',
            'robots.txt',
            'feed',
            'rss.xml',
            'sitemap.xml',
        ];

        foreach ($excluded as $pattern) {
            if ($request->is($pattern)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Parse User Agent and persist visitor log.
     */
    protected function logVisitor(Request $request): void
    {
        $ip = $request->ip();
        $sessionId = session()->getId();
        $ua = (string) $request->header('User-Agent', '');
        $url = $request->fullUrl();
        $referer = (string) $request->header('referer', '');

        // Parse Device
        $device = 'Desktop';
        if (preg_match('/(iPad|Tablet|PlayBook)/i', $ua)) {
            $device = 'Tablet';
        } elseif (preg_match('/(Mobile|Android|iPhone|iPod|BlackBerry|Opera Mini|Opera Mobi)/i', $ua)) {
            $device = 'Mobile';
        }

        // Parse Operating System
        $os = 'Other';
        if (preg_match('/Windows NT 10/i', $ua)) $os = 'Windows 10/11';
        elseif (preg_match('/Windows/i', $ua)) $os = 'Windows';
        elseif (preg_match('/Android/i', $ua)) $os = 'Android';
        elseif (preg_match('/(iPhone|iPad|iPod)/i', $ua)) $os = 'iOS';
        elseif (preg_match('/Macintosh|Mac OS X/i', $ua)) $os = 'macOS';
        elseif (preg_match('/Linux/i', $ua)) $os = 'Linux';

        // Parse Browser
        $browser = 'Other';
        if (preg_match('/Edg/i', $ua)) $browser = 'Edge';
        elseif (preg_match('/OPR|Opera/i', $ua)) $browser = 'Opera';
        elseif (preg_match('/Chrome|CriOS/i', $ua)) $browser = 'Chrome';
        elseif (preg_match('/Firefox|FxiOS/i', $ua)) $browser = 'Firefox';
        elseif (preg_match('/Safari/i', $ua)) $browser = 'Safari';

        // Parse Referer Source
        $refererSource = 'Direct';
        if (!empty($referer)) {
            if (preg_match('/facebook\.com|fb\.com|l\.facebook\.com/i', $referer)) {
                $refererSource = 'Facebook';
            } elseif (preg_match('/google\./i', $referer)) {
                $refererSource = 'Google';
            } elseif (preg_match('/t\.co|twitter\.com|x\.com/i', $referer)) {
                $refererSource = 'Twitter/X';
            } elseif (preg_match('/whatsapp/i', $referer)) {
                $refererSource = 'WhatsApp';
            } elseif (preg_match('/youtube\.com/i', $referer)) {
                $refererSource = 'YouTube';
            } elseif (parse_url($referer, PHP_URL_HOST) !== parse_url($url, PHP_URL_HOST)) {
                $refererSource = 'External Link';
            }
        }

        // Extract post_id if viewing single news article
        $postId = null;
        $pageTitle = null;
        if ($request->routeIs('post')) {
            $slug = $request->route('slug');
            $post = \App\Models\Post::where('slug', $slug)->first();
            if ($post) {
                $postId = $post->id;
                $pageTitle = $post->title;
            }
        } elseif ($request->is('/')) {
            $pageTitle = 'হোমপেজ | দৈনিক ভোলা জার্নাল';
        }

        VisitorLog::create([
            'ip_address'     => $ip,
            'session_id'     => $sessionId,
            'device'         => $device,
            'browser'        => $browser,
            'os'             => $os,
            'url'            => $url,
            'page_title'     => $pageTitle,
            'post_id'        => $postId,
            'referer'        => $referer ?: null,
            'referer_source' => $refererSource,
        ]);
    }
}
