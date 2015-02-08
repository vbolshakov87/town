<?php

/**
 * Crop image for the exect format
 * Class ImageCropWidget
 */
class ImageCropWidget extends ImageUploadWidget
{
    protected $_view = '_ImageCropWidget';
    protected $_fromFileSrc = '';
    protected $_fileOriginalSrc = '';
    protected $_fromFileSize = array();
    public $cropFrom = '';
    public $cropFromType = '';
    public $minWidth = 100;
    public $minHeight = 100;
    public $previewType = '';

    public function init()
    {
        parent::init();
        $this->_fromFileSrc = $this->model->getImageSrc($this->cropFromType, $this->cropFrom, true);
        $this->_fromFileSize = $this->model->getImageSize($this->cropFromType, $this->cropFrom);
        if (!empty($this->previewType)) {
            $this->_fileOriginalSrc = $this->model->getImageSrc($this->previewType, $this->attribute, true);
        }
    }


    public function run() {
        $this->render($this->_view, array(
            'src' => $this->_src,
            'fromFileSrc' => $this->_fromFileSrc,
            'fromFileSize' => $this->_fromFileSize,
            'attribute' => $this->attribute,
            'fileOriginalSrc' => $this->_fileOriginalSrc,
            'fileSrc' => $this->_fileSrc,
            'model' => $this->model,
            'minWidth' => $this->minWidth,
            'minHeight' => $this->minHeight,
        ));
    }
} 