<?php

namespace App\Controller\Admin;

use App\Model\Category;
use App\Widget\Pagination;
use Home\CmsMini\App;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\File;
use Home\CmsMini\Flash;
use Home\CmsMini\FormBuilder as Form;
use Home\CmsMini\Router;
use Home\CmsMini\Validator\Validation;
use Home\CmsMini\Validator\{NotEmpty, Unique};

class CategoryController extends Controller
{
    protected string $layout = 'admin';

    protected function access(): bool
    {
        return Auth::isLoggedIn();
    }
    
    protected function accessDeny()
    {
        return App::request()->redirect(Auth::LOGIN_URL);
    }

    public function index()
    {
        $this->view->setMeta('title', 'categories');
        $this->view->setMeta('header', 'categories');
        $this->view->setMeta('headerClass', 'bg-info');
        $this->view->render('admin/list', [
            'page'      => new Pagination(Category::query(), 10),
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
        $v = new Validation(App::request()->post());
        $v->rule('title', new NotEmpty);
        $v->rule('title', new Unique(Category::class, 'title'));

        if (!$v->validate()) {
            Flash::addError('Category creation error!');
            App::request()->setOld($v->sourceData);
            App::request()->setErrors($v->errors);
            App::request()->redirect();
        };

        $category = new Category;
        $category->recordModeEnable();
        $category->title = strtolower($v->cleanedData['title']);
        $category->save();

        Flash::addSuccess('Category created!');
        App::request()->redirect();
    }

    public function edit(Category $category)
    {
        $form = Form::open([
            'id'     => 'mainForm',
            'action' => Router::url('category-update', ['id' => $category->id]),
        ]);
        
        $form .= Form::text([
            'name'      => 'title',
            'value'     => $category->title,
            'id'        => 'formTitle',
            'placeholder' => 'Enter title',
        ], 'Title');
        
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
        $v = new Validation(App::request()->post());
        $v->rule('title', new NotEmpty);
        $v->rule('title', new Unique(Category::class, 'title', $category->title));

        if (!$v->validate()) {
            Flash::addError('Category update error!');
            App::request()->setOld($v->sourceData);
            App::request()->setErrors($v->errors);
            App::request()->redirect();
        };

        $category->recordModeEnable();
        $category->title = $v->cleanedData['title'];
        $category->save();

        Flash::addSuccess('Category updated!');

        App::request()->redirect(Router::url('categories'));
    }

    public function delete(Category $category)
    {
        $category->delete();
        
        Flash::addSuccess('Category deleted!');
        
        App::request()->redirect(Router::url('categories'));
    }

    public function table()
    {
        $this->view->renderPart('admin/category/table', [
            'page' => new Pagination(Category::query(), 10)
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
        $file = new File(App::request()->files('file'));
        
        $content = file_get_contents($file->getTempName());
        if ($file->isJson()) {
            $result = json_decode($content, true);
        } elseif ($file->isXml()) {
            $result = new \SimpleXMLElement($content);
        }

        foreach ($result as $item) {
            $v = new Validation($item);
            $v->rule('title', new NotEmpty);
            $v->rule('title', new Unique(Category::class, 'title'));

            if (!$v->validate()) {
                Flash::addError("Category \"{$item['title']}\" not uploaded!");
                continue;
            };

            Category::create(['title' => $item['title']]);

            Flash::addSuccess("Category \"{$item['title']}\" created!");
        }

        return App::request()->redirect();
    }
}
