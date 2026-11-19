# 🎨 Social Media Card Studio Tool (দৈনিক ভোলা জার্নাল)

এই ফোল্ডারে দৈনিক ভোলা জার্নালের **সোশ্যাল মিডিয়া ফটো কার্ড ও পোস্টার জেনারেটর** টুলের স্থাপত্য ও রেফারেন্স নথিভুক্ত রয়েছে।

---

## 📁 আর্কিটেকচার ম্যাপিং ও ফাইল লোকেশন (Module Architecture):

1. **কন্ট্রোলার (Controller):**
   - `app/Http/Controllers/Admin/Tools/SocialCardController.php`
   - রোল: সোশ্যাল কার্ড জেনারেটর পেজ রেন্ডার, সেটিংস JSON সেভ এবং কর্নার লোগো/ওয়াটারমার্ক আপলোড প্রসেসিং।

2. **ভিউ ইন্টারফেস (View Layer):**
   - `resources/views/admin/tools/social_card/index.blade.php`
   - রোল: HTML5 Canvas চালিত সম্পূর্ণ 1080×1080 ফটো কার্ড ও কোট পোস্টার স্টুডিও ইঞ্জিন।

3. **রাউটসমূহ (Routes):**
   - `GET /admin/tools/social-card` (`admin.tools.social-card`) — সর্বশেষ সংবাদের কার্ড জেনারেটরে প্রবেশ।
   - `GET /admin/tools/social-card/{id}` (`admin.tools.social-card.show`) — নির্দিষ্ট সংবাদের কার্ড এডিটর।
   - `POST /admin/tools/social-card/settings` (`admin.tools.social-card.settings`) — ওয়াটারমার্ক, লোগো ও থিম কনফিগারেশন সেভার।
   - *ব্যাকওয়ার্ডস-কমপ্যাটিবল অ্যালায়াস:* `/admin/posts/{id}/social-card`, `/admin/social-card`

4. **কনফিগারেশন ও মিডিয়া (Storage & Media):**
   - `storage/app/social_card_settings.json` — থিম কালার, লোগো পজিশন ও অপাসিটি সেটিংস।
   - `public/uploads/social_card/` — স্টুডিওর ওয়াটারমার্ক ও কর্নার লোগো স্টোরেজ।
