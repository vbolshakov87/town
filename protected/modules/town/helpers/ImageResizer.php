<?php
/**
 * Class ImageResizer
 * @property $_im Imagick
 */
class ImageResizer {

	public $srcPath;
	public $destPath;

	public $srcExtention;
	public $destExtention;

	public $destX;
	public $destY;
	public $destCropX = null;
	public $destCropY = null;

	public $srcX;
	public $srcY;

	protected $_destQuality = 100;

	protected $_im;
	protected $_cropBy = 'X';           // X - обрезать слева и справа, Y - обрезать сверху и снизу

	// Опции
	protected $_saveAnimation = false;  // Сохранить анимацию
	protected $_saveFit = false;        // true - вписать изображение (сохранять пропорции), false - растягивать изображение (не сохранять пропорции)


	protected $extentionToMIME = array(
					'jpg' => 'image/jpeg',
					'png' => 'image/png',
					'gif' => 'image/gif',
					'bmp' => 'image/bmp'
	);

	public function __construct($srcPath = null, $destPath = null, $destX = 0, $destY = 0)
	{
		if(!empty($srcPath) && !empty($destPath)){
			$this->setSrcPath($srcPath);
			$this->setDestPath($destPath);
		}

		if(!empty($destX) && !empty($destY)){
			$this->setDimension($destX, $destY);
		}
	}

	public function __destruct()
	{
		if(!empty($this->_im)){
			$this->_im->clear();
			$this->_im->destroy();
		}
	}

	public function resize ()
	{
		$this->srcX = $this->_im->getImageWidth();
		$this->srcY = $this->_im->getImageHeight();

		if($this->srcX <= $this->destX && $this->srcY <= $this->destY){
			return $this;
		}

		if($this->_saveAnimation && $this->destExtention === 'gif'){
			$this->resizeAnimate();
		}
		else{
			$this->resizeStatic();
		}

		return $this;
	}

	public function resizeAnimate ()
	{
		foreach($this->_im as $frame){
			$frame->scaleImage( $this->destX, $this->destY, $this->_saveFit);
		}
		return $this;
	}

	public function resizeStatic ()
	{
		$this->_im->setCompressionQuality($this->_destQuality);
		$this->_im->scaleImage( $this->destX, $this->destY, $this->_saveFit);
		return $this;
	}

	public function crop ()
	{
		if($this->_saveAnimation && $this->destExtention === 'gif'){
			$this->cropAnimate();
		}
		else{
			$this->cropStatic();
		}
		return $this;
	}

	public function cropAnimate ()
	{
		foreach($this->_im as $frame){
			if (!is_null($this->destCropX) || !is_null($this->destCropY)) {
				$frame->cropImage($this->destX, $this->destY, $this->destCropX, $this->destCropY);
			}
			else {
				$frame->cropThumbnailImage( $this->destX, $this->destY);
			}
		}
		return $this;
	}

	public function cropStatic ()
	{

		$this->_im->setCompressionQuality($this->_destQuality);
		if (!is_null($this->destCropX) || !is_null($this->destCropY)) {
       //     echo "<pre>";print_r(array($this->destX, $this->destY, $this->destCropX, $this->destCropY));echo "</pre>";exit;
			$this->_im->cropImage($this->destX, $this->destY, $this->destCropX, $this->destCropY);
		}
		else {
			$this->_im->cropThumbnailImage($this->destX, $this->destY);
		}
		return $this;
	}

	public function save ()
	{
		if($this->_saveAnimation && $this->destExtention === 'gif'){
			$this->saveAnimate();
		}
		else{
			$this->saveStatic();
		}
	}

	public function saveAnimate ()
	{
		$this->_im->writeImages($this->destPath, true);
	}

	public function saveStatic ()
	{
		$this->_im->writeImage($this->destPath);
	}

	public function out ()
	{
		header('Content-type: ' . $this->extentionToMIME[$this->destExtention]);
		echo $this->_im->getImageBlob();
	}


	protected function createImagick ($srcPath)
	{
		$this->_im = new Imagick($srcPath);
		return $this->_im;
	}

	public function getImagick ()
	{
		return $this->_im;
	}

	public function setSrcPath ($srcPath, $srcExtention = null)
	{
		$this->srcPath = $srcPath;
		$this->srcExtention = !empty($srcExtention) ? $srcExtention : $this->getExtention($srcPath);
		$this->createImagick($srcPath);
	}

	public function setDestPath ($destPath)
	{
		if(empty($this->srcExtention))
			throw new Exception('Не указан файл источника или он не имеет расширения');

		$this->destPath = $destPath;
		$this->destExtention = $this->getExtention($destPath);

		if($this->srcExtention !== $this->destExtention){
			$this->changeImageType();
		}
	}

	public function setDimension ($destX = 0, $destY = 0)
	{
		$this->destX = $destX;
		$this->destY = $destY;
		return $this;
	}
	
	public function getExtention ($filename)
	{
		return substr(strrchr($filename, '.'), 1);
	}

	protected function changeImageType ($destExtention = null)
	{
		if($destExtention === null)
			$destExtention = $this->destExtention;
		switch ($destExtention){
			case 'jpg':
			case 'jpeg':
				$this->_im->setCompressionQuality($this->_destQuality);
				$imageFormat = 'jpeg';
				break;
			default:
				$imageFormat = $destExtention;
		}
		$this->_im->setImageFormat($imageFormat);
		return $this;
	}

	public function saveAnimation ($saveAnimation = true)
	{
		$this->_saveAnimation = $saveAnimation;
		return $this;
	}

	public function saveFit ($saveFit = true)
	{
		$this->_saveFit = $saveFit;
		return $this;
	}


	public function setQuality ($quality)
	{
		$this->_destQuality = $quality;
		return $this;
	}


	public function stripImage()
	{
		$this->_im->stripImage();
		return $this;
	}
	
}
