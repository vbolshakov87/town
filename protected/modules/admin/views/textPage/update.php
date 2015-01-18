<?php
/* @var $this TextPageController */
/* @var $model TextPage */

?>

<h2>Редактирование страницы &laquo;<?php echo $model->title; ?>&raquo;</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>