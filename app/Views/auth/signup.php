<section class="profile mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <?php \Home\CmsMini\Flash::show() ?>
                        <h4><?= $this->header ?></h4>
                    </div>
                    <div class="card-body">
                    <?php
                            use Home\CmsMini\Form\{Form, Fieldset, Input, Label, Button};

                            $form = new Form([
                                'id'        => 'signUpForm',
                                'action'    => '/register', 
                                'method'    => 'POST', 
                                'class'     => 'needs-validation', 
                                'novalidate'=> '', 
                            ]);

                            // Username
                            $fieldset = new Fieldset(['class' => 'mb-3']);
                            $fieldset->add(new Label('Username', true, [
                                'for'       => 'userUsername',
                                'class'     => 'form-label'
                            ]));
                            $fieldset->add(new Input([
                                'id'        => 'userUsername', 
                                'name'      => 'username', 
                                'type'      => 'text', 
                                'class'     => 'form-control form__control', 
                                'placeholder' => 'Enter Username',
                                'data-valid'  => 'notEmpty',
                            ]));
                            $form->add($fieldset);

                            // Email
                            $fieldset = new Fieldset(['class' => 'mb-3']);
                            $fieldset->add(new Label('Email address', true, [
                                'for'       => 'userEmail',
                                'class'     => 'form-label'
                            ]));
                            $fieldset->add(new Input([
                                'id'        => 'userEmail', 
                                'name'      => 'email', 
                                'type'      => 'email', 
                                'class'     => 'form-control form__control', 
                                'placeholder' => 'Enter email',
                                'data-valid'  => 'email',
                            ]));
                            $form->add($fieldset);

                            // Password
                            $fieldset = new Fieldset(['class' => 'mb-3']);
                            $fieldset->add(new Label('Password', true, [
                                'for'       => 'userPassword',
                                'class'     => 'form-label'
                            ]));
                            $fieldset->add(new Input([
                                'id'        => 'userPassword', 
                                'name'      => 'password', 
                                'type'      => 'password', 
                                'class'     => 'form-control form__control', 
                                'placeholder' => 'Enter password',
                                'data-valid'  => 'notEmpty',
                            ]));
                            $form->add($fieldset);

                            // Password confirm
                            $fieldset = new Fieldset(['class' => 'mb-3']);
                            $fieldset->add(new Label('Password confirm', true, [
                                'for'       => 'userConfirm',
                                'class'     => 'form-label'
                            ]));
                            $fieldset->add(new Input([
                                'id'        => 'userConfirm', 
                                'name'      => 'confirm', 
                                'type'      => 'password', 
                                'class'     => 'form-control form__control', 
                                'placeholder' => 'Enter confirm password',
                                'data-valid'  => 'notEmpty',
                            ]));
                            $form->add($fieldset);
                            
                            $fieldset = new Fieldset(['class' => 'mb-3']);
                            $fieldsetInner = new Fieldset(['class' => 'd-grid gap-2']);
                            $fieldsetInner->add(new Button('Sing Up', [
                                'type'  => 'submit', 
                                'class' => 'btn btn-outline-primary form__submit',
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
