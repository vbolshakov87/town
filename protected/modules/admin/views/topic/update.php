<?php
/* @var $this TopicController */
/* @var $model Topic */

$this->breadcrumbs=array(
	'Темы'=>array('admin'),
	$model->title
);

$this->menu=array(
	array('label'=>'Добавить тему', 'url'=>array('create')),
	array('label'=>'Темы', 'url'=>array('admin')),
);
?>

<h1>Редактирование темы №<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>