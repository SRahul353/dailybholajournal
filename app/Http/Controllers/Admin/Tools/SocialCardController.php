<?php

namespace App\Http\Controllers\Admin\Tools;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SocialCardController extends Controller
{
    /**
     * Redirect to the Social Card Generator of the latest post.
     */
    public function index()
    {
        Gate::authorize('admin-or-super');

        $post = Post::latest()->first();
        if (!$post) {
            return redirect()->route('admin.dashboard')->with('error', 'কোনো সংবাদ পোস্ট পাওয়া যায়নি।');
        }
        return redirect()->route('admin.tools.social-card.show', $post->id);
    }

    /**
     * Show the Social Card Generator studio for a specific post.
     */
    public function show($id)
    {
        Gate::authorize('admin-or-super');

        $post = Post::with('categories')->findOrFail($id);
        
        $themeSettingsPath = storage_path('app/theme_settings.json');
        $themeSettings = [
            'logo_image' => '',
            'logo_text' => 'দৈনিক ভোলা<span>জার্নাল</span>'
        ];
        if (file_exists($themeSettingsPath)) {
            $themeSettings = array_merge($themeSettings, json_decode(file_get_contents($themeSettingsPath), true) ?: []);
        }
        $recentPosts = Post::latest()->take(20)->get();

        $cardSettingsPath = storage_path('app/social_card_settings.json');
        $cardSettings = [
            'card_style' => 'classic',
            'theme_key' => 'royal',
            'custom_bg_color' => '#1e3a8a',
            'date_color' => '#38bdf8',
            'border_color' => '#38bdf8',
            'font_family' => "'Noto Sans Bengali', sans-serif",
            'font_size' => 52,
            'line_height' => 1.3,
            'headline_align' => 'center',
            'corner_logo_visible' => true,
            'corner_logo_position' => 'right',
            'corner_logo_size' => 135,
            'corner_logo_shadow' => true,
            'corner_logo_3d_border' => false,
            'corner_logo_image' => '',
            'watermark_visible' => true,
            'watermark_opacity' => 12,
            'watermark_image' => '',
            'footer_mode' => 'ad',
            'ad_image' => '',
            'category_badge_visible' => true,
            'category_badge_color' => '#dc2626',
            'reporter_badge_bottom' => 25,
            'details_hint_visible' => true,
            'details_hint_text' => 'বিস্তারিত কমেন্টে......',
            'brand_title' => 'দৈনিক ভোলা জার্নাল',
            'brand_tagline' => 'সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর',
            'brand_web' => 'dailybholajournal.com',
            'brand_social' => '/dailybholajournalBN',
            'quote_cutout_mode' => true,
            'quote_img_scale' => 100,
            'quote_img_y' => 0,
            'quote_img_x' => 0,
            'quote_col_width' => 350,
        ];
        if (file_exists($cardSettingsPath)) {
            $saved = json_decode(file_get_contents($cardSettingsPath), true);
            if (is_array($saved)) {
                $cardSettings = array_merge($cardSettings, $saved);
            }
        }

        // Default per-style settings (separate logo and object visibility for each style)
        $defaultStyleSettings = [
            'classic' => [
                'logo_visible' => true,
                'logo_image' => '',
                'logo_position' => 'right',
                'logo_size' => 135,
                'watermark_visible' => true,
                'badge_visible' => true,
                'date_visible' => true,
                'hint_visible' => true,
                'footer_visible' => true,
            ],
            'poster' => [
                'logo_visible' => false,
                'logo_image' => '',
                'logo_position' => 'right',
                'logo_size' => 135,
                'watermark_visible' => false,
                'badge_visible' => false,
                'date_visible' => true,
                'hint_visible' => false,
                'footer_visible' => false,
            ],
            'quote' => [
                'logo_visible' => true,
                'logo_image' => '',
                'logo_position' => 'right',
                'logo_size' => 135,
                'watermark_visible' => true,
                'badge_visible' => false,
                'date_visible' => true,
                'hint_visible' => true,
                'footer_visible' => false,
                'quote_symbol_visible' => true,
                'speaker_visible' => true,
            ],
            'breaking' => [
                'logo_visible' => true,
                'logo_image' => '',
                'logo_position' => 'right',
                'logo_size' => 135,
                'watermark_visible' => true,
                'badge_visible' => false,
                'date_visible' => true,
                'hint_visible' => true,
                'footer_visible' => false,
                'excerpt_visible' => true,
            ]
        ];

        if (!isset($cardSettings['style_settings']) || !is_array($cardSettings['style_settings'])) {
            $cardSettings['style_settings'] = $defaultStyleSettings;
        } else {
            foreach ($defaultStyleSettings as $k => $def) {
                if (!isset($cardSettings['style_settings'][$k]) || !is_array($cardSettings['style_settings'][$k])) {
                    $cardSettings['style_settings'][$k] = $def;
                } else {
                    $cardSettings['style_settings'][$k] = array_merge($def, $cardSettings['style_settings'][$k]);
                }
            }
        }

        // Sanitize numeric and boolean values to prevent JS template parse errors
        $cardSettings['quote_img_y'] = is_numeric($cardSettings['quote_img_y'] ?? null) ? (int)$cardSettings['quote_img_y'] : 0;
        $cardSettings['quote_img_x'] = is_numeric($cardSettings['quote_img_x'] ?? null) ? (int)$cardSettings['quote_img_x'] : 0;
        $cardSettings['quote_img_scale'] = is_numeric($cardSettings['quote_img_scale'] ?? null) ? (float)$cardSettings['quote_img_scale'] : 100;
        $cardSettings['quote_cutout_mode'] = !empty($cardSettings['quote_cutout_mode']);

        return view('admin.tools.social_card.index', compact('post', 'themeSettings', 'recentPosts', 'cardSettings'));
    }

    /**
     * Persist Social Card Settings permanently.
     */
    public function saveSettings(Request $request)
    {
        Gate::authorize('admin-or-super');

        $cardSettingsPath = storage_path('app/social_card_settings.json');
        $currentSettings = [
            'card_style' => 'classic',
            'theme_key' => 'royal',
            'custom_bg_color' => '#1e3a8a',
            'date_color' => '#38bdf8',
            'border_color' => '#38bdf8',
            'font_family' => "'Noto Sans Bengali', sans-serif",
            'font_size' => 52,
            'line_height' => 1.3,
            'headline_align' => 'center',
            'corner_logo_visible' => true,
            'corner_logo_position' => 'right',
            'corner_logo_size' => 135,
            'corner_logo_shadow' => true,
            'corner_logo_3d_border' => false,
            'corner_logo_image' => '',
            'watermark_visible' => true,
            'watermark_opacity' => 12,
            'watermark_image' => '',
            'footer_mode' => 'ad',
            'ad_image' => '',
            'category_badge_visible' => true,
            'category_badge_color' => '#dc2626',
            'reporter_badge_bottom' => 25,
            'details_hint_visible' => true,
            'details_hint_text' => 'বিস্তারিত কমেন্টে......',
            'brand_title' => 'দৈনিক ভোলা জার্নাল',
            'brand_tagline' => 'সত্য ও ন্যায়ের নির্ভীক কণ্ঠস্বর',
            'brand_web' => 'dailybholajournal.com',
            'brand_social' => '/dailybholajournalBN',
            'quote_cutout_mode' => true,
            'quote_img_scale' => 100,
            'quote_img_y' => 0,
            'quote_img_x' => 0,
            'quote_col_width' => 350,
        ];

        if (file_exists($cardSettingsPath)) {
            $saved = json_decode(file_get_contents($cardSettingsPath), true);
            if (is_array($saved)) {
                $currentSettings = array_merge($currentSettings, $saved);
            }
        }

        $uploadDir = public_path('uploads/social_card');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if ($request->hasFile('corner_logo_file')) {
            $file = $request->file('corner_logo_file');
            $filename = 'corner_logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $currentSettings['corner_logo_image'] = 'uploads/social_card/' . $filename;
        } elseif ($request->boolean('reset_corner_logo')) {
            $currentSettings['corner_logo_image'] = '';
        }

        if ($request->hasFile('watermark_file')) {
            $file = $request->file('watermark_file');
            $filename = 'watermark_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $currentSettings['watermark_image'] = 'uploads/social_card/' . $filename;
        } elseif ($request->boolean('reset_watermark')) {
            $currentSettings['watermark_image'] = '';
        }

        if ($request->hasFile('ad_file')) {
            $file = $request->file('ad_file');
            $filename = 'ad_banner_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $currentSettings['ad_image'] = 'uploads/social_card/' . $filename;
        } elseif ($request->filled('ad_url')) {
            $currentSettings['ad_image'] = $request->ad_url;
        } elseif ($request->boolean('reset_ad')) {
            $currentSettings['ad_image'] = '';
        }

        $fields = [
            'card_style', 'theme_key', 'custom_bg_color', 'date_color', 'border_color',
            'font_family', 'font_size', 'line_height', 'headline_align',
            'corner_logo_visible', 'corner_logo_position', 'corner_logo_size', 'corner_logo_shadow', 'corner_logo_3d_border',
            'watermark_visible', 'watermark_opacity',
            'footer_mode', 'brand_title', 'brand_tagline', 'brand_web', 'brand_social',
            'category_badge_visible', 'category_badge_color', 'reporter_badge_bottom',
            'details_hint_visible', 'details_hint_text',
            'quote_cutout_mode', 'quote_img_scale', 'quote_img_y', 'quote_img_x', 'quote_col_width'
        ];

        $booleanFields = [
            'corner_logo_visible', 'corner_logo_shadow', 'corner_logo_3d_border',
            'watermark_visible', 'category_badge_visible', 'details_hint_visible',
            'quote_cutout_mode'
        ];
        $numericFields = [
            'corner_logo_size', 'watermark_opacity', 'reporter_badge_bottom',
            'quote_img_scale', 'quote_img_y', 'quote_img_x', 'quote_col_width',
            'font_size'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $val = $request->input($field);
                if (in_array($field, $booleanFields)) {
                    $val = filter_var($val, FILTER_VALIDATE_BOOLEAN);
                } elseif (in_array($field, $numericFields)) {
                    $val = is_numeric($val) ? (float)$val : 0;
                }
                $currentSettings[$field] = $val;
            }
        }

        // Process per-style object and logo configurations
        if ($request->has('style_settings')) {
            $incoming = json_decode($request->input('style_settings'), true);
            if (is_array($incoming)) {
                if (!isset($currentSettings['style_settings']) || !is_array($currentSettings['style_settings'])) {
                    $currentSettings['style_settings'] = [];
                }
                foreach (['classic', 'poster', 'quote', 'breaking'] as $sKey) {
                    if (isset($incoming[$sKey]) && is_array($incoming[$sKey])) {
                        if (!isset($currentSettings['style_settings'][$sKey])) {
                            $currentSettings['style_settings'][$sKey] = [];
                        }
                        unset($incoming[$sKey]['logo_image_preview']);
                        $currentSettings['style_settings'][$sKey] = array_merge(
                            $currentSettings['style_settings'][$sKey],
                            $incoming[$sKey]
                        );
                    }
                }
            }
        }

        // Process style-specific logo files
        foreach (['classic', 'poster', 'quote', 'breaking'] as $sKey) {
            $fileInputName = 'style_logo_file_' . $sKey;
            if ($request->hasFile($fileInputName)) {
                $file = $request->file($fileInputName);
                $filename = 'style_logo_' . $sKey . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadDir, $filename);
                if (!isset($currentSettings['style_settings'][$sKey])) {
                    $currentSettings['style_settings'][$sKey] = [];
                }
                $currentSettings['style_settings'][$sKey]['logo_image'] = 'uploads/social_card/' . $filename;
            } elseif ($request->boolean('reset_style_logo_' . $sKey)) {
                if (isset($currentSettings['style_settings'][$sKey])) {
                    $currentSettings['style_settings'][$sKey]['logo_image'] = '';
                }
            }
        }

        file_put_contents($cardSettingsPath, json_encode($currentSettings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return response()->json([
            'success' => true,
            'message' => 'কার্ড সেটিংস সফলভাবে সংরক্ষণ করা হয়েছে!',
            'settings' => $currentSettings
        ]);
    }
}
