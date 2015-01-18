<?
/**
 * @var $this CWidget
 * @var $attribute
 * @var $model ActiveRecord
 */
if (!empty($fileSrc)) :?>
	<span class="image-del">
	<img src="<?=$fileSrc?>" alt="" style="max-width: 200px; display: block;" />
    <label class="checkbox" style="display: inline; padding: 0 6px;">
	    <input type="checkbox" value="1" name="<?=get_class($this->model)?>[<?=$attribute?>_del]" style="float: none; margin: 0" />
	    Удалить
    </label>или&nbsp;&nbsp;
</span>
<?endif;?>
<?=CHtml::activeFileField($model, $attribute);?>
<div class="clear-fix"></div>