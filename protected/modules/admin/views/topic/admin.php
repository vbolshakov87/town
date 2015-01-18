<?php
/* @var $this TopicController */
/* @var $model Topic */

$this->breadcrumbs=array(
	'Темы',
);

$this->menu=array(
	array('label'=>'Добавить тему', 'url'=>array('create')),
);

?>

<h1>Темы</h1>
<p><?=CHtml::link('Добавить тему', Yii::app()->createUrl('admin/topic/create'), array('class' => 'btn btn-small btn-primary')); ?></p>

<?php $this->widget('GridView', array(
	'id'=>'topic-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'50px'),
		),
		'title',
		'create_time' => array(
			'name' => 'create_time',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'150px'),
			'value' => '$data->create_time > 0 ? date("d.m.Y H:i", $data->create_time) : "Не задано"',
			'filter'=>  false
		),
		'user_group_id' => array(
			'name' => 'user_group_id',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'150px'),
			'value' => '$data->user_group_id > 0 ? $data->userGroup->name : "Не выбрано"',
		),
		'booked_time' => array(
			'name' => 'create_time',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'150px'),
			'value' => '$data->booked_time > 0 ? date("d.m.Y H:i", $data->booked_time) : "Не задано"',
			'filter'=>  false
		),
		array(
			'name' => 'status',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'80px'),
			'value' => '$data->status == "done" ? "Готово" : "В работе"',
			'filter'=>  false
		),
		array(
			'htmlOptions'=>array('width'=>'75px'),
			'class'=>'CButtonColumn',
		),
	),
)); ?>
