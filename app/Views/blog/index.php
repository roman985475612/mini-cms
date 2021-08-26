<?php
use Home\CmsMini\Router;
?>
<?php $this->renderPart('page-header') ?>

<section class="blog mt-3">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($page->objects as $article): ?>
            <div class="col-md-4">
                <div class="card h-100">
                <img src="<?= $article->img ?>" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <a href="<?= Router::url('blog-by-category', ['id' => $article->category->id]) ?>" class="btn btn-outline-primary text-capitalize btn-sm my-2"><?= $article->category ?></a>
                        <h5 class="card-title text-capitalize"><?= $article->title ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Writen by <?= $article->author ?> on <?= $article->updated_at ?></h6>
                        <hr>
                        <p class="card-text"><?= $article->excerpt ?></p>
                        <a href="<?= Router::url('blog-show', ['id' => $article->id]) ?>" class="btn btn-secondary">Read more...</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        </div>
        <div class="row">
            <div class="col-12">
                <?php $page->render('main-pagination') ?>
            </div>
        </div>
    </div>
</section>
<!-- /.blog -->
