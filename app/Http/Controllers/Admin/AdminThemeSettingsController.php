<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminThemeSettingsController extends Controller
{
    /**
     * Display the theme settings editing form.
     */
    public function index()
    {
        Gate::authorize('super-admin-only');

        $themeSettingsPath = storage_path('app/theme_settings.json');
        $settings = [
            'logo_text' => 'দৈনিক ভোলা<span>জার্নাল</span>',
            'logo_image' => '',
            'footer_logo_image' => '',
            'primary_color' => '#1a1a2e',
            'accent_color' => '#0d6efd',
            'bg_site' => '#f3f4f6',
            'text_main' => '#1e1e2f',
            'font_family' => "'Noto Sans Bengali', 'Outfit', sans-serif",
            'custom_css' => '',
            'menu_structure' => [],
            'homepage_categories' => [],
            'footer_text' => 'দৈনিক ভোলা জার্নাল জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র ও ডিজিটাল ই-পেপার। আমরা অত্যন্ত সততা, নিষ্ঠা ও নিরপেক্ষতার সাথে সব ধরণের স্থানীয় ও জাতীয় সংবাদ প্রকাশ করি।',
            'social_facebook' => '#',
            'social_twitter' => '#',
            'social_youtube' => '#',
            'social_instagram' => '#',
            'contact_address' => 'বার্তা ও বাণিজ্যিক কার্যালয়- ভোলা সদর, ভোলা।',
            'contact_phone' => '০১৭১১৪৬৯৫৩৯',
            'contact_email' => 'news.dailybholajournal@gmail.com',
            'editorial_board_president' => '',
            'editorial_publisher' => 'দৈনিক ভোলা জার্নাল প্রকাশনা পর্ষদ',
            'editorial_editor' => 'সম্পাদক',
            'copyright_text' => 'দৈনিক ভোলা জার্নাল। সর্বস্বত্ব সংরক্ষিত।'
        ];

        if (file_exists($themeSettingsPath)) {
            $settings = array_merge($settings, json_decode(file_get_contents($themeSettingsPath), true));
        }

        $categories = \App\Models\Category::withCount(['posts' => function($q) {
            $q->where('status', 'publish');
        }])->orderBy('name')->get();

        return view('admin.theme.settings', compact('settings', 'categories'));
    }

    /**
     * Save the theme settings in a JSON config file.
     */
    public function update(Request $request)
    {
        Gate::authorize('super-admin-only');

        $request->validate([
            'logo_text' => 'required|string',
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'footer_logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'primary_color' => 'required|string|size:7',
            'accent_color' => 'required|string|size:7',
            'bg_site' => 'required|string|size:7',
            'text_main' => 'required|string|size:7',
            'font_family' => 'required|string',
            'custom_css' => 'nullable|string',
            'menu_structure' => 'nullable|string',
            'homepage_categories' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'social_facebook' => 'nullable|string',
            'social_twitter' => 'nullable|string',
            'social_youtube' => 'nullable|string',
            'social_instagram' => 'nullable|string',
            'contact_address' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'contact_email' => 'nullable|string',
            'editorial_board_president' => 'nullable|string',
            'editorial_publisher' => 'nullable|string',
            'editorial_editor' => 'nullable|string',
            'copyright_text' => 'nullable|string',
        ]);

        $themeSettingsPath = storage_path('app/theme_settings.json');
        $settings = [
            'logo_text' => 'ভোলা<span>টাইমস২৪</span>',
            'logo_image' => '',
            'footer_logo_image' => '',
            'primary_color' => '#0a1128',
            'accent_color' => '#e31c25',
            'bg_site' => '#f3f4f6',
            'text_main' => '#2b2d42',
            'font_family' => "'Hind Siliguri', 'Outfit', sans-serif",
            'custom_css' => '',
            'menu_structure' => [],
            'homepage_categories' => [],
            'footer_text' => 'দৈনিক ভোলা জার্নাল জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র ও ডিজিটাল ই-পেপার। আমরা অত্যন্ত সততা, নিষ্ঠা ও নিরপেক্ষতার সাথে সব ধরণের স্থানীয় ও জাতীয় সংবাদ প্রকাশ করি।',
            'social_facebook' => '#',
            'social_twitter' => '#',
            'social_youtube' => '#',
            'social_instagram' => '#',
            'contact_address' => 'বার্তা ও বাণিজ্যিক কার্যালয়- ভোলা সদর, ভোলা।',
            'contact_phone' => '০১৭১১৪৬৯৫৩৯',
            'contact_email' => 'news.dailybholajournal@gmail.com',
            'editorial_board_president' => '',
            'editorial_publisher' => 'দৈনিক ভোলা জার্নাল প্রকাশনা পর্ষদ',
            'editorial_editor' => 'সম্পাদক',
            'copyright_text' => 'দৈনিক ভোলা জার্নাল। সর্বস্বত্ব সংরক্ষিত।'
        ];

        if (file_exists($themeSettingsPath)) {
            $settings = array_merge($settings, json_decode(file_get_contents($themeSettingsPath), true));
        }

        // Update settings
        $settings['logo_text'] = $request->logo_text;
        $settings['primary_color'] = $request->primary_color;
        $settings['accent_color'] = $request->accent_color;
        $settings['bg_site'] = $request->bg_site;
        $settings['text_main'] = $request->text_main;
        $settings['font_family'] = $request->font_family;
        $settings['custom_css'] = $request->custom_css;
        $settings['menu_structure'] = $request->filled('menu_structure') ? (json_decode($request->menu_structure, true) ?: []) : [];
        $settings['homepage_categories'] = $request->filled('homepage_categories') ? (json_decode($request->homepage_categories, true) ?: []) : [];
        $settings['footer_text'] = $request->footer_text ?? '';
        $settings['social_facebook'] = $request->social_facebook ?? '';
        $settings['social_twitter'] = $request->social_twitter ?? '';
        $settings['social_youtube'] = $request->social_youtube ?? '';
        $settings['social_instagram'] = $request->social_instagram ?? '';
        $settings['contact_address'] = $request->contact_address ?? '';
        $settings['contact_phone'] = $request->contact_phone ?? '';
        $settings['contact_email'] = $request->contact_email ?? '';
        $settings['editorial_board_president'] = $request->editorial_board_president ?? '';
        $settings['editorial_publisher'] = $request->editorial_publisher ?? '';
        $settings['editorial_editor'] = $request->editorial_editor ?? '';
        $settings['copyright_text'] = $request->copyright_text ?? '';

        // Handle logo file upload
        if ($request->hasFile('logo_image')) {
            $file = $request->file('logo_image');
            $fileName = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Create uploads directory if not exists
            if (!file_exists(public_path('uploads'))) {
                mkdir(public_path('uploads'), 0755, true);
            }

            $file->move(public_path('uploads'), $fileName);
            
            // Delete old logo if exists
            if (!empty($settings['logo_image']) && file_exists(public_path($settings['logo_image']))) {
                @unlink(public_path($settings['logo_image']));
            }

            $settings['logo_image'] = 'uploads/' . $fileName;
        }

        // Handle footer logo file upload
        if ($request->hasFile('footer_logo_image')) {
            $file = $request->file('footer_logo_image');
            $fileName = 'footer_logo_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Create uploads directory if not exists
            if (!file_exists(public_path('uploads'))) {
                mkdir(public_path('uploads'), 0755, true);
            }

            $file->move(public_path('uploads'), $fileName);
            
            // Delete old logo if exists
            if (!empty($settings['footer_logo_image']) && file_exists(public_path($settings['footer_logo_image']))) {
                @unlink(public_path($settings['footer_logo_image']));
            }

            $settings['footer_logo_image'] = 'uploads/' . $fileName;
        }

        // Save back to JSON config file
        file_put_contents($themeSettingsPath, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Clear view cache so changes immediately take effect
        try {
            \Illuminate\Support\Facades\Artisan::call('view:clear');
        } catch (\Exception $e) {
            // Ignore if artisan cache clear fails in local env
        }

        return redirect()->route('admin.theme.settings')->with('success', 'থিম ডিজাইন সেটিংস সফলভাবে আপডেট করা হয়েছে।');
    }
}
