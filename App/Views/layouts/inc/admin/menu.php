<ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <?php foreach ($menu as $item): ?>
        <li class="nav-item">
            <a 
                class="<?= $item['class'] ?>"
                <?= $item['aria'] ?>
                href="<?= $item['url'] ?>"
            >
                <?= $item['title'] ?>
            </a>
        </li>
    <?php endforeach ?>
</ul>
