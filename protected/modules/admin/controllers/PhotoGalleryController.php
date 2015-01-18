<?php
/**
 * Контроллер обработки фотогалереи
 */
class PhotoGalleryController extends AdminController
{
	/**
	 * Загрузка нового изображения
	 */
	public function actionUpload()
	{
		$this->disableLogs();

		if (empty($_FILES))
			Yii::app()->end();

		$originalFile = $_FILES['Filedata']['tmp_name'];

		$imageSize = getimagesize($originalFile);

		if (empty($imageSize[0]))
			Yii::app()->end();

		$photo = new GalleryPhoto();
		$photo->name = '***';
		$photo->original_name = trim( htmlspecialchars($_FILES['Filedata']['name']) );
		$photo->essence = Yii::app()->getRequest()->getParam('essence');
		$photo->essence_id = Yii::app()->getRequest()->getParam('essence_id');
		$photo->width = $imageSize[0];
		$photo->height = $imageSize[1];
		$photo->type = str_replace(array('image/', 'jpeg'), array('', 'jpg'), $imageSize['mime']);
		$photo->mimetype = $imageSize['mime'];

		if (!$photo->save()) {
			Yii::app()->end();
		}


		$imageSizeTypes = array('gallery/list', 'gallery/detail');

		// название файла в структуре
		$imageUploaded = new StdClass();
		$imageUploaded->tempName = $_FILES['Filedata']['tmp_name'];
		$imageUploaded->name = $_FILES['Filedata']['name'];
		$name = Image::createFileName('gallery_image'.$photo->id, $imageUploaded);
		Image::transform('gallery/source', $imageUploaded->tempName, $name);
		foreach ($imageSizeTypes as $imageSize) {
			Image::transform($imageSize, Yii::app()->params['fileParams']['type']['gallery/source']['path'] . DIRECTORY_SEPARATOR . $name, $name);
		}

		$photo->image = $name;
		$photo->save();


		echo json_encode(array(
			'html' => $this->renderPartial('_photoInList', array('image'=>$photo), true),
			'id' => $photo->id,
		));
		Yii::app()->end();
	}


	/**
	 * Удаление файла
	 */
	public function actionDelete()
	{
		$result = array(
			'status' => 'false',
		);

		$id = intval(Yii::app()->getRequest()->getParam('id'));
		if ($id < 1) {
			echo json_encode($result);
			Yii::app()->end();
		}

		GalleryPhoto::model()->deleteByPk($id);
		$result['status'] = 'done';

		echo json_encode($result);
		Yii::app()->end();
	}

	/**
	 * Смена сортировки фотографий раздела
	 */
	public function actionResort()
	{
		$ids = Yii::app()->getRequest()->getParam('ids');
		$sort = 0;
		if (!empty($ids)) {
			foreach ($ids as $k => $id) {
				if ($id < 1)
					continue;

				$sort +=10;

				GalleryPhoto::model()->updateByPk($id, array('sort' => $sort));
			}
		}
		echo 'ok';
		Yii::app()->end();
	}


	/**
	 * Смена описания фотографии
	 */
	public function actionRename()
	{
		$id = Yii::app()->getRequest()->getParam('id');
		$status = 'go';

		/** @var GalleryPhoto $model */
		$model=GalleryPhoto::model()->findByPk($id);
		if (empty($id)) {
			$this->renderPartial('rename',array(
				'model'=>$model,
				'status'=>'error',
			));
			Yii::app()->end();
		}


		if(isset($_POST['GalleryPhoto']))
		{
			$model->name=$_POST['GalleryPhoto']['name'];
			$model->description=$_POST['GalleryPhoto']['description'];
			$model->update_time=time();

			if($model->save()) {
				$status = 'done';
			}
		}

		$this->renderPartial('rename',array(
			'model'=>$model,
			'status'=>$status,
		));
	}
} 