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
                <?php \Home\CmsMini\Flash::show() ?>
                    <div class="card-body">
                        <h3 class="text-center">Please fill out this form to contact us</h3>
                        <hr>
                        <?php
                            use Home\CmsMini\Form\{Form, Fieldset, Input, Textarea, Button};
                            use Home\CmsMini\Request;

                            $form = new Form([
                                'id'        => 'contactForm2',
                                'action'    => '/contact', 
                                'method'    => 'POST', 
                                'class'     => 'row g-3 contact__form form', 
                                'novalidate'=> '', 
                            ]);

                            $fieldset = new Fieldset(['class' => 'col-6']);
                            $fieldset->add(new Input([
                                'id'        => 'contactFirstName', 
                                'name'      => 'firstname', 
                                'type'      => 'text', 
                                'class'     => 'form-control form__control', 
                                'placeholder' => 'Enter first name',
                                'data-valid'  => 'notEmpty',
                            ]));
                            $form->add($fieldset);

                            $fieldset = new Fieldset(['class' => 'col-6']);
                            $fieldset->add(new Input([
                                'id'        => 'contactLastName', 
                                'name'      => 'lastname', 
                                'type'      => 'text', 
                                'class'     => 'form-control form__control', 
                                'placeholder' => 'Enter last name',
                                'data-valid'  => 'notEmpty',
                            ]));
                            $form->add($fieldset);

                            $fieldset = new Fieldset(['class' => 'col-6']);
                            $fieldset->add(new Input([
                                'id'        => 'contactEmail', 
                                'name'      => 'email', 
                                'type'      => 'email', 
                                'class'     => 'form-control form__control', 
                                'placeholder' => 'Enter email',
                                'data-valid'  => 'email',
                            ]));
                            $form->add($fieldset);

                            $fieldset = new Fieldset(['class' => 'col-6']);
                            $fieldset->add(new Input([
                                'id'        => 'contactPhone', 
                                'name'      => 'phone', 
                                'type'      => 'tel', 
                                'class'     => 'form-control form__control', 
                                'placeholder' => 'Enter phone',
                                'data-valid'  => 'notEmpty',
                            ]));
                            $form->add($fieldset);

                            $fieldset = new Fieldset(['class' => 'col-12']);
                            $fieldset->add(new Textarea(Request::old('body'), [
                                'id'        => 'contactBody', 
                                'name'      => 'body', 
                                'rows'      => '3', 
                                'class'     => 'form-control form__control', 
                                'placeholder' => 'Enter body',
                                'data-valid'  => 'notEmpty',
                            ]));
                            $form->add($fieldset);

                            $fieldset = new Fieldset(['class' => 'col-12']);
                            $fieldsetInner = new Fieldset(['class' => 'd-grid gap-2']);
                            $fieldsetInner->add(new Button('Send', [
                                'type'  => 'submit', 
                                'class' => 'btn btn-outline-danger form__submit',
                            ]));
                            $fieldset->add($fieldsetInner);
                            $form->add($fieldset);

                            echo $form->render();
                        ?>
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