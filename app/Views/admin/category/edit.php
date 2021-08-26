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

<section class="actions">
    <div class="container">
        <div class="row actions__btns">
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a href="<?= Router::url('admin') ?>" class="btn btn-info actions__btn">
                        <svg class="actions__icon">
                            <use xlink:href="icons/sprite.svg#arrow-circle-left-solid"></use>
                        </svg>
                        back to dashboard
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a href="<?= Router::url('category-update', ['id' => $category->id]) ?>" class="btn btn-success actions__btn">
                        <svg class="actions__icon">
                            <use xlink:href="icons/sprite.svg#check-circle-solid"></use>
                        </svg>
                        save changes
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a href="<?= Router::url('category-delete', ['id' => $category->id]) ?>" class="btn btn-danger actions__btn">
                        <svg class="actions__icon">
                            <use xlink:href="icons/sprite.svg#trash-alt-solid"></use>
                        </svg>
                        delete category
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.actions -->

<section class="detail">
    <div class="container">
        <div class="row">
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <h4>edit category</h4>
                    </div>
                    <div class="card-body">
                        <?= $form->render() ?>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</section>
<!-- /.detail -->
