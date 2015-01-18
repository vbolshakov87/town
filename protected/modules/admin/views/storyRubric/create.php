<?php
/** @var $this StoryRubricController
 * @var $model StoryRubric
 * @var $userGroupArrDropDown array
 */

$this->breadcrumbs=array(
	'Рубрикатор исторических материалов'=>array('admin'),
	'Создание новой рубрики',
);

$this->menu=array(
	array('label'=>'Рубрикатор исторических материалов', 'url'=>array('admin')),
);

?>

<h1>Создание новой рубрики исторических материалов</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>