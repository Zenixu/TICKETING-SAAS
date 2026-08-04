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

            // Cari user berdasarkan email, jika belum ada buat user baru otomatis
            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'google_oauth_token' => $googleUser->token,
                // Email dari Google sudah terverifikasi otomatis
                'email_verified_at' => now(),
            ]);

            Auth::login($user);
            session()->regenerate();

            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal melakukan login dengan Google: ' . $e->getMessage()
            ]);
        }
    }
}
