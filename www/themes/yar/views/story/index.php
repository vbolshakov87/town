<?
/**
* @var $items Story[]
* @var $this FrontController
* @var $countRemains
* @var $page
*/
$pager = new CPagination($countAll);
$pager->pageSize = $limit;
$pager->pageVar = 'page';
?>
<div class="col-cont box">
	<section class="publications">
        <?foreach ($items as $story) :
            $image = $story->getDocumentImageSrc('itemsList', 'image', true);
            $url = Yii::app()->createUrl('story/view', array('id'=>$story->id));
            if (empty($story->brief)) {
                $story->brief = TextModifier::stripTextWords( strip_tags($story->content), 0, 250, '&hellip;');
            }
            $story->brief = TextModifier::stripTextWords( strip_tags($story->brief), 0, 250, '&hellip;');
        ?>
            <div class="publications__article">

                <?if (!empty($image)):?>
                    <a href="<?=$url?>" class="items-list__img-link items-list__img-link-story" data-bordercolor="#6fc068"><img src="<?=$image?>" alt="<?=TextModifier::textForMetaTag($story->title)?>" class="publication__img publication__img-story"></a>
                <?endif;?>
                <a href="<?=$url?>" class="publications__title"><?=$story->title?></a>
                <div class="publications__brief"><?=$story->brief?></div>
                <?$this->renderPartial('webroot.themes.yar.views._documentItemCounts', array('item' => $story))?>
                <div class="clear"></div>
            </div>
        <?endforeach;?>
	</section>
    <?$this->widget('LinkPager', array('pages' => $pager, 'showLastPage' => true)); ?>
</div>