<?php
use Home\CmsMini\Flash;
use Home\CmsMini\FormBuilder as Form;
use Home\CmsMini\Router;
?>
<section class="profile my-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <?php Flash::show() ?>
                    <div class="card-header">
                        <h4><?= $this->getMeta('header') ?></h4>
                    </div>
                    <div class="card-body">
                        <?= Form::open([
                            'id'          => 'signInForm',
                            'action'      => Router::url('login'),
                            'class'       => 'needs-validation',
                            'novalidate'  => '',
                        ]) ?>
                        <?= Form::email([
                            'id'          => 'userEmail',
                            'name'        => 'email',
                            'class'       => 'form-control form__control',
                            'placeholder' => 'Enter email',
                            'data-valid'  => 'email',
                        ], 'Email address') ?>
                        <?= Form::password([
                            'id'          => 'userPassword',
                            'name'        => 'password',
                            'class'       => 'form-control form__control',
                            'placeholder' => 'Enter password',
                            'data-valid'  => 'notEmpty',
                        ], 'Password') ?>
                        <?= Form::submit('Sing In', ['class' => 'btn btn-outline-primary form__submit']) ?>
                        <?= Form::close() ?>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</section>
