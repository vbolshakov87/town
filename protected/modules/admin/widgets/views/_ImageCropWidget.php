<?
/**
 * @var $this CWidget
 * @var $attribute
 * @var $fromFileSrc
 * @var $fileSrc
 * @var $minWidth
 * @var $minHeight
 * @var $model ActiveRecord
 * @var $fromFileSize
 */
$cropId = 'jcrop_target_'.md5(time().rand(1,100000));
?>
<?if (!empty($fileOriginalSrc)) :?>
    <span class="image-del">
	    <?if (!empty($fileOriginalSrc)):?>
            <a class="fancybox" href="<?=$fileOriginalSrc?>">
        <?endif;?>
        <img src="<?=!empty($fileOriginalSrc) ? $fileOriginalSrc : $fileSrc?>" alt="" style="max-width: 1000px; display: block;" />
        <?if (!empty($fileOriginalSrc)):?>
            </a>
        <?endif;?>
        <label class="checkbox" style="display: inline; padding: 0 6px;">
            <input type="checkbox" value="1" name="<?=get_class($this->model)?>[<?=$attribute?>_del]" style="float: none; margin: 0" />
            Удалить
        </label>или&nbsp;&nbsp;
    </span>
<?endif;?>
<?=CHtml::activeFileField($model, $attribute);?>
<div class="clear-fix"></div>
<?if (!empty($fromFileSize) && $fromFileSize[0] >= $minWidth && $fromFileSize[1] >= $minHeight) :?>
    <button type="button" class="btn btn-primary btn-sm crop-id-toggle" id="<?=$cropId?>_toggle">Вырезать из основного изображения</button>
    <div id="<?=$cropId?>_wrapper" class="crop-id-wrapper crop-id-wrapper-hidden">
        <img src="<?=$fromFileSrc?>" id="<?=$cropId?>" />
        <input type="hidden" size="4" id="<?=$cropId?>_x" name="<?=get_class($this->model)?>[crop_<?=$attribute?>][x]" disabled="disabled" />
        <input type="hidden" size="4" id="<?=$cropId?>_y" name="<?=get_class($this->model)?>[crop_<?=$attribute?>][y]" disabled="disabled" />
        <input type="hidden" size="4" id="<?=$cropId?>_x2" name="<?=get_class($this->model)?>[crop_<?=$attribute?>][x2]" disabled="disabled" />
        <input type="hidden" size="4" id="<?=$cropId?>_y2" name="<?=get_class($this->model)?>[crop_<?=$attribute?>][y2]" disabled="disabled" />
        <input type="hidden" size="4" id="<?=$cropId?>_w" name="<?=get_class($this->model)?>[crop_<?=$attribute?>][w]" disabled="disabled" />
        <input type="hidden" size="4" id="<?=$cropId?>_h" name="<?=get_class($this->model)?>[crop_<?=$attribute?>][h]" disabled="disabled" />
    </div>
    <script>
        $(function(){

            var $wrapper = $('#<?=$cropId?>_wrapper');
            $('#<?=$cropId?>_toggle').click(function(e){
                e.preventDefault();
                $wrapper.toggleClass('crop-id-wrapper-hidden').find('input').each(function(){
                    if ($(this).attr('disabled') !== undefined) {
                        $(this).removeAttr('disabled');
                    } else {
                        $(this).attr('disabled', 'disabled');
                    }
                });
            });

            var aspectRatio = <?=($minWidth/$minHeight)?>,
                padding = 10,
                minSizeW = <?=$minWidth?>,
                minSizeH = <?=$minHeight?>,
                maxSizeX = <?=$fromFileSize[0]?>,
                maxSizeY = maxSizeX * minSizeH / minSizeW;
            if (maxSizeY > <?=$fromFileSize[1]?>) {
                maxSizeY = <?=$fromFileSize[1]?>;
                maxSizeY = maxSizeY * minSizeW / minSizeH;
            }

            var selected = {
                    left_width : padding,
                    left_height : padding,
                    right_width : maxSizeX - padding,
                    right_height : (maxSizeY - padding)/aspectRatio
                },
                params  = {
                    minSize : [w=minSizeW,h=minSizeH],
                    aspectRatio : aspectRatio,
                    onChange: showCoords<?=$cropId?>,
                    onSelect: showCoords<?=$cropId?>
                };

            $('#<?=$cropId?>').Jcrop(params, function(){
                jcrop_api = this;
                jcrop_api.setSelect([selected.left_width, selected.left_height, selected.right_width, selected.right_height])
            });


        });
        function showCoords<?=$cropId?>(c) {
            $('#<?=$cropId?>_x').val(c.x);
            $('#<?=$cropId?>_y').val(c.y);
            $('#<?=$cropId?>_x2').val(c.x2);
            $('#<?=$cropId?>_y2').val(c.y2);
            $('#<?=$cropId?>_w').val(c.w);
            $('#<?=$cropId?>_h').val(c.h);
        }
    </script>
<?else :?>
    <div class="alert alert-warning" role="alert">Оригинал не подходит для создания нужного изображения</div>
<?endif;?>
