<?php
/* @var $this ContentBlockController */
/* @var $model ContentBlock */

$this->breadcrumbs=array(
	Yii::t('ContentBlock', 'Manage')=>array('admin'),
	$model->name=>array(Yii::t('all', 'update'),'id'=>$model->id),
);

$this->menu=array(
	array('label'=>Yii::t('all', 'Create'), 'url'=>array('create')),
	array('label'=>Yii::t('ContentBlock', 'Manage Content Blocks'), 'url'=>array('admin')),
);
?>

<h1><?=Yii::t('ContentBlock', 'Update content block')?> <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

<div>
	<h2><?=Yii::t('all', 'Preview')?></h2>
	<div class="highlight">
		<?php echo $model->text; ?>
	</div>
</div>