<?php

class TextPageController extends AdminController
{
	public $layout = 'application.modules.admin.views.layout.two_columns';


	public function beforeAction($action)
	{
		if (!Yii::app()->userGroup->isInGroup('admin')) {
			throw new HttpException(403);
		}

		return parent::beforeAction($action);
	}

	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TextPage();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TextPage']))
		{
			$model->attributes=$_POST['TextPage'];
			if($model->save()) {
				$this->redirect($this->formRedirectUrl($model));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['TextPage'])) {

			$model->attributes=$_POST['TextPage'];

			if($model->save())
            {
                Yii::app()->cache->delete('TextPage_'.$model->identifier);
                $this->redirect($this->formRedirectUrl($model));
            }

		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout = 'application.modules.admin.views.layout.one_column';
		$model=new TextPage('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TextPage']))
			$model->attributes=$_GET['TextPage'];

		/* @var CActiveDataProvider $dataProvider */
		$dataProvider = $model->search();
		$dataProvider->pagination = array('pageSize' => 50);

		$this->render('admin',array(
			'model'=>$model,
			'dataProvider' => $dataProvider
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Event the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = TextPage::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	/**
	 * Performs the AJAX validation.
	 * @param Event $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='textPage-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
