<?if (!empty($fileInfo)) :?>
	<span class="image-del">
	<a href="<?=$fileInfo['src']?>" target="_blank"><i class="icon-attach-1" style="font-weight: bold; font-size: 17px; margin-left: -1px;"></i></a>
    <label class="checkbox" style="display: inline; padding: 0 6px;">
	    <input type="checkbox" value="1" name="<?=get_class($this->model)?>[<?=$attribute?>_del]" style="float: none; margin: 0" />
	    Удалить
    </label>или&nbsp;&nbsp;
</span>
<?endif;?>
<?=CHtml::activeFileField($model, $attribute);?>