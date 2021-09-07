<?php

namespace Home\CmsMini;

use App\Model\User;

class Auth
{
    const LOGIN_URL = '/signin';

    public static function login(User $user)
    {
        $user->setToken();
        $_SESSION['UID'] = $user->token;
    }

    public static function logout()
    {
        if (isset($_SESSION['UID'])) {
            unset($_SESSION['UID']);
        }
    }

    public static function user(): ?User
    {
        return self::isLoggedIn() ? User::find('token', $_SESSION['UID'])->one() : null;
    }

    public static function isLoggedIn()
    {   
        return isset($_SESSION['UID']) && !empty($_SESSION['UID']);
    }

    public static function isGuest()
    {   
        return !self::isLoggedIn();
    }

    public static function isAdmin()
    {   
        return self::isLoggedIn() 
            && self::user()->role == User::ADMIN;
    }

    public static function loginRequired()
    {
        if (!self::isLoggedIn()) {
            Request::redirect(Auth::LOGIN_URL);
        }
    }
}