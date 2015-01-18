<?php
class LinkPager extends CLinkPager
{

	const CSS_FIRST_PAGE='none';
	const CSS_LAST_PAGE='none';
	const CSS_PREVIOUS_PAGE='g-paginator-prev g-png-alpha';
	const CSS_NEXT_PAGE='g-paginator-next g-png-alpha';
	const CSS_INTERNAL_PAGE='';
	const CSS_HIDDEN_PAGE='hidden';
	const CSS_SELECTED_PAGE='current';

	public $htmlOptions = array('class' => 'pages width720 mb20');
	public $cssFile = false;
	public $maxButtonCount = 10;

	public $nextPageLabel = 'Следующая';
	public $prevPageLabel = 'Предыдущая';
	public $firstPageLabel = '1';
	public $showLastPage = false;
	public $showNextPage = false;


	public function init()
	{
		$this->firstPageLabel='1';
		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='yiiPager';
	}


	/**
	 * Вывод постраничной навигации
	 */
	public function run()
	{
		/*
<div class="pages width720 mb20">

        <div class="fr ar"><a href="/photos/category/82/?pager=2">Следующая</a></div>


    <div class="pageslist">
        <a href="/photos/category/82/" class="current">1</a>
		<a href="/photos/category/82/?pager=2">2</a>
		<a href="/photos/category/82/?pager=3">3</a>
		<a href="/photos/category/82/?pager=4">4</a>
		<a href="/photos/category/82/?pager=5">5</a>
		<a href="/photos/category/82/?pager=6">6</a>
		<a href="/photos/category/82/?pager=7">7</a>
		<a href="/photos/category/82/?pager=8">8</a>
		<a href="/photos/category/82/?pager=9">9</a><span>...</span><a href="/photos/category/82/?pager=999">999</a>
    </div>

    			</div>
		 * */
		$this->registerClientScript();
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		echo $this->header;
		echo CHtml::tag('div',$this->htmlOptions,implode("\n",$buttons));
		echo $this->footer;
	}




	/**
	 * Вывод одного пункта навигации
	 * @param string $label
	 * @param int $page
	 * @param string $class
	 * @param bool $hidden
	 * @param bool $selected
	 * @return string
	 */
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
		return CHtml::link($label,$this->createPageUrl($page), array('class'=>$class));
	}

	/**
	 * Вывод пунктов навигаци
	 * @return array
	 */
	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();




		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		if($currentPage+1 < $pageCount) {
			$buttons[]='<div class="fr ar">';
			$buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);
			$buttons[]='</div>';
			$nextPage = $this->createPageButton('...',$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);
		}

		// prev page
		if(($page=$currentPage-1)<0) {
			$page=0;
		}
		if ($currentPage > 0) {
			$buttons[]='<div class="fr ar">';
			$buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);
			$buttons[]='</div>';
		}

		$buttons[] = '<div class="pageslist">';

		// first page
		if ($currentPage >$this->maxButtonCount)
			$buttons[]= $this->createPageButton($this->firstPageLabel,0,self::CSS_FIRST_PAGE,$currentPage<=0,false) . '<span>...</span>';

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i) {
			if ($i == $pageCount-1) {
				$this->showLastPage = false;
				$this->showNextPage = false;
			}
			$buttons[]=$this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);
		}

		if ($this->showNextPage) {
			$buttons[]=$nextPage;
		}


		// last page
		if ($this->showLastPage)
			$buttons[]= '<span>...</span>' . $this->createPageButton($pageCount,$pageCount-1,self::CSS_LAST_PAGE,$currentPage>=$pageCount-1,false);

		$buttons[] = '</div>';

		return $buttons;
	}


}
