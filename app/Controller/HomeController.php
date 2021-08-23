<?php

namespace App\Controller;

use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\Request;
use Home\CmsMini\Validator\Validation;
use Home\CmsMini\Validator\{Alphanumeric, NotEmpty, Email, Phone};
use App\Model\Message;

class HomeController extends Controller
{
    public function index()
    {
        return $this->render('home/index');
    }

    public function about()
    {
        $this->title = 'about us';
        $this->header = 'about us';
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render('home/about');
    }

    public function services()
    {
        $this->title = 'our services';
        $this->header = 'our services';
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render('home/services');
    }

    public function contact()
    {
        $this->title = 'contact us';
        $this->header = 'contact us';
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';

        return $this->render('home/contact');
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
        return Request::redirect('/contact');
    }
}