<?php

class AuthController extends AdminController
{
	public $layout = 'application.modules.admin.views.layout.login';

	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}


	/**
	 * Авторизация пользователя в админке
	 */
	public function actionLogin()
	{
		// если пользователь уже авторизован, то тут ему делать нечего
		if (Yii::app()->user->getId()) {
			$this->redirect(Yii::app()->createUrl('admin/index/index'));
			Yii::app()->end();
		}
		$this->addPageTitle('Авторизация');
		$model = new AdminLoginForm();

		if(isset($_POST['ajax'])  && ( $_POST['ajax']==='login-form' )) {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['AdminLoginForm'])) {
			$model->attributes=$_POST['AdminLoginForm'];
			if($model->validate() && $model->login()) {
				$this->redirect(Yii::app()->request->getUrlReferrer());
				Yii::app()->end();
			}
		}
		$this->render('login',array('model'=>$model));
	}


	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(str_replace('.index.php', '', Yii::app()->request->getUrlReferrer()));
	}
}