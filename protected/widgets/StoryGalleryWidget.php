<?php
/**
 * Фотогалерея в статье
 */
class StoryGalleryWidget extends CWidget
{
	public $galleryPhotos;
	public $view = '_StoryGalleryWidget';

	protected $_gallery;


	public function init(){}

	public function run()
	{
		$this->render($this->view, array('gallery' => $this->galleryPhotos));
	}
}