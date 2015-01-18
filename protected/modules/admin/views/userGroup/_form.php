<?php
/* @var $this UserGroupController */
/* @var $model UserGroup */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-group-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'class' => 'form-horizontal',
	),
)); ?>
	<p class="note">Поля <span class="required">*</span> обязательны для заполнения.</p>

	<?=$form->errorSummary($model, '<div class="alert alert-danger">', '</div>'); ?>

	<div class="form-group row <?if (!empty($model->errors['name'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'name', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?=$form->textField($model,'name',array('class'=>'form-control')); ?>
		</div>
	</div>

	<div class="form-group row <?if (!empty($model->errors['code'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'code', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?=$form->textField($model,'code',array('class'=>'form-control')); ?>
		</div>
	</div>


	<div class="control-group buttons">
		<?=CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('name' => 'save', 'class'=>'btn btn-primary')); ?>
		<?=CHtml::submitButton('Применить', array('name' => 'apply', 'class'=>'btn btn-primary')); ?>&nbsp;&nbsp;
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->