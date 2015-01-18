<?php
/** @var $this FigureRubricController
 * @var $model FigureRubric
 * @var $userGroupArrDropDown array
 */

$this->breadcrumbs=array(
	'Рубрикатор личностей'=>array('admin'),
	'Редактирование '.$model->title,
);

$this->menu=array(
	array('label'=>'Создание новой рубрики', 'url'=>array('create')),
	array('label'=>'Список рубрик', 'url'=>array('admin')),
);
?>

<h1>Личности. Редактирование рубрики №<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>