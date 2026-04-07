<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Services\MidtransService;
use App\Models\AkunJamaah;

class AuthController extends Controller
{
    public function login()
    {
        return view('Auth.login2');
    }

    public function Auth(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // ❌ Tolak jika jamaah login manual
            if ($user->role === 'jamaah') {
                Auth::logout();
                return back()->withErrors([
                    'loginError' => 'Jamaah harus login menggunakan Google.',
                ]);
            }

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('indexAdminUtama');
                case 'superadmin':
                    return redirect()->route('indexAdminUtama');
                case 'marketing':
                    return redirect()->route('dashMarketing');
                case 'logistik':
                    return redirect()->route('dashLogistik');
                case 'developer':
                    return redirect()->route('dashboard.dev');

                default:
                    Auth::logout();
                    return back()->withErrors([
                        'loginError' => 'Role pengguna tidak dikenali.',
                    ]);
            }
        }

        return back()->withErrors([
            'loginError' => 'Username atau password salah.',
        ])->withInput();
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $jamaah = AkunJamaah::where('email', $googleUser->email)->first();

        if (!$jamaah) {

            $jamaah = AkunJamaah::create([
                'username' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
            ]);

            // 🔥 Generate VA sekali saja
            $va = app(MidtransService::class)->createStaticVA($jamaah);

            $jamaah->update([
                'va_number' => $va
            ]);
        }

        // 🔥 Login ke guard jamaah
        Auth::guard('jamaah')->login($jamaah, true);

        // 🔥 Set guard aktif di session
        session()->put('auth_guard', 'jamaah');

        return redirect()->route('dashJamaah');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function logout_jamaah()
    {
        Auth::guard('jamaah')->logout();
        return redirect('/');
    }
}
