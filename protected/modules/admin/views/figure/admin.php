<?php
/* @var $this StoryController */
/* @var $model Story */

$this->breadcrumbs=array(
	'Личности'=>Yii::app()->createUrl('figure/index'),
	'Управление списком личностей',
);

$this->menu=array(
	array('label'=>'Личности на сайте', 'url'=>Yii::app()->createUrl('figure/index'), 'linkOptions'=>array('target'=>'_blank')),
	array('label'=>'Добавить новую личность', 'url'=>array('create')),
);

?>

<h1>Выдающиеся личности</h1>
<p><?=CHtml::link('Добавить личность', Yii::app()->createUrl('admin/figure/create'), array('class' => 'btn btn-small btn-primary')); ?></p>

<?php $this->widget('GridView', array(
	'id'=>'story-grid',
	'dataProvider'=>$model->adminSearch(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'50px'),
		),
		'title',
		array(
			'name' => 'active',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'50px'),
			'value' => '$data->active == 1 ? "Да" : "Нет"',
			'filter'=>  false
		),
		'create_time' => array(
			'name' => 'create_time',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'150px'),
			'value' => '$data->create_time > 0 ? date("d.m.Y H:i", $data->create_time) : "Не задано"',
			'filter'=>  false
		),
		'user_group_id' => array(
			'filter'=>Html::dropDownList('Figure[user_group_id]', $model->user_group_id,
					Html::getUserGroupListForDropDown(true)
				),
			'name' => 'user_group_id',
			'value' => '$data->getGroupNameById()',
		),
		array(
			'class'=>'AdminButtonColumn',
			'buttons'=>array(
				'view'=>array(
					'label'=>'Просмотреть на сайте',
					'url'=>'Yii::app()->createUrl(\'figure/view\', array(\'id\' => $data->id))',
				),
			),
		),
	),
)); ?>
