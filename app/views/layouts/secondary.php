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
          <a class="navbar-brand" href="index.html"><?= $this->brand ?></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link main-menu__link active" aria-current="page" href="index.html">dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link main-menu__link" href="posts.html">posts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link main-menu__link" href="categories.html">categories</a>
              </li>
              <li class="nav-item">
                <a class="nav-link main-menu__link" href="users.html">users</a>
              </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle main-menu__link" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg class="main-menu__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#user-solid"></use>
                        </svg>
                        Welcome, Admin
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
                    <a class="nav-link main-menu__link" href="login.html">
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

    <header class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="main-header__title">
                        <svg class="main-header__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#cog-solid"></use>
                        </svg>
                        <?= $this->header ?>
                    </h1>
                </div>
            </div>
        </div>
    </header>
    <!-- /.main-header -->

    <?= $content ?>

    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="main-footer__copy">
                        Copyright &copy; 2021 Blogen
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- /.main-footer -->

    <script src="/assets/admin/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/js/main.min.js"></script>
</body>
</html>