<?php

namespace App\Controller\Admin;

use App\Model\Post;
use App\Model\Category;
use App\Model\User;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\FormBuilder as Form;
use Home\CmsMini\Request;
use Home\CmsMini\Router;
use Home\CmsMini\Validator\Alphanumeric;
use Home\CmsMini\Validator\Always;
use Home\CmsMini\Validator\Email;
use Home\CmsMini\Validator\Equal;
use Home\CmsMini\Validator\NotEmpty;
use Home\CmsMini\Validator\Unique;
use Home\CmsMini\Validator\Validation;

class AdminController extends Controller
{
    protected string $layout = 'admin';

    protected function access(): bool
    {
        return Auth::isLoggedIn();
    }
    
    protected function accessDeny()
    {
        Request::redirect(Auth::LOGIN_URL);
    }

    public function index()
    {
        $this->view->setMeta('title', 'dashboard');
        $this->view->setMeta('header', 'dashboard');
        $this->view->setMeta('headerClass', 'bg-primary');
        $this->view->render('admin/index', [
            'entity' => 'Post',
            'counts' => [
                'post'     => Post::count(),
                'category' => Category::count(),
                'user'     => User::count(),
            ],
        ]);
    }

    public function profile()
    {
        $user = Auth::user();

        $form = Form::open([
            'id'          => 'mainForm',
            'action'      => Router::url('profile-update'),
            'class'       => 'needs-validation',
            'enctype'     => 'multipart/form-data',
            'novalidate'  => '',
        ]);
        $form .= Form::text([
            'id'          => 'mainForm',
            'name'        => 'username',
            'class'       => 'form-control form__control',
            'placeholder' => 'Enter Username',
            'value'       => $user->username,
            'data-valid'  => 'notEmpty',
        ], 'Username');
        $form .= Form::email([
            'id'          => 'userEmail',
            'name'        => 'email',
            'class'       => 'form-control form__control',
            'placeholder' => 'Enter email',
            'value'       => $user->email,
            'data-valid'  => 'email',
        ], 'Email address');
        $form .= Form::password([
            'id'          => 'userPassword',
            'name'        => 'password',
            'class'       => 'form-control form__control',
            'placeholder' => 'Enter password',
            'data-valid'  => 'notEmpty',
        ], 'Password');
        $form .= Form::password([
            'id'          => 'userConfirm',
            'name'        => 'confirm',
            'class'       => 'form-control form__control',
            'placeholder' => 'Enter confirm password',
            'data-valid'  => 'notEmpty',
        ], 'Confirm password');
        $form .= Form::textarea([
            'name'        => 'bio',
            'id'          => 'userBio',
            'placeholder' => 'Enter bio',
        ], 'Bio', $user->bio);
        $form .= Form::file([
            'name'  => 'image',
            'id'    => 'userImage',
            'value' => $user->image,
        ], 'Image');
        $form .= Form::close();

        $this->view->setMeta('title', 'profile');
        $this->view->setMeta('header', $user->username);
        $this->view->setMeta('headerClass', 'bg-secondary');
        $this->view->render('admin/edit', [
            'form'        => $form,
            'entity'      => 'Profile',
            'backUrl'     => Router::url('admin'),
            'saveUrl'     => Router::url('profile-update'),
            'deleteUrl'   => Router::url('profile-delete'),
        ]);
    }

    public function update()
    {
        $user = Auth::user();

        $v = new Validation(Request::post());
        $v->rule('username', new Alphanumeric);
        $v->rule('email'   , new Email);
        $v->rule('email'   , new Unique(User::class, 'email', $user->email));
        $v->rule('bio'     , new Always);
        $v->rule('password', new Always);
        $v->rule('confirm' , new Always);
        $v->rule('password', new Equal('Password confirm', Request::post('confirm')));

        if (!$v->validate()) {
            Flash::addError('Profile update failed!');
            Request::redirect();
        };

        $user->username = $v->cleanedData['username'];
        $user->email    = $v->cleanedData['email'];
        $user->bio      = $v->cleanedData['bio'];

        if (!empty($v->cleanedData['password'])) {
            $user->setPassword($v->cleanedData['password']);
        }

        $user->setImage();

        if ($user->save()) {
            Flash::addSuccess('Profile updated!');
        }

        Flash::addSuccess('Profile update success!');
        Request::redirect();
    }

    public function delete()
    {
        Auth::user()->delete();
        Auth::logout();

        Flash::addSuccess('Profile deleted!');
        Request::redirect(Router::url('home'));
    }

    public function settings()
    {
        $this->view->setMeta('title', 'settings');
        $this->view->setMeta('header', 'settings');
        $this->view->render('admin/settings');
    }
}