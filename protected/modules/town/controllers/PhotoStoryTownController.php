<?php
/**
 * Class PhotoStoryController
 * Контроллер фотохроник
 */
class PhotoStoryTownController extends FrontController
{
	public function actions()
	{
		return array(
			'index' => array(
				'class' => 'DocumentListPhotosAction',
				'limit' => 5,
			),
		);
	}

	public function actionView()
	{
		$id = Yii::app()->getRequest()->getParam('id');
		$id = intval($id);

		if ($id < 1)
			throw new CHttpException(404);

		$photoStory = PhotoStory::model()->findByPk($id);
		if (empty($photoStory))
			throw new CHttpException(404);

		$this->render('view', array(
			'photoStory' => $photoStory
		));

	}

} 