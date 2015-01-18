<?php
$this->breadcrumbs=array(
	Yii::t('Poll', 'Polls')=>array('admin'),
	Yii::t('Poll', 'Create'),
);

$this->menu=array(
  array('label'=>Yii::t('Poll', 'List Polls'), 'url'=>Yii::app()->createUrl('post/index'), 'linkOptions'=>array('target'=>'_blank')),
  array('label'=>Yii::t('Poll', 'Manage Polls'), 'url'=>array('admin')),
);
?>

<h1><?=Yii::t('Poll', 'Create Poll');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'choices'=>$choices)); ?>
