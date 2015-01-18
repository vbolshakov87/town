<?php

class UserController extends AdminController
{
	public $layout = 'application.modules.admin.views.layout.two_columns';


	public function beforeAction($action)
	{
		if (!Yii::app()->getUser()->getUser()->isGroupAdmin() && !Yii::app()->getUser()->isAdmin()) {
			Yii::app()->getRequest()->redirect('/admin/');
		}

		return parent::beforeAction($action);
	}



	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save()) {

				$userCreatedGroups = Yii::app()->getUser()->getAvailableGroups();
				if (count($userCreatedGroups) == 1) {
					print "<pre>";
					print_r($userCreatedGroups);
					print "</pre>";
				}

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
		$userGroupArr = Yii::app()->getUser()->getAvailableGroups();

		if (!empty($_POST['linkUserGroupUser'])) {

			$transaction = Yii::app()->getDb()->beginTransaction();
			try
			{
				LinkUserGroupUser::model()->deleteAllByAttributes(array('user_id' => $model->id, 'user_group_id' => array_keys($userGroupArr) ));

				foreach ($_POST['linkUserGroupUser']['group'] as $groupId => $on) {
					if ( !empty($userGroupArr[$groupId])) {
						$lug = new LinkUserGroupUser();
						$lug->user_group_id = $groupId;
						$lug->user_id = $model->id;
						if (!empty($_POST['linkUserGroupUser']['admin'][$groupId])) {
							$lug->group_admin = 1;
						}
						$lug->save();
					}
				}

				$transaction->commit();
				$this->redirect($this->formRedirectUrl($model));
			}
			catch (Exception $e)
			{
				$transaction->rollback();
			}
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect($this->formRedirectUrl($model));
		}

		$this->render('update',array(
			'model'=>$model,
			'userGroupArr'=>$userGroupArr,
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
		$delete = false;

		if ($id > 1) {
			if (Yii::app()->getUser()->isAdmin()) {
				$delete = true;
			}
			else {
				/** @var LinkUserGroupUser[] $linkUserGroups */
				$linkUserGroups = LinkUserGroupUser::model()->findByAttributes(array('user_id' => $id));
				if (count($linkUserGroups) > 1) {
					$delete = false;
				}
				elseif (Yii::app()->getUser()->getUser()->isAdminInGroup($linkUserGroups[0]->user_group_id)) {
					$delete = true;
				}
			}

			if ($delete === true)
				$this->loadModel($id)->delete();
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
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
