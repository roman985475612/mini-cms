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

    public function actionCreate()
    {
        if (!$this->isPost()) {
            $this->redirect('admin');
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        $validation = new Validation($_POST['article']);
        $validation
            ->add('title', new NotEmpty)
            ->add('title', new Unique(Article::class, 'title'))
            ->add('category', new NotEmpty)
            ->add('post', new Always)
            ->validate();
        
        if ($validation->hasErrors) {
            Flash::addError('Article not added!');
            $this->redirect('admin');
        };
    
        $article = new Article;
        $article->title = $validation->cleanedData['title'];
        $article->post = $validation->cleanedData['post'];
        $article->category_id = $validation->cleanedData['category'];
        $article->user_id = Auth::userId();
        $article->save();

        Flash::addSuccess('Article added!');

        $this->redirect('admin');
    }

    public function actionUpdate(int $id)
    {
        $article = Article::findOne($id);
        $this->header = $article->title;

        return $this->render('admin/article/update', compact('article'));
    }

    public function actionDelete(int $id)
    {
        $article = Article::findOne($id);
        $article->delete();

        return $this->redirect('admin');
    }
}
