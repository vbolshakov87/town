<?php
/**
 * @var $this StoryRubricController
 * @var $model StoryRubric
 * @var $form CActiveForm
 * @var $userGroupArrDropDown array
 */
?>

<div class="form">



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'storyRubric-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'class' => 'form-horizontal',
		'enctype' => 'multipart/form-data',
	),
)); ?>
	<p class="note"><?=Yii::t('all', 'Fields with <span class="required">*</span> are required.')?></p>

	<?=$form->errorSummary($model, '<div class="alert alert-danger">', '</div>'); ?>

	<div class="form-group row <?if (!empty($model->errors['title'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'title', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?=$form->textField($model,'title',array('class'=>'form-control')); ?>
		</div>
	</div>

	<div class="form-group row <?if (!empty($model->errors['brief'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'brief', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?=$form->textArea($model,'brief',array('class'=>'form-control','rows' => 7)); ?>
		</div>
	</div>


	<div class="form-group row <?if (!empty($model->errors['user_group_id'])) :?> error<?endif;?>">
		<?=$form->labelEx($model,'user_group_id', array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?=$form->dropDownList($model,'user_group_id', $userGroupArrDropDown, array('class' => 'form-control')); ?>
		</div>
	</div>

	<?if (!empty($model->id) && (Yii::app()->getUser()->isAdmin() || Yii::app()->getUser()->getUser()->isAdminInGroup($model->user_group_id))) :?>
	<div class="control-group<?if (!empty($model->errors['active'])) :?> error<?endif;?>">
		<div class="">
			<label class="checkbox">
				<?=$form->checkBox($model,'active'); ?>
				<?=$form->error($model,'active'); ?>
				<?=$model->getAttributeLabel('active')?>
			</label>
		</div>
	</div>
	<?endif;?>

	<div class="control-group buttons">
		<?=CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('name' => 'save', 'class'=>'btn btn-primary')); ?>
		<?=CHtml::submitButton('Применить', array('name' => 'apply', 'class'=>'btn btn-primary')); ?>&nbsp;&nbsp;
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->