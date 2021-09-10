<?php
use Home\CmsMini\Router;

$this->renderPart('admin/header');
?>

<section class="actions">
    <div class="container">
        <div class="row actions__btns">
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a href="<?= $backUrl ?>" class="btn btn-info actions__btn">
                        <svg class="actions__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#arrow-circle-left-solid"></use>
                        </svg>
                        back to dashboard
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <button id="btnSave"
                            class="btn btn-success actions__btn">
                        <svg class="actions__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#check-circle-solid"></use>
                        </svg>
                        save changes
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a onclick="return confirm('Are you sure?')" 
                       href="<?= $deleteUrl ?>" 
                       class="btn btn-danger actions__btn"
                       >
                        <svg class="actions__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#trash-alt-solid"></use>
                        </svg>
                        delete <?= $entity ?>
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
                        <h4>edit <?= $entity ?></h4>
                    </div>
                    <div class="card-body">
                        <?= $form ?>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</section>
<!-- /.detail -->

<script>
window.addEventListener('DOMContentLoaded', () => {
    const btnSave = document.querySelector('#btnSave')
    const form = document.querySelector('#mainForm')

    btnSave.addEventListener('click', () => {
        form.submit()
    })
})
</script>