<?php

/**
 * Class FotoramaWidget
 * Фотогалерея fotorama
 * @link http://fotorama.io/
 *
 * @property GalleryPhoto[] $galleryPhotos
 */
class FotoramaWidget extends CWidget
{
	public $galleryPhotos = array();

	protected $_data = array();
	public $height = 500;
	public $width = 1000;

	public function init()
	{
		foreach ($this->galleryPhotos as $photo) {

			$photoSrc = $photo->getImageSrc('photoStoryDetail/list', 'image', true);
			$photoNavSrc = $photo->getImageSrc('photoStoryDetail/thumb', 'image', true);


			if (empty($photoSrc)) {
				continue;
			}

			if (!empty($photo->width) && !empty($photo->height)) {
				$height = $photo->height > $this->height ? $this->height : $photo->height;
				$width = floor($height*$photo->width/$photo->height);

				$sizeString = 'width="'.$width.'" height="'.$height.'"';
			}
			else {
				$size = getimagesize($_SERVER['DOCUMENT_ROOT'].$photoNavSrc);
				$sizeString = $size[3];
			}


			$this->_data[] = array(
				'id' => 'gallery'.$photo->id,
				'title' => htmlspecialchars($photo->name),
				'photoSrc' => $photoSrc,
				'photoNavSrc' => $photoNavSrc,
				'size' => $sizeString,
				'sizeOriginal' => array(
                    'width' => $photo->width,
                    'height' => $photo->height,
                ),
			);
		}

	}


	public function run()
	{
		$this->render('fotorama/photos', array('data'=>$this->_data));
	}
} 