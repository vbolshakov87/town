<?php
/* @var $this PhotoStoryRubricController */
/* @var $model PhotoStoryRubric */

$this->breadcrumbs=array(
	'Рубрики фотохроники',
);

$this->menu=array(
	array('label'=>'Фотохроника на сайте', 'url'=>Yii::app()->createUrl('photoStory/index'), 'linkOptions'=>array('target'=>'_blank')),
	array('label'=>'Создать новую рубрику', 'url'=>array('create')),
);

?>

<h1>Рубрики фотохроники</h1>
<p><?=CHtml::link('Добавить рубрику фотохроники', Yii::app()->createUrl('admin/photoStoryRubric/create'), array('class' => 'btn btn-small btn-primary')); ?></p>

<?php $this->widget('GridView', array(
	'id'=>'story-grid',
	'dataProvider'=>$model->search(),
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
		array(
			'htmlOptions'=>array('width'=>'75px'),
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
			/*'buttons'=>array(
				'view'=>array(
					'label'=>'Просмотреть на сайте',
					'url'=>'Yii::app()->createUrl(\'story/view\', array(\'id\' => $data->id))',
				),
			),*/
			//'viewButtonOptions'=> array('class'=>'view', 'target'=>'_blank')
		),
	),
)); ?>
