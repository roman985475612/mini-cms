<?php

namespace App\Controller\Admin;

use App\Model\User;
use Home\CmsMini\App;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Exception\UserNotFoundException;
use Home\CmsMini\Flash;
use Home\CmsMini\Router;
use Home\CmsMini\Validator\Validation;
use Home\CmsMini\Validator\{Alphanumeric, NotEmpty, Email, Equal, Unique};

class AuthController extends Controller
{
    protected string $layout = 'base';

    protected function permissions(): array
    {
        return [
            'logout' => [Auth::class, 'isLoggedIn'],
        ];
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

        User::create($v->cleanedData);

        Flash::addSuccess('To confirm registration, follow the link indicated in the letter');

        App::request()->redirect(Router::url('home'));
    }

    public function confirm()
    {
        $user = User::findOne('token', App::request()->get('token'));
        
        if ($user->isEmpty()) {
            Flash::addError('Invalid token!');
            App::request()->redirect(Router::url('home'));
        }

        $user->setConfirmed();

        Auth::login($user);

        Flash::addSuccess('Congratulations on your successful registration!');

        App::cache()->clear('menu');
        App::request()->redirect(Router::url('home'));
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
        } catch (UserNotFoundException $e) {
            Flash::addError('Authorization failed!');
            App::request()->setErrors($v->errors);
            App::request()->redirect();
        }

        Auth::login($user);
        
        App::cache()->clear('menu');

        Flash::addSuccess('Welcome, ' . ucfirst($user->username) . '!');
        
        App::request()->redirect(Router::url('admin'));
    }

    public function forgot()
    {
        $this->view->setMeta('title', 'Forgot password');
        $this->view->setMeta('header', 'Forgot password');
        $this->view->render('auth/forgot');
    }

    public function recovery()
    {
        $v = new Validation(App::request()->post());
        $v->rule('email', new Email);
        $v->validate();

        if (!$v->isValid()) {
            Flash::addError('Recovery failed!');
            App::request()->setOld(App::request()->post(), ['password']);
            App::request()->setErrors($v->getErrors());
            App::request()->redirect();
        }

        $user = User::findOne('email', $v->getCleanedDate('email'));
        if (!$user->isEmpty()) {
            $user->recoveryPassword();
        }

        Flash::addSuccess('A letter with a new password has been sent to the specified e-mail');

        App::request()->redirect(Router::url('home'));
    }

    public function logout()
    {
        Auth::logout();

        App::cache()->clear('menu');
        App::request()->redirect();
    }
}