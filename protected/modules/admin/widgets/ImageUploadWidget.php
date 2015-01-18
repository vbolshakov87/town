<?php
/**
 * Добавление фото в форме
 */
class ImageUploadWidget extends CWidget
{
	public $type = ''; // тип изображения из параметров
	public $attribute; // по какому полю
	public $model = null; // модель (одна запись)

	protected $_fileSrc = '';
	protected $_src; // название файла


	public function init()
	{
		$this->_src = $this->model->{$this->attribute};
		$this->_fileSrc = $this->model->getImageSrc($this->type, $this->attribute, true);
	}


	/**
	 * Runs the widget.
	 * This registers the necessary javascript code and renders the form close tag.
	 */
	public function run() {
		$this->render('_ImageUploadWidget', array(
			'src' => $this->_src,
			'attribute' => $this->attribute,
			'fileSrc' => $this->_fileSrc,
			'model' => $this->model
		));
	}

}