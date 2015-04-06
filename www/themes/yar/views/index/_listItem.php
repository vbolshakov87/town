<?/**
 * @var $item Document
 * @var $this FrontController
 */
?>
<article>
	<h2><a href="<?=$item->createUrl()?>"><?=$item->title?></a></h2>
	<div class="pre"><?=$item->brief?></div>
	<?$this->renderPartial('webroot.themes.yar.views._documentItemCounts', array('item' => $item))?>
</article>