<?php
class LinkPager extends CLinkPager
{
	const CSS_PREVIOUS_PAGE='g-paginator-prev g-png-alpha';
	const CSS_NEXT_PAGE='g-paginator-next g-png-alpha';
	const CSS_INTERNAL_PAGE='';
	const CSS_HIDDEN_PAGE='hidden';
	const CSS_SELECTED_PAGE='current';

	public $htmlOptions = array('class' => 'pages width720 mb20');
	public $cssFile = false;
	public $maxButtonCount = 5;

	public $nextPageLabel = 'Следующая';
	public $prevPageLabel = 'Предыдущая';
	public $firstPageLabel = '1';
	public $showLastPage = false;
	public $showNextPage = false;




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
	//	echo $this->header;
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


		$buttons[] = '<div class="pageslist">';

		// first page
		if ($currentPage >($this->maxButtonCount - ($this->maxButtonCount/2))) {
            //print 111; exit;
            $buttons[]= $this->createPageButton($this->firstPageLabel,0,self::CSS_FIRST_PAGE,$currentPage<=0,false);
            if ($currentPage >($this->maxButtonCount - floor($this->maxButtonCount/2))) {
                $buttons[] = '<span>...</span>';
            }
        }

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i) {
			if ($i == $pageCount-1) {
				$this->showLastPage = false;
				$this->showNextPage = false;
			}
			$buttons[]=$this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);
		}



		// last page
		if ($this->showLastPage)
			$buttons[]= '<span>...</span>' . $this->createPageButton($pageCount,$pageCount-1,self::CSS_LAST_PAGE,$currentPage>=$pageCount-1,false);

		$buttons[] = '</div>';

		return $buttons;
	}


}
