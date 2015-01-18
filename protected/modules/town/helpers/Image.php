<?php
class ImageResizerPSException extends CException {}

/**
 * Class Image
 * @property ImageResizer $_imageResizer
 */
class Image extends File
{

	protected $_imageResizer;

    public static function transform($type, $file, $name)
    {
        if (empty(Yii::app()->params['fileParams']['type'][$type])) {
	        throw new Exception('Тип изображения не задан либо задан не корректно');
        }

        $params = Yii::app()->params['fileParams']['type'][$type];

	    $path = $params['path'] . DIRECTORY_SEPARATOR . $name;
        $resize = !empty($params['resize']) && $params['resize'] === true ? true : false;
        $crop = !empty($params['crop']) && $params['crop'] === true ? true : false;

        // проверяем существование директории
        if (!file_exists(dirname($path))) mkdir(dirname($path), 0775, true);

        if (!$resize && !$crop) {
            copy($file, $path);
        }
        else {
            // размеры
            $height = 20000;
            $width = 20000;
            if (!empty($params['height'])) $height = $params['height'];
            if (!empty($params['width'])) $width = $params['width'];

            // если используется библиотека gd
            if (Yii::app()->params['imageProvider'] == 'gd') {

                $imageTransform = new ImageTransform();
                // ресайз
                if ($resize) {
                    $imageTransform->resize($file, $width, $height, $path);
                }
                // кроп
                elseif($crop) {
                    $imageTransform->crop($file, $width, $height, $path);
                }
            }
            // если используется библиотека imagick
            else {
                $imageResize = new ImageResizer($file, $path, $width, $height);

                // если не выставлены конечные размеры
                if (empty($imageResize->destX) && empty($imageResize->destY)) $imageResize->setDimension($width, $height);

                if (file_exists($path))  return true;

                // проверяем по конфигу способ изменения размера
                if ($crop) {
                    $imageResize->crop();
                }
                else {
                    $imageResize->saveFit(true)->resize();
                }
                $imageResize->save();
            }
        }
        return true;
    }


    /**
     * @static Получение разрешения файла
     * @param $file string - путь к файлу | array - массив $_FILES
     * @return string
     */
    public static function getFileTypeByFile($file)
    {
        // дефолтное значение
        $type = 'jpg';

        if (!is_array($file)) {
            $pathInfo = pathinfo($file);
            $type = $pathInfo['extension'];
        }
        else {
            if (isset($file['type']) && strpos($file['type'], 'image') !== false) {
                $typeArr = explode('/', $file['type']);
                $type = $typeArr[1];
            }
            else {
                $pathInfo = pathinfo($file['name']);
                $type = $pathInfo['extension'];
            }
        }

        $type = strtolower($type);
        if ($type == 'jpeg') $type = 'jpg';
        return $type;
    }


	/**
	 * Получение данных о фотографии
	 * @param $type
	 * @param $name
	 * @return array
	 */
	public static function getImageData($type, $name)
    {
        if (empty($name) || empty( Yii::app()->params['fileParams']['type'][$type])) return array();
        $params = Yii::app()->params['fileParams']['type'][$type];
	    $sourceType = $params['source'];

	    if (!file_exists($params['path'] . '/' . $name)) {
		    $paramsSource = Yii::app()->params['fileParams']['type'][$sourceType];
		    if (!file_exists($paramsSource['path'] . '/' . $name)) {
			    return array();
		    }
		    if (!self::transform($type, $paramsSource['path']. '/' . $name, $name)) return array();
	    }

        return array(
            'src' => $params['folder']. '/' . $name,
            'size' => getimagesize($params['path']. '/' . $name)
        );
    }



	/**
	 * @static Получение разрешения файла
	 * @param $file string - путь к файлу | array - массив $_FILES
	 * @return string
	 */
	public static function getFileNameByFile($file)
	{
		// дефолтное значение
		$type = 'jpg';

		if (!is_array($file)) {
			$pathInfo = pathinfo($file);
			$type = $pathInfo['extension'];
		}
		else {
			if (isset($file['type']) && strpos($file['type'], 'image') !== false) {
				$typeArr = explode('/', $file['type']);
				$type = $typeArr[1];
			}
			else {
				$pathInfo = pathinfo($file['name']);
				$type = $pathInfo['extension'];
			}
		}

		$type = strtolower($type);
		if ($type == 'jpeg') $type = 'jpg';
		return $type;
	}


	/**
	 * Получение разрешения файла по mine type
	 * @param $mine
	 * @return string
	 */
	public static function getExtensionByFileType($mine)
	{
		$typeArr = explode('/', $mine);
		$type = $typeArr[1];
		if ($type == 'jpeg') $type = 'jpg';

		return $type;
	}


	/**
	 * Вывод файла в браузер по пути к нему на сервере
	 * @param $fileSrc
	 */
	public static function echoFile($fileSrc)
	{
		$fileSize = getimagesize($fileSrc);

		$im = new Imagick($fileSrc);
	//	$im->setImageColorSpace(Imagick::COLORSPACE_SRGB);
		header('Content-type: '.$fileSize['mime']);
		echo $im->getImageBlob();
	}
	
	
	/**
	 * Получение отступа от которого нужно резать кроп
	 * @param $img_width int ширина изображение
	 * @param $img_height int высота изображения
	 * @param $crop_width int ширина кропа
	 * @param $crop_height int высота кропа
	 * @return array
	 */
	public static function getCropStartCoordinates($img_width, $img_height, $crop_width, $crop_height)
	{
		$offset = array();
		
		//кропим по высоте
		if($crop_width / $crop_height >= $img_width / $img_height) {
			$offset['left'] = 0;
			$offset['top'] = ($img_height - ($img_width / $crop_width) * $crop_height) / 2;
		}
		//кропим по ширине
		else {
			$offset['left'] = ($img_width - ($img_height / $crop_height) * $crop_width) / 2;
			$offset['top'] = 0;
		}
		return $offset;
	}




	/**
	 * @param $srcPath
	 * @param $destPath
	 * @param $destFileParams
	 * @param bool $rewrite
	 * @throws ImageResizerPSException
	 */
	public function createThumbnail($srcPath, $destPath, $destFileParams, $rewrite = false, $coordinates = array()) {

		if ( empty($srcPath) || empty($destPath) || empty($destFileParams))  {
			throw new ImageResizerPSException('Плохой запрос', 400);
		}

		if ( !file_exists($srcPath))  {
			throw new ImageResizerPSException('Нет исходника', 500);
		}

		if (!$rewrite && file_exists($destPath))  {
			throw new ImageResizerPSException('Невозможно переписать файл', 500);
		}

		$destPathDirName = dirname($destPath);

		// создаем все необходимые директории
		if (!is_dir($destPathDirName)){
			mkdir($destPathDirName, 0777, true);
		}

		if (!empty($destFileParams['original'])) {
			copy($srcPath, $destPath);
		}
		else {

			$srcImageData = getimagesize($srcPath);
			$extension = Image::getExtensionByFileType($srcImageData['mime']);
			$this->_imageResizer = new ImageResizer();
			$this->_imageResizer->setSrcPath($srcPath, $extension);
			$this->_imageResizer->setDestPath($destPath);
			$this->_imageResizer->setDimension($destFileParams['width'], $destFileParams['height']);
			$this->_imageResizer->setQuality($destFileParams['quality']);
			$this->_imageResizer->stripImage();

			if (!empty($destFileParams['crop'])) {

                if (empty($coordinates) && $srcImageData[0]/$srcImageData[1] == $destFileParams['width'] / $destFileParams['height']) {
                    // если для кропа нужно просто пропорцианально уменьшить изображение и не переданы координаты оригинального изображения
                    $this->_imageResizer->resize();
                }
                else {
                    if (!empty($coordinates)) {
                        $this->_imageResizer->destCropX = $coordinates['x'];
                        $this->_imageResizer->destCropY = $coordinates['y'];
                    }
                    $this->_imageResizer->crop();
                }


			}
			else {
				$this->_imageResizer->saveFit(true);
				$this->_imageResizer->resize();
			}

			$this->_imageResizer->save();
		}


	}

	/**
	 * Вывод изображения в браузер
	 */
	public function out() {

		if ( empty($this->_imageResizer))  {
			throw new ImageResizerPSException('Нет объекта imageResuzer',500);
		}
		$this->_imageResizer->out();
	}
}
