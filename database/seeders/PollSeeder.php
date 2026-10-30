<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poll;

class PollSeeder extends Seeder
{
    public function run(): void
    {
        if (Poll::count() === 0) {
            Poll::create([
                'question' => 'ভোলা-বরিশাল সেতু নির্মাণ প্রকল্প দ্রুত বাস্তবায়ন হলে দক্ষিণাঞ্চলের অর্থনীতিতে বৈপ্লবিক পরিবর্তন আসবে বলে আপনি কি মনে করেন?',
                'is_active' => true,
                'yes_votes' => 142,
                'no_votes' => 18,
                'neutral_votes' => 6,
            ]);
        }
    }
}
