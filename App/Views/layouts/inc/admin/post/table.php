<?php
use \Home\CmsMini\Router;
?>
<table class="table table-hover table-striped">
    <thead class="bg-dark text-white">
        <tr>
            <th scope="col">#</th>
            <th scope="col" style="width: 20%">image</th>
            <th scope="col">title</th>
            <th scope="col">category</th>
            <th scope="col">author</th>
            <th scope="col">date</th>
            <th scope="col">action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($page->objects as $post): ?>
        <tr>
            <th scope="row"><?= $post->id ?></th>
            <td>
                <img
                    class="img-fluid img-thumbnail"
                    src="<?= $post->getImage() ?>"
                    alt="<?= $post->title ?>">
            </td>
            <td><?= $post->title ?></td>
            <td><?= $post->getCategory() ?></td>
            <td><?= $post->getAuthor() ?></td>
            <td><?= $post->getDate() ?></td>
            <td>
                <a href="<?= Router::url('post-edit', ['id' => $post->id]) ?>" class="btn btn-warning posts__btn">
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