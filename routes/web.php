<?php

use App\Http\Controllers\NewspaperController;
use Illuminate\Support\Facades\Route;

// Public Front-end Routes
Route::get('/', [NewspaperController::class, 'index'])->name('home');
Route::get('/epaper', [NewspaperController::class, 'epaper'])->name('epaper');
Route::get('/post/{slug}', [NewspaperController::class, 'show'])->name('post');
Route::get('/category/{slug}', [NewspaperController::class, 'category'])->name('category');
Route::get('/tag/{slug}', [NewspaperController::class, 'tag'])->name('tag');
Route::get('/search', [NewspaperController::class, 'search'])->name('search');
Route::get('/privacy-policy', [NewspaperController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/about-us', [NewspaperController::class, 'aboutUs'])->name('about.us');
Route::get('/about', [NewspaperController::class, 'aboutUs'])->name('about');
Route::get('/terms-of-use', [NewspaperController::class, 'termsOfUse'])->name('terms.of.use');
Route::get('/terms', [NewspaperController::class, 'termsOfUse'])->name('terms');
Route::get('/comment-policy', [NewspaperController::class, 'commentPolicy'])->name('comment.policy');
Route::get('/editorial-policy', [NewspaperController::class, 'editorialPolicy'])->name('editorial.policy');
Route::get('/contact', [NewspaperController::class, 'contact'])->name('contact');
Route::get('/our-family', [NewspaperController::class, 'contact'])->name('our.family');

// Contact Form Submission (throttled to 6 submissions per minute per IP)
Route::post('/contact', [NewspaperController::class, 'submitContact'])->middleware('throttle:6,1')->name('contact.submit');

// Opinion & Column Submission Routes (throttled to 6 submissions per minute per IP)
Route::get('/opinion/submit', [App\Http\Controllers\OpinionController::class, 'create'])->name('opinion.submit');
Route::post('/opinion/submit', [App\Http\Controllers\OpinionController::class, 'store'])->middleware('throttle:6,1')->name('opinion.store');

// Interactive Poll Voting (throttled to 15 requests per minute per IP)
Route::post('/poll/vote', [NewspaperController::class, 'votePoll'])->middleware('throttle:15,1')->name('poll.vote');

// Newsletter Subscription (throttled to 10 requests per minute per IP)
Route::post('/newsletter/subscribe', [NewspaperController::class, 'subscribeNewsletter'])->middleware('throttle:10,1')->name('newsletter.subscribe');

// Dynamic SEO Sitemap, Robots.txt & RSS Feed
Route::get('/sitemap.xml', [App\Http\Controllers\SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/robots.txt', [App\Http\Controllers\SeoController::class, 'robots'])->name('seo.robots');
Route::get('/rss', [App\Http\Controllers\SeoController::class, 'rss'])->name('seo.rss');
Route::get('/feed', [App\Http\Controllers\SeoController::class, 'rss'])->name('seo.feed');
Route::get('/rss.xml', [App\Http\Controllers\SeoController::class, 'rss'])->name('seo.rss.xml');

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Unprotected Auth Routes
    Route::get('/login', [App\Http\Controllers\Admin\AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\AdminLoginController::class, 'login'])->middleware('throttle:5,1')->name('login.submit');

    // Protected Admin Panel Routes
    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', [App\Http\Controllers\Admin\AdminLoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Post CRUD Resource
        Route::resource('posts', App\Http\Controllers\Admin\AdminPostController::class)->except(['show']);
        Route::get('/posts/{id}/social-card', [App\Http\Controllers\Admin\AdminPostController::class, 'socialCard'])->name('posts.social-card');
        Route::get('/social-card', [App\Http\Controllers\Admin\AdminPostController::class, 'socialCardIndex'])->name('social-card');
        
        // Category CRUD Resource
        Route::resource('categories', App\Http\Controllers\Admin\AdminCategoryController::class)->only(['index', 'store', 'update', 'destroy']);

        // Tag CRUD Resource
        Route::resource('tags', App\Http\Controllers\Admin\AdminTagController::class)->except(['show', 'create', 'edit']);

        // Opinion Submissions & Approval Resource
        Route::get('/opinions', [App\Http\Controllers\Admin\AdminOpinionController::class, 'index'])->name('opinions.index');
        Route::get('/opinions/{id}', [App\Http\Controllers\Admin\AdminOpinionController::class, 'show'])->name('opinions.show');
        Route::post('/opinions/{id}/approve', [App\Http\Controllers\Admin\AdminOpinionController::class, 'approve'])->name('opinions.approve');
        Route::post('/opinions/{id}/reject', [App\Http\Controllers\Admin\AdminOpinionController::class, 'reject'])->name('opinions.reject');
        Route::delete('/opinions/{id}', [App\Http\Controllers\Admin\AdminOpinionController::class, 'destroy'])->name('opinions.destroy');

        // Contact Messages Inbox
        Route::get('/messages', [App\Http\Controllers\Admin\AdminContactMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{id}', [App\Http\Controllers\Admin\AdminContactMessageController::class, 'show'])->name('messages.show');
        Route::delete('/messages/{id}', [App\Http\Controllers\Admin\AdminContactMessageController::class, 'destroy'])->name('messages.destroy');

        // Live Poll Engine Management
        Route::get('/polls', [App\Http\Controllers\Admin\AdminPollController::class, 'index'])->name('polls.index');
        Route::post('/polls', [App\Http\Controllers\Admin\AdminPollController::class, 'store'])->name('polls.store');
        Route::post('/polls/{id}/toggle', [App\Http\Controllers\Admin\AdminPollController::class, 'toggle'])->name('polls.toggle');
        Route::post('/polls/{id}/reset', [App\Http\Controllers\Admin\AdminPollController::class, 'resetVotes'])->name('polls.reset');
        Route::delete('/polls/{id}', [App\Http\Controllers\Admin\AdminPollController::class, 'destroy'])->name('polls.destroy');

        // Newsletter Subscribers
        Route::get('/subscribers', [App\Http\Controllers\Admin\AdminSubscriberController::class, 'index'])->name('subscribers.index');
        Route::delete('/subscribers/{id}', [App\Http\Controllers\Admin\AdminSubscriberController::class, 'destroy'])->name('subscribers.destroy');

        // User CRUD Resource (Super Admin only)
        Route::resource('users', App\Http\Controllers\Admin\AdminUserController::class)->except(['show', 'create', 'edit']);

        // Theme Settings (Super Admin only)
        Route::get('/theme/settings', [App\Http\Controllers\Admin\AdminThemeSettingsController::class, 'index'])->name('theme.settings');
        Route::post('/theme/settings', [App\Http\Controllers\Admin\AdminThemeSettingsController::class, 'update'])->name('theme.settings.update');

        // E-Paper Layout Builder Routes
        Route::get('/epaper', [App\Http\Controllers\Admin\AdminEPaperController::class, 'index'])->name('epaper.index');
        Route::get('/epaper/load', [App\Http\Controllers\Admin\AdminEPaperController::class, 'loadDateData'])->name('epaper.load');
        Route::post('/epaper/save', [App\Http\Controllers\Admin\AdminEPaperController::class, 'store'])->name('epaper.save');
        Route::get('/epaper/wp-posts', [App\Http\Controllers\Admin\AdminEPaperController::class, 'proxyWPPosts'])->name('epaper.wp_posts');
        Route::get('/epaper/proxy-image', [App\Http\Controllers\Admin\AdminEPaperController::class, 'proxyImage'])->name('epaper.proxy_image');
        
        // Secure Live Deployment Helper Routes (Super Admin Only)
        Route::get('/epaper/migrate', function () {
            \Illuminate\Support\Facades\Gate::authorize('super-admin-only');
            try {
                \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
                return response()->json([
                    'success' => true,
                    'message' => 'Database migrated successfully.',
                    'output' => \Illuminate\Support\Facades\Artisan::output()
                ]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        })->name('epaper.migrate');

        Route::get('/epaper/clear-cache', function () {
            \Illuminate\Support\Facades\Gate::authorize('super-admin-only');
            try {
                \Illuminate\Support\Facades\Artisan::call('view:clear');
                \Illuminate\Support\Facades\Artisan::call('cache:clear');
                \Illuminate\Support\Facades\Artisan::call('config:clear');
                return response()->json([
                    'success' => true,
                    'message' => 'Cache, view, and config cleared successfully.'
                ]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        })->name('epaper.clear_cache');
    });
});
