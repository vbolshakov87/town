<?php
/** @var $this PhotoStoryController
 * @var $model PhotoStory
 * @var $userGroupArrDropDown array
 */


$this->breadcrumbs=array(
	'Управление фотохроникой'=>Yii::app()->createUrl('admin/photoStory/admin'),
	'Добавление галереи',
);

$this->menu=array(
	array('label'=>'Фотохроника на сайте', 'url'=>Yii::app()->createUrl('photoStory/index'), 'linkOptions'=>array('target'=>'_blank')),
	array('label'=>'Управлени фотохроникой', 'url'=>Yii::app()->createUrl('admin/photoStory/admin')),
);
?>

<h1>Создание новой галереи</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>