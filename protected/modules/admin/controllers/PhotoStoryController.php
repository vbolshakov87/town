<?php

class PhotoStoryController extends AdminController
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PhotoStory;
		$userGroupArr = Yii::app()->getUser()->getAvailableGroups();

		if (empty($userGroupArr))
			throw new HttpException(403);

		$userGroupArrDropDown = array();
		foreach ($userGroupArr as $userGroup) {
			$userGroupArrDropDown[$userGroup['id']] = $userGroup['name'];
		}


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PhotoStory']))
		{
			$model->attributes=$_POST['PhotoStory'];
			$model->date_begin = intval(strtotime($model->date_begin));
			$model->date_end = intval(strtotime($model->date_end));

			if ($model->date_begin == 0) {
				$model->date_begin = $model->date_end;
			}
			elseif($model->date_end == 0) {
				$model->date_end = $model->date_begin;
			}


			if($model->save()) {
				// сохранение изображения
				$model->updateImage('image', array('photoStory_admin/form'));
				$model->updateImage('image_top_1', array('photoStory_admin/form', 'photoStory/topIndex', 'photoStory/top'));
				$model->updateImage('image_top_3', array('photoStory_admin/form', 'photoStory/topIndex', 'photoStory/top'));
				$model->updateImage('image_sidebar', array('photoStory_admin/form', 'photoStory/sidebar'));

				if (!empty($model->image)) {
					$model->save();
				}
				CacheTaggedHelper::deleteByTags(array('photo_story_all'));
				UserActionLog::addTolog('photoStory', $model->id, UserActionLog::ACTION_CREATE);
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
	 */
	public function actionUpdate()
	{
		$id = intval(Yii::app()->getRequest()->getParam('id',0));
		$model = $this->loadModel($id);
		$modelImage = $model->image;
		$modelImageTop1 = $model->image_top_1;
		$modelImageTop3 = $model->image_top_3;
		$modelImageSidebar = $model->image_sidebar;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PhotoStory']))
		{
			$model->attributes=$_POST['PhotoStory'];
			$model->image = $modelImage;
			$model->image_top_1 = $modelImageTop1;
			$model->image_top_3 = $modelImageTop3;
			$model->image_sidebar = $modelImageSidebar;
			$model->date_begin = intval(strtotime($model->date_begin));
			$model->date_end = intval(strtotime($model->date_end));

			if ($model->date_begin == 0) {
				$model->date_begin = $model->date_end;
			}
			elseif($model->date_end == 0) {
				$model->date_end = $model->date_begin;
			}

			$model->updateImage('image', array('photoStory_admin/form'));
			$model->updateImage('image_top_1', array('photoStory_admin/form', 'photoStory/topIndex', 'photoStory/top'));
			$model->updateImage('image_top_3', array('photoStory_admin/form', 'photoStory/topIndex', 'photoStory/top'));
			$model->updateImage('image_sidebar', array('photoStory_admin/form', 'photoStory/sidebar'));



			if($model->save()) {
				CacheTaggedHelper::deleteByTags(array(PhotoStory::cacheKey($model->id), 'photo_story_all'));
				UserActionLog::addTolog('photoStory', $model->id, UserActionLog::ACTION_UPDATE);
				$this->redirect($this->formRedirectUrl($model));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'userGroupArrDropDown'=>Yii::app()->getUser()->getAvailableGroupsDropDown(),
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
			CacheTaggedHelper::deleteByTags(array(Story::cacheKey($id), 'photo_story_all'));
			UserActionLog::addTolog('photoStory', $id, UserActionLog::ACTION_DELETE);

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

		}
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PhotoStory('adminSearch');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PhotoStory']))
			$model->attributes=$_GET['PhotoStory'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PhotoStory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		if ($id < 1)
			throw new CHttpException(404);

		/** @var PhotoStory $model */
		$model = PhotoStory::model()->scopeByGroupAccess()->findByPk($id);
		if (empty($model))
			throw new CHttpException(403);

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PhotoStory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='story-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
