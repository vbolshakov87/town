<?php
/* @var $this UserController */
/* @var $model User */
/* @var $formGroup CActiveForm */
/* @var $userGroupArr array */

$this->breadcrumbs=array(
	'Управление пользователями'=>array('admin'),
	$model->name=>array('update','id'=>$model->id),
);

$this->menu=array(
	array('label'=>'Создание нового пользователя', 'url'=>array('create')),
	array('label'=>'Управление пользователями', 'url'=>array('admin')),
);
?>

<h1>Редактирование пользователя №<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?if (Yii::app()->getUser()->isAdmin() || Yii::app()->getUser()->getUser()->isGroupAdmin()) :?>
<h2>Группы пользователя</h2>

<?=CHtml::beginForm(Yii::app()->createUrl('admin/user/update', array('id' => $model->id)), 'post', array('class' => 'form-horizontal'));?>

	<div class="form-group row">
		<div class="col-sm-10">
			<table class="table table-striped">
				<tr>
					<th>Группа</th>
					<th>В группе</th>
					<th>Админ группы</th>
				</tr>
			<?foreach ($userGroupArr as $userGroup) :?>
				<tr>
					<td>
						<?=$userGroup['name']?>
					</td>
					<td>
						<input type="checkbox" name="linkUserGroupUser[group][<?=$userGroup['id']?>]" <?if ($model->isInGroup($userGroup['id'])) :?>checked="checked"<?endif;?>>
					</td>
					<td>
						<input type="checkbox" name="linkUserGroupUser[admin][<?=$userGroup['id']?>]" <?if ($model->isAdminInGroup($userGroup['id'])) :?>checked="checked"<?endif;?>>
					</td>

				</tr>
			<?endforeach;?>
			</table>
		</div>
	</div>


	<div class="control-group buttons">
		<?=CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('name' => 'save', 'class'=>'btn btn-primary')); ?>
		<?=CHtml::submitButton('Применить', array('name' => 'apply', 'class'=>'btn btn-primary')); ?>&nbsp;&nbsp;
	</div>
<?=CHtml::endForm();?>
<?endif;?>