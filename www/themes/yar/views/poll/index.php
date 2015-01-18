<?php
/**
 * @var $dataProvider CActiveDataProvider
 * @var $this PollController
 */
$this->breadcrumbs=array(
	Yii::t('Poll', 'Polls'),
);
?>

<h1><?=Yii::t('Poll', 'Polls')?></h1>
<?foreach ($dataProvider->getData() as $model) :
	$userVote = $this->loadVote($model);
	$userChoice = $this->loadChoice($model, $userVote->choice_id);

	$this->renderPartial('view', array(
		'model' => $model,
		'userVote' => $userVote,
		'userChoice' => $userChoice,
		'userCanCancel' => $model->userCanCancelVote($userVote),
	));
endforeach?>
<?$this->widget('LinkPager', array('pages' => $dataProvider->getPagination(), 'showLastPage' => true)); ?>