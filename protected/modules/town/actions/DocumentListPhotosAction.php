<?php
/**
 * Created by PhpStorm.
 * User: vbolshakov
 * Date: 3/5/14
 * Time: 11:08 AM
 */

class DocumentListPhotosAction extends DocumentListRedactionAction
{
	protected function _getCriteria()
	{
		$criteria = $this->_getBaseCriteria();
	//	$criteria->together = true;
	//	$criteria->with[] = 'gallery';
		$criteria->scopes[] = 'active';
		$criteria->scopes['scopeRubric'] =  array('rubricId' => $this->_rubricId);
        $criteria->addCondition('(SELECT count(1) from gallery_photo where gallery_photo.essence = \'photo_story\' and gallery_photo.`essence_id` = t.id limit 0,1) > 0');
		return $criteria;
	}

    protected function _getCountAll()
    {
        $criteria = $this->_getCriteria();

        return ActiveRecord::model($this->modelClass)->active()->count($criteria);
    }
} 