<?php

namespace Home\CmsMini;

use App\Model\User;

class Auth
{
    const LOGIN_URL = '/login';

    public static function checkUser()
    {
        return isset($_SESSION['session'])
            && isset($_COOKIE['session']) 
            && ($_SESSION['session'] === $_COOKIE['session']);
    }
    
    public static function checkOrRedirect(string $allowPriv = '*', string $back = '')
    {
        if (!static::checkUser()) {
            header('Location: /' . Auth::$redirectTo . '?back=' . $back);
            exit;
        }

        $session = Session::findBy('session', $_SESSION['session']);
        if ($allowPriv !== '*' 
            && !in_array(strtolower($allowPriv), $session->user->role->privileges)) {
            header('Location: /');
            exit;
        }
        
        $session->updateLastTime();
    }

    public static function login(User $user)
    {
        $_SESSION['user_id']  = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['username'] = $user->username;

        // $expires = isset($cleaned_data['remember_me']) ? time() + 10 * 24 * 60 * 60 : 0;

        // setcookie('session', $session->session, $expires, '/');
    }

    public static function userId()
    {
        return self::isLoggedIn() ? $_SESSION['user_id'] : null;
    }

    public static function isLoggedIn()
    {   
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    public static function loginRequired(string $back = '')
    {
        if (!Auth::isLoggedIn()) {
            header('Location: /' . Auth::LOGIN_URL);
            // header('Location: /' . Auth::LOGIN_URL . '?back=' . $back);
            exit;
        }
    }

    public static function logout()
    {
        // if (isset($_SESSION['session'])) {
        //     $session = Session::findBy('session', $_SESSION['session']);
        //     $session->delete();
        //     unset($_SESSION['session']);
        // }

        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
        }

        if (isset($_SESSION['username'])) {
            unset($_SESSION['username']);
        }

        // setcookie('session', '', time() - 24 * 60 * 60, '/');

        header('Location: /' . Auth::LOGIN_URL);
        exit;
    }

    public static function name()
    {
        return isset($_SESSION['username']) ? ucfirst($_SESSION['username']) : 'Anonymous';
    }
}