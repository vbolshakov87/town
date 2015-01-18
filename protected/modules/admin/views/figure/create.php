<?php
/** @var $this StoryController
 * @var $model Story
 * @var $userGroupArrDropDown array
 */

$this->breadcrumbs=array(
	'Управление личностями'=>Yii::app()->createUrl('admin/figure/admin'),
	'Добавление личности',
);

$this->menu=array(
	array('label'=>'Личности на сайте', 'url'=>Yii::app()->createUrl('figure/index'), 'linkOptions'=>array('target'=>'_blank')),
	array('label'=>'Управлени личностями', 'url'=>Yii::app()->createUrl('admin/figure/admin')),
);

?>

<h1>Добавление личности</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>