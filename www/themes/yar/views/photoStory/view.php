<?
/**
 * @var $photoStory PhotoStory
 * @var $this FrontController
 */
$this->contentClass = 'width photos cf photo-page photo-page-detail';
$this->layout = 'column1';

$title = TextModifier::textForMetaTag(CHtml::encode(CHtml::decode($photoStory->title)));
$keywords = $title;
$description = TextModifier::textForMetaTag($photoStory->brief);
$pageUrl = Yii::app()->createAbsoluteUrl('photoStory/view', array('id'=>$photoStory->id));
$image = $photoStory->getImageSrc('photoStory/detail', 'image', true);
$this->renderPartial('webroot.themes.yar.views._pageMetaTags', array('title' => $title, 'keywords' => $keywords, 'description' => $description, 'pageUrl' => $pageUrl, 'image' => $image));
?>

<h1><?=$photoStory->title?></h1>
<article class="cf">
	<div class="detail-gallery-description">
		<?=$photoStory->content;?>
	</div>
	<?$this->widget('FotoramaWidget', array('galleryPhotos' => $photoStory->gallery));?>
</article>
<p class="back-to-list"><a href="<?=Yii::app()->createUrl('photoStory/index')?>">Назад к списку фотогалерей</a></p>
<?$this->renderPartial('webroot.themes.yar.views._itemStat', array('item' => $photoStory))?>
<?$this->renderPartial('webroot.themes.yar.views._detailPageRatingStars', array('model' => $photoStory));?>
<div class="gallery-page-buttons">
	<?$this->renderPartial('webroot.themes.yar.views._pageButtons');?>
</div>