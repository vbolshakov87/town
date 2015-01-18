<?php
/**
 * @var $this StoryController
 * @var $model Story
 * @var $form CActiveForm
 * @var $status
 */
if ($status == 'error') :?>
	<div class="alert alert-danger">Ошибка загрузки данных</div>
<?else :?>
<div class="form" style="width: 450px" id="form-wrapper" data-id="<?=$model->id?>">
	<?if ($status == 'done') :?>
		<div class="alert alert-success">Сохранено</div>
	<?endif;?>

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'gallery-rename-form',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array(
			//'class' => 'form-horizontal',
			//'enctype' => 'multipart/form-data',
		),
	)); ?>
	<p class="note">Поля <span class="required">*</span> обязательны для заполнения.</p>

	<?=$form->errorSummary($model, '<div class="alert alert-danger">', '</div>'); ?>

	<div class="form-group <?if (!empty($model->errors['name'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'name', array('class'=>'control-label')); ?>
		<div style="width: 450px">
			<?=$form->textField($model,'name',array('class'=>'form-control')); ?>
		</div>
	</div>

	<div class="form-group <?if (!empty($model->errors['description'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'description', array('class'=>'control-label')); ?>
		<div style="width: 450px">
			<?=$form->textArea($model,'description',array('class'=>'form-control')); ?>
		</div>
	</div>

	<div class="control-group buttons">
		<?=CHtml::submitButton('Сохранить', array('name' => 'save', 'class'=>'btn btn-primary')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
<?endif;?>