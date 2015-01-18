<?php
/**
 * Action to handle image uploads from imperavi-redactor-widget
 *
 * @author Bogdan Savluk <savluk.bogdan@gmail.com>
 *
 * Example of use:
 *  1. add it to your conroller actions()
 *      'imgUpload'=>array(
 *          'class'=>'ext.imperavi-redactor-widget.ImageUploadAction',
 *          'directory = 'uploads/redactor'
 *      ),
 *
 *  2. render your widget specifying url and options for upload
 *
 *      $this->widget('ext.imperavi-redactor-widget.ImperaviRedactorWidget', array(
 *          'model' => $model,
 *          'attribute' => 'redactorArea',
 *
 *          'options' => array(
 *              'imageUpload'=>$this->createUrl('imgUpload'), // place here route to your ImageUploadAction
 *
 *              // additional field if you have csrf request validation enabled
 *              'uploadFields'=>array(
 *                  Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
 *              ),
 *          ),
 *
 *      ));
 *
 *
 */
class ImageUploadAction extends CAction
{
	public function run()
	{
		$this->controller->disableLogs();

		if (Yii::app()->user->isGuest)
			throw new CHttpException(403);

		$imageUploaded = CUploadedFile::getInstanceByName('file');

		if (!empty($imageUploaded->tempName)) {

			$name = Image::createFileName($imageUploaded->name, $imageUploaded);

			Image::transform('redactor/source', $imageUploaded->tempName, $name);
			Image::transform('redactor', Yii::app()->params['fileParams']['type']['redactor/source']['path'] . DIRECTORY_SEPARATOR . $name, $name);
			Image::deleteFile(Yii::app()->params['fileParams']['type']['redactor/source']['path'] . DIRECTORY_SEPARATOR . $name);

			$fileInfo = Image::getImageData('redactor', $name);

			$array = array(
				'filelink' => $fileInfo['src'],
			);
			echo CJSON::encode($array);
		} else {
			echo CJSON::encode(array(
				"error" => "Wrong file type",
				"anothermessage" => "Mime-type \"" . $_FILES['file']['type'] . "\" is not allowed",
			));
		}


	}
}