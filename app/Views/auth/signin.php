<section class="profile mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <?php \Home\CmsMini\Flash::show() ?>
                    <div class="card-header">
                        <h4><?= $this->header ?></h4>
                    </div>
                    <div class="card-body">
                        <?php
                            use Home\CmsMini\Form\{Form, Fieldset, Input, Label, Button};

                            $form = new Form([
                                'id'        => 'signInForm',
                                'action'    => '/login', 
                                'method'    => 'POST', 
                                'class'     => 'needs-validation', 
                                'novalidate'=> '', 
                            ]);

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

                            $fieldset = new Fieldset(['class' => 'mb-3']);
                            $fieldsetInner = new Fieldset(['class' => 'd-grid gap-2']);
                            $fieldsetInner->add(new Button('Sing In', [
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
