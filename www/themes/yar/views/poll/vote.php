<?php
$this->breadcrumbs=array(
  'Polls'=>array('index'),
  $model->title=>array('view','id'=>$model->id),
);

?>

<h1><?php echo CHtml::encode($model->title) ?></h1>

<?php echo $this->renderPartial('_vote', array('model'=>$model,'vote'=>$vote,'choices'=>$choices)); ?>
