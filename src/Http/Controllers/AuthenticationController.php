<?php

namespace x96\SocialitePassport\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;

class AuthenticationController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::with('laravelpassport')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('laravelpassport')->user();

        $controller = LoginController::class;
        $method = 'loginWithPassport';

        return LoginController::loginWithPassport($user);
    }
}
