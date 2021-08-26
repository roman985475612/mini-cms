<?php

namespace App\Controller;

use Home\CmsMini\App;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\Request;
use Home\CmsMini\Validator\Validation;
use Home\CmsMini\Validator\{Alphanumeric, NotEmpty, Email, Equal, Unique};
use Home\CmsMini\View;
use App\Model\User;

class AuthController extends Controller
{
    protected function access(): bool
    {
        return (App::$route->action == 'logout' && Auth::isLoggedIn())
            || (App::$route->action != 'logout' && !Auth::isLoggedIn());
    }

    public function signup()
    {
        $view = new View;
        $view->title = "Sign Up";
        $view->header = "Sign Up";
        $view->template = 'auth/signup';
        $view->render();
    }

    public function register()
    {
        $v = new Validation(Request::post());
        $v->rule('username', new Alphanumeric);
        $v->rule('email', new Email);
        $v->rule('email', new Unique(User::class, 'email'));
        $v->rule('password', new NotEmpty);
        $v->rule('confirm', new NotEmpty);
        $v->rule('password', new Equal('Password confirm', Request::post('confirm')));

        if (!$v->validate()) {
            Flash::addError('Registratioin failed!');
            Request::redirect();
        };

        $user = new User;
        $user->username = $v->cleanedData['username'];
        $user->email = $v->cleanedData['email'];
        $user->setGuest();
        $user->setPassword($v->cleanedData['password']);
        $user->save();

        Flash::addSuccess('Registratioin success!');
        return Request::redirect('/');
    }

    public function signin()
    {
        $view = new View;
        $view->title = "Sign In";
        $view->header = "Sign In";
        $view->template = 'auth/signin';
        $view->render();
    }

    public function login()
    {
        $v = new Validation(Request::post());
        $v->rule('email', new Email);
        $v->rule('password', new NotEmpty);

        if (!$v->validate()) {
            Flash::addError('Authorization failed!');
            Request::redirect();
        };

        try {
            $user = User::attempt(
                $v->cleanedData['email'], 
                $v->cleanedData['password']
            );    
        } catch (\Throwable $e) {
            Flash::addError('Authorization failed!');
            Request::redirect();
        }

        Auth::login($user);
        Flash::addSuccess('Welcome, ' . ucfirst($user->username) . '!');
        Request::redirect('/');
    }

    public function logout()
    {
        Auth::logout();
    }
}