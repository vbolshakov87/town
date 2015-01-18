<?php
/* @var $this TopicController */
/* @var $model Topic */

$this->breadcrumbs=array(
	'Темы'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Темы', 'url'=>array('admin')),
);
?>

<h1>Добавление темы</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>