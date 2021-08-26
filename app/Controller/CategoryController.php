<?php

namespace App\Controller;

use App\Model\Category;
use App\Widget\Pagination;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\Request;
use Home\CmsMini\Router;
use Home\CmsMini\View;
use Home\CmsMini\Form\{Form, Fieldset, Input, Label, Button};
use Home\CmsMini\Validator\Validation;
use Home\CmsMini\Validator\{Alphanumeric, NotEmpty, Email, Phone};

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
        $page = new Pagination(Category::class, 3);
        
        $view = new View;
        $view->title = 'categories';
        $view->header = 'categories';
        $view->layout = 'admin';
        $view->template = 'admin/category/index';
        $view->render(compact('page'));
    }

    public function create()
    {
        $form = $this->getForm(Router::url('category-store'));
        echo $form->render();
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
        return Request::redirect(Router::url('categories'));
    }

    public function edit(Category $category)
    {
        $form = $this->getForm(Router::url('category-update', ['id' => $category->id]), $category);

        $view = new View;
        $view->title = $category->title;
        $view->header = $category->title;
        $view->layout = 'admin';
        $view->template = 'admin/category/edit';
        $view->render(compact('category', 'form'));
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

    protected function getForm(string $action, ?Category $category = null)
    {
        $form = new Form([
            'id'        => 'categoryUpdate',
            'action'    => $action, 
            'method'    => 'POST', 
            'class'     => 'needs-validation', 
            'novalidate'=> '', 
        ]);
        
        $fieldset = new Fieldset(['class' => 'mb-3']);
        $fieldset->add(new Label('Title', true, [
            'for'       => 'categoryTitle',
            'class'     => 'form-label'
        ]));
        $fieldset->add(new Input([
            'id'        => 'categoryTitle', 
            'name'      => 'title', 
            'type'      => 'text', 
            'class'     => 'form-control form__control', 
            'placeholder' => 'Enter title',
            'data-valid'  => 'notEmpty',
            'value'     => $category->title ?? ''
        ]));
        $form->add($fieldset);
        
        $fieldset = new Fieldset(['class' => 'mb-3']);
        $fieldsetInner = new Fieldset(['class' => 'd-grid gap-2']);
        $fieldsetInner->add(new Button('Save', [
            'type'  => 'submit', 
            'class' => 'btn btn-outline-success form__submit',
        ]));
        $fieldset->add($fieldsetInner);
        $form->add($fieldset);
        
        return $form;
    }
}
