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
          <a class="navbar-brand" href="/"><?= $this->brand ?></a>
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
                        Copyright &copy; 2021 <?= $this->brand ?>
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