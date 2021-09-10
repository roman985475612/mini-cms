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
                                <use xlink:href="icons/sprite.svg#lock-solid"></use>
                            </svg>
                            change password
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-grid gap-2">
                        <a href="../../../../localhost/bootstrap/blogen/src/posts.html" class="btn btn-danger actions__btn">
                            <svg class="actions__icon">
                                <use xlink:href="icons/sprite.svg#trash-alt-solid"></use>
                            </svg>
                            delete account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- /.actions -->

<section class="profile">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4>edit profile</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name"value="John Doe">
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"value="jdoe@example.com">
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea class="form-control" id="bio" rows="3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Alias dicta ea mollitia consequatur doloribus suscipit aperiam laudantium quod voluptates eum repudiandae ex recusandae, ullam sequi!</textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 avatar">
                <h3 class="avatar__title">your avatar</h3>
                <picture>
                    <source srcset="img/avatar.webp" type="image/webp">
                    <img src="../../../../localhost/bootstrap/blogen/src/img/avatar.png" alt="avatar" class="avatar__img">
                </picture>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary avatar__btn" type="button">edit image</button>
                    <button class="btn btn-danger avatar__btn" type="button">delete image</button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.detail -->
