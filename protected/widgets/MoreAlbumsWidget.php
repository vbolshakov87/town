<?php

/**
 * Class MoreAlbumsWidget
 * Photo galleries for additional images
 */
class MoreAlbumsWidget extends CWidget
{
    public $currentId = null;
    public $limit = 2;

    protected $_data = array();

    public function init()
    {
        $criteria = new CDbCriteria(array(
            'order' => 'rand()',
            'limit' => $this->limit,
            'condition' => 't.id != :currentId',
            'params' => array(
                ':currentId' => $this->currentId
            ),
        ));
        $criteria->addCondition('(SELECT count(1) from gallery_photo where gallery_photo.essence = \'photo_story\' and gallery_photo.`essence_id` = t.id limit 0,1) > 7');

        $this->_data = PhotoStory::model()->findAll($criteria);
        foreach ($this->_data as $gallery) {
            $gallery->gallery;
        }
    }


    public function run()
    {
        $this->render('_MoreAlbumsWidget', array('data' => $this->_data));
    }
} 