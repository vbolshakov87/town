<?php
/**
 * @var $this StoryController
 * @var $model Story
 * @var $form CActiveForm
 * @var $userGroupArrDropDown array
 */
?>

<div class="form">



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'story-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'class' => 'form-horizontal',
		'enctype' => 'multipart/form-data',
	),
)); ?>
	<p class="note"><?=Yii::t('all', 'Fields with <span class="required">*</span> are required.')?></p>

	<?=$form->errorSummary($model, '<div class="alert alert-danger">', '</div>'); ?>


	<ul class="nav nav-tabs">
		<li class="active"><a href="#base" data-toggle="tab"><?=Yii::t('all', 'Base');?></a></li>
		<li><a href="#images" data-toggle="tab"><?=Yii::t('all', 'Images');?></a></li>
		<li><a href="#meta" data-toggle="tab"><?=Yii::t('all', 'Meta data');?></a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="base">

			<div class="form-group row <?if (!empty($model->errors['title'])) :?> error<?endif;?>">
				<?=$form->labelEx($model,'title', array('class'=>'col-sm-2 control-label')); ?>
				<div class="col-sm-10">
					<?=$form->textField($model,'title',array('class'=>'form-control')); ?>
				</div>
			</div>

			<div class="form-group row <?if (!empty($model->errors['rubric_id'])) :?> error<?endif;?>">
				<?=$form->labelEx($model,'rubric_id', array('class'=>'col-sm-2 control-label')); ?>
				<div class="col-sm-10">
					<?=$form->dropDownList($model,'rubric_id', CHtml::listData(StoryRubric::model()->findAll(array('order'=>'t.title ASC')), 'id', 'title'), array('empty'=>'Выберите рубрику', 'class' => 'form-control')); ?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-2 control-label">
					Даты
				</div>
				<div class="col-sm-10">
					<table>
						<tr>
							<td>
								<div class="date-control control-group<?if (!empty($model->errors['date_begin'])) :?> error<?endif;?>">
									<?=$form->labelEx($model,'date_begin', array('class'=>'control-label control-label-inline')); ?>
									<?
									if ($model->date_begin == 0)
										$model->date_begin = 'Не выбрано';
									else
										$model->date_begin = date('d.m.Y', $model->date_begin);

									$this->widget(
										'application.modules.admin.widgets.EJuiDateTimePicker.EJuiDateTimePicker',
										array(
											'model'=>$model,
											'mode' => 'date',
											'value' => 'hello',
											'attribute'=>'date_begin',
											'htmlOptions' => array(
												'class' => 'date-time-input'
											),
										)
									);
									?>
								</div>
							</td>
							<td style="width: 20px"></td>
							<td>
								<div class="date-control control-group<?if (!empty($model->errors['date_end'])) :?> error<?endif;?>">
									<?=$form->labelEx($model,'date_end', array('class'=>'control-label control-label-inline')); ?>
									<?
									if ($model->date_end == 0)
										$model->date_end = 'Не выбрано';
									else
										$model->date_end = date('d.m.Y', $model->date_end);

									$this->widget(
										'application.modules.admin.widgets.EJuiDateTimePicker.EJuiDateTimePicker',
										array(
											'model'=>$model,
											'mode' => 'date',
											'attribute'=>'date_end',
											'htmlOptions' => array(
												'class' => 'date-time-input'
											),
										)
									);
									?>
								</div>

							</td>
						</tr>
					</table>
				</div>
			</div>




			<div class="form-group row <?if (!empty($model->errors['brief'])) :?> error<?endif;?>">
				<?=$form->labelEx($model,'brief', array('class'=>'col-sm-2 control-label')); ?>
				<div class="col-sm-10">
					<?=$form->textArea($model,'brief',array('class'=>'form-control','rows' => 7)); ?>
				</div>
			</div>


			<div class="form-group row <?if (!empty($model->errors['content'])) :?> error<?endif;?>">
				<?=$form->labelEx($model,'content', array('class'=>'col-sm-2 control-label')); ?>
				<div class="col-sm-10">
				<?$this->widget('application.extensions.ImperaviRedactorWidget.ImperaviRedactorWidget',
					array(
						'model' => $model,
						'attribute' => 'content',
						'options' => array(
							'lang' => 'ru',
							'minHeight' => 200,
							'imageUpload'=>$this->createUrl('imgUpload'),
							'uploadFields'=>array(
								Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
							),
						),
					)
				);?>
				<?=$form->error($model,'content'); ?>
				</div>
			</div>


			<div class="form-group row <?if (!empty($model->errors['tags'])) :?> error<?endif;?>">
				<?=$form->labelEx($model,'tags', array('class'=>'col-sm-2 control-label')); ?>
				<div class="col-sm-10">
					<?=$form->textField($model,'tags',array('class'=>'form-control')); ?>
				</div>
			</div>

			<?if (Yii::app()->getUser()->isAdmin()) :?>
			<div class="form-group row <?if (!empty($model->errors['main_page'])) :?> error<?endif;?>">
				<?=$form->labelEx($model,'main_page', array('class'=>'col-sm-2 control-label')); ?>
				<div class="col-sm-10">
					<?=$form->checkBox($model,'main_page'); ?>
				</div>
			</div>
			<?endif;?>

			<div class="form-group row <?if (!empty($model->errors['user_group_id'])) :?> error<?endif;?>">
				<?=$form->labelEx($model,'user_group_id', array('class'=>'col-sm-2 control-label')); ?>
				<div class="col-sm-10">
					<?=$form->dropDownList($model,'user_group_id', $userGroupArrDropDown); ?>
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
		</div>
		<div class="tab-pane" id="images">
			<div class="form-group row <?if (!empty($model->errors['image'])) :?> error<?endif;?>">
				<?=$form->labelEx($model,'image', array('class'=>'col-sm-2 control-label')); ?>
				<div class="col-sm-10">
					<?$this->widget('ImageUploadWidget', array('attribute'=>'image', 'model' => $model)); ?>
				</div>
			</div>

			<div class="form-group row <?if (!empty($model->errors['image_top_3'])) :?> error<?endif;?>">
				<?=$form->labelEx($model,'image_top_3', array('class'=>'col-sm-2 control-label')); ?>
				<div class="col-sm-10">
					<?$this->widget('ImageUploadWidget', array('attribute'=>'image_top_3', 'model' => $model)); ?>
				</div>
			</div>

			<div class="form-group row <?if (!empty($model->errors['image_top_1'])) :?> error<?endif;?>">
				<?=$form->labelEx($model,'image_top_1', array('class'=>'col-sm-2 control-label')); ?>
				<div class="col-sm-10">
					<?$this->widget('ImageUploadWidget', array('attribute'=>'image_top_1', 'model' => $model)); ?>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="meta">
			<div class="form-group row <?if (!empty($model->errors['meta_title'])) :?> error<?endif;?>">
				<?=$form->labelEx($model,'meta_title', array('class'=>'col-sm-2 control-label')); ?>
				<div class="col-sm-10">
					<?=$form->textField($model,'meta_title',array('class'=>'form-control')); ?>
				</div>
			</div>
			<div class="form-group row <?if (!empty($model->errors['meta_keywords'])) :?> error<?endif;?>">
				<?=$form->labelEx($model,'meta_keywords', array('class'=>'col-sm-2 control-label')); ?>
				<div class="col-sm-10">
					<?=$form->textArea($model,'meta_keywords',array('class'=>'form-control','rows' => 7)); ?>
				</div>
			</div>
			<div class="form-group row <?if (!empty($model->errors['meta_description'])) :?> error<?endif;?>">
				<?=$form->labelEx($model,'meta_description', array('class'=>'col-sm-2 control-label')); ?>
				<div class="col-sm-10">
					<?=$form->textArea($model,'meta_description',array('class'=>'form-control','rows' => 7)); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="control-group buttons">
		<?=CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('name' => 'save', 'class'=>'btn btn-primary')); ?>
		<?=CHtml::submitButton('Применить', array('name' => 'apply', 'class'=>'btn btn-primary')); ?>&nbsp;&nbsp;
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->