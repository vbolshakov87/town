<?php

class UserGroupController extends AdminController
{

	public function beforeAction($action)
	{
		if (!Yii::app()->getUser()->isAdmin()) {
			Yii::app()->getRequest()->redirect('/admin/');
		}

		return parent::beforeAction($action);
	}


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new UserGroup;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UserGroup']))
		{
			$model->attributes=$_POST['UserGroup'];
			if($model->save())
				$this->redirect($this->formRedirectUrl($model));
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

		if(isset($_POST['UserGroup']))
		{
			$model->attributes=$_POST['UserGroup'];
			if($model->save())
				$this->redirect($this->formRedirectUrl($model));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$id = Yii::app()->getRequest()->getParam('id', 0);
		$id = intval($id);

		if ($id > 1)
			$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('UserGroup');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new UserGroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserGroup']))
			$model->attributes=$_GET['UserGroup'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	/**
	 * Удаление пользователя из группы
	 */
	public function actionDeleteUserFromGroup()
	{

		$userId = Yii::app()->getRequest()->getParam('userId', 0);
		$groupId = Yii::app()->getRequest()->getParam('groupId', 0);

		if (Yii::app()->getUser()->isAdmin() || $groupId != UserGroup::GROUP_ADMIN) {
			if ($userId > 0 && $groupId > 0) {
				LinkUserGroupUser::model()->deleteAllByAttributes(array('user_id' => $userId, 'group_id' => $groupId));
			}
		}

		Yii::app()->getRequest()->redirect( Yii::app()->createUrl('admin/userGroup/view', array('id' => $groupId)) );
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return UserGroup the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=UserGroup::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param UserGroup $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-group-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
