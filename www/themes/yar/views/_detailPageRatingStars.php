<?php
/**
 * @var $model Document
 * @var $this FrontController
 */
$modelClass = get_class($model);
$modelId = $model->id;
$this->beginClip('ratingStars');
$options = array(
	'half' => true,
	'click' => "js:function(score, evt){ updateScore(this, score, ".$modelId.", '".$modelClass."');  }",
);
$value = !empty($model->weight) ? round(10*$model->weight)/10 : 3.5;
if ( Yii::app()->getUser()->isRatedDocument($modelClass, $modelId)) {
	$options['readOnly'] = true;
}
$this->widget('ext.DzRaty.DzRaty', array(
	'model' => $model,
	'attribute' => 'weight',
	'options' => $options,
	'value' => $value,
));
$this->endClip();