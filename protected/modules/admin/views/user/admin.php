<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Управление пользователями',
);

$this->menu=array(
	array('label'=>'Создание нового пользователя', 'url'=>array('create')),
);
?>
<h1>Управление пользоватями</h1>

<p><?=CHtml::link('Добавить пользователя', Yii::app()->createUrl('admin/user/create'), array('class' => 'btn btn-small btn-primary')); ?></p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-group-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-striped',
	'columns'=>array(
		'id',
		'name',
		'login',
		'email',
		array(
			'htmlOptions'=>array('width'=>'75px'),
			'class'=>'UserGroupButtonColumn',
			'template'=>'{update} {delete}',
			//'viewButtonOptions'=> array('class'=>'view', 'target'=>'_blank')
		),
	),
)); ?>
