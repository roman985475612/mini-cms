<?php

namespace App\Controller;

use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\Request;
use Home\CmsMini\Validator\Validation;
use Home\CmsMini\Validator\{Alphanumeric, NotEmpty, Email, Phone};
use Home\CmsMini\View;
use App\Model\Message;
use Home\CmsMini\Router;

class HomeController extends Controller
{
    public function index()
    {
        $view = new View;
        $view->template = 'home/index';
        $view->render();
    }

    public function about()
    {
        $view = new View;
        $view->title = 'about us';
        $view->header = 'about us';
        $view->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        $view->template = 'home/about';
        $view->render();
    }

    public function services()
    {
        $view = new View;
        $view->title = 'our services';
        $view->header = 'our services';
        $view->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        $view->template = 'home/services';
        $view->render();
    }

    public function contact()
    {
        $view = new View;
        $view->title = 'contact us';
        $view->header = 'contact us';
        $view->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        $view->template = 'home/contact';
        $view->render();
    }

    public function contactStore()
    {
        $v = new Validation(Request::post('contact'));
        $v->rule('firstname', new Alphanumeric);
        $v->rule('lastname', new Alphanumeric);
        $v->rule('email', new Email);
        $v->rule('phone', new Phone);
        $v->rule('body', new NotEmpty);

        if (!$v->validate()) {
            Flash::addError('Message error!');
            Request::redirect();
        };

        $message = new Message;
        $message->fill($v->cleanedData);
        $message->save();

        Flash::addSuccess('Message added!');
        return Request::redirect(Router::url('contact'));
    }
}