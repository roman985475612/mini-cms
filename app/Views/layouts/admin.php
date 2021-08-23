<?php
    use Home\CmsMini\Auth;
    use Home\CmsMini\Flash;
    use Home\CmsMini\Router;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/admin/css/style.min.css">
    <title><?= $this->title ?></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark main-menu">
        <div class="container">
          <a class="navbar-brand" href="<?= Router::url('home'); ?>"><?= $this->brand ?></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php new \App\Widget\Menu(
                containerClass: 'navbar-nav me-auto mb-2 mb-lg-0',
                filename      : 'menu-admin'
            ) ?>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle main-menu__link" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg class="main-menu__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#user-solid"></use>
                        </svg>
                        Welcome, <?= Auth::user()->username ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
                        <li>
                            <a class="dropdown-item main-menu__dropdown-item" href="profile.html">
                                <svg class="main-menu__icon main-menu__icon--dropdown">
                                    <use xlink:href="/assets/admin/icons/sprite.svg#user-circle-regular"></use>
                                </svg>
                                profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item main-menu__dropdown-item" href="settings.html">
                                <svg class="main-menu__icon main-menu__icon--dropdown">
                                    <use xlink:href="/assets/admin/icons/sprite.svg#cog-solid"></use>
                                </svg>
                                settings
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link main-menu__link" href="<?= Router::url('logout'); ?>">
                        <svg class="main-menu__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#user-times-solid"></use>
                        </svg>
                        logout                
                    </a>
                </li>            
            </ul>
          </div>
        </div>
    </nav>

    <?php Flash::show() ?>

    <?= $content ?>

    <?php $this->renderPart('footer') ?>

<script src="/assets/admin/js/bootstrap.bundle.min.js"></script>
<script src="/assets/admin/js/main.min.js"></script>
</body>
</html>