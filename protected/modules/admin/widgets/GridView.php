<?php

Yii::import('zii.widgets.grid.CGridView');

/**
 * Расширение GridView
 */
class GridView extends CGridView
{
	public $template = '{items}{pager}';
	public $itemsCssClass = 'table table-striped';
	public $pager = 'GridViewLinkPager';
	public $pagerCssClass = 'aaaa';

	public function init()
	{
		parent::init();
	}


	/**
	 * Renders the table header.
	 */
	public function renderTableHeader()
	{
		if(!$this->hideHeader)
		{
			echo "<thead>\n";

			if($this->filterPosition===self::FILTER_POS_HEADER)
				$this->renderFilter();

			echo "<tr>\n";
			foreach($this->columns as $column) {
				ob_start();
				$column->renderHeaderCell();
				$headerCell = ob_get_contents();
				ob_end_clean();
				if (strpos($headerCell, '"sort-link"') !== false)
					$headerCell = str_replace('</a>', '<span class="glyphicon glyphicon-sort"></span></a>', $headerCell);
				elseif (strpos($headerCell, '"sort-link asc"') !== false)
					$headerCell = str_replace('</a>', '<span class="glyphicon glyphicon-arrow-up"></span></a>', $headerCell);
				elseif (strpos($headerCell, '"sort-link desc"') !== false)
					$headerCell = str_replace('</a>', '<span class="glyphicon glyphicon-arrow-down"></span></a>', $headerCell);

				echo $headerCell;
			}
			echo "</tr>\n";

			if($this->filterPosition===self::FILTER_POS_BODY)
				$this->renderFilter();

			echo "</thead>\n";
		}
		elseif($this->filter!==null && ($this->filterPosition===self::FILTER_POS_HEADER || $this->filterPosition===self::FILTER_POS_BODY))
		{
			echo "<thead>\n";
			$this->renderFilter();
			echo "</thead>\n";
		}
	}



} 