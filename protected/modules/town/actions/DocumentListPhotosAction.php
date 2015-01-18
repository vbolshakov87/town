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
		return $criteria;
	}
} 