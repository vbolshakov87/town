<?php
class GalleryAdminWidget extends CWidget
{
    public $config=array();
    protected  $_gallery;
    public $essence;
    public $essence_id;

    public function init()
    {
	    $this->_gallery = GalleryPhoto::model()->findAllByAttributes(array('essence' => $this->essence, 'essence_id' => $this->essence_id), array('order' => 't.sort ASC, t.id DESC'));
    }

    public function run()
    {
	    Yii::app()->clientScript->registerCoreScript( 'jquery.ui' );
	    Yii::app()->clientScript->registerScriptFile('/ajax_upload/swfobject.js');
	    Yii::app()->clientScript->registerScriptFile('/ajax_upload/jquery.uploadify.v2.1.4.min.js');
	    Yii::app()->clientScript->registerCssFile('/ajax_upload/uploadify.css');

        $this->render("_GalleryAdminWidget", array('gallery' => $this->_gallery));
    }

}