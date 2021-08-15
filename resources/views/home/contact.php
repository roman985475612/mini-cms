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
                    <div class="card-body">
                        <h3 class="text-center">Please fill out this form to contact us</h3>
                        <hr>
                        <form class="row g-3 contact__form form" novalidate>
                            <div class="col-6">
                                <input
                                    name="contact[first]" 
                                    type="text" 
                                    class="form-control form__control" 
                                    id="contactFirstName" 
                                    placeholder="Enter first name"
                                    data-valid="notEmpty"
                                >
                            </div>
                            <div class="col-6">
                                <input
                                name="contact[last]"
                                type="text" 
                                class="form-control form__control" 
                                id="contactLastName" 
                                placeholder="Enter last name"
                                data-valid="notEmpty"
                            >
                            </div>
                            <div class="col-6">
                                <input
                                    name="contact[email]" 
                                    type="email" 
                                    class="form-control form__control" 
                                    id="contactEmail" 
                                    placeholder="Enter email"
                                    data-valid="email"
                                >
                            </div>
                            <div class="col-6">
                                <input
                                name="contact[phone]"
                                type="tel"
                                class="form-control form__control" 
                                id="contactPhone" 
                                placeholder="Enter phone"
                                data-valid="phone"
                            >
                            </div>
                            <div class="col-12">
                                <textarea
                                    name="contact[message]" 
                                    class="form-control form__control" 
                                    id="contactMessage" 
                                    rows="3"
                                    data-valid="notEmpty"
                                ></textarea>
                            </div>
                            <div class="col-12">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-outline-danger form__submit">Sign in</button>
                                </div>
                            </div>
                        </form>
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
