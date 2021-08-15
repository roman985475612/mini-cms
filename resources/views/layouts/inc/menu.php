<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
    <?php
        $menu = json_decode(file_get_contents(CONFIG . '/menu.json'), true);
        foreach ($menu as $item) : 
            $current = ($item['controller'] == $this->controller && $item['action'] == $this->action);
    ?>
        <li class="nav-item">
            <a 
                class="nav-link <?= $current ? ' active' : '' ?>"
                <?php if ($current): ?>
                    aria-current="page" 
                <?php endif ?>
                href="/<?= $item['action'] ?>"
            >
                <?= $item['title'] ?>
            </a>
        </li>
    <?php endforeach ?>
</ul>
