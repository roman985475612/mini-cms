<?php
use Home\CmsMini\Flash;
use Home\CmsMini\FormBuilder as Form;
use Home\CmsMini\Router;
?>
<?php $this->renderPart('page-header') ?>

<section class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card p-4">
                    <div class="card-body">
                        <h4>Get In Touch</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia, aut?</p>
                        <h4>Address</h4>
                        <p>550 Main st, Boston MA</p>
                        <h4>Email</h4>
                        <p><a href="mailto:info@example.com">info@example.com</a></p>
                        <h4>Phone</h4>
                        <p><a href="tel:0123456789">+0 123 456 789</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card p-4">
                <?php Flash::show() ?>
                    <div class="card-body">
                        <h3 class="text-center">Please fill out this form to contact us</h3>
                        <hr>
                        <?= Form::open([
                            'id'          => 'contactForm2',
                            'action'      => Router::url('contact'),
                            'class'       => 'row g-3 contact__form form',
                            'novalidate'  => '',
                        ]) ?>
                        <?= Form::text([
                            'id'          => 'contactFirstName',
                            'name'        => 'firstname',
                            'class'       => 'form-control form__control',
                            'placeholder' => 'Enter first name',
                            'data-valid'  => 'notEmpty',
                        ], '', 'col-6') ?>
                        <?= Form::text([
                            'id'          => 'contactLastName',
                            'name'        => 'lastname',
                            'class'       => 'form-control form__control',
                            'placeholder' => 'Enter first name',
                            'data-valid'  => 'notEmpty',
                        ], '', 'col-6') ?>
                        <?= Form::email([
                            'id'          => 'contactEmail',
                            'name'        => 'email',
                            'class'       => 'form-control form__control',
                            'placeholder' => 'Enter email',
                            'data-valid'  => 'email',
                        ], '', 'col-6') ?>
                        <?= Form::phone([
                            'id'          => 'contactPhone',
                            'name'        => 'phone',
                            'class'       => 'form-control form__control',
                            'placeholder' => 'Enter phone',
                            'data-valid'  => 'notEmpty',
                        ], '', 'col-6') ?>
                        <?= Form::textarea([
                            'id'          => 'contactBody',
                            'name'        => 'body',
                            'rows'        => '3',
                            'class'       => 'form-control form__control',
                            'placeholder' => 'Enter body',
                            'data-valid'  => 'notEmpty',
                        ], '', '', 'col-12') ?>
                        <?= Form::submit('Send', ['class' => 'btn btn-outline-danger form__submit'], 'col-12') ?>
                        <?= Form::close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.contact -->

<section class="staff">
    <div class="container">
        <h2 class="staff__title">our staff</h2>
        <ul class="staff__list">
            <li class="staff__item">
                <picture>
                    <source srcset="/assets/img/person1.webp" type="image/webp">
                    <img src="/assets/img/person1.jpg" alt="" class="staff__img">
                </picture>
                <span class="staff__name">jane doe</span>
                <span class="staff__job">marketing manager</span>
            </li>
            <li class="staff__item">
                <picture>
                    <source srcset="/assets/img/person2.webp" type="image/webp">
                    <img src="/assets/img/person2.jpg" alt="" class="staff__img">
                </picture>
                <span class="staff__name">sarah williams</span>
                <span class="staff__job">business manager</span>
            </li>
            <li class="staff__item">
                <picture>
                    <source srcset="/assets/img/person3.webp" type="image/webp">
                    <img src="/assets/img/person3.jpg" alt="" class="staff__img">
                </picture>
                <span class="staff__name">john doe</span>
                <span class="staff__job">CEO</span>
            </li>
            <li class="staff__item">
                <picture>
                    <source srcset="/assets/img/person4.webp" type="image/webp">
                    <img src="/assets/img/person4.jpg" alt="" class="staff__img">
                </picture>
                <span class="staff__name">steve smith</span>
                <span class="staff__job">web designer</span>
            </li>
        </ul>
    </div>
</section>
<!-- /.staff -->

<script>
    window.addEventListener('DOMContentLoaded', () => {
        new Form('#contactForm')
    })
</script>