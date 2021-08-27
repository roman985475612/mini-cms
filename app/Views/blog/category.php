<?php
use Home\CmsMini\Router;

$this->renderPart('page-header') 
?>

<section class="blog mt-3">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($articles as $article): ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="<?= $article->getImage() ?>" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <a href="<?= Router::url('blog-by-category', ['id' => $article->getCategory()->id]) ?>" class="btn btn-outline-primary text-capitalize btn-sm my-2"><?= $article->getCategory() ?></a>
                        <h5 class="card-title text-capitalize"><?= $article->title ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Writen by <?= $article->getAuthor() ?> on <?= $article->getDate() ?></h6>
                        <hr>
                        <p class="card-text"><?= $article->getExcerpt() ?></p>
                        <a href="<?= Router::url('blog-show', ['id' => $article->id]) ?>" class="btn btn-secondary">Read more...</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        </div>
    </div>
</section>
<!-- /.blog -->