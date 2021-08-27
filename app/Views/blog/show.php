<?php
use Home\CmsMini\Router;

$this->renderPart('page-header') 
?>

<section class="blog mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                <img src="<?= $article->getImage() ?>" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <a href="<?= Router::url('blog-by-category', ['id' => $article->getCategory()->id]) ?>" class="btn btn-outline-primary text-capitalize btn-sm my-2"><?= $article->getCategory() ?></a>
                        <h5 class="card-title text-capitalize"><?= $article->title ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Writen by <?= $article->getAuthor() ?> on <?= $article->getDate() ?></h6>
                        <hr>
                        <p class="card-text"><?= $article->post ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mt-3 mx-auto">
                <a href="/blog" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</section>
<!-- /.blog -->
