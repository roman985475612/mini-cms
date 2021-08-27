<?php

namespace App\Controller;

use App\Model\Category;
use App\Widget\Pagination;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\FormBuilder as Form;
use Home\CmsMini\Request;
use Home\CmsMini\Router;
use Home\CmsMini\View;
use Home\CmsMini\Validator\Validation;
use Home\CmsMini\Validator\{NotEmpty};

class CategoryController extends Controller
{
    protected function access(): bool
    {
        return Auth::isLoggedIn();
    }
    
    protected function accessDeny()
    {
        return Request::redirect(Auth::LOGIN_URL);
    }

    public function index()
    {
        $view = new View;
        $view->title = 'categories';
        $view->header = 'categories';
        $view->layout = 'admin';
        $view->template = 'admin/category/index';
        $view->render([
            'headerClass' => 'bg-info',
            'page'      => new Pagination(Category::class, 3),
            'entity'    => 'Post',
            'createUrl' => Router::url('category-create'),
        ]);
    }

    public function create()
    {
        $form = Form::open(['action' => Router::url('category-store')]);
        $form .= Form::input(['name' => 'title', 'id' => 'formTitle', 'placeholder' => 'Enter title'], 'Title');
        $form .= Form::submit('Save');
        $form .= Form::close();

        echo $form;
    }

    public function store()
    {
        $v = new Validation(Request::post());
        $v->rule('title', new NotEmpty);

        if (!$v->validate()) {
            Flash::addError('Category creation error!');
            Request::redirect();
        };

        $category = new Category;
        $category->title = $v->cleanedData['title'];
        $category->save();

        Flash::addSuccess('Category created!');
        return Request::redirect();
    }

    public function edit(Category $category)
    {
        $form = Form::open(['action' => Router::url('category-update')]);
        $form .= Form::input(['name' => 'title', 'value' => $category->title, 'id' => 'formTitle', 'placeholder' => 'Enter title'], 'Title');
        $form .= Form::submit('Save');
        $form .= Form::close();

        $view = new View;
        $view->title    = $category->title;
        $view->header   = $category->title;
        $view->layout   = 'admin';
        $view->template = 'admin/edit';
        $view->render([
            'headerClass' => 'bg-secondary',
            'object'    => $category, 
            'form'      => $form,
            'entity'    => 'Post',
            'backUrl'   => Router::url('categories', ['id' => $category->id]),
            'saveUrl'   => Router::url('category-update', ['id' => $category->id]),
            'deleteUrl' => Router::url('category-delete', ['id' => $category->id]),
        ]);
    }

    public function update(Category $category)
    {
        $v = new Validation(Request::post());
        $v->rule('title', new NotEmpty);

        if (!$v->validate()) {
            Flash::addError('Category update error!');
            Request::redirect();
        };

        $category->title = $v->cleanedData['title'];
        $category->save(['title']);

        Flash::addSuccess('Category updated!');
        return Request::redirect(Router::url('categories'));
    }

    public function delete(Category $category)
    {
        $category->delete();
        
        Flash::addSuccess('Category deleted!');
        return Request::redirect(Router::url('categories'));
    }
}
