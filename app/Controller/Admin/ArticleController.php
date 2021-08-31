<?php

namespace App\Controller\Admin;

use App\Model\Article;
use App\Model\Category;
use App\Widget\Pagination;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\FormBuilder as Form;
use Home\CmsMini\Request;
use Home\CmsMini\Router;
use Home\CmsMini\Validator\Validation;
use Home\CmsMini\Validator\{Alphanumeric, Always, NotEmpty, Email, Equal, Unique};
use Home\CmsMini\View;

class ArticleController extends Controller
{
    protected string $layout = 'admin';

    protected function access(): bool
    {
        return Auth::isLoggedIn();
    }
    
    protected function accessDeny()
    {
        Request::redirect(Auth::LOGIN_URL);
    }

    public function index()
    {
        $this->view->setMeta('title', 'Articles');
        $this->view->setMeta('header', 'Articles');
        $this->view->setMeta('headerClass', 'bg-info');
        $this->view->render('admin/list', [
            'page'      => new Pagination(Article::class, 3),
            'entity'    => 'Post',
            'createUrl' => Router::url('article-create'),
            'tableUrl'  => Router::url('article-table'),
        ]);
    }

    public function create()
    {
        $options = [];
        foreach (Category::all() as $cat) {
            $options[] = [
                'key'   => $cat->id,
                'value' => $cat->title,    
            ];
        }

        $form = Form::open(['action' => Router::url('article-store'), 'enctype' => 'multipart/form-data']);
        $form .= Form::input(['name' => 'title', 'id' => 'formPostTitle', 'placeholder' => 'Enter title'], 'Title');
        $form .= Form::select($options, ['name' => 'category_id', 'id' => 'formPostCategory'], 'Category');
        $form .= Form::text(['name' => 'post', 'id' => 'formPostBody', 'placeholder' => 'Enter body'], 'Post');
        $form .= Form::file(['name' => 'img', 'id' => 'formPostPhoto'], 'Photo');
        $form .= Form::submit('Save');
        $form .= Form::close();

        echo $form;
    }

    public function store()
    {
        $v = new Validation(Request::post());
        $v->rule('title', new NotEmpty);
        $v->rule('title', new Unique(Article::class, 'title'));
        $v->rule('category_id', new NotEmpty);
        $v->rule('post', new Always);
        
        if (!$v->validate()) {
            Flash::addError('Article not added!');
            Request::redirect();
        };

        $article = new Article;
        $article->title       = $v->cleanedData['title'];
        $article->post        = $v->cleanedData['post'];
        $article->category_id = $v->cleanedData['category_id'];
        $article->user_id     = Auth::user()->id;
        $article->setImage();
        $article->save();

        unset($_SESSION['old']);
        Flash::addSuccess('Article added!');
        Request::redirect();
    }

    public function edit(Article $article)
    {
        $options = [];
        foreach (Category::all() as $cat) {
            $options[] = [
                'key'   => $cat->id,
                'value' => $cat->title,
                'cur'   => $cat->id == $article->category_id,   
            ];
        }

        $form = Form::open([
            'id'      => 'mainForm',
            'action'  => Router::url('article-update', ['id' => $article->id]),
            'enctype' => 'multipart/form-data',
        ]);
        $form .= Form::input(['name' => 'title', 'value' => $article->title, 'id' => 'formPostTitle', 'placeholder' => 'Enter title'], 'Title');
        $form .= Form::select($options, ['name' => 'category_id', 'id' => 'formPostCategory'], 'Category');
        $form .= Form::textarea(['name' => 'post', 'id' => 'formPostBody', 'placeholder' => 'Enter post'], 'Post', $article->post);
        $form .= Form::file(['name' => 'img', 'value' => $article->img, 'id' => 'formPostPhoto'], 'Photo');
        $form .= Form::close();

        $this->view->setMeta('title', $article->title);
        $this->view->setMeta('header', $article->title);
        $this->view->setMeta('headerClass', 'bg-secondary');
        $this->view->render('admin/edit', [
            'object'      => $article,
            'form'        => $form,
            'entity'      => 'Post',
            'backUrl'     => Router::url('articles', ['id' => $article->id]),
            'saveUrl'     => Router::url('article-update', ['id' => $article->id]),
            'deleteUrl'   => Router::url('article-delete', ['id' => $article->id]),
        ]);
    }

    public function update(Article $article)
    {
        $v = new Validation(Request::post());
        $v->rule('title', new NotEmpty);
        $v->rule('title', new Unique(Article::class, 'title', $article->title));
        $v->rule('category_id', new NotEmpty);
        $v->rule('post', new Always);
        
        if (!$v->validate()) {
            Flash::addError('Article not updated!');
            Request::redirect();
        };

        $article->title       = $v->cleanedData['title'];
        $article->post        = $v->cleanedData['post'];
        $article->category_id = $v->cleanedData['category_id'];
        $article->setImage();
        
        if ($article->save()) {
            Flash::addSuccess('Article updated!');
        }

        Request::redirect();
    }

    public function delete(Article $article)
    {
        $article->delete();
        
        Flash::addSuccess('Article deleted!');
        Request::redirect(Router::url('articles'));
    }

    public function table()
    {
        $this->view->renderPart('admin/article/table', [
            'page' => new Pagination(Article::class, 5)
        ]);
    }
}
