<?php
$this->breadcrumbs=array(
  'Polls'=>array('index'),
  'Manage',
);

$this->menu=array(
  array('label'=>Yii::t('Poll', 'List Polls'), 'url'=>Yii::app()->createUrl('post/index'), 'linkOptions'=>array('target'=>'_blank')),
  array('label'=>Yii::t('Poll', 'Create Poll'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
  $('.search-form').toggle();
  return false;
});
$('.search-form form').submit(function(){
  $.fn.yiiGridView.update('poll-grid', {
    data: $(this).serialize()
  });
  return false;
});
");
?>

<h1><?=Yii::t('Poll', 'Manage Polls')?></h1>

<p><?=CHtml::link(Yii::t('Poll', 'Create new poll'), Yii::app()->createUrl('admin/poll/create'), array('class' => 'btn btn-small btn-primary')); ?></p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
  'id'=>'poll-grid',
  'dataProvider'=>$model->search(),
	'template'=> '{items}{pager}',
	'itemsCssClass' => 'table table-striped',
  'filter'=>$model,
  'columns'=>array(
    'title',
    'description',
    array(
      'name' => 'status',
      'value' => 'CHtml::encode($data->getStatusLabel($data->status))',
      'filter' => CHtml::activeDropDownList($model, 'status', $model->statusLabels(), array('class' => 'form-control')),
    ),
	  array(
		  'class'=>'AdminButtonColumn',
		  'buttons'=>array(
			  'view'=>array(
				  'label'=>'Просмотреть на сайте',
				  'url'=>'Yii::app()->createUrl(\'poll/view\', array(\'id\' => $data->id))',
			  ),
		  ),
	  ),
  ),
)); ?>
