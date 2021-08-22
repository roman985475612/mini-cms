<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
    <?php
        use \Home\CmsMini\Auth;
        use \Home\CmsMini\App;

        $menu = include CONFIG . '/menu.php';
        $currentUrl = App::$route['url'];
        $currentUrl = empty($currentUrl) ? '/' : $currentUrl;

        $menu = array_filter($menu, function ($item) {
            return !isset($item['role']) || ( isset($item['role']) && Auth::{$item['role']}() );
        });

        $menu = array_values($menu);
        
        $menu = array_map(function ($item) use ($currentUrl) {
            $isCurrent = ($currentUrl == $item['url']);

            $item['class'] = $isCurrent ? ' active' : '';
            $item['aria'] = $isCurrent ? 'aria-current="page"' : '';

            unset($item['role']);
            return $item;
        }, $menu);
        
        foreach ($menu as $item) :
    ?>
        <li class="nav-item">
            <a 
                class="nav-link<?= $item['class'] ?>"
                <?= $item['aria'] ?>
                href="<?= $item['url'] ?>"
            >
                <?= $item['title'] ?>
            </a>
        </li>
    <?php endforeach ?>
</ul>
