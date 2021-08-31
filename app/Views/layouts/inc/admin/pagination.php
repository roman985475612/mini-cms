<nav class="my-3 mx-auto">
    <ul class="pagination">
        
        <?php if ($page->isPrev): ?>
            <li class="page-item">
                <a class="page-link text-success" href="<?= $page->prev ?>">&lt;</a>
            </li>
        <?php endif ?>

        <?php foreach ($page->pages as $p): ?>
            <li class="page-item <?= $p->isCurrent ? 'active' : '' ?>">
                <a class="page-link <?= $p->isCurrent ? 'bg-success text-white' : 'text-success' ?>" href="<?= $p->href ?>">
                    <?= $p->title ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($page->isNext): ?>
            <li class="page-item">
                <a class="page-link text-success" href="<?= $page->next ?>">&gt;</a>
            </li>
        <?php endif ?>
    </ul>
</nav>
