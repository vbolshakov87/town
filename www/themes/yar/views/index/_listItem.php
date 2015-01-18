<?/**
 * @var $item Document
 * @var $this FrontController
 */
$itemUrl = Yii::app()->createUrl( $item->essence.'/view', array('id'=>$item->essence_id));
?>
<article>
	<h2><a href="<?=$itemUrl?>"><?=$item->title?></a></h2>
	<div class="pre"><?=$item->brief?></div>
	<?$this->renderPartial('webroot.themes.yar.views._documentItemCounts', array('item' => $item))?>
</article>


