<?php
use Home\CmsMini\Router;
?>
<header class="main-header main-header--success py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="main-header__title">
                    <svg class="main-header__icon">
                        <use xlink:href="/assets/admin/icons/sprite.svg#folder-solid"></use>
                    </svg>
                    <?= $this->header ?>
                </h1>
            </div>
        </div>
    </div>
</header>
<!-- /.main-header -->

<section class="search">
    <div class="container">
        <div class="row">
            <div class="col-6 m-auto">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search categories..." aria-label="Search categories..." aria-describedby="button-addon2">
                    <button class="btn btn-outline-success" type="button" id="button-addon2">Button</button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.search -->

<section class="posts">
    <div class="container">
        <div class="row">
            <div class="col-9 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4>latest categories</h4>
                    </div>
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

                    <?php $page->render('admin-cat-pagination') ?>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.posts -->
