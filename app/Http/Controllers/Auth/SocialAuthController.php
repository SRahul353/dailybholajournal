<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
            return Socialite::driver($provider)->redirect();
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', ucfirst($provider) . ' সোশ্যাল লগইন সাময়িকভাবে অনুপলব্ধ। দয়া করে ক্রেডেনশিয়াল বা সেটিংস চেক করুন।');
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

        try {
            // Retrieve user details from OAuth provider (stateless avoids session mismatch)
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (Exception $e) {
            try {
                $socialUser = Socialite::driver($provider)->user();
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

        // Determine destination redirect
        $intended = session()->pull('url.intended');
        if ($intended) {
            return redirect($intended)->with('success', 'স্বাগতম, ' . $user->name . '! সফলভাবে লগইন হয়েছে।');
        }

        if (in_array($user->role, ['admin', 'super_admin', 'editor'])) {
            return redirect()->route('admin.dashboard')->with('success', 'স্বাগতম, ' . $user->name . '!');
        }

        return redirect()->route('home')->with('success', 'স্বাগতম, ' . $user->name . '! দৈনিক ভোলা জার্নালে আপনাকে স্বাগতম।');
    }
}
