<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
    <?php
        use \Home\CmsMini\Auth;
        use \Home\CmsMini\App;

        $menu = include CONFIG . '/menu.php';
        $currentUrl = App::$route['url'];
        $currentUrl = empty($currentUrl) ? '/' : $currentUrl;
        foreach ($menu as $item) :
            if (isset($item['role']) && !Auth::{$item['role']}()) {
                continue;
            }
            $isCurrent = $currentUrl == $item['url'];
    ?>
        <li class="nav-item">
            <a 
                class="nav-link<?= $isCurrent ? ' active' : '' ?>"
                <?= $isCurrent ? 'aria-current="page"' : '' ?>
                href="<?= $item['url'] ?>"
            >
                <?= $item['title'] ?>
            </a>
        </li>
    <?php endforeach ?>
</ul>
