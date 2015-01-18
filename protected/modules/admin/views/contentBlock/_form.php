<?php
/* @var $this ContentBlockController */
/* @var $model ContentBlock */
/* @var $form CActiveForm */
?>

<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'figure-form',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array(
			'class' => 'form-horizontal',
			'enctype' => 'multipart/form-data',
		),
	)); ?>

	<p class="note"><?=Yii::t('all', 'Fields with <span class="required">*</span> are required.')?></p>

	<?=$form->errorSummary($model, '<div class="alert alert-danger">', '</div>'); ?>


	<div class="form-group row <?if (!empty($model->errors['name'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'name', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?=$form->textField($model,'name',array('class'=>'form-control', 'readonly' => 'readonly')); ?>
		</div>
	</div>

	<div class="form-group row <?if (!empty($model->errors['text'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'text', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?=$form->textArea($model,'text',array('class'=>'form-control')); ?>
		</div>
	</div>


	<div class="control-group buttons">
		<?=CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('name' => 'save', 'class'=>'btn btn-primary')); ?>
		<?=CHtml::submitButton('Применить', array('name' => 'apply', 'class'=>'btn btn-primary')); ?>&nbsp;&nbsp;
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->