<?php
/**
 * @var $this FigureController
 * @var $model Figure
 * @var $userGroupArrDropDown
 */

$this->breadcrumbs=array(
	'Личности'=>Yii::app()->createUrl('figure/index'),
	'Управление'=>Yii::app()->createUrl('admin/figure/admin'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'Личности на сайте', 'url'=>Yii::app()->createUrl('figure/index'), 'linkOptions'=>array('target'=>'_blank')),
	array('label'=>'Просмотреть эту запись на сайте', 'url'=>Yii::app()->createUrl('figure/view', array('id' => $model->id)), 'linkOptions'=>array('target'=>'_blank')),
	array('label'=>'Управление личностями', 'url'=>array('admin')),
	array('label'=>'Добавить новую личность', 'url'=>array('create')),
);
?>

<h1>Редактирование личности <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>


<?$this->widget('GalleryAdminWidget', array('essence' => 'figure', 'essence_id' => $model->id));?>