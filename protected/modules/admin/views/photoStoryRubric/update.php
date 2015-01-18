<?php
/** @var $this PhotoStoryRubricController
 * @var $model PhotoStoryRubric
 * @var $userGroupArrDropDown array
 */

$this->breadcrumbs=array(
	'Рубрикатор фотохроники'=>array('admin'),
	'Редактирование '.$model->title,
);

$this->menu=array(
	array('label'=>'Создание новой рубрики фотохроники', 'url'=>array('create')),
	array('label'=>'Список рубрик фотохроники', 'url'=>array('admin')),
);
?>

<h1>Редактирование рубрики фотохроники №<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>