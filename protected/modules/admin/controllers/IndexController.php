<?php

class IndexController extends AdminController
{

	public function actionLogin()
	{
		$this->layout = 'login';
		// если пользователь уже авторизован, то тут ему делать нечего
		if (Yii::app()->user->getId()) {
			$this->redirect(Yii::app()->createUrl('admin/index'));
			Yii::app()->end();
		}
		$model = new LoginForm;

		if(isset($_POST['ajax']) && $_POST['ajax']==='auth-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			if($model->validate() && $model->login()) {
				Yii::app()->getRequest()->redirect(Yii::app()->createUrl('admin/sitePlace/index'));
				Yii::app()->end();
			}

		}
		$this->render('login',array('model'=>$model));
	}


	public function actionIndex()
	{
		$this->render('index');
	}


	public function actionAjaxContainerList()
	{
		$arResult = array();
		$query = Yii::app()->request->getParam('q');
		$query = trim($query);
		$criteria = new CDbCriteria(array(
			'limit' => 10,
			'order' => 't.caption ASC'
		));

		if(!empty($query)) {
			$criteria->addSearchCondition('t.caption', $query);
		}
		$container = Container::model()->findAll($criteria);
		foreach ($container as $item) {
			$arResult[] = array('id' => $item->id, 'name' => $item->caption);
		}

		header('Content-type: application/json');
		echo CJSON::encode($arResult);
		Yii::app()->end();
	}
}