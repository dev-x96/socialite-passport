<?php

use Illuminate\Support\Facades\Route;

Route::get(config('socialite-passport.route_login.uri'), [
    'middleware' => 'web',
    'uses' => 'AuthenticationController@redirectToProvider'
])->name(config('socialite-passport.route_login.name'));

Route::get(config('socialite-passport.route_logout.uri'), [
    'middleware' => 'web',
    'uses' => 'LoginController@LogOut'
])->name(config('socialite-passport.route_logout.name'));

Route::get(config('services.laravelpassport.redirect'), [
    'middleware' => 'web',
    'uses' => 'AuthenticationController@handleProviderCallback'
]);
