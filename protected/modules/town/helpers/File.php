<?php
/**
 * Работа с файлами
 */
class File {

	public static function getFileInfo($type, $name)
	{
		if (empty($name) || empty( Yii::app()->params['fileParams']['type'][$type])) return array();
		$params = Yii::app()->params['fileParams']['type'][$type];


		if (!file_exists($params['path'] . '/' . $name)) {
				return array();
		}

		return array(
			'src' => $params['folder']. '/' . $name,
			'size' => getimagesize($params['path']. '/' . $name)
		);
	}


	public function save($type, $file, $name)
	{
		if (empty(Yii::app()->params['fileParams']['type'][$type]))
			throw new Exception('Тип изображения не задан либо задан не корректно');

		$path = Yii::app()->params['fileParams']['type'][$type]['path'] . DIRECTORY_SEPARATOR . $name;

		// проверяем существование директории
		if (!file_exists(dirname($path)))
			mkdir(dirname($path), 0775, true);

		copy($file, $path);

		return true;
	}



	public static function createFileName($essence, $imageUploaded)
	{
		$name = md5($essence . '_' . time()) . '.'. Image::getFileTypeByFile($imageUploaded->name);
		return substr($name, 0, 3) . '/' .  $name;
	}


	public static function deleteFile($fileName)
	{
		unlink($fileName);
	}

}