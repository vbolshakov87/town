<?php

class StoryController extends AdminController
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Story;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Story']))
		{
			$model->attributes=$_POST['Story'];
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
				$model->updateImage('image', array('story_admin/form'));
				$model->updateImage('image_top_1', array('story_admin/form', 'story/topIndex', 'stroy/top'));
				$model->updateImage('image_top_3', array('story_admin/form', 'story/topIndex', 'story/top'));
				if (!empty($model->image)) {
					$model->save();
				}
				UserActionLog::addTolog('story', $model->id, UserActionLog::ACTION_CREATE);
				CacheTaggedHelper::deleteByTags(array('story_all'));
				$this->redirect($this->formRedirectUrl($model));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'userGroupArrDropDown'=>Yii::app()->getUser()->getAvailableGroupsDropDown(),
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Story']))
		{
			$model->attributes=$_POST['Story'];
			$model->image = $modelImage;
			$model->image_top_1 = $modelImageTop1;
			$model->image_top_3 = $modelImageTop3;

			$model->date_begin = intval(strtotime($model->date_begin));
			$model->date_end = intval(strtotime($model->date_end));

			if ($model->date_begin == 0) {
				$model->date_begin = $model->date_end;
			}
			elseif($model->date_end == 0) {
				$model->date_end = $model->date_begin;
			}

            $model->updateImage('image', array('story_admin/form'));
            $model->cropImageFromUploaded('image_top_1', array('story_admin/form', 'story/top'), 'story_top');
            $model->cropImageFromUploaded('image_top_3', array('story_admin/form', 'story/topIndex'), 'story_big_top');

			if($model->save()) {
				CacheTaggedHelper::deleteByTags(array(Story::cacheKey($model->id)));
				UserActionLog::addTolog('story', $model->id, UserActionLog::ACTION_UPDATE);
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
			CacheTaggedHelper::deleteByTags(array(Story::cacheKey($id)));
			UserActionLog::addTolog('story', $id, UserActionLog::ACTION_DELETE);

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
		$model=new Story('adminSearch');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Story']))
			$model->attributes=$_GET['Story'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Story the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		if ($id < 1)
			throw new CHttpException(404);

		/** @var PhotoStory $model */
		$model = Story::model()->scopeByGroupAccess()->findByPk($id);
		if (empty($model))
			throw new CHttpException(403);

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Story $model the model to be validated
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
