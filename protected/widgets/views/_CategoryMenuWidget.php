<div class="addtool form">
	<select name="category" class="sel" id="category_change" data-base_url="<?=Yii::app()->createUrl($type.'/index')?>">
		<option value="all">Материал их всех категорий</option>
		<?foreach ($data as $category) :?>
			<option value="<?=$category['id']?>"<?if ($category['id'] == $activeRubric) :?> selected="selected" <?endif;?>><?=$category['title']?></option>
		<?endforeach;?>
	</select>
	<input type="button" name="h" value="Написать историю или анализ" class="btn">
</div>