<?php
use Home\CmsMini\Router;

$this->renderPart('admin/header');

$this->renderPart('admin/search-bar') 
?>

<section class="posts">
    <div class="container">
        <div class="row">
            <div class="col-9 m-auto">
                <div class="card">
                    <div id="openBtn" class="card-header">
                        <button class="btn btn-outline-success openBtn"
                                data-url="<?= $createUrl ?>"
                                data-title="Create <?= $entity ?>"
                                >
                            Add new <?= $entity ?>
                        </button>
                        <button class="btn btn-outline-secondary openBtn"
                                data-url="<?= $uploadUrl ?>"
                                data-title="Upload <?= $entity ?>"
                                >
                            Upload <?= $entity ?>
                        </button>
                    </div>
                    <div id="content" data-content-url="<?= $tableUrl ?>"></div>
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
    getTable()

    const openBtn = document.querySelector('#openBtn')
    const $modal = document.querySelector('#formModal')
    const $body = $modal.querySelector('.modal-body')
    const $title = $modal.querySelector('.modal-title')
    const adminModal = new bootstrap.Modal($modal)

    openBtn.addEventListener('click', async e => {
        if (!e.target.classList.contains('openBtn')) {
            return false
        }
        e.preventDefault()

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

async function getTable() {
    const $content = document.querySelector('#content')
    const contentUrl = $content.dataset.contentUrl

    let response = await fetch(contentUrl)

    if (!response.ok) {
        alert("Ошибка HTTP: " + response.status);
    }

    $content.innerHTML = await response.text();

    const $page = document.querySelector('.pagination')

    $content.addEventListener('click', async e => {
        if (!e.target.classList.contains('page-link')) {
            return false
        }
        e.preventDefault()

        let response = await fetch(e.target.href)

        if (!response.ok) {
            alert("Ошибка HTTP: " + response.status);
        }

        $content.innerHTML = await response.text();
    })
}
</script>
