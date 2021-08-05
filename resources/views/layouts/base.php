<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="<?= $this->keywords ?>">
    <meta name="description" content="<?= $this->description ?>">
    <link rel="stylesheet" href="/assets/front/css/all.min.css">
    <link rel="stylesheet" href="/assets/front/css/style.min.css">
    <title><?= $this->title ?></title>
</head>
<body>
    <nav id="sectionTop" class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/"><?= $this->brand ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">about us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.html">services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="blog.html">blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- /.navbar -->

    <header class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6 page-header__container">
                    <h1 class="page-header__title"><?= $this->pageTitle ?></h1>
                    <p class="page-header__text"><?= $this->pageSubTitle ?></p>
                </div>
            </div>
        </div>
    </header>
    <!-- /.page-header -->

    <?= $content ?>

    <footer class="main-footer">
        <div class="conteiner">
            <div class="row">
                <div class="col">
                    <p>Copyright &copy; 2021 <?= $this->brand ?></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- /.main-footer -->

    <script src="/assets/front/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/front/js/main.min.js"></script>
</body>
</html>