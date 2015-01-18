<?php
/* @var $this PhotoStoryController */
/* @var $model PhotoStory */

$this->breadcrumbs=array(
	'Фотохроника'=>Yii::app()->createUrl('photoStory/index'),
	'Управление фотохроникой',
);

$this->menu=array(
	array('label'=>'Фотохроника на сайте', 'url'=>Yii::app()->createUrl('photoStory/index'), 'linkOptions'=>array('target'=>'_blank')),
	array('label'=>'Добавить новую галерею', 'url'=>array('create')),
);


?>

<h1>Фотохроника</h1>
<p><?=CHtml::link('Добавить галерею', Yii::app()->createUrl('admin/photoStory/create'), array('class' => 'btn btn-small btn-primary')); ?></p>

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
		'date_begin' => array(
			'name' => 'date_begin',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'150px'),
			'value' => '$data->date_begin > 0 ? date("d.m.Y H:i", $data->date_begin) : "Не выбрано"',
			'filter'=>  false
		),
		'date_end' => array(
			'name' => 'date_end',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'150px'),
			'value' => '$data->date_end > 0 ? date("d.m.Y H:i", $data->date_end) : "Не выбрано"',
			'filter'=>  false
		),
		'user_group_id' => array(
			'filter'=>Html::dropDownList('PhotoStory[user_group_id]', $model->user_group_id,
				Html::getUserGroupListForDropDown(true), array('class' => 'form-control')
			),
			'name' => 'user_group_id',
			'value' => '$data->getGroupNameById()',
		),
		array(
			'class'=>'AdminButtonColumn',
			'buttons'=>array(
				'view'=>array(
					'label'=>'Просмотреть на сайте',
					'url'=>'Yii::app()->createUrl(\'photoStory/view\', array(\'id\' => $data->id))',
				),
			),
		),
	),
)); ?>
