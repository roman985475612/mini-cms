<?php

namespace App\Controller\Admin;

use App\Model\Post;
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

class PostController extends Controller
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
        $this->view->setMeta('title', 'Posts');
        $this->view->setMeta('header', 'Posts');
        $this->view->setMeta('headerClass', 'bg-info');
        $this->view->render('admin/list', [
            'page'      => new Pagination(Post::class, 3),
            'entity'    => 'Post',
            'createUrl' => Router::url('post-create'),
            'tableUrl'  => Router::url('post-table'),
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

        $form = Form::open(['id' => 'createForm', 'action' => Router::url('post-store'), 'enctype' => 'multipart/form-data']);
        $form .= Form::input(['name' => 'title', 'id' => 'formPostTitle', 'placeholder' => 'Enter title'], 'Title');
        $form .= Form::select($options, ['name' => 'category_id', 'id' => 'formPostCategory'], 'Category');
        $form .= Form::textarea(['name' => 'content', 'id' => 'postContent', 'placeholder' => 'Enter content'], 'Content');
        $form .= Form::file(['name' => 'image', 'id' => 'postImage'], 'Image');
        $form .= Form::submit('Save');
        $form .= Form::close();

        echo $form;
    }

    public function store()
    {
        $v = new Validation(Request::post());
        $v->rule('title', new NotEmpty);
        $v->rule('title', new Unique(Post::class, 'title'));
        $v->rule('category_id', new NotEmpty);
        $v->rule('content', new Always);
        
        if (!$v->validate()) {
            Flash::addError('Post not added!');
            Request::redirect();
        };

        $post = new Post;
        $post->title       = $v->cleanedData['title'];
        $post->content     = $v->cleanedData['content'];
        $post->category_id = $v->cleanedData['category_id'];
        $post->user_id     = Auth::user()->id;
        $post->setImage();
        $post->save();

        unset($_SESSION['old']);
        Flash::addSuccess('Post added!');
        Request::redirect();
    }

    public function edit(Post $post)
    {
        $options = [];
        foreach (Category::all() as $cat) {
            $options[] = [
                'key'   => $cat->id,
                'value' => $cat->title,
                'cur'   => $cat->id == $post->category_id,   
            ];
        }

        $form = Form::open([
            'id'      => 'mainForm',
            'action'  => Router::url('post-update', ['id' => $post->id]),
            'enctype' => 'multipart/form-data',
        ]);
        $form .= Form::input(['name' => 'title', 'value' => $post->title, 'id' => 'formPostTitle', 'placeholder' => 'Enter title'], 'Title');
        $form .= Form::select($options, ['name' => 'category_id', 'id' => 'formPostCategory'], 'Category');
        $form .= Form::textarea(['name' => 'content', 'id' => 'postContent', 'placeholder' => 'Enter content'], 'Post', $post->content);
        $form .= Form::file(['name' => 'image', 'value' => $post->image, 'id' => 'postImage'], 'Image');
        $form .= Form::close();

        $this->view->setMeta('title', $post->title);
        $this->view->setMeta('header', $post->title);
        $this->view->setMeta('headerClass', 'bg-secondary');
        $this->view->render('admin/edit', [
            'object'      => $post,
            'form'        => $form,
            'entity'      => 'Post',
            'backUrl'     => Router::url('posts', ['id' => $post->id]),
            'saveUrl'     => Router::url('post-update', ['id' => $post->id]),
            'deleteUrl'   => Router::url('post-delete', ['id' => $post->id]),
        ]);
    }

    public function update(Post $post)
    {
        $v = new Validation(Request::post());
        $v->rule('title', new NotEmpty);
        $v->rule('title', new Unique(Post::class, 'title', $post->title));
        $v->rule('category_id', new NotEmpty);
        $v->rule('content', new Always);
        
        if (!$v->validate()) {
            Flash::addError('Post not updated!');
            Request::redirect();
        };

        $post->title       = $v->cleanedData['title'];
        $post->content     = $v->cleanedData['content'];
        $post->category_id = $v->cleanedData['category_id'];
        $post->setImage();
        
        if ($post->save()) {
            Flash::addSuccess('Post updated!');
        }

        Request::redirect();
    }

    public function delete(Post $post)
    {
        $post->delete();
        
        Flash::addSuccess('Post deleted!');
        Request::redirect(Router::url('posts'));
    }

    public function table()
    {
        $this->view->renderPart('admin/post/table', [
            'page' => new Pagination(Post::class, 5)
        ]);
    }
}
