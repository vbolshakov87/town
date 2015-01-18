<?/**
 * @var $form  CActiveForm
 * @var $formModel RegistrationForm
 */?>
<div class="front-signup js-front-signup form">
	<h2><strong>New on Site?</strong> Sign up</h2>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action' => 'auth   /registration',
		'id'=>'registration-form',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
		'htmlOptions' => array(
			'class' => 'signup'
		),
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="placeholding-input row">
		<?=$form->textField($formModel,'name', array('autocomplete'=>'off', 'maxlength' => 32, 'placeholder' => $formModel->getAttributeLabel('name'))); ?>
		<?=$form->error($formModel,'name'); ?>
	</div>
	<div class="placeholding-input row">
		<?=$form->emailField($formModel,'email', array('maxlength' => 32, 'placeholder' => $formModel->getAttributeLabel('email'))); ?>
		<?=$form->error($formModel,'email'); ?>
	</div>
	<div class="placeholding-input row">
		<?=$form->passwordField($formModel,'password', array('autocomplete'=>'off', 'maxlength' => 32, 'placeholder' => $formModel->getAttributeLabel('password'))); ?>
		<?=$form->error($formModel,'password'); ?>
	</div>


		<?=CHtml::submitButton('Registration on site'); ?>
	<?php $this->endWidget(); ?>
</div>