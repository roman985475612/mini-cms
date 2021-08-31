<?php
use Home\CmsMini\FormBuilder as Form;
use Home\CmsMini\Router;
?>
<section class="newsletter">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="newsletter__title">sign up for our newsletter</h2>
                <p class="newsletter__text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero dignissimos nemo asperiores tempore reiciendis, dolore modi ex similique maiores quidem.</p>
                <?= Form::open([
                    'action'      => Router::url('subscribe'),
                    'class'       => 'row g-3 newsletter__form form',
                    'novalidate'  => '',
                ]) ?>
                <?= Form::text([
                    'id'          => 'newsletterName',
                    'name'        => 'newsletter[name]',
                    'class'       => 'form-control form__control',
                    'placeholder' => 'Enter name',
                    'data-valid'  => 'notEmpty',
                ], wrap: 'col-auto') ?>
                <?= Form::email([
                    'id'          => 'newsletterEmail',
                    'name'        => 'newsletter[email]',
                    'class'       => 'form-control form__control',
                    'placeholder' => 'Enter email',
                    'data-valid'  => 'email',
                ], wrap: 'col-auto') ?>
                <?= Form::submit('Subscribe', ['class' => 'btn btn-primary form__submit'], 'col-auto') ?>
                <?= Form::close() ?>
            </div>
        </div>
    </div>
</section>
<!-- /.newsletter -->
