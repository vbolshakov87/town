<?php
/* @var $this ContentBlockController */
/* @var $model ContentBlock */

$this->breadcrumbs=array(
	Yii::t('ContentBlock','Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('ContentBlock','Create ContentBlock'), 'url'=>array('create')),
);;
?>

<h1><?=Yii::t('ContentBlock', 'Manage Content Blocks')?></h1>
<p><?=CHtml::link(Yii::t('ContentBlock', 'Add block'), Yii::app()->createUrl('admin/contentBlock/create'), array('class' => 'btn btn-small btn-primary')); ?></p>

<?php $this->widget('GridView', array(
	'id'=>'content-block-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'50px'),
		),
		'name',
		'create_time' => array(
			'name' => 'create_time',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'150px'),
			'value' => '$data->create_time > 0 ? date("d.m.Y H:i", $data->create_time) : "-"',
			'filter'=>  false
		),
		array(
			'class'=>'AdminButtonColumn',
			'template'=>'{update} {delete}'
		),
	),
)); ?>
