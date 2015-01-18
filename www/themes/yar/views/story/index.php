<?
/**
* @var $items Story[]
* @var $this FrontController
* @var $countRemains
* @var $page
*/
?>
<div class="col-cont box">

	<?$this->widget('TopDocumentsWidget', array('type' => 'story', 'columns' => 2, 'limit' => 2))?>


	<section id="mainlist">
		<div class="articles">
			<?foreach ($items as $story) :
				$this->renderPartial('_listItem', array('item' => $story));
			endforeach;?>
		</div>

		<div class="all all-begin"<?if ($page < 2):?> style="display: none;" <?endif;?>>
			<a href="<?=Yii::app()->createUrl('story/index')?>">В начало</a>
		</div>

		<?if ($countRemains > 0):
			$params = array('page'=>($page+1));
			$rubricId = intval(Yii::app()->getRequest()->getParam('rubricId', 0));
			if (Yii::app()->getRequest()->getParam('rubricId', 0) > 0)
				$params['rubricId'] = $ru
			?>
			<div class="all">
				<a href="<?=Yii::app()->createUrl('story/index', $params)?>" id="next" data-type="story" data-page="<?=($page+1)?>" data-href="<?=Yii::app()->createUrl('story/index')?>">Еще <?=$countRemains?> <?=ChoiceFormat::format(array('статья', 'статьи', 'статей'), $countRemains);?></a>
			</div>
		<?endif;?>
	</section>
</div>