<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect user ke halaman Login Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Callback dari Google OAuth setelah user berhasil login.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Jika user sudah ada, hanya update token dan set email verified (jangan timpa name/password)
                $user->update([
                    'google_oauth_token' => $googleUser->token,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            } else {
                // Jika user belum ada, buat baru
                $user = User::create([
                    'email' => $googleUser->getEmail(),
                    'name' => $googleUser->getName(),
                    'google_oauth_token' => $googleUser->token,
                    'email_verified_at' => now(),
                ]);
            }

            Auth::login($user);
            session()->regenerate();

            // Setelah login Google, mendarat di landing page dulu (role-aware)
            return redirect()->intended('/');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal melakukan login dengan Google: ' . $e->getMessage()
            ]);
        }
    }
}
