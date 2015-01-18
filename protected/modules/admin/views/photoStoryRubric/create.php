<?php
/** @var $this PhotoStoryRubricController
 * @var $model PhotoStoryRubric
 * @var $userGroupArrDropDown array
 */

$this->breadcrumbs=array(
	'Рубрикатор фотохроники'=>array('admin'),
	'Создание новой рубрики',
);

$this->menu=array(
	array('label'=>'Рубрикатор фотохроники', 'url'=>array('admin')),
);
?>

<h1>Создать рубрику фотохроники</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>