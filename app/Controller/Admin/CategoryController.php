<?php

namespace App\Controller\Admin;

use App\Model\Category;
use App\Widget\Pagination;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\File;
use Home\CmsMini\Flash;
use Home\CmsMini\FormBuilder as Form;
use Home\CmsMini\Request;
use Home\CmsMini\Router;
use Home\CmsMini\Validator\Validation;
use Home\CmsMini\Validator\{NotEmpty};

class CategoryController extends Controller
{
    protected string $layout = 'admin';

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
        $this->view->setMeta('title', 'categories');
        $this->view->setMeta('header', 'categories');
        $this->view->setMeta('headerClass', 'bg-info');
        $this->view->render('admin/list', [
            'page'      => new Pagination(Category::class, 10),
            'entity'    => 'Category',
            'createUrl' => Router::url('category-create'),
            'tableUrl'  => Router::url('category-table'),
            'uploadUrl' => Router::url('categoryUploadForm'),
        ]);
    }

    public function create()
    {
        $form = Form::open(['id' => 'createForm', 'action' => Router::url('category-store')]);
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
        Request::redirect();
    }

    public function edit(Category $category)
    {
        $form = Form::open([
            'id'     => 'mainForm',
            'action' => Router::url('category-update')]
        );
        $form .= Form::input(['name' => 'title', 'value' => $category->title, 'id' => 'formTitle', 'placeholder' => 'Enter title'], 'Title');
        $form .= Form::close();

        $this->view->setMeta('title', $category->title);
        $this->view->setMeta('header', $category->title);
        $this->view->setMeta('headerClass', 'bg-secondary');
        $this->view->render('admin/edit', [
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
        Request::redirect(Router::url('categories'));
    }

    public function delete(Category $category)
    {
        $category->delete();
        
        Flash::addSuccess('Category deleted!');
        Request::redirect(Router::url('categories'));
    }

    public function table()
    {
        $this->view->renderPart('admin/category/table', [
            'page' => new Pagination(Category::class, 10)
        ]);
    }

    public function uploadForm()
    {
        $form = Form::open(['action' => Router::url('categoryUpload'), 'enctype' => 'multipart/form-data']);
        $form .= Form::file(['name' => 'file', 'id' => 'uploadFile'], 'Photo');
        $form .= Form::submit('Upload');
        $form .= Form::close();

        echo $form;
    }

    public function upload()
    {
        $file = new File('file');
        
        $content = file_get_contents($file->getTempName());
        if ($file->isJson()) {
            $result = json_decode($content);
        } elseif ($file->isXml()) {
            $result = new \SimpleXMLElement($content);
        }

        foreach ($result as $item) {
           $category = new Category;
           $category->title = (string) $item->title;
           $category->save();

           Flash::addSuccess("Category created!");
        }

        return Request::redirect();
    }
}
