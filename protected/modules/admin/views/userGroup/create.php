<?php
/* @var $this UserGroupController */
/* @var $model UserGroup */

$this->breadcrumbs=array(
	'Управление группами'=>array('admin'),
	'Создание новой группы',
);

$this->menu=array(
	array('label'=>'Управление группами', 'url'=>array('admin')),
);
?>

<h1>Создание новой группы пользователей</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>