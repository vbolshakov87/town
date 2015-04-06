<?/**
 * @var $data PhotoStory[]
 */ ?>
<?if (!empty($data)) :?>
    <h3>Другие истории в фотографиях</h3>
    <?foreach ($data as $k => $item) :?>
        <div class="preview-gallery-wrapper<?if ($k==0):?> preview-gallery-wrapper-first<?endif?>">
            <a href="<?=Yii::app()->createUrl('photoStory/view', array('id' => $item->id))?>"><?=$item->title;?></a>
            <article class="preview-gallery">
            <?
            $countGallery = count($item->gallery);
            $k = 0;
            foreach ($item->gallery as $galleryItem) :
                $imageSrc = $galleryItem->getImageSrc('photoStoryDetail/thumb2', 'image', true);
                $galleryUrl = Yii::app()->createUrl('photoStory/view', array('id' =>$item->id)).'#gallery'.$galleryItem->id;
                if (empty($imageSrc)) continue;
                $k++;
                if ($k>15) break;
            ?>
                <div class="mosaicflow__item">
                    <a href="<?=$galleryUrl?>"><img src="<?=$imageSrc;?>" alt="<?=$galleryItem->name;?>" /></a>
                </div>
            <?endforeach;?>
            </article>
            <div class="clear"></div>
        </div>
    <?endforeach;?>
    <div class="clear"></div>
<?endif;?>