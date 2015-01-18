<?
/**
 * @var $this FrontController
 * @var $documents Document[]
 * @var $searchResults array
 * @var $totalFound
 * @var $total
 * @var $text
 * @var $pager CPagination
 */
$this->layout = 'column2';
$this->pageTitle = 'Результат поиска';
if(empty($activeLookAt)) $activeLookAt = 'all';
if(empty($activeSort)) $activeSort = 'weight';


$lookAt = array(
	'all' => 'Везде',
	'story' => 'В историях',
	'photo_story' => 'В фотоисториях',
	'figure' => 'В личностях',
);

$sortTypes = array(
	'weight' => 'релевантности',
	'date' => 'дате',
);
?>
<div class="col-cont box">
<?=Html::beginForm(Yii::app()->createUrl($this->id . '/' . $this->action->id), 'get', array('name' => 'serach_form','class' => 'search-form'));?>
	<div class="search-form__wrapper">
		<div class="search-form_what">
			<input type="text" name="q" id="query" class="search-form__input" value="<?=$text?>" />
			<input type="submit" class="search-form__submit" value="Найти"/>
		</div>
		<div class"search-form__where">
			<span class="search-form__where-title">Искать: </span>
			<?foreach($lookAt as $type => $label) :?>
				<span class="search-form__where-item">
					<label for="look-<?=$type?>"><?=$label?></label>
					<input type="radio" name="look_at" id="look-<?=$type?>" value="<?=$type?>" <? if($type == $activeLookAt) echo 'checked="checked"'; ?>>
				</span>
			<?endforeach;?>
		</div>
		<!-- Filter -->
		<div class="search-form__by">
			<span class="search-form__by-title">Сортировать по: </span>
			<?foreach($sortTypes as $type => $label) :?>
				<span class="search-form__by-item">
					<label for="sort-<?=$type?>"><?=$label?></label>
					<input type="radio" name="sort_by" id="sort-<?=$type?>" value="<?=$type?>" <? if($type == $activeSort) echo 'checked="checked"'; ?>>
				</span>
			<?endforeach;?>
		</div>

		
	</div>
<?=Html::endForm();?>
<?if(!empty($documents)) :?>
	<div class="col-cont col-cont-search box">
		<div class="foundAll">Результаты поиска (<?=$totalFound?>)</div>
		
		<div class="search-list">
			<? foreach($documents as $k => $item) :
				$itemImgSrc = $item->getDocumentImageSrc('list', 'image', true);
				$itemUrl = $item->createUrl();
				$brief = TextModifier::stripText($item->brief);
				if (strpos($searchResults[$item->id]['brief'], '<span class="g-finded">') !== false)
					$brief = $searchResults[$item->id]['brief'];
				elseif (strpos($searchResults[$item->id]['content'], '<span class="g-finded">') !== false)
					$brief = $searchResults[$item->id]['content'];
			?>
				<div class="search-item">
					<?if (!empty($itemImgSrc)) :?>
						<a href="<?=$itemImgSrc?>" class="search-item__img">
							<img src="<?=$itemImgSrc?>" alt="<?=$item->title?>" class="search-item__img" />
						</a>
					<?endif;?>
					<div class="cont">
						<h2><a href="<?=$itemUrl;?>"><?=($k+1)?>.&nbsp;<?=$searchResults[$item->id]['title'];?></a></h2>
						<p><?=$brief;?></p>
					</div>
				</div>
			<? endforeach; ?>
		</div>

		<?$this->widget('LinkPager', array('pages' => $pager, 'showLastPage' => true)); ?>
	</div>
<?elseif(!empty($query)) : ?>
	<div class="font18 blue pl10 lh13">К сожалению ничего не найдено.<br />Попробуйте использовать другие слова или настройки.</div>
<?endif;?>
</div>