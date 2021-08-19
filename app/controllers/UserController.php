<?php declare(strict_types=1);

namespace App\Controller;

use App\Model\User;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\Validation;
use Home\CmsMini\Validator\{Alphanumeric, NotEmpty, Email, Equal, Unique};

class UserController extends Controller
{
    protected string $layout = 'layouts/secondary';

    public function store()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $v = new Validation($_POST['user']);
        $v->rule('name', new NotEmpty);
        $v->rule('name', new Alphanumeric);
        $v->rule('email', new NotEmpty);
        $v->rule('email', new Email);
        $v->rule('email', new Unique(User::class, 'email'));
        $v->rule('password', new NotEmpty);
        $v->rule('password', new Alphanumeric);
        $v->rule('password_confirm', new NotEmpty);
        $v->rule('password_confirm', new Alphanumeric);
        $v->rule('password', new Equal('Password confirm', $_POST['user']['password_confirm']));

        if ($v->validate()) {
            Flash::addError('Registratioin failed');
            $this->redirect('admin');
        };

        $user = new User;
        $user->username = $v->cleanedData['name'];
        $user->email = $v->cleanedData['email'];
        $user->setPassword($v->cleanedData['password']);
        $user->save();

        Flash::addSuccess('Registratioin success!');

        return $this->redirect('admin');
    }

    public function login()
    {
        if (!$this->isPost()) {
            $this->redirect('admin');
        }
        $showError = true;

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $v = new Validation($_POST['user']);
        $v->rule('email', new NotEmpty);
        $v->rule('email', new Email);
        $v->rule('password', new NotEmpty);
        $v->rule('password', new Alphanumeric);

        if ($v->validate()) {
            $this->render('admin/user/login', [
                'source' => $v->sourceData,
                'errors' => $v->errors,
                'showError' => $showError,
            ]);
        };

        try {
            $user = User::attempt(
                $v->cleanedData['email'], 
                $v->cleanedData['password']
            );    
        } catch (\Throwable $e) {
            $this->render('admin/user/login', [
                'source' => $v->sourceData,
                'errors' => [
                    'email' => 'Email and password does not matches!', 
                    'password' => 'Email and password does not matches!'
                ],
                'showError' => $showError,
            ]);
        }

        Auth::login($user);

        Flash::addSuccess('Welcome, ' . ucfirst($user->username) . '!');
        $this->redirect('admin');
    }

    public function logout()
    {

    }
}