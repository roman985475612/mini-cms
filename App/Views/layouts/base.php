<?php
use App\Widget\Menu;
use Home\CmsMini\Flash;
use Home\CmsMini\Router;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="<?= $this->getMeta('keywords') ?>">
    <meta name="description" content="<?= $this->getMeta('description') ?>">
    <link rel="stylesheet" href="/assets/front/css/all.min.css">
    <link rel="stylesheet" href="/assets/front/css/style.min.css">
    <title><?= $this->getMeta('title') ?></title>
</head>
<body>
    <nav id="sectionTop" class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= Router::url('home'); ?>"><?= $this->getMeta('brand') ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <?php new Menu(
                    filename: 'menu',
                    template: 'home/menu',
                ) ?>
            </div>
        </div>
    </nav>
    <!-- /.navbar -->
    <?php Flash::show() ?>

    <?= $content ?>

    <?php $this->renderPart('footer') ?>

<script src="/assets/front/js/bootstrap.bundle.min.js"></script>
<script src="/assets/front/js/main.min.js"></script>
<script>
    if (document.querySelector('.slider__item')) {
        const slider = new Slider('.slider__item', 'slider__item--visible')
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