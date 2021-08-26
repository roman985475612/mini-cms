<?php
use \Home\CmsMini\Router;
?>
    
<header class="main-header py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="main-header__title">
                    <svg class="main-header__icon">
                        <use xlink:href="/assets/admin/icons/sprite.svg#cog-solid"></use>
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
                    <a class="btn btn-primary actions__btn" id="addArticle">
                        <svg class="actions__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#plus-circle-solid"></use>
                        </svg>
                        add article
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a class="btn btn-success actions__btn" 
                       data-title="Create category"
                       data-url="<?= Router::url('category-create') ?>">
                        <svg class="actions__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#plus-circle-solid"></use>
                        </svg>
                        add category
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a class="btn btn-warning actions__btn" id="addUser">
                        <svg class="actions__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#plus-circle-solid"></use>
                        </svg>
                        add user
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.actions -->

<section class="posts">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4>latest posts</h4>
                    </div>
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
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <th scope="row"><?= $article->id ?></th>
                                <td><?= $article->title ?></td>
                                <td><?= $article->category ?></td>
                                <td><?= $article->author ?></td>
                                <td><?= $article->created_at ?></td>
                                <td>
                                    <a href="<?= Router::url('article-edit', ['id' => $article->id]) ?>" class="btn btn-warning posts__btn">
                                        <svg class="icon">
                                            <use xlink:href="/assets/admin/icons/sprite.svg#angle-double-right-solid"></use>
                                        </svg>            
                                        update
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-3 widgets">
                <div class="card widgets__item widgets__item--primary">
                    <div class="card-body">
                        <h3 class="widgets__title">posts</h3>
                        <div class="widgets__box">
                            <svg class="widgets__icon">
                                <use xlink:href="/assets/admin/icons/sprite.svg#pencil-alt-solid"></use>
                            </svg>
                            <span class="widgets__info"><?= $counts['article'] ?></span>    
                        </div>
                        <a href="<?= Router::url('articles') ?>" class="btn btn-outline-light">view</a>
                    </div>
                </div>
                <div class="card widgets__item widgets__item--success">
                    <div class="card-body">
                        <h3 class="widgets__title">categories</h3>
                        <div class="widgets__box">
                            <svg class="widgets__icon">
                                <use xlink:href="/assets/admin/icons/sprite.svg#folder-solid"></use>
                            </svg>
                            <span class="widgets__info"><?= $counts['category'] ?></span>    
                        </div>
                        <a href="<?= Router::url('categories') ?>" class="btn btn-outline-light">view</a>
                    </div>
                </div>
                <div class="card widgets__item widgets__item--warning">
                    <div class="card-body">
                        <h3 class="widgets__title">users</h3>
                        <div class="widgets__box">
                            <svg class="widgets__icon">
                                <use xlink:href="/assets/admin/icons/sprite.svg#users-solid"></use>
                            </svg>
                            <span class="widgets__info"><?= $counts['user'] ?></span>    
                        </div>
                        <a href="<?= Router::url('users') ?>" class="btn btn-outline-light">view</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.posts -->

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"></div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

<script>
window.addEventListener('DOMContentLoaded', () => {
    const openBtns = document.querySelector('.actions__btns')
    const $modal = document.querySelector('#formModal')
    const $body = $modal.querySelector('.modal-body')
    const $title = $modal.querySelector('.modal-title')
    const adminModal = new bootstrap.Modal($modal)

    openBtns.addEventListener('click', async e => {
        if (!e.target.classList.contains('actions__btn')) {
            return false
        }

        let url = e.target.dataset.url
        let title = e.target.dataset.title

        let response = await fetch(url);
        
        if (!response.ok) {
            alert("Ошибка HTTP: " + response.status);
        }
        let $form = await response.text();

        $title.innerHTML = title
        $body.innerHTML = $form

        adminModal.show();
    })

})
</script>

<script src="/assets/admin/js/ckeditor.js"></script>
    <script>
        window.addEventListener('load', () => {
            window.addEventListener('load', () => {
            ClassicEditor
                .create(document.querySelector( 'textarea' ))
                .catch( error => {
                    console.error( error );
                })
            })
        })
</script>
