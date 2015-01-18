<?/**
 * @var $figure Figure
 * @var $this FrontController
 */

$title = TextModifier::textForMetaTag(CHtml::encode(CHtml::decode($figure->title)));
$keywords = $title;
$description = TextModifier::textForMetaTag($figure->brief);
$pageUrl = Yii::app()->createAbsoluteUrl('story/view', array('id'=>$figure->id));
$image = $figure->getImageSrc('figure/detail', 'image', true);
$this->renderPartial('webroot.themes.yar.views._pageMetaTags', array('title' => $title, 'keywords' => $keywords, 'description' => $description, 'pageUrl' => $pageUrl, 'image' => $image));

$this->contentClass = 'width photos cf content-'.$this->id;
$this->layout = 'page';
?>
<h1><?=$figure->title?></h1>

<?if (!empty($figure->image)) :
$imageSrc = $figure->getImageSrc('figure/thumb', 'image', true);
?>

<figure class="fig cf" style="float: left">
	<img src="<?=$imageSrc?>" alt="<?=$figure->title?>">
</figure>
<?endif;?>
<?$this->renderPartial('webroot.themes.yar.views._detailPageRatingStars', array('model' => $figure));?>
<?=$figure->content;?>
<img src="<?=Yii::app()->createUrl('figure/stat', array('id' => $figure->id))?>" style="display:none; width:1px; height:1px" />

<?$this->widget('StoryGalleryWidget', array('galleryPhotos' => $figure->gallery, 'view' => '_StoryGalleryFotoramaWidget'))?>

<?$this->renderPartial('webroot.themes.yar.views._itemStat', array('item' => $figure))?>