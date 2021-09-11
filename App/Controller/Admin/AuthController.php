<?php

namespace App\Controller\Admin;

use App\Model\User;
use Home\CmsMini\App;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\Request;
use Home\CmsMini\Router;
use Home\CmsMini\Validator\Validation;
use Home\CmsMini\Validator\{Alphanumeric, NotEmpty, Email, Equal, Unique};

class AuthController extends Controller
{
    protected string $layout = 'base';

    protected function access(): bool
    {
        return (App::getRoute()->action == 'logout' && Auth::isLoggedIn())
            || (App::getRoute()->action != 'logout' && !Auth::isLoggedIn());
    }

    public function signup()
    {
        $this->view->setMeta('title', 'Sign Up');
        $this->view->setMeta('header', 'Sign Up');
        $this->view->render('auth/signup');
    }

    public function register()
    {
        $v = new Validation(App::request()->post());
        $v->rule('username', new Alphanumeric);
        $v->rule('email', new Email);
        $v->rule('email', new Unique(User::class, 'email'));
        $v->rule('password', new NotEmpty);
        $v->rule('confirm', new NotEmpty);
        $v->rule('password', new Equal('Password confirm', App::request()->post('confirm')));

        if (!$v->validate()) {
            Flash::addError('Registratioin failed!');
            App::request()->setOld($v->sourceData, ['password', 'confirm']);
            App::request()->setErrors($v->errors);
            App::request()->redirect();
        };

        $user = new User;
        $user->recordModeEnable();
        $user->username = $v->cleanedData['username'];
        $user->email    = $v->cleanedData['email'];
        $user->setEditor();
        $user->setPassword($v->cleanedData['password']);
        $user->save();

        Auth::login($user);

        Flash::addSuccess('Registratioin success!');

        App::request()->redirect(Router::url('admin'));
    }

    public function signin()
    {
        $this->view->setMeta('title', 'Sign In');
        $this->view->setMeta('header', 'Sign In');
        $this->view->render('auth/signin');
    }

    public function login()
    {
        $v = new Validation(App::request()->post());
        $v->rule('email', new Email);
        $v->rule('password', new NotEmpty);

        if (!$v->validate()) {
            Flash::addError('Authorization failed!');
            App::request()->setOld($v->sourceData, ['password']);
            App::request()->setErrors($v->errors);
            App::request()->redirect();
        };

        try {
            $user = User::attempt(
                $v->cleanedData['email'], 
                $v->cleanedData['password']
            );    
        } catch (\Throwable $e) {
            Flash::addError('Authorization failed!');
            App::request()->setErrors($v->errors);
            App::request()->redirect();
        }

        Auth::login($user);
        Flash::addSuccess('Welcome, ' . ucfirst($user->username) . '!');
        App::request()->redirect(Router::url('admin'));
    }

    public function logout()
    {
        Auth::logout();
        App::request()->redirect();
    }
}