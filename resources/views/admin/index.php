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
                    <a class="btn btn-success actions__btn" id="addCategory">
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
                                    <a href="/article-admin/update/<?= $article->id ?>" class="btn btn-warning posts__btn">
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
                        <a href="posts.html" class="btn btn-outline-light">view</a>
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
                        <a href="categories.html" class="btn btn-outline-light">view</a>
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
                        <a href="users.html" class="btn btn-outline-light">view</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.posts -->

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
