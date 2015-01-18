<?php
/* @var $this ContentBlockController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Content Blocks',
);

$this->menu=array(
	array('label'=>'Create ContentBlock', 'url'=>array('create')),
	array('label'=>'Manage ContentBlock', 'url'=>array('admin')),
);
?>

<h1>Content Blocks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
