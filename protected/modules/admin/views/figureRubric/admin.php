<?php
/* @var $this FigureRubricController */
/* @var $model FigureRubric */

$this->breadcrumbs=array(
	'Рубрики личностей',
);

$this->menu=array(
	array('label'=>'Личности на сайте', 'url'=>Yii::app()->createUrl('figure/index'), 'linkOptions'=>array('target'=>'_blank')),
	array('label'=>'Создать новую рубрику', 'url'=>array('create')),
);

?>

<h1>Личности. Рубрики</h1>
<p><?=CHtml::link('Добавить рубрику', Yii::app()->createUrl('admin/figureRubric/create'), array('class' => 'btn btn-small btn-primary')); ?></p>

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
