<?php
use \Home\CmsMini\Router;

$this->renderPart('admin/header');
?>

<section class="actions">
    <div class="container">
        <div class="row actions__btns">
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a href="../../../../localhost/bootstrap/blogen/src/posts.html" class="btn btn-info actions__btn">
                        <svg class="actions__icon">
                            <use xlink:href="icons/sprite.svg#arrow-circle-left-solid"></use>
                        </svg>
                        back to dashboard
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a href="../../../../localhost/bootstrap/blogen/src/posts.html" class="btn btn-success actions__btn">
                        <svg class="actions__icon">
                            <use xlink:href="icons/sprite.svg#check-circle-solid"></use>
                        </svg>
                        save changes
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.actions -->

<section class="settings">
    <div class="container">
        <div class="row">
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <h4>edit settings</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="allowUserRegistr" checked>
                                <label class="form-check-label" for="allowUserRegistr">allow user registration</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="homePage" checked>
                                <label class="form-check-label" for="homePage">home page format</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.detail -->
