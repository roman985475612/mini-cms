<?php
use \Home\CmsMini\Router;
?>
<table class="table table-hover table-striped">
    <thead class="bg-dark text-white">
        <tr>
            <th scope="col">#</th>
            <th scope="col" style="width: 20%">image</th>
            <th scope="col">username</th>
            <th scope="col">email</th>
            <th scope="col">role</th>
            <th scope="col">Registration</th>
            <th scope="col">action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($page->objects as $user): ?>
        <tr>
            <th scope="row"><?= $user->id ?></th>
            <td>
                <img
                    class="img-thumbnail"
                    style="border-radius: 50%"
                    src="<?= $user->getImage() ?>"
                    alt="<?= $user->username ?>">
            </td>
            <td><?= $user->username ?></td>
            <td><?= $user->email ?></td>
            <td><?= $user->role ?></td>
            <td><?= $user->getDate() ?></td>
            <td>
                <a 
                    href="<?= Router::url('user-edit', ['id' => $user->id]) ?>" 
                    class="btn btn-warning posts__btn">
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