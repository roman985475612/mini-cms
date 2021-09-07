<?php

namespace App\Controller\Admin;

use App\Model\User;
use App\Widget\Pagination;
use Home\CmsMini\App;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\FormBuilder as Form;
use Home\CmsMini\Router;
use Home\CmsMini\Validator\Validation;
use Home\CmsMini\Validator\{Alphanumeric, Always, NotEmpty, Email, Equal, Unique};

class UserController extends Controller
{
    protected string $layout = 'admin';

    protected function access(): bool
    {
        return Auth::isAdmin();
    }
    
    protected function accessDeny()
    {
        App::request()->redirect(Auth::LOGIN_URL);
    }

    protected function getRoles(): array
    {
        return [
            ['key' => User::ADMIN , 'value' => 'Administrator'],
            ['key' => User::EDITOR, 'value' => 'Editor'],
            ['key' => User::GUEST , 'value' => 'Guest'],
        ];
    }

    public function index()
    {
        $this->view->setMeta('title', 'Users');
        $this->view->setMeta('header', 'Users');
        $this->view->setMeta('headerClass', 'bg-info');
        $this->view->render('admin/list', [
            'page'      => new Pagination(User::query(), 5),
            'entity'    => 'User',
            'createUrl' => Router::url('user-create'),
            'tableUrl'  => Router::url('user-table'),
            'uploadUrl' => Router::url('user-upload-form'),
        ]);
    }

    public function create()
    {
        $form = Form::open([
            'id'          => 'createForm',
            'action'      => Router::url('user-store'),
            'enctype'     => 'multipart/form-data',
            'class'       => 'needs-validation',
            'novalidate'  => '',
        ]);
        $form .= Form::text([
            'id'          => 'userUsername',
            'name'        => 'username',
            'class'       => 'form-control form__control',
            'placeholder' => 'Enter Username',
            'data-valid'  => 'notEmpty',
        ], 'Username');
        $form .= Form::email([
            'id'          => 'userEmail',
            'name'        => 'email',
            'class'       => 'form-control form__control',
            'placeholder' => 'Enter email',
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
        $form .= Form::select($this->getRoles(), ['name' => 'role', 'id' => 'userRole'], 'Role');
        $form .= Form::textarea(['name' => 'bio', 'id' => 'userBio', 'placeholder' => 'Enter bio'], 'Bio');
        $form .= Form::file(['name' => 'image', 'id' => 'userImage'], 'Image');
        $form .= Form::submit('Save', ['class' => 'btn btn-outline-primary form__submit']);
        $form .= Form::close();

        echo $form;
    }

    public function store()
    {
        $v = new Validation(App::request()->post());
        $v->rule('username', new Alphanumeric);
        $v->rule('email', new Email);
        $v->rule('email', new Unique(User::class, 'email'));
        $v->rule('role', new NotEmpty);
        $v->rule('bio', new Always);
        $v->rule('password', new NotEmpty);
        $v->rule('confirm', new NotEmpty);
        $v->rule('password', new Equal('Password confirm', App::request()->post('confirm')));

        if (!$v->validate()) {
            Flash::addError('User creation failed!');
            App::request()->setOld($v->sourceData, ['password', 'confirm']);
            App::request()->setOld($v->sourceData);
            App::request()->setErrors($v->errors);
            App::request()->redirect();
        };

        $user = new User;
        $user->recordModeEnable();
        $user->username = $v->cleanedData['username'];
        $user->email    = $v->cleanedData['email'];
        $user->role     = $v->cleanedData['role'];
        $user->bio      = $v->cleanedData['bio'];
        $user->setPassword($v->cleanedData['password']);
        $user->setImage();
        $user->save();

        Flash::addSuccess('User creation success!');

        App::request()->redirect();
    }

    public function edit(User $user)
    {
        $options = $this->getRoles();

        foreach ($options as &$option) {
            $option['cur'] = $user->role == $option['key'];
        }

        $form = Form::open([
            'id'          => 'mainForm',
            'action'      => Router::url('user-update', ['id' => $user->id]),
            'enctype'     => 'multipart/form-data',
            'class'       => 'needs-validation',
            'novalidate'  => '',
        ]);
        $form .= Form::text([
            'id'          => 'userUsername',
            'name'        => 'username',
            'class'       => 'form-control form__control',
            'placeholder' => 'Enter Username',
            'data-valid'  => 'notEmpty',
            'value'       => $user->username,
        ], 'Username');
        $form .= Form::email([
            'id'          => 'userEmail',
            'name'        => 'email',
            'class'       => 'form-control form__control',
            'placeholder' => 'Enter email',
            'data-valid'  => 'email',
            'value'       => $user->email,
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
        $form .= Form::select($options, ['name' => 'role', 'id' => 'userRole'], 'Role');
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

        $this->view->setMeta('title', $user->username);
        $this->view->setMeta('header', $user->username);
        $this->view->setMeta('headerClass', 'bg-secondary');
        $this->view->render('admin/edit', [
            'object'      => $user,
            'form'        => $form,
            'entity'      => 'User',
            'backUrl'     => Router::url('users', ['id' => $user->id]),
            'saveUrl'     => Router::url('user-update', ['id' => $user->id]),
            'deleteUrl'   => Router::url('user-delete', ['id' => $user->id]),
        ]);
    }

    public function update(User $user)
    {
        $v = new Validation(App::request()->post());
        $v->rule('username', new Alphanumeric);
        $v->rule('email', new Email);
        $v->rule('email', new Unique(User::class, 'email', $user->email));
        $v->rule('role', new NotEmpty);
        $v->rule('bio', new Always);
        $v->rule('password', new Always);
        $v->rule('confirm', new Always);
        $v->rule('password', new Equal('Password confirm', App::request()->post('confirm')));
        
        if (!$v->validate()) {
            Flash::addError('User not updated!');
            App::request()->setOld($v->sourceData, ['password', 'confirm']);
            App::request()->setErrors($v->errors);
            App::request()->redirect();
        };

        $user->recordModeEnable();
        $user->username = $v->cleanedData['username'];
        $user->email = $v->cleanedData['email'];
        $user->bio = $v->cleanedData['bio'];
        $user->role = $v->cleanedData['role'];

        if (!empty($v->cleanedData['password'])) {
            $user->setPassword($v->cleanedData['password']);
        }

        $user->setImage();

        if ($user->save()) {
            Flash::addSuccess('User updated!');
        }

        App::request()->redirect();
    }

    public function delete(User $user)
    {
        $user->delete();
        
        Flash::addSuccess('User deleted!');
        
        App::request()->redirect(Router::url('users'));
    }

    public function table()
    {
        $this->view->renderPart('admin/user/table', [
            'page' => new Pagination(User::query(), 5)
        ]);
    }

    public function uploadForm()
    {
        $this->view->renderPart('404');
    }
}
