<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\Validation;
use Home\CmsMini\Validator\{Alphanumeric, Always, NotEmpty, Email, Equal, Unique};

class ArticleController extends Controller
{
    protected string $layout = 'layouts/secondary';

    protected function access(): bool
    {
        return Auth::isLoggedIn();
    }
    
    protected function accessDeny()
    {
        return $this->redirect(Auth::LOGIN_URL);
    }

    public function actionList()
    {
        $articles = Article::all();
        
        $this->header = 'Articles';
        $this->title = 'Articles' . ' | ' . $this->title;
        
        return $this->render('admin/article/list', compact('articles'));
    }

    public function actionCreate()
    {
        if (!$this->isPost()) {
            $this->redirect('article/list');
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $validation = new Validation($_POST['article']);
        $validation
            ->add('title', new NotEmpty)
            ->add('title', new Unique(Article::class, 'title'))
            ->add('category_id', new NotEmpty)
            ->add('post', new Always)
            ->validate();
        
        if ($validation->hasErrors) {
            Flash::addError('Article not added!');
            $this->redirect('article/list');
        };
    
        $article = new Article;
        $article->title       = $validation->cleanedData['title'];
        $article->post        = $validation->cleanedData['post'];
        $article->category_id = $validation->cleanedData['category_id'];
        $article->user_id     = Auth::userId();
        $article->save(array_keys($validation->cleanedData));

        Flash::addSuccess('Article added!');

        $this->redirect('article/list');
    }

    public function actionUpdate(int $id)
    {
        $article = Article::get($id);
        $categories = Category::all();
        $showError = false;
        $errors = [];

        $this->header = $article->title;

        if ($this->isPost()) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $validation = new Validation($_POST['article']);
            $validation
                ->add('title', new NotEmpty)
                ->add('category_id', new NotEmpty)
                ->add('post', new Always)
                ->validate();
            
            if (!$validation->hasErrors) {
                $article->title = $validation->cleanedData['title'];
                $article->category_id = $validation->cleanedData['category_id'];
                $article->post = $validation->cleanedData['post'];
                $article->save(array_keys($validation->cleanedData));
    
                Flash::addSuccess('Article updated!');
                $this->redirect('article/list');                                     
            };
            // Errors
            $showError = true;
            $errors = $validation->errors;

            Flash::addError('Article not updated!');
        }

        return $this->render('admin/article/update', compact('article', 'categories', 'showError', 'errors'));
    }

    public function actionDelete(int $id)
    {
        $article = Article::get($id);
        $article->delete();

        Flash::addSuccess('Article deleted!');
        return $this->redirect('article/list');
    }
}
