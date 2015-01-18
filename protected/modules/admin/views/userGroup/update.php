<?php
/* @var $this UserGroupController */
/* @var $model UserGroup */

$this->breadcrumbs=array(
	'Управление группами'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Создание новой группы', 'url'=>array('create')),
	array('label'=>'Управление группами', 'url'=>array('admin')),
);
?>

<h1>Редактирование группы №<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>