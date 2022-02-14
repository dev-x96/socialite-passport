<?php

namespace x96\SocialitePassport\Http\Controllers;

use x96\SocialitePassport\Http\Controllers\Controller;
use x96\SocialitePassport\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    static function loginWithPassport($user) // gets authenticated $user injected
    {
        $hasPermissions = false;
        $token = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $user->token)[1]))));

        $user_ = User::firstOrCreate(['name' => $user['name'], 'email' => $user['email']]);
        $user_->api_token = $token->jti;
        $user_->password = Str::random(10);
        if (array_key_exists('permissions', $user->user)) {
            $user_->permissions = $user->user['permissions'];
        }

        $user_->save();

        if (isset($user_->permissions['roles'])) {
            if (count($user_->permissions['roles']) !== 0)
            {
                $hasPermissions = true;
            }
        }

        if (isset($user_->permissions['actions'])) {
            if (count($user_->permissions['actions']) !== 0)
            {
                $hasPermissions = true;
            }
        }

        if ($hasPermissions) {
            Auth::login($user_);
            session(['access_token' => $user->token]);
            return redirect('/');
        }

        return 'У Вас нет прав в данном сервисе.';
    }

    public function LogOut(Request  $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('access_token')
        ])->get(config('services.laravelpassport.host') . '/api/logout');
        $id = Auth::id();

        $user = User::find($id);
        $user->api_token = '';
        $user->save();


        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        //return session('access_token');
        return redirect('/');
    }
}
