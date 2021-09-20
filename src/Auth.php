<?php

namespace Home\CmsMini;

use App\Model\User;
use Home\CmsMini\Exception\UserNotFoundException;

class Auth
{
    const UID_KEY = 'UID';

    public static function redirectToLoginUrl(): void
    {
        App::request()->redirect(Auth::loginUrl());
    }

    public static function login(User $user)
    {
        $user->setToken();
        App::session()->set(self::UID_KEY, $user->token);
    }

    public static function logout()
    {
        App::session()->remove(self::UID_KEY);
    }

    public static function user(): User
    {
        if (!self::isLoggedIn()) {
            throw new UserNotFoundException;
        }

        $user = User::findOne('token', App::session()->get(self::UID_KEY));
        if ($user->isEmpty()) {
            throw new UserNotFoundException;
        }

        return $user;
    }

    public static function isLoggedIn(): bool
    {
        return App::session()->has(self::UID_KEY) 
            && !App::session()->isEmpty(self::UID_KEY);
    }

    public static function isGuest(): bool
    {
        return !self::isLoggedIn();
    }

    public static function isAdmin(): bool
    {
        return self::isLoggedIn() 
            && self::user()->isAdmin();
    }

    public static function loginRequired()
    {
        if (!self::isLoggedIn()) {
            self::redirectToLoginUrl();
        }
    }
    
    private static function loginUrl()
    {
        return Router::url('signin');
    }
}