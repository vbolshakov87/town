<?php
/** @var $this StoryController
 * @var $model Story
 * @var $userGroupArrDropDown array
 */

$this->breadcrumbs=array(
	'Управление историческими материалами'=>Yii::app()->createUrl('admin/story/admin'),
	'Добавление материала',
);

$this->menu=array(
	array('label'=>'Исторические материалы на сайте', 'url'=>Yii::app()->createUrl('story/index'), 'linkOptions'=>array('target'=>'_blank')),
	array('label'=>'Управлени историческими материалами', 'url'=>Yii::app()->createUrl('admin/story/admin')),
);

?>

<h1>Создание нового материала</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'userGroupArrDropDown' => $userGroupArrDropDown)); ?>