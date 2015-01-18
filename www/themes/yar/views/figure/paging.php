<?
/**
 * @var $items Figure[]
 * @var $this FrontController
 */
foreach ($items as $figure) :
	$this->renderPartial('_listItem', array('item' => $figure));
endforeach;?>
