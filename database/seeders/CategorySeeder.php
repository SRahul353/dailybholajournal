<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Uncategorized', 'slug' => 'uncategorized', 'description' => null],
            ['id' => 2, 'name' => 'জাতীয়', 'slug' => 'national', 'description' => 'জাতীয় সংবাদ ও খবরাখবর'],
            ['id' => 3, 'name' => 'ভোলা সদর', 'slug' => 'bhola-sadar', 'description' => 'ভোলা সদর উপজেলার সংবাদ'],
            ['id' => 4, 'name' => 'আন্তর্জাতিক', 'slug' => 'international', 'description' => 'আন্তর্জাতিক সংবাদ ও বিশ্ব পরিস্থিতি'],
            ['id' => 5, 'name' => 'অপরাধ', 'slug' => 'crime', 'description' => 'আইন শৃঙ্খলা ও অপরাধ সংবাদ'],
            ['id' => 6, 'name' => 'রাজনীতি', 'slug' => 'politics', 'description' => 'রাজনৈতিক খবর ও বিশ্লেষণ'],
            ['id' => 7, 'name' => 'সর্বশেষ', 'slug' => 'latest', 'description' => 'সর্বশেষ ব্রেকিং নিউজ'],
            ['id' => 8, 'name' => 'ভোলা জেলা', 'slug' => 'bhola-district', 'description' => 'ভোলা জেলা সম্পর্কিত সকল সংবাদ'],
            ['id' => 9, 'name' => 'অর্থনীতি', 'slug' => 'economy', 'description' => 'অর্থনীতি, ব্যবসা-বাণিজ্য ও বাজারদর'],
            ['id' => 10, 'name' => 'খেলা', 'slug' => 'sports', 'description' => 'দেশ-বিদেশের খেলাধুলার সংবাদ'],
            ['id' => 11, 'name' => 'বিনোদন', 'slug' => 'entertainment', 'description' => 'বিনোদন ও শোবিজ জগতের খবর'],
            ['id' => 12, 'name' => 'লাইফ স্টাইল', 'slug' => 'lifestyle', 'description' => 'জীবনধারা ও স্বাস্থ্য সচেতনতা'],
            ['id' => 13, 'name' => 'ইসলাম ও জীবন', 'slug' => 'islam-and-life', 'description' => 'ধর্ম ও জীবনধারা'],
            ['id' => 14, 'name' => 'আইটি বিশ্ব', 'slug' => 'tech-world', 'description' => 'তথ্যপ্রযুক্তি ও বিজ্ঞান'],
            ['id' => 15, 'name' => 'সম্পাদকীয়', 'slug' => 'editorial', 'description' => 'সম্পাদকীয় ও মতামত'],
            ['id' => 16, 'name' => 'দৌলতখান', 'slug' => 'daulatkhan', 'description' => 'দৌলতখান উপজেলার সংবাদ'],
            ['id' => 17, 'name' => 'মনপুরা', 'slug' => 'monpura', 'description' => 'মনপুরা দ্বীপ উপজেলার সংবাদ'],
            ['id' => 18, 'name' => 'চরফ্যাশন', 'slug' => 'charfasson', 'description' => 'চরফ্যাশন উপজেলার সংবাদ'],
            ['id' => 19, 'name' => 'তজুমদ্দিন', 'slug' => 'tazumuddin', 'description' => 'তজুমদ্দিন উপজেলার সংবাদ'],
            ['id' => 20, 'name' => 'বোরহানউদ্দিন', 'slug' => 'borhanuddin', 'description' => 'বোরহানউদ্দিন উপজেলার সংবাদ'],
            ['id' => 21, 'name' => 'লালমোহন', 'slug' => 'lalmohan', 'description' => 'লালমোহন উপজেলার সংবাদ'],
            ['id' => 22, 'name' => 'রকমারি', 'slug' => 'variety', 'description' => 'বিচিত্র খবর ও ফিচার'],
            ['id' => 23, 'name' => 'চিকিৎসা', 'slug' => 'health', 'description' => 'চিকিৎসা ও স্বাস্থ্যসেবা'],
            ['id' => 24, 'name' => 'কৃষি', 'slug' => 'agriculture', 'description' => 'কৃষি ও কৃষকের খবর'],
            ['id' => 25, 'name' => 'শিক্ষা', 'slug' => 'education', 'description' => 'শিক্ষা ও ক্যাম্পাস সংবাদ'],
            ['id' => 26, 'name' => 'মৎস্য', 'slug' => 'fisheries', 'description' => 'ইলিশ ও উপকূলীয় মৎস্য সম্পদ']
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['id' => $cat['id']],
                [
                    'name' => $cat['name'],
                    'slug' => $cat['slug'],
                    'description' => $cat['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
