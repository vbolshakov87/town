<?php
/** @var $this PhotoStoryRubricController
 * @var $model PhotoStoryRubric
 * @var $userGroupArrDropDown array
 */

$this->breadcrumbs=array(
	'Рубрикатор личностей'=>array('admin'),
	'Создание новой рубрики',
);

$this->menu=array(
	array('label'=>'Рубрикатор личностей', 'url'=>array('admin')),
);
?>

<h1>Создание новой рубрики личностей</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>