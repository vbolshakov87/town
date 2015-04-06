<?php

/**
 * Class StoryController
 * Контроллер исторических материалов
 */
class StoryTownController extends FrontController
{

	public function actions()
	{
		return array(
			'index' => array(
				'class' => 'DocumentListRedactionAction',
				'limit' => Yii::app()->params['limitOnPage'],
				'modelClass' => 'Story',
			),

		);
	}


	public function actionView()
	{
		$id = Yii::app()->getRequest()->getParam('id');
		$id = intval($id);

		if ($id < 1)
			throw new CHttpException(404);


		$cacheKey = 'story_view_'.$id;
		$cacheDependency = new CacheTaggedDependency(array(Story::cacheKey($id)));
		$story = Yii::app()->cache->get($cacheKey);
		if ($story === false) {
			/** @var Story $story */
			$story = Story::model()->findByPk($id);
			$story->gallery;
			Yii::app()->cache->set($cacheKey, $story, 60*60*24, $cacheDependency);
		}

		if (empty($story))
			throw new CHttpException(404);

		$this->render('view', array(
			'story' => $story
		));

	}
} 