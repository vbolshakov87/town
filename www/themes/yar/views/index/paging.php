<?
/**
 * @var $items Document[]
 * @var $this FrontController
 */
foreach ($items as $item) :
	$this->renderPartial('_listItem', array('item' => $item));
endforeach;?>
