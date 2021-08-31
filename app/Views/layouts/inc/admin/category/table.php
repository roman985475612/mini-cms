<?php
use \Home\CmsMini\Router;
?>
<table class="table table-hover table-striped">
    <thead class="bg-dark text-white">
        <tr>
            <th scope="col">#</th>
            <th scope="col">title</th>
            <th scope="col">date</th>
            <th scope="col">action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($page->objects as $category): ?>
            <tr>
                <th scope="row"><?= $category->id ?></th>
                <td><?= $category->title ?></td>
                <td><?= $category->created_at ?></td>
                <td>
                    <a href="<?= Router::url('category-edit', ['id' => $category->id]) ?>" class="btn btn-success posts__btn">
                        <svg class="icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#angle-double-right-solid"></use>
                        </svg>
                        detail
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php $page->render('admin/pagination') ?>
