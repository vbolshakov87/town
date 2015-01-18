<?php
/* @var $this UserGroupController */
/* @var $model UserGroup */

$this->breadcrumbs=array(
	'Управление пользователями'=>array('admin'),
	'Создание нового пользователя',
);

$this->menu=array(
	array('label'=>'Управление пользователями', 'url'=>array('admin')),
);
?>

<h1>Создание нового пользователя</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>