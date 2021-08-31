<?php
use \Home\CmsMini\Router;
?>
<table class="table table-hover table-striped">
    <thead class="bg-dark text-white">
        <tr>
            <th scope="col">#</th>
            <th scope="col">title</th>
            <th scope="col">category</th>
            <th scope="col">author</th>
            <th scope="col">date</th>
            <th scope="col">action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($page->objects as $article): ?>
        <tr>
            <th scope="row"><?= $article->id ?></th>
            <td><?= $article->title ?></td>
            <td><?= $article->getCategory() ?></td>
            <td><?= $article->getAuthor() ?></td>
            <td><?= $article->getDate() ?></td>
            <td>
                <a href="<?= Router::url('article-edit', ['id' => $article->id]) ?>" class="btn btn-warning posts__btn">
                    <svg class="icon">
                        <use xlink:href="/assets/admin/icons/sprite.svg#angle-double-right-solid"></use>
                    </svg>
                    show
                </a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php $page->render('admin/pagination') ?>