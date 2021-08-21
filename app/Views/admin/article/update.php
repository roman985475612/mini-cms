<section class="actions">
    <div class="container">
        <div class="row actions__btns">
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a href="/admin" class="btn btn-info actions__btn">
                        <svg class="actions__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#arrow-circle-left-solid"></use>
                        </svg>
                        back to dashboard
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a href="posts.html" class="btn btn-success actions__btn">
                        <svg class="actions__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#check-circle-solid"></use>
                        </svg>
                        save changes
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a 
                        href="<?= $article->getDeleteUrl() ?>" 
                        class="btn btn-danger actions__btn"
                        onclick="return confirm('Are you sure?')"
                    >
                        <svg class="actions__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#trash-alt-solid"></use>
                        </svg>
                        delete post
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
                        <h4>edit post</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= $article->getUpdateUrl() ?>">
                            <div class="mb-3">
                                <label 
                                    for="articleTitle" 
                                    class="form-label"
                                >
                                    Title
                                </label>
                                <input
                                    name="article[title]" 
                                    type="text" 
                                    <?php if ($showError): ?>
                                        <?php if (isset($errors['title'])): ?>
                                            class="form-control is-invalid"
                                        <?php else: ?>
                                            class="form-control is-valid"
                                        <?php endif ?>
                                    <?php else: ?>
                                        class="form-control"
                                    <?php endif ?>
                                    id="articleTitle" 
                                    value="<?= $article->title ?>"
                                >
                                <?php if ($showError && isset($errors['title'])): ?>
                                    <div class="invalid-feedback"><?= $errors['title'] ?></div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label 
                                    for="postCat" 
                                    class="form-label"
                                >
                                    Category
                                </label>
                                <select 
                                    id="postCat" 
                                    name="article[category_id]"
                                    <?php if ($showError): ?>
                                        <?php if (isset($errors['category_id'])): ?>
                                            class="form-select is-invalid"
                                        <?php else: ?>
                                            class="form-select is-valid"
                                        <?php endif ?>
                                    <?php else: ?>
                                        class="form-select"
                                    <?php endif ?>
                                >
                                    <?php foreach ($categories as $cat): ?>
                                        <option 
                                            value="<?= $cat->id ?>"
                                            <?php if ($cat->id == $article->category_id): ?> selected<?php endif ?>
                                        >
                                            <?= $cat->title ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <?php if ($showError && isset($errors['category_id'])): ?>
                                    <div class="invalid-feedback"><?= $errors['category_id'] ?></div>
                                <?php endif ?>
                            </div>
                            <!-- <div class="mb-3">
                                <label for="formFile" class="form-label">Picture</label>
                                <input class="form-control" type="file" id="formFile">
                            </div>
                            <div class="mb-3">
                                <label for="articleExcerpt" class="form-label">Excerpt</label>
                                <textarea 
                                    class="form-control" 
                                    id="articleExcerpt" 
                                    rows="3"
                                ><?= $article->excerpt ?></textarea>
                            </div> -->
                            <div class="mb-3">
                                <label 
                                    for="articlePost" 
                                    class="form-label"
                                >
                                    Post
                                </label>
                                <textarea 
                                    <?php if ($showError): ?>
                                        <?php if (isset($errors['post'])): ?>
                                            class="form-control is-invalid"
                                        <?php else: ?>
                                            class="form-control is-valid"
                                        <?php endif ?>
                                    <?php else: ?>
                                        class="form-control"
                                    <?php endif ?>
                                    id="articlePost" 
                                    rows="3"
                                    name="article[post]"
                                ><?= $article->post ?></textarea>
                                <?php if ($showError && isset($errors['post'])): ?>
                                    <div class="invalid-feedback"><?= $errors['post'] ?></div>
                                <?php endif ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</section>
<!-- /.detail -->
