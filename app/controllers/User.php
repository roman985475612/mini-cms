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

    public function actionRegister()
    {
        if (!$this->isPost()) {
            $this->redirect('admin');
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $validation = new Validation($_POST['user']);
        $validation
            ->add('name', new NotEmpty)
            ->add('name', new Alphanumeric)
            ->add('email', new NotEmpty)
            ->add('email', new Email)
            ->add('email', new Unique(User::class, 'email'))
            ->add('password', new NotEmpty)
            ->add('password', new Alphanumeric)
            ->add('password_confirm', new NotEmpty)
            ->add('password_confirm', new Alphanumeric)
            ->add('password', new Equal('Password confirm', $_POST['user']['password_confirm']));
            
        $validation->validate();
        if ($validation->hasErrors) {
            Flash::addError('Registratioin failed');
            $this->redirect('admin');
        };

        $user = new User;
        $user->username = $validation->cleanedData['name'];
        $user->email = $validation->cleanedData['email'];
        $user->setPassword($validation->cleanedData['password']);
        $user->save();

        Flash::addSuccess('Registratioin success!');

        $this->redirect('admin');
    }

    public function actionLogin()
    {
        if (!$this->isPost()) {
            $this->redirect('admin');
        }
        $showError = true;

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $validation = new Validation($_POST['user']);
        $validation
            ->add('email', new NotEmpty)
            ->add('email', new Email)
            ->add('password', new NotEmpty)
            ->add('password', new Alphanumeric)
            ->validate();

        if ($validation->hasErrors) {
            $this->render('admin/user/login', [
                'source' => $validation->sourceData,
                'errors' => $validation->errors,
                'showError' => $showError,
            ]);
        };

        try {
            $user = User::attempt(
                $validation->cleanedData['email'], 
                $validation->cleanedData['password']
            );    
        } catch (\Throwable $e) {
            $this->render('admin/user/login', [
                'source' => $validation->sourceData,
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
}