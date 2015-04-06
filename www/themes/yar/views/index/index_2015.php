<?/**
 * @var $this FrontController
 * @var $items Document[]
 * @var $page int
 * @var $countRemains int
 */
$columns = 3;
$countList = Yii::app()->params['countList'];
$tdItems = array();
for ($i=0; $i<$columns; $i++) {
    $tdItems[$i] = array();
}
$i = 0;
foreach ($items as $item) {
    if ($i == $columns) $i = 0;
    if (empty($item->brief)) {
        $item->brief = TextModifier::stripTextWords( strip_tags($item->content), 0, 150);
    }
    $item->brief = TextModifier::stripTextWords( strip_tags($item->brief), 0, 150, '&hellip;');
    $tdItems[$i][] = $item;
    $i++;
}
$pager = new CPagination($countAll);
$pager->pageSize = $limit;
$pager->pageVar = 'page';
?>

<?$this->widget('TopDocumentsWidget', array('limit' => 1, 'view' => '1column', 'columns' => 1))?>


<section id="mainlist" class="mainlist-2015">
    <table class="items-list">
        <tr>
            <?for ($i=0; $i < $columns; $i++) :?>
            <td class="items-list__td">
                <?foreach ($tdItems[$i] as $item) :
                    $image = '';
                    $images = array();
                    /** @var Document $item */
                    if ($item->essence == 'photo_story') {
                        $k = 0;
                        /** @var PhotoStory $photoStory */
                        $photoStory = $item->photoStory;
                        $countOfColumns = 3;
                        $countGallery = count($photoStory->gallery);
                        $images = array();
                        foreach ($photoStory->gallery as $galleryItem) {
                            /** @var GalleryPhoto $galleryItem */
                            $imageSrc = $galleryItem->getImageSrc('gallery/photoStoryItemsList', 'image', true);
                            if (empty($imageSrc))
                                continue;

                            $galleryUrl = Yii::app()->createUrl('photoStory/view', array('id' =>$item->id)).'#gallery'.$galleryItem->id;
                            $images[$galleryItem->id] = array(
                                'src' => $imageSrc,
                                'url' => $galleryUrl,
                                'title' => TextModifier::textForMetaTag($galleryItem->name),
                            );
                            $k++;
                            if (($countGallery < 6 && $k==4) || $k == 6) break;
                        }
                    } else {
                        $image = $item->getDocumentImageSrc('itemsList', 'image', true);
                    }
                    $url = $item->createUrl();
                    $essenceData = $item->getEssenceTitleLink();

                ?>
                    <div class="items-list__item">
                        <a href="<?=$essenceData['link']?>" class="items-list__block-title"><?=$essenceData['label']?></a>
                        <?if ($item->essence != 'photo_story' && !empty($image)):?>
                            <a href="<?=$url?>" class="items-list__img-link"><img src="<?=$image?>" alt="<?=TextModifier::textForMetaTag($item->title)?>" class="items-list__img"></a>
                        <?endif;?>
                        <?if (!empty($images)) :?>
                            <div class="items-list__gallery">
                                <?foreach ($images as $galleryItem) :?>
                                    <a href="<?=$galleryItem['url']?>">
                                        <img data-original="<?=$galleryItem['src']?>" alt="<?=$galleryItem['title']?>" src="<?=$galleryItem['src']?>" class="items-list__photo lazy">
                                    </a>
                                <?endforeach?>
                            </div>
                        <?endif;?>
                        <a class="items-list__title" href="<?=$url?>"><?=$item->title?></a>
                        <div class="items-list__brief"><?=$item->brief?></div>
                    </div>
                <?endforeach;?>
            </td>
            <?endfor;?>
        </tr>
    </table>

    <?$this->widget('LinkPager', array('pages' => $pager, 'showLastPage' => true)); ?>
</section>

<div class="col-cont box">
    <article class="why">
        <?$this->widget('ContentBlockWidget', array('name' => 'why'));?>
    </article>
</div>