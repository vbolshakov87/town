<?php
$this->breadcrumbs=array(
	Yii::t('Poll', 'Polls')=>array('admin'),
  $model->title=>array('update','id'=>$model->id),
);

$this->menu=array(
  array('label'=>Yii::t('Poll', 'List Polls'), 'url'=>Yii::app()->createUrl('post/index'), 'linkOptions'=>array('target'=>'_blank')),
  array('label'=>Yii::t('Poll', 'Create Poll'), 'url'=>array('create')),
  array('label'=>Yii::t('Poll', 'View Poll'), 'url'=>Yii::app()->createUrl('post/view', array('id'=>$model->id))),
 # array('label'=>Yii::t('Poll', 'Export Poll'), 'url'=>array('export', 'id'=>$model->id)),
  array('label'=>Yii::t('Poll', 'Manage Polls'), 'url'=>array('admin')),
);
?>

<h1><?=Yii::t('Poll', 'Update Poll')?>: <?php echo CHtml::encode($model->title); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'choices'=>$choices)); ?>
