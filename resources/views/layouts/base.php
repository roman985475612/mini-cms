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
                <?php $this->renderPart('menu') ?>
            </div>
        </div>
    </nav>
    <!-- /.navbar -->

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
    <script>
        if (document.querySelector('.slider__item')) {
            const slider = new Slider('.slider__item', 'slider__item--visible')
        }
        if (document.querySelector('.newsletter__form')) {
            const form1 = new Form('.newsletter__form')
        }
        if (document.querySelector('.contact__form')) {
            const form2 = new Form('.contact__form')
        }
        if (document.querySelector('.accord1')) {
            const accord1 = new Accord('.accord1')
        }
        if (document.querySelector('.accord2')) {
            const accord2 = new Accord('.accord2')
        }
    </script>
</body>
</html>