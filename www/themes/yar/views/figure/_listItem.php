<?/**
 * @var $item Figure
 */
$figureUrl = Yii::app()->createUrl('figure/view', array('id'=>$item->id));
?>
<article>
	<h2><a href="<?=$figureUrl?>"><?=$item->title?></a></h2>
	<div class="pre"><?=$item->brief?></div>
	<?$this->renderPartial('webroot.themes.yar.views._documentItemCounts', array('item' => $item))?>
</article>
