<?php
/**
 * Виджет загрузки файлов через админку
 */
class FileUploadWidget extends CWidget
{
	public $type = 'form'; // тип изображения из параметров
	public $attribute; // по какому полю
	public $model = null; // ActiveRecord
	protected $_fileInfo = array();
	protected $_src; // название файла


	public function init()
	{
		$this->_src = $this->model->{$this->attribute};
		$this->_fileInfo = File::getFileInfo('fotoobraz/pdf', $this->_src);
	}


	/**
	 * Runs the widget.
	 * This registers the necessary javascript code and renders the form close tag.
	 */
	public function run() {
		$this->render('_FileUploadWidget', array(
			'src' => $this->_src,
			'attribute' => $this->attribute,
			'fileInfo' => $this->_fileInfo,
			'model' => $this->model
		));
	}
}