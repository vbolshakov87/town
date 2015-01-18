<?/**
 * @var $story Story
 * @var $this FrontController
 */
$this->layout = 'page';
$this->contentClass = 'width photos cf content-'.$this->id.'-detail';


$title = TextModifier::textForMetaTag(CHtml::encode(CHtml::decode($story->title)));
$keywords = $title;
$description = TextModifier::textForMetaTag($story->brief);
$pageUrl = Yii::app()->createAbsoluteUrl('story/view', array('id'=>$story->id));
$image = $story->getImageSrc('story/detail', 'image', true);
$this->renderPartial('webroot.themes.yar.views._pageMetaTags', array('title' => $title, 'keywords' => $keywords, 'description' => $description, 'pageUrl' => $pageUrl, 'image' => $image));

?>
<h1><?=$story->title?></h1>

<?if (!empty($story->image)) :
$imageSrc = $story->getImageSrc('story/thumb', 'image', true);
$imageDetailSrc = $story->getImageSrc('story/detail', 'image', true);
?>
<a href="<?=$imageDetailSrc?>" class="fancybox"><img src="<?=$imageSrc?>" alt="<?=$story->title?>" class="photo-top"></a>

<?endif;?>
<?$this->renderPartial('webroot.themes.yar.views._detailPageRatingStars', array('model' => $story));?>
<?=$story->content;?>
<img src="<?=Yii::app()->createUrl('story/stat', array('id' => $story->id))?>" style="display:none; width:1px; height:1px" />

<?$this->widget('StoryGalleryWidget', array('galleryPhotos' => $story->gallery, 'view' => '_StoryGalleryFotoramaWidget'))?>

<?$this->renderPartial('webroot.themes.yar.views._itemStat', array('item' => $story))?>
	