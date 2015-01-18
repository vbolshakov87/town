<?php
/** @var $this StoryRubricController
 * @var $model StoryRubric
 * @var $userGroupArrDropDown array
 */

$this->breadcrumbs=array(
	'Рубрикатор исторических материалов'=>array('admin'),
	'Редактирование '.$model->title,
);

$this->menu=array(
	array('label'=>'Создание новой рубрики', 'url'=>array('create')),
	array('label'=>'Список рубрик исторических материалов', 'url'=>array('admin')),
);

?>
<h1>Редактирование рубрики исторических материалов №<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>