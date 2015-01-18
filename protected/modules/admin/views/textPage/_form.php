<?php
/* @var $this TextPageController */
/* @var $model TextPage */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'textPage-form',
	'htmlOptions' => array(
		'class' => 'bs-docs-example form-horizontal',
	),
	'enableAjaxValidation'=>false,
)); ?>


	<?=$form->errorSummary($model, '<div class="alert alert-error">', '</div>'); ?>

	<div class="control-group<?if (!empty($model->errors['title'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'title', array('class'=>'control-label')); ?>
		<div class="controls">
			<?=$form->textField($model,'title',array('class'=>'input-xxlarge','maxlength'=>255)); ?>
		</div>
	</div>
	
	<div class="control-group<?if (!empty($model->errors['identifier'])) :?> error<?endif;?>">
		<?=$form->labelEx($model, 'identifier', array('class'=>'control-label')); ?>
		<div class="controls">
			<?=$form->textField($model,'identifier',array('class'=>'input-xxlarge','maxlength'=>255)); ?>
		</div>
	</div>

	<div class="control-group<?if (!empty($model->errors['content'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'content', array('class'=>'control-label')); ?>
		<div class="controls">
			<?=$form->textArea($model,'content',array('class'=>'input-xxlarge','rows'=>20)); ?>
		</div>
	</div>

	<div class="control-group buttons">
		<?=CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('name' => 'save', 'class'=>'btn btn-primary')); ?>
		<?=CHtml::submitButton('Применить', array('name' => 'apply', 'class'=>'btn btn-primary')); ?>&nbsp;&nbsp;
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->