<?php

class FigureController extends AdminController
{


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Figure;
		$userGroupArr = Yii::app()->getUser()->getAvailableGroups();
		$userGroupArrDropDown = array();
		foreach ($userGroupArr as $userGroup) {
			$userGroupArrDropDown[$userGroup['id']] = $userGroup['name'];
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Figure'])) {
			$model->attributes=$_POST['Figure'];
			$model->date_of_birth = intval(strtotime($model->date_of_birth));
			$model->date_of_death = intval(strtotime($model->date_of_death));

			if($model->save()) {
				// сохранение изображения
				$model->updateImage('image', array('figure_admin/form'));
				$model->updateImage('image_top_1', array('figure_admin/form', 'figure/top'));
				$model->updateImage('image_top_3', array('figure_admin/form', 'figure/topIndex'));
				if (!empty($model->image)) {
					$model->save();
				}
				CacheTaggedHelper::deleteByTags(array('figure_all'));
				UserActionLog::addTolog('figure', $model->id, UserActionLog::ACTION_CREATE);
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
		$modelImage = $model->image;
		$modelImageTop1 = $model->image_top_1;
		$modelImageTop3 = $model->image_top_3;
		$userGroupArr = Yii::app()->getUser()->getAvailableGroups();
		$userGroupArrDropDown = array();
		foreach ($userGroupArr as $userGroup) {
			$userGroupArrDropDown[$userGroup['id']] = $userGroup['name'];
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Figure']))
		{
			$model->attributes=$_POST['Figure'];
			$model->image = $modelImage;
			$model->image_top_1 = $modelImageTop1;
			$model->image_top_3 = $modelImageTop3;
			$model->date_of_birth = intval(strtotime($model->date_of_birth));
			$model->date_of_death = intval(strtotime($model->date_of_death));

			$model->updateImage('image', array('figure_admin/form'));
			$model->cropImageFromUploaded('image_top_1', array('figure_admin/form', 'figure/top'), 'figure_top');
			$model->cropImageFromUploaded('image_top_3', array('figure_admin/form', 'figure/topIndex'), 'figure_big_top');

			if($model->save()) {
				CacheTaggedHelper::deleteByTags(array(Figure::cacheKey($model->id)));
				UserActionLog::addTolog('figure', $model->id, UserActionLog::ACTION_UPDATE);
				$this->redirect($this->formRedirectUrl($model));
			}
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
		$model = $this->loadModel($id);
		if (Yii::app()->getUser()->isAdmin() || Yii::app()->getUser()->getUser()->isAdminInGroup($model->user_group_id)) {
			$model->delete();
			CacheTaggedHelper::deleteByTags(array(Figure::cacheKey($id)));
			UserActionLog::addTolog('figure', $id, UserActionLog::ACTION_DELETE);

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Figure');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Figure('adminSearch');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Figure']))
			$model->attributes=$_GET['Figure'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Figure the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		if ($id < 1)
			throw new CHttpException(404);

		/** @var PhotoStory $model */
		$model = Figure::model()->scopeByGroupAccess()->findByPk($id);
		if (empty($model))
			throw new CHttpException(403);

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Figure $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='figure-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
