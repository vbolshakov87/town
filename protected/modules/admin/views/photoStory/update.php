<?php
/** @var $this PhotoStoryController
 * @var $model PhotoStory
 * @var $userGroupArrDropDown array
 */

$this->breadcrumbs=array(
	'Фотохроника'=>Yii::app()->createUrl('figure/index'),
	'Управление фотохроникой'=>Yii::app()->createUrl('admin'),
	'Редактирование фотохроники '.$model->title,
);

$this->menu=array(
	array('label'=>'Фотохроника на сайте', 'url'=>Yii::app()->createUrl('photoStory/index'), 'linkOptions'=>array('target'=>'_blank')),
	array('label'=>'Просмотреть эту запись на сайте', 'url'=>Yii::app()->createUrl('photoStory/view', array('id' => $model->id)), 'linkOptions'=>array('target'=>'_blank')),
	array('label'=>'Управление фотохроникой', 'url'=>array('admin')),
	array('label'=>'Добавить новую галерею', 'url'=>array('create')),
);
?>

<h1>Редактирование фотохроники №<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>

<?$this->widget('GalleryAdminWidget', array('essence' => 'photo_story', 'essence_id' => $model->id));?>