<?
/**
 * @var $items Story[]
 * @var $this FrontController
 */
foreach ($items as $story) :
	$this->renderPartial('_listItem', array('item' => $story));
endforeach;?>
