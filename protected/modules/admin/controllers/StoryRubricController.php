<?php

class StoryRubricController extends AdminController
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new StoryRubric;
		$userGroupArr = Yii::app()->getUser()->getAvailableGroups();
		$userGroupArrDropDown = array();
		foreach ($userGroupArr as $userGroup) {
			$userGroupArrDropDown[$userGroup['id']] = $userGroup['name'];
		}


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['StoryRubric']))
		{
			$model->attributes=$_POST['StoryRubric'];
			if($model->save()) {
				$this->redirect($this->formRedirectUrl($model));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'userGroupArrDropDown'=>$userGroupArrDropDown,
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
		$userGroupArr = Yii::app()->getUser()->getAvailableGroups();
		$userGroupArrDropDown = array();
		foreach ($userGroupArr as $userGroup) {
			$userGroupArrDropDown[$userGroup['id']] = $userGroup['name'];
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['StoryRubric']))
		{
			$model->attributes=$_POST['StoryRubric'];
			if($model->save())
				$this->redirect($this->formRedirectUrl($model));
		}

		$this->render('update',array(
			'model'=>$model,
			'userGroupArrDropDown'=>$userGroupArrDropDown,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new StoryRubric('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['StoryRubric']))
			$model->attributes=$_GET['StoryRubric'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return StoryRubric the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=StoryRubric::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param StoryRubric $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='storyRubric-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
