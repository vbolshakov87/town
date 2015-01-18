<?php
/**
 * @var $items PhotoStory[]
 * @var $this FrontController
 * @var $countRemains
 * @var GalleryPhoto $galleryItem
 * @var $page
 * @var $countAll
 * @var $limit
 */
$this->contentClass = 'width photos cf photo-page';
$this->layout = 'column1';
$defaultColumns = array();
$countOfColumns = 4;
for ($i=0; $i<$countOfColumns; $i++) {
	$defaultColumns[$i] = array();
}
$imageSrcArr = array();


$pager = new CPagination($countAll);
$pager->pageSize = $limit;
$pager->pageVar = 'page';

?>
<?foreach ($items as $item) :?>
<h2><a href="<?=Yii::app()->createUrl($this->getRoute(), array('century' => Date::getCentury($item->date_begin, 'param')))?>"><?=Date::getCentury($item->date_begin);?> век</a></h2>
<h3><a href="<?=Yii::app()->createUrl('photoStory/view', array('id' => $item->id))?>"><?=$item->title;?></a></h3>
<article class="cf">
	<?
	$k = 0;
	$columns = $defaultColumns;
	foreach ($item->gallery as $galleryItem) {
		$imageSrc = $galleryItem->getImageSrc('gallery/photoStoryList', 'image', true);
		if (empty($imageSrc))
			continue;

		$imageSrcArr[$galleryItem->id] = $imageSrc;
		$columns[$k%$countOfColumns][] = $galleryItem;
		$k++;
	}?>
	<?foreach ($columns as $k => $column) :?>
	<div class="col col<?=($k+1);?>">
		<?foreach ($column as $galleryItem) :
			$galleryUrl = Yii::app()->createUrl('photoStory/view', array('id' =>$item->id)).'#gallery'.$galleryItem->id;
			$imageSrc = $imageSrcArr[$galleryItem->id];?>
		<figure onclick="location.href='<?=$galleryUrl?>'">
			<img src="<?=$imageSrc;?>" alt="<?=$galleryItem->name;?>">
			<figcaption class="cf" onclick="location.href='<?=$galleryUrl;?>'">
				<span><?=$galleryItem->name;?></span>
				<div>
					<a class="h" href="<?=$galleryUrl;?>"></a> | <a class="s" href="<?=$galleryUrl;?>"></a>
				</div>
			</figcaption>
		</figure>
		<?endforeach;?>
	</div>
	<?endforeach;?>
</article>
<?endforeach;?>
<?$this->widget('LinkPager', array('pages' => $pager, 'showLastPage' => true)); ?>