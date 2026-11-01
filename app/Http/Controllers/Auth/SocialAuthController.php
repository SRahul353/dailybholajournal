<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\OpinionSubmission;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Supported social providers.
     */
    protected array $supportedProviders = ['google', 'facebook'];

    /**
     * Redirect the user to the Social Provider authentication page.
     */
    public function redirect(Request $request, string $provider)
    {
        if (!in_array($provider, $this->supportedProviders)) {
            return redirect()->route('login')->with('error', 'অননুমোদিত সোশ্যাল মিডিয়া প্রোভাইডার।');
        }

        // Validate client credentials before sending user to avoid OAuth 400 invalid_request error
        $clientId = config("services.{$provider}.client_id");
        $clientSecret = config("services.{$provider}.client_secret");

        if (empty($clientId) || empty($clientSecret) || str_starts_with($clientId, 'your_')) {
            $providerTitle = $provider === 'google' ? 'গুগল (Google)' : 'ফেসবুক (Facebook)';
            $envKey = strtoupper($provider) . '_CLIENT_ID';
            return redirect()->back()->with('error', "{$providerTitle} লগইন চালু করতে .env ফাইলে {$envKey} ও সিক্রেট যোগ করুন। এর বিকল্প হিসেবে নিচে 'পাঠক হিসেবে দ্রুত সাইন-ইন' করতে পারেন।");
        }

        // Store intended destination if provided or referrer
        if ($request->has('redirect')) {
            session(['url.intended' => $request->get('redirect')]);
        } elseif (!session()->has('url.intended')) {
            $prev = url()->previous();
            if ($prev && !str_contains($prev, '/login') && !str_contains($prev, '/auth/')) {
                session(['url.intended' => $prev]);
            }
        }

        try {
            $redirectUrl = route('social.callback', ['provider' => $provider]);
            return Socialite::driver($provider)->redirectUrl($redirectUrl)->redirect();
        } catch (Exception $e) {
            return redirect()->back()->with('error', ucfirst($provider) . ' সোশ্যাল লগইন সাময়িকভাবে অনুপলব্ধ। দয়া করে ক্রেডেনশিয়াল বা রিডাইরেক্ট ইউআরএল চেক করুন।');
        }
    }

    /**
     * Obtain the user information from the Provider.
     */
    public function callback(string $provider)
    {
        if (!in_array($provider, $this->supportedProviders)) {
            return redirect()->route('login')->with('error', 'অননুমোদিত সোশ্যাল মিডিয়া প্রোভাইডার।');
        }

        $redirectUrl = route('social.callback', ['provider' => $provider]);

        try {
            // Retrieve user details from OAuth provider (stateless avoids session mismatch)
            $socialUser = Socialite::driver($provider)->redirectUrl($redirectUrl)->stateless()->user();
        } catch (Exception $e) {
            try {
                $socialUser = Socialite::driver($provider)->redirectUrl($redirectUrl)->user();
            } catch (Exception $e2) {
                return redirect()->route('login')->with('error', ucfirst($provider) . ' লগইন ব্যর্থ হয়েছে বা বাতিল করা হয়েছে। আবার চেষ্টা করুন।');
            }
        }

        if (!$socialUser || (!$socialUser->getEmail() && !$socialUser->getId())) {
            return redirect()->route('login')->with('error', 'সোশ্যাল অ্যাকাউন্ট থেকে প্রয়োজনীয় তথ্য পাওয়া যায়নি।');
        }

        $socialIdField = $provider . '_id';
        $email = $socialUser->getEmail();
        $socialId = $socialUser->getId();

        // 1. Try finding user by provider ID
        $user = User::where($socialIdField, $socialId)->first();

        // 2. If not found, try finding by email
        if (!$user && $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                // Link social ID and avatar to existing user
                $user->update([
                    $socialIdField => $socialId,
                    'avatar' => $user->avatar ?: $socialUser->getAvatar(),
                ]);
            }
        }

        // 3. If still no user, register new user as Reader
        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName() ?: ($socialUser->getNickname() ?: 'সম্মানিত পাঠক'),
                'email' => $email ?: ($provider . '_' . $socialId . '@dailybholajournal.com'),
                $socialIdField => $socialId,
                'avatar' => $socialUser->getAvatar(),
                'role' => 'reader', // Registered as Reader as specified
                'password' => null,
                'email_verified_at' => now(),
            ]);
        }

        // Authenticate the user with remember option
        Auth::login($user, true);

        // Process any pending submission or redirect
        return self::handlePostLoginRedirect($user);
    }

    /**
     * Quick reader sign-in using Name & Email.
     * Allows seamless submission and login without requiring external OAuth setup.
     */
    public function quickReaderLogin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
        ], [
            'name.required' => 'আপনার নাম প্রদান করুন।',
            'email.required' => 'একটি সঠিক ইমেইল ঠিকানা দিন।',
        ]);

        $email = strtolower(trim($request->input('email')));
        $name = trim($request->input('name'));

        $user = User::where('email', $email)->first();
        if ($user) {
            // Security Check: If user is admin/staff or has a password set, require password authentication!
            if ($user->role !== 'reader' || !empty($user->password)) {
                return redirect()->route('login')->with('error', 'এই ইমেইলটি পাসওয়ার্ড সুরক্ষিত। অনুগ্রহ করে পাসওয়ার্ড দিয়ে প্রবেশ করুন।')->withInput(['email' => $email]);
            }
        } else {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'role' => 'reader',
                'password' => null,
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, true);

        return self::handlePostLoginRedirect($user);
    }

    /**
     * Save submission draft before social redirect.
     */
    public function saveSubmissionDraft(Request $request)
    {
        $type = $request->input('type');
        $data = $request->except(['_token', 'type']);

        if ($type === 'contact') {
            session(['pending_contact_submission' => $data]);
        } elseif ($type === 'opinion') {
            session(['pending_opinion_submission' => $data]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Unified handler for post-login redirection.
     * Automatically commits any pending contact or opinion submissions.
     */
    public static function handlePostLoginRedirect($user)
    {
        // 1. Process pending Contact Message
        if (session()->has('pending_contact_submission')) {
            $contactData = session()->pull('pending_contact_submission');
            if (empty($contactData['name'])) {
                $contactData['name'] = $user->name;
            }
            if (empty($contactData['email'])) {
                $contactData['email'] = $user->email;
            }
            $contactData['ip_address'] = request()->ip();
            $contactData['is_read'] = false;

            ContactMessage::create([
                'name' => $contactData['name'],
                'phone' => $contactData['phone'] ?? 'N/A',
                'email' => $contactData['email'],
                'subject' => $contactData['subject'] ?? 'সাধারণ অনুসন্ধান',
                'message' => $contactData['message'] ?? '',
                'ip_address' => $contactData['ip_address'],
                'is_read' => false,
            ]);

            return redirect()->route('contact')->with('success', 'স্বাগতম ' . $user->name . '! আপনার লগইন সফল হয়েছে এবং বার্তাটি সফলভাবে পাঠানো হয়েছে।');
        }

        // 2. Process pending Opinion Submission
        if (session()->has('pending_opinion_submission')) {
            $opinionData = session()->pull('pending_opinion_submission');
            if (empty($opinionData['author_name'])) {
                $opinionData['author_name'] = $user->name;
            }
            if (empty($opinionData['author_email'])) {
                $opinionData['author_email'] = $user->email;
            }

            $submission = OpinionSubmission::create([
                'author_name' => $opinionData['author_name'],
                'author_email' => $opinionData['author_email'],
                'author_phone' => $opinionData['author_phone'] ?? 'N/A',
                'author_designation' => $opinionData['author_designation'] ?? 'কলামিস্ট',
                'author_bio' => $opinionData['author_bio'] ?? null,
                'author_photo' => $opinionData['author_photo'] ?? null,
                'title' => $opinionData['title'] ?? 'মতামত',
                'topic' => $opinionData['topic'] ?? 'সমসাময়িক বিষয়',
                'content' => $opinionData['content'] ?? '',
                'featured_image' => $opinionData['featured_image'] ?? null,
                'status' => 'pending',
            ]);

            return redirect()->route('opinion.submit')->with('submission_success', [
                'tracking_id' => $submission->id,
                'author_name' => $submission->author_name,
                'title' => $submission->title,
            ]);
        }

        // 3. Fallback to intended URL (ensure readers are never trapped into admin routes)
        $intended = session()->pull('url.intended');
        if ($intended) {
            if ($user->role === 'reader' && str_contains($intended, '/admin')) {
                return redirect()->route('home')->with('success', 'স্বাগতম, ' . $user->name . '! দৈনিক ভোলা জার্নালে আপনাকে স্বাগতম।');
            }
            return redirect($intended)->with('success', 'স্বাগতম, ' . $user->name . '! সফলভাবে লগইন হয়েছে।');
        }

        // 4. Default based on role
        if (in_array($user->role, ['admin', 'super_admin', 'editor'])) {
            return redirect()->route('admin.dashboard')->with('success', 'স্বাগতম, ' . $user->name . '!');
        }

        return redirect()->route('home')->with('success', 'স্বাগতম, ' . $user->name . '! দৈনিক ভোলা জার্নালে আপনাকে স্বাগতম।');
    }
}
