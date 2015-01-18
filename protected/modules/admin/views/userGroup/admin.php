<?php
/* @var $this UserGroupController */
/* @var $model UserGroup */

$this->breadcrumbs=array(
	'Группы пользователей',
);

$this->menu=array(
	array('label'=>'Создание новой группы', 'url'=>array('create')),
);
?>
<h1>Управление группами пользователей</h1>

<p><?=CHtml::link('Добавить группу', Yii::app()->createUrl('admin/userGroup/create'), array('class' => 'btn btn-small btn-primary')); ?></p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-group-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-striped',
	'columns'=>array(
		'id',
		'name',
		'code',
		array(
			'htmlOptions'=>array('width'=>'75px'),
			'class'=>'CButtonColumn',
			'template'=>'{view} {update} {delete}',
			'viewButtonOptions'=> array('class'=>'view', 'target'=>'_blank')
		),
	),
)); ?>
