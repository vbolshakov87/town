<?php
/* @var $this TopicController */
/* @var $model Topic */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'topic-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'class' => 'form-horizontal',
		'enctype' => 'multipart/form-data',
	),
)); ?>

<p class="note">Поля <span class="required">*</span> обязательны для заполнения.</p>

<?=$form->errorSummary($model, '<div class="alert alert-danger">', '</div>'); ?>

	<div class="form-group row <?if (!empty($model->errors['title'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'title', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?=$form->textField($model,'title',array('class'=>'form-control')); ?>
		</div>
	</div>


	<div class="form-group row <?if (!empty($model->errors['user_group_id'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'user_group_id', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?=$form->dropDownList($model,'user_group_id', $userGroupArrDropDown, array('class' => 'form-control')); ?>
		</div>
	</div>

	<div class="form-group row <?if (!empty($model->errors['status'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'status', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?=$form->dropDownList($model,'status', Topic::$statusList); ?>
		</div>
	</div>


	<div class="control-group buttons">
		<?=CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('name' => 'save', 'class'=>'btn btn-primary')); ?>
		<?=CHtml::submitButton('Применить', array('name' => 'apply', 'class'=>'btn btn-primary')); ?>&nbsp;&nbsp;
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->