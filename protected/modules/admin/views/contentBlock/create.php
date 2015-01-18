<?php
/* @var $this ContentBlockController */
/* @var $model ContentBlock */

$this->breadcrumbs=array(
	Yii::t('ContentBlock', 'Content Blocks')=>array('admin'),
	Yii::t('all', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('ContentBlock', 'Manage Content Blocks'), 'url'=>array('admin')),
);
?>

<h1><?=Yii::t('ContentBlock', 'Manage Content Blocks')?></h1>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>