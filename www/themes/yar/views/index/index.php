<?/**
 * @var $this FrontController
 * @var $items Document[]
 * @var $page int
 * @var $countRemains int
 */?>

<?$this->widget('TopDocumentsWidget', array('limit' => 1, 'view' => '1column', 'columns' => 1))?>
<?$this->widget('TopDocumentsWidget', array('limit' => 3, 'view' => '3columns', 'columns' => 3))?>


<div class="col-cont box">

	<section id="mainlist">
		<div class="articles">
			<?foreach ($items as $item) :
				$this->renderPartial('_listItem', array('item' => $item));
			endforeach;?>
		</div>

		<div class="all all-begin"<?if ($page < 2):?> style="display: none;" <?endif;?>>
			<a href="<?=Yii::app()->createUrl('index/index')?>">В начало</a>
		</div>

		<?if ($countRemains > 0):
			$params = array('page'=>($page+1));
			?>
			<div class="all">
				<a href="<?=Yii::app()->createUrl('index/index', $params)?>" id="next" data-type="document" data-page="<?=($page+1)?>" data-href="<?=Yii::app()->createUrl('index/index')?>">Еще <?=$countRemains?> <?=ChoiceFormat::format(array('статья', 'статьи', 'статей'), $countRemains);?></a>
			</div>
		<?endif;?>
	</section>

</div>