<?php

class SiteTownController extends FrontController
{

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			)
		);
	}


	public function actionPage()
	{
		$code = Yii::app()->getRequest()->getParam('code');
		if (empty($code)) {
			throw new CHttpException(404);
		}

		$cacheId = json_encode(array('pageDataCache', $code));
		$post = Yii::app()->getCache()->get($cacheId);
		if ($post === false) {
			$post = Post::model()->findByPk(1);
			Yii::app()->getCache()->set($cacheId, $post, 60);
		}

		$this->render('application.views.site.pages.'.$code, array('aaa' => $_GET, 'bbb' => 222, 'post' => $post));

	}



	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}



}
