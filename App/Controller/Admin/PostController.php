<?php

namespace App\Controller\Admin;

use App\Model\Post;
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
use Home\CmsMini\Validator\{Always, NotEmpty, Unique};

class PostController extends Controller
{
    protected string $layout = 'admin';

    protected function access(): bool
    {
        return Auth::isAdmin();
    }

    public function index()
    {
        $this->view->setMeta('title', 'Posts');
        $this->view->setMeta('header', 'Posts');
        $this->view->setMeta('headerClass', 'bg-info');
        $this->view->render('admin/list', [
            'page'      => new Pagination(Post::query(), 3),
            'entity'    => 'Post',
            'createUrl' => Router::url('post-create'),
            'tableUrl'  => Router::url('post-table'),
            'uploadUrl' => Router::url('postUploadForm'),
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
        $v = new Validation(App::request()->post());
        $v->rule('title', new NotEmpty);
        $v->rule('title', new Unique(Post::class, 'title'));
        $v->rule('category_id', new NotEmpty);
        $v->rule('content', new Always);
        
        if (!$v->validate()) {
            App::request()->setOld($v->sourceData);
            App::request()->setErrors($v->errors);
            App::request()->redirect();
            Flash::addError('Post not added!');
        };

        $post = new Post;
        $post->recordModeEnable();
        $post->title       = $v->cleanedData['title'];
        $post->content     = $v->cleanedData['content'];
        $post->category_id = $v->cleanedData['category_id'];
        $post->setAuthor();
        $post->setImage();
        $post->save();

        Flash::addSuccess('Post added!');

        App::request()->redirect();
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
        $v = new Validation(App::request()->post());
        $v->rule('title', new NotEmpty);
        $v->rule('title', new Unique(Post::class, 'title', $post->title));
        $v->rule('category_id', new NotEmpty);
        $v->rule('content', new Always);
        
        if (!$v->validate()) {
            Flash::addError('Post not updated!');
            App::request()->setOld($v->sourceData);
            App::request()->setErrors($v->errors);
            App::request()->redirect();
        };

        $post->recordModeEnable();
        $post->title       = $v->cleanedData['title'];
        $post->content     = $v->cleanedData['content'];
        $post->category_id = $v->cleanedData['category_id'];
        $post->setImage();
        
        if ($post->save()) {
            Flash::addSuccess('Post updated!');
        }

        App::request()->redirect();
    }

    public function delete(Post $post)
    {
        $post->delete();
        
        Flash::addSuccess('Post deleted!');
        App::request()->redirect(Router::url('posts'));
    }

    public function table()
    {
        $this->view->renderPart('admin/post/table', [
            'page' => new Pagination(Post::query(), 5)
        ]);
    }

    public function uploadForm()
    {
        $form = Form::open(['action' => Router::url('postUpload'), 'enctype' => 'multipart/form-data']);
        $form .= Form::file(['name' => 'dataFile', 'id' => 'uploadFile'], 'JSON');
        $form .= Form::file(['name' => 'images[]', 'id' => 'uploadImages', 'multiple' => ''], 'Images');
        $form .= Form::submit('Upload');
        $form .= Form::close();

        echo $form;
    }

    public function upload()
    {
        $imageNames = [];
        $files = File::factory('images');
        foreach ($files as $file) {
            $file->setNewName();
            $file->moveToStorage();
            $imageNames[$file->name] = $file->getNewName();
        }

        $dataFile = new File(App::request()->files('dataFile'));
        $content = file_get_contents($dataFile->getTempName());
        if ($dataFile->isJson()) {
            $result = json_decode($content, true);
        } elseif ($dataFile->isXml()) {
            $result = new \SimpleXMLElement($content);
        }

        foreach ($result as $item) {
            $v = new Validation($item);
            $v->rule('title', new NotEmpty);
            $v->rule('title', new Unique(Post::class, 'title'));
            $v->rule('category', new NotEmpty);
            $v->rule('content', new Always);

            if (!$v->validate()) {
                Flash::addError("Post \"{$item['title']}\" not uploaded!");
                continue;
            };

            $post = new Post;
            $post->recordModeEnable();
            $post->title = $item['title'];
            $post->content = $item['content'];
            $post->image = $imageNames[$item['image']];
            $post->setCategory(Category::find('title', $item['category'])->one());
            $post->setAuthor();
            $post->save();

            Flash::addSuccess("Post \"{$post->title}\" created!");
        }

        App::request()->redirect();
    }
}
