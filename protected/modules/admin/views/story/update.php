<?php
/** @var $this StoryController
 * @var $model Story
 * @var $userGroupArrDropDown array
 */

$this->breadcrumbs=array(
	'Исторические материалы'=>Yii::app()->createUrl('story/index'),
	'Управление материалами'=>Yii::app()->createUrl('admin/story/admin'),
	'Редактирование материала '.$model->title,
);

$this->menu=array(
	array('label'=>'Исторические материалы на сайте', 'url'=>Yii::app()->createUrl('story/index'), 'linkOptions'=>array('target'=>'_blank')),
	array('label'=>'Просмотреть эту запись на сайте', 'url'=>Yii::app()->createUrl('story/view', array('id' => $model->id)), 'linkOptions'=>array('target'=>'_blank')),
	array('label'=>'Управление материалами', 'url'=>array('admin')),
	array('label'=>'Добавить новый материал', 'url'=>array('create')),
);
?>

<h1>Редактирование исторического материала №<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>

<?$this->widget('GalleryAdminWidget', array('essence' => 'story', 'essence_id' => $model->id));?>