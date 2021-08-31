<?php

namespace App\Controller;

use App\Model\Subscribe;
use App\Model\Message;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\Request;
use Home\CmsMini\Validator\Validation;
use Home\CmsMini\Validator\{Alphanumeric, NotEmpty, Email, Phone};
use Home\CmsMini\Router;

class HomeController extends Controller
{
    protected string $layout = 'base';

    public function index()
    {
        $this->view->render('home/index');
    }

    public function about()
    {
        $this->view->setMeta('title', 'about us');
        $this->view->setMeta('header', 'about us');
        $this->view->setMeta('description', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.');
        $this->view->render('home/about');
    }

    public function services()
    {
        $this->view->setMeta('title', 'our services');
        $this->view->setMeta('header', 'our services');
        $this->view->setMeta('description', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.');
        $this->view->render('home/services');
    }

    public function contact()
    {
        $this->view->setMeta('title', 'contact us');
        $this->view->setMeta('header', 'contact us');
        $this->view->setMeta('description', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.');
        $this->view->render('home/contact');
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
        Request::redirect(Router::url('contact'));
    }

    public function subscribe()
    {
        $v = new Validation(Request::post('newsletter'));
        $v->rule('name', new Alphanumeric);
        $v->rule('email', new Email);

        if (!$v->validate()) {
            Flash::addError('Subscribe error!');
            Request::redirect();
        };

        if (Subscribe::create($v->cleanedData)) {
            Flash::addSuccess('You have successfully subscribed !');
        }

        Request::redirect();
    }
}