<?php

/**
 * Class FigureController
 * Контроллер выдающихся личностей
 */
class FigureTownController extends FrontController
{

	public function actions()
	{
		return array(
			'index' => array(
				'class' => 'DocumentListRedactionAction',
				'limit' => 5,
				'modelClass' => 'Figure',
			),

		);
	}
	
	
	public function actionView()
	{
		$id = Yii::app()->getRequest()->getParam('id');
		$id = intval($id);

		if ($id < 1)
			throw new CHttpException(404);

		$cacheKey = 'figure_view_'.$id;
		$cacheDependency = new CacheTaggedDependency(array(Figure::cacheKey($id)));
		$figure = Yii::app()->cache->get($cacheKey);
		if ($figure === false) {
			/** @var Figure $figure */
			$figure = Figure::model()->findByPk($id);
			$figure->gallery;
			Yii::app()->cache->set($cacheKey, $figure, 60*60*24, $cacheDependency);
		}

		if (empty($figure))
			throw new CHttpException(404);

		$this->render('view', array(
			'figure' => $figure
		));

	}
} 