<?php
use Home\CmsMini\Router;

$this->renderPart('admin/header', compact('headerClass'));

$this->renderPart('admin/search-bar') 
?>

<section class="posts">
    <div class="container">
        <div class="row">
            <div class="col-9 m-auto">
                <div class="card">
                    <div class="card-header">
                        <button
                           id="openBtn" 
                           class="btn btn-outline-success"
                           data-url="<?= $createUrl ?>"
                           data-title="Create <?= $entity ?>"
                           >
                            Add new <?= $entity ?>
                        </button>
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
                        <?php foreach ($page->objects as $article): ?>
                            <tr>
                                <th scope="row"><?= $article->id ?></th>
                                <td><?= $article->title ?></td>
                                <td><?= $article->getCategory() ?></td>
                                <td><?= $article->getAuthor() ?></td>
                                <td><?= $article->created_at ?></td>
                                <td>
                                    <a href="<?= Router::url('article-edit', ['id' => $article->id]) ?>" 
                                       class="btn btn-outline-primary text-uppercase">
                                        show
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>

                    <?php $page->render('admin/pagination') ?>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.posts -->

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
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
    const openBtn = document.querySelector('#openBtn')
    const $modal = document.querySelector('#formModal')
    const $body = $modal.querySelector('.modal-body')
    const $title = $modal.querySelector('.modal-title')
    const adminModal = new bootstrap.Modal($modal)

    openBtn.addEventListener('click', async e => {
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
