<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class,
        ]);

        $admin = User::first();

        // Create standard tags
        $topTag = Tag::firstOrCreate(['name' => 'শীর্ষ খবর', 'slug' => 'top-news']);
        $leadTag = Tag::firstOrCreate(['name' => 'প্রধান খবর', 'slug' => 'lead-news']);

        // Create initial sample news posts for Daily Bhola Journal
        $postsData = [
            [
                'title' => 'দৈনিক ভোলা জার্নালের আনুষ্ঠানিক যাত্রা শুরু: সত্য ও ন্যায়ের সন্ধানে সার্বক্ষণিক',
                'slug' => 'daily-bhola-journal-launch',
                'excerpt' => 'ভোলা জেলার গণমানুষের কথা বলতে এবং সত্য ও নিরপেক্ষ সংবাদ পরিবেশনের অঙ্গীকার নিয়ে আনুষ্ঠানিকভাবে যাত্রা শুরু করেছে দৈনিক ভোলা জার্নাল।',
                'content' => '<p>ভোলা জেলার গণমানুষের কথা বলতে এবং বস্তুনিষ্ঠ ও নিরপেক্ষ সংবাদ পরিবেশনের দৃঢ় অঙ্গীকার নিয়ে আনুষ্ঠানিকভাবে যাত্রা শুরু করেছে দৈনিক ভোলা জার্নাল। আধুনিক তথ্যপ্রযুক্তির সমন্বয়ে পত্রিকাটি অনলাইন পোর্টাল ও ডিজিটাল ই-পেপার সংস্করণে একযোগে প্রকাশিত হচ্ছে।</p><p>পত্রিকার সম্পাদক ও পরিচালনা পর্ষদ জানান, প্রান্তিক মানুষের সুখ-দুঃখের গল্প তুলে ধরার পাশাপাশি জাতীয় ও আন্তর্জাতিক অঙ্গনের সব গুরুত্বপূর্ণ সংবাদ সবার আগে পাঠকদের পৌঁছে দেওয়াই আমাদের মূল লক্ষ্য।</p>',
                'featured_image' => null,
                'status' => 'publish',
                'category_id' => 7, // সর্বশেষ
                'is_top' => true,
            ],
            [
                'title' => 'ভোলার মেঘনা ও তেঁতুলিয়া নদীতে ইলিশের প্রাচুর্য, জেলেদের মুখে হাসির ঝিলিক',
                'slug' => 'bhola-fishermen-hilsha-abundance',
                'excerpt' => 'ভোলার মেঘনা ও তেঁতুলিয়া নদীতে ঝাঁকে ঝাঁকে ধরা পড়ছে রুপালি ইলিশ। ব্যস্ত সময় পার করছেন ভোলার ঘাটগুলোর মৎস্যজীবীরা।',
                'content' => '<p>ভোলার মেঘনা ও তেঁতুলিয়া নদীতে চলতি মৌসুমে প্রচুর রূপালি ইলিশ ধরা পড়ছে। ঘাটগুলোতে ক্রেতা-বিক্রেতাদের পদচারণায় মুখরিত চারপাশ। আড়তগুলোতে শুরু হয়েছে উৎসবমুখর পরিবেশ।</p><p>মৎস্য কর্মকর্তারা জানান, সরকারি নির্দেশনামূলক নিষেধাজ্ঞা সঠিকভাবে পালিত হওয়ায় এ বছর ইলিশের উৎপাদন লক্ষ্যমাত্রা ছাড়িয়ে গেছে।</p>',
                'featured_image' => null,
                'status' => 'publish',
                'category_id' => 26, // মৎস্য
                'is_top' => true,
            ],
            [
                'title' => 'ভোলা সদর ও লালমোহনে আধুনিক স্বাস্থ্যসেবা সম্প্রসারণের উদ্যোগ',
                'slug' => 'bhola-healthcare-development-project',
                'excerpt' => 'ভোলা সদর ও দক্ষিণাঞ্চলের লালমোহনে আধুনিক চিকিৎসাসেবা পৌঁছে দিতে বিশেষ প্রকল্প গ্রহণ করা হয়েছে।',
                'content' => '<p>দ্বীপজেলা ভোলার মানুষের সার্বিক স্বাস্থ্য সুরক্ষায় ভোলা সদর ও লালমোহন উপজেলা স্বাস্থ্য কমপ্লেক্সে নতুন চিকিৎসা সরঞ্জাম ও জরুরি সেবা ইউনিট চালু করার উদ্যোগ নেওয়া হয়েছে।</p>',
                'featured_image' => null,
                'status' => 'publish',
                'category_id' => 23, // চিকিৎসা
                'is_top' => true,
            ],
            [
                'title' => 'ভোলা-বরিশাল সেতু নির্মাণ নিয়ে নতুন সমীক্ষা: দ্বীপবাসীর দীর্ঘদিনের স্বপ্নপূরণের পথে',
                'slug' => 'bhola-barishal-bridge-survey-update',
                'excerpt' => 'ভোলা-বরিশাল সংযোগ সেতু নির্মাণে নতুন অগ্রগতি হয়েছে। দ্বীপ জেলাকে জাতীয় গ্রিড ও স্থলপথের সাথে যুক্ত করার জোর দাবি ভোলাবাসীর।',
                'content' => '<p>দেশের একমাত্র দ্বীপ জেলা ভোলাকে মূল ভূখণ্ডের সঙ্গে যুক্ত করতে ভোলা-বরিশাল সেতু নির্মাণের জন্য বিস্তারিত কারিগরি ও অর্থনৈতিক সমীক্ষা দ্রুত এগিয়ে চলেছে। সেতুটি নির্মিত হলে দক্ষিণ জনপদের অর্থনীতিতে নতুন দিগন্ত উন্মোচিত হবে।</p>',
                'featured_image' => null,
                'status' => 'publish',
                'category_id' => 2, // জাতীয়
                'is_top' => true,
            ],
            [
                'title' => 'ভোলার চরাঞ্চলে কৃষি বিপ্লব: আধুনিক প্রযুক্তিতে বাম্পার ফলন',
                'slug' => 'bhola-agriculture-bumper-harvest',
                'excerpt' => 'ভোলার চরফ্যাশন ও মনপুরার চরাঞ্চলে আধুনিক চাষাবাদে বিভিন্ন ফসলের রেকর্ড ফলন হয়েছে। কৃষকের মুখে এখন চওড়া হাসি।',
                'content' => '<p>ভোলার নদীবিধৌত চরাঞ্চলে পলিমাটির উর্বরতায় সবজি ও দানাদার শস্যের বাম্পার উৎপাদন হয়েছে। কৃষি বিভাগ থেকে কৃষকদের প্রয়োজনীয় প্রণোদনা ও প্রশিক্ষণ প্রদান করা হচ্ছে।</p>',
                'featured_image' => null,
                'status' => 'publish',
                'category_id' => 24, // কৃষি
                'is_top' => false,
            ]
        ];

        foreach ($postsData as $p) {
            $catId = $p['category_id'];
            $isTop = $p['is_top'];
            unset($p['category_id'], $p['is_top']);

            $p['user_id'] = $admin ? $admin->id : 1;
            $p['created_at'] = now();
            $p['updated_at'] = now();

            $postId = DB::table('posts')->insertGetId($p);

            DB::table('category_post')->insert([
                'post_id' => $postId,
                'category_id' => $catId
            ]);

            if ($isTop) {
                DB::table('post_tag')->insert([
                    'post_id' => $postId,
                    'tag_id' => $topTag->id
                ]);
            }
        }
    }
}
