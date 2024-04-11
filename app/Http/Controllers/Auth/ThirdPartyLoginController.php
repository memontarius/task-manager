<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialNetwork;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ThirdPartyLoginController extends Controller
{
    public function redirect(string $provider): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider): \Illuminate\Http\RedirectResponse
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::firstOrCreate(
            ['email' => $socialUser->email],
            ['name' => $socialUser->getName()]
        );

        SocialNetwork::updateOrCreate(
            [
                'social_id' => $socialUser->getId(),
                'provider' => $provider
            ],
            [
                'user_id' => $user->id,
                'token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken,
            ]);

        Auth::login($user);

        return to_route('tasks.index');
    }
}
