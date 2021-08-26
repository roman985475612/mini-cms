<?php
use Home\CmsMini\Router;
use Home\CmsMini\Form\{Form, Fieldset, Input, Label, Button};

$form = new Form([
    'id'        => 'categoryUpdate',
    'action'    => Router::url('category-update', ['id' => $category->id]), 
    'method'    => 'POST', 
    'class'     => 'needs-validation', 
    'novalidate'=> '', 
]);

$fieldset = new Fieldset(['class' => 'mb-3']);
$fieldset->add(new Label('Title', true, [
    'for'       => 'categoryTitle',
    'class'     => 'form-label'
]));
$fieldset->add(new Input([
    'id'        => 'categoryTitle', 
    'name'      => 'title', 
    'type'      => 'text', 
    'class'     => 'form-control form__control', 
    'placeholder' => 'Enter title',
    'data-valid'  => 'notEmpty',
    'value'     => $category->title
]));
$form->add($fieldset);

$fieldset = new Fieldset(['class' => 'mb-3']);
$fieldsetInner = new Fieldset(['class' => 'd-grid gap-2']);
$fieldsetInner->add(new Button('Save', [
    'type'  => 'submit', 
    'class' => 'btn btn-outline-success form__submit',
]));
$fieldset->add($fieldsetInner);
$form->add($fieldset);

return $form->render();
?>