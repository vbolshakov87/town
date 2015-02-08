<?php
/**
 * Базовый класс ORM моделей
 */
class ActiveRecord extends CActiveRecord
{

	public $sum;

	/**
	 * Ставим дату добавления и обновления элемента при сохранении
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave()) {
			try {
				if($this->isNewRecord) {
					if (array_key_exists('create_time', $this->attributes) && empty($this->attributes['create_time']))
						$this->create_time=time();

					if (array_key_exists('update_time', $this->attributes) && empty($this->attributes['update_time']))
						$this->update_time=time();
				}
				else {
					if (array_key_exists('update_time', $this->attributes) && empty($this->attributes['update_time']))
						$this->update_time=time();
				}
			}
			catch (Exception $e) {}

			return true;
		}
		else {
			return false;
		}
	}


	/**
	 * Сохранение изображений
	 * @param string $field
	 * @param array $imageSizes
	 * @param $imageUploaded
	 * @return bool
	 */
	public function updateImage($field='image', $imageSizes = array(), $imageUploaded = null, $modelType = null, $createdFromAttr = 'image')
	{
       // удаление фото если необходимо
		if (isset($_POST[get_class($this)][$field . '_del'])) {
			$this->deleteImage($field);
			$this->{$field} = '';
		}

		// получаем объект файла для загрузки если он существует
		if (is_null($imageUploaded)) {
			$imageUploaded = CUploadedFile::getInstance($this, $field);
		}

		if (!empty($imageUploaded->tempName)) {

            // удаляем старые изображения для всех существующих типов
			$this->deleteImage($field);

			// название файла в структуре
			if (empty($modelType)) {
				$modelType = strtolower(get_class($this));
			}
			$name = Image::createFileName($modelType.$field.$this->id, $imageUploaded);
            Image::transform($modelType.'/source', $imageUploaded->tempName, $name);
			foreach ($imageSizes as $imageSize) {
				Image::transform($imageSize, Yii::app()->params['fileParams']['type'][$modelType.'/source']['path'] . DIRECTORY_SEPARATOR . $name, $name);
			}

			// передаем данные в объект для сохранения в базе
			$this->{$field} = $name;
		}
	}


    public function cropImageFromUploaded($field='image', $imageSizes = array(), $modelType = null, $createdFromAttr = 'image')
    {
        $imageUploaded = new StdClass();
        if (empty($modelType)) {
            $modelType = strtolower(get_class($this));
        }

        if (!empty($_POST[get_class($this)]['crop_'.$field]['x2'])) {

            $coordinates = $_POST[get_class($this)]['crop_'.$field];

            $type = $modelType.'/source';
            $params = Yii::app()->params['fileParams']['type'][$type];
            if (empty($params)) {
                throw new CException($type . 'images type is not found');
            }
            if (empty($params['original'])) {
                throw new CException($type . ' is not an original');
            }
            if (empty($params['createdFrom'])) {
                throw new CException($type . ' does not have createdFrom param');
            }
            if (empty(Yii::app()->params['fileParams']['type'][Yii::app()->params['fileParams']['type'][$type]['createdFrom']])) {
                throw new CException(Yii::app()->params['fileParams']['type']['createdFrom'] . 'images type is not found');
            }

            $createdFromParams = Yii::app()->params['fileParams']['type'][Yii::app()->params['fileParams']['type'][$type]['createdFrom']];
            $originalFilePath = $createdFromParams['path'] . DIRECTORY_SEPARATOR . $this->{$createdFromAttr};


            $imageUploaded->name = $this->{$createdFromAttr};
            $destinationFilePath = '/tmp/'.Image::createFileName($modelType.$field.$this->id, $imageUploaded);

            $croped = Image::cropBycoordinates($originalFilePath, $destinationFilePath, $coordinates);
            if ($croped) {

                $imageUploaded->tempName = $destinationFilePath;
            }
        }
        //print 222; exit;
        return $this->updateImage($field, $imageSizes, $imageUploaded, $modelType);
    }



	public function updateFile($field, $type, $imageUploaded = null)
	{
		// удаление фото если необходимо
		if (isset($_POST[get_class($this)][$field . '_del'])) {
			$this->deleteFile($field, $type);
			$this->{$field} = '';
		}

		// получаем объект файла для загрузки если он существует
		if (is_null($imageUploaded)) {
			$imageUploaded = CUploadedFile::getInstance($this, $field);
		}

		if (!empty($imageUploaded->tempName)) {

			// удаляем старого файла
			$this->deleteFile($field, $type);

			// название файла в структуре
			$name = File::createFileName(strtolower(get_class($this)).$field.$this->id, $imageUploaded);
			File::save($type, $imageUploaded->tempName, $name);

			// передаем данные в объект для сохранения в базе
			$this->{$field} = $name;
		}
	}


	/**
	 * Удаление файла модели
	 * @param string $field
	 * @return bool
	 */
	public function deleteImage($field='image') {
		if (!empty($this->{$field})) {
			foreach (Yii::app()->params['fileParams']['type'] as $params) {
				$file = $params['path'].'/'.$this->{$field};
				if (file_exists($file))
					unlink($file);
			}
		}
		return true;
	}


	/**
	 * Удаление файла модели
	 * @param string $field
	 * @return bool
	 */
	public function deleteFile($field, $type) {
		if (!empty($this->{$field}) && !empty(Yii::app()->params['fileParams']['type'][$type])) {
			$file = Yii::app()->params['fileParams']['type'][$type]['path'].'/'.$this->{$field};
			if (file_exists($file))
				unlink($file);
		}
		return true;
	}


	/**
	 * @param $type - тип из конфига изображений
	 * @param string $attribute - свойство с изображением
	 * @param bool $create - создавать картинку при необходимости
	 * @return string - src изображения
	 */
	public function getImageSrc($type, $attribute='image', $create = false, $modelType = null)
	{
		if (empty($this->{$attribute}) || empty( Yii::app()->params['fileParams']['type'][$type]))
			return '';

		$params = Yii::app()->params['fileParams']['type'][$type];

		if (empty($modelType))
			$modelType = strtolower(get_class($this));

		if ($create === true && !file_exists($params['path'] . DIRECTORY_SEPARATOR . $this->{$attribute})) {
			$paramsSource = Yii::app()->params['fileParams']['type'][$modelType.'/source'];
			if (!file_exists($paramsSource['path'] . DIRECTORY_SEPARATOR . $this->{$attribute})) {
				return '';
			}
			if (!Image::transform($type, $paramsSource['path']. DIRECTORY_SEPARATOR . $this->{$attribute}, $this->{$attribute}))
				return '';
		}

		return  $params['folder']. '/' . $this->{$attribute};
	}





    public function getImageSize($type, $attribute='image')
    {
        if (empty($this->{$attribute}) || empty(Yii::app()->params['fileParams']['type'][$type]))
            return '';

        $params = Yii::app()->params['fileParams']['type'][$type];

        $filePath = $params['path'] . DIRECTORY_SEPARATOR . $this->{$attribute};

        if (!file_exists($filePath)) {
            return array();
        }

        return getimagesize($filePath);
    }


	/**
	 * Url файла для скачивания
	 * @param $type - тип из конфига файлов
	 * @param string $attribute - свойство с файлов
	 * @return string - src файла
	 */
	public function getFileSrc($type, $attribute='image')
	{
		if (empty($this->{$attribute}) || empty( Yii::app()->params['fileParams']['type'][$type]))
			return '';

		$params = Yii::app()->params['fileParams']['type'][$type];
		return  $params['folder']. '/' . $this->{$attribute};
	}


	public function sum($field, CDbCriteria $criteria = null)
	{
		if (empty($criteria))
			$criteria = new CDbCriteria();

		$criteria->select = 'SUM(t.'.$field.') as sum';
		$data = ActiveRecord::model(get_class($this))->find($criteria);
		return $data->sum;
	}



	public function scopeRubric($rubricId)
	{
		if($rubricId < 1)
			return $this;

		$tableAlias = $this->getTableAlias(false, false);
		$this->getDbCriteria()->mergeWith(array(
			'condition' => $tableAlias.'.rubric_id = :rubricId',
			'params' => array(
				':rubricId' => $rubricId,
			),
		));
		return $this;
	}


	


	public function afterDelete()
	{
		if (in_array(get_class($this), array('Story', 'PhotoStory', 'Figure'))) {
			$essence = $this->getEssence();
			Document::model()->deleteAllByAttributes(array('essence'=>$essence, 'essence_id' => $this->id));
		}
		parent::afterDelete();
	}


	public function getEssence()
	{
		return strtolower(get_class($this));
	}


	/**
	 * Изображение отдельной сущности
	 * @param $type
	 * @param string $attribute
	 * @param bool $create
	 * @param null $modelType
	 * @return mixed
	 */
	public function getDocumentImageSrc($type, $attribute='image', $create = false)
	{
		$essence = $this->getEssence();
		$type = $essence.'/'.$type;
		return $this->getImageSrc($type, $attribute, $create, $essence);
	}

}
