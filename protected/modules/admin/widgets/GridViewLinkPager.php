<?php
/**
 * Pager for listview
 */
class GridViewLinkPager extends CLinkPager
{
	public $nextPageLabel = '»';
	public $prevPageLabel = '«';
	public $selectedPageCssClass = 'active';
	public $showLastPage = true;
	public $showNextPage = true;
	public $htmlOptions= array('class' => 'pagination');

	public $pagerList = array(
	  '10' => 10,
	  '25' => 25,
	  '50' => 50,
	  '100' => 100,
	);

	protected $_currentShowCount = null;

	public $pagerListHtmlOptions = array();

	public function init()
	{
		parent::init();

		$this->_currentShowCount = Yii::app()->getRequest()->getParam('show_count', 25);

		$this->footer  = '<div class="show_count">';
		$this->footer .= 'Выводить по ';
		$this->footer .= CHtml::dropDownList($this->getId(),$this->_currentShowCount,$this->pagerList,$this->pagerListHtmlOptions, array('class' => 'form-control'));
		$this->footer .= '</div>';
	}


	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();


		// prev page
		if(($page=$currentPage-1)<0) {
			$page=0;
		}
		if ($currentPage > 0) {
			$buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);
		}


		// first page
		if ($currentPage >$this->maxButtonCount)
			$buttons[]= $this->createPageButton($this->firstPageLabel,0,self::CSS_FIRST_PAGE,$currentPage<=0,false);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i) {
			if ($i == $pageCount-1) {
				$this->showLastPage = false;
				$this->showNextPage = false;
			}
			$buttons[]=$this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);
		}

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		if($currentPage+1 < $pageCount) {
			$buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);
			$nextPage = $this->createPageButton('...',$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);
		}

		if ($this->showNextPage) {
			$buttons[]=$nextPage;
		}

		// last page
		if ($this->showLastPage)
			$buttons[] =  $this->createPageButton($pageCount,$pageCount-1,self::CSS_LAST_PAGE,$currentPage>=$pageCount-1,false);

		return $buttons;
	}


	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);

		return CHtml::tag('li', array('class'=>$class), CHtml::link($label,$this->createPageUrl($page)), true);
	}

} 