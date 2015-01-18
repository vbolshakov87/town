<?php
/* @var $this TextPageController */
/* @var $model TextPage */
/* @var $dataProvider */

?>

<h1>Текстовые страницы</h1>

<p><?=CHtml::link('Добавить страницу', Yii::app()->createUrl('admin/textPage/create'), array('class' => 'btn btn-small btn-primary')); ?></p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'event-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'template'=> '{items}{pager}',
	'htmlOptions' => array(
		'class' => 'table table table-striped table-vmiddle table-hover'
	),
	'columns'=>array(
		'id' => array(
			'name' => 'id',
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'50px'),
			'value' => '$data->id',
		),
		'title',
		'identifier',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {update}',
			'buttons'=>array(
				'view'=>array(
					'label'=>'Просмотреть на сайте',
					'url'=>'Yii::app()->createUrl("page/index", array("code"=>$data->identifier))',
				),
			),
			'viewButtonOptions'=> array('class'=>'view', 'target'=>'_blank')
		),
	),
)); ?>
