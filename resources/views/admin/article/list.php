<?php $this->getTemplatePart('searchBar') ?>

<section class="posts">
    <div class="container">
        <div class="row">
            <div class="col-9 m-auto">
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
                                    <a href="<?= $article->getUpdateUrl() ?>" class="btn btn-primary text-uppercase posts__btn">
                                        update
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>

                    <nav class="m-auto" aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.posts -->
