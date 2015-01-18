<?php
Yii::import('application.vendors.sphinx.sphinxapi', true);
/**
 * Поиск по сайту
 * @property SphinxClient $_sphinxClient
 */
class SphinxSearch extends CComponent
{

	protected $_sphinxClient = null;
	public $host;
	public $port;
	public $highlightOptions = array(
		'before_match'	  => '<span class="g-finded">',
		'after_match'	  => '</span>',
		'chunk_separator' => ' &hellip; ',
		'limit'			  => 128,
		'around'		  => 3
	);


	public function init()
	{
		$this->_sphinxClient = new SphinxClient();
		$this->_sphinxClient->SetServer($this->host, $this->port);
		$this->_sphinxClient->SetConnectTimeout ( 1 );
		$this->_sphinxClient->SetArrayResult ( true );
		$this->_sphinxClient->SetMatchMode (SPH_MATCH_ALL);
		$this->_sphinxClient->SetRankingMode(SPH_RANK_PROXIMITY_BM25);
	}


	/**
	 * Поиск по индексу в
	 * @param SphinxCriteria $criteria
	 * @return bool
	 * @throws CException
	 */
	public function findAll(SphinxCriteria $criteria)
	{

		if (!empty($criteria->weight))
			$this->_sphinxClient->SetWeights ($criteria->weight);

		//if ( count($filtervals) )	$cl->SetFilter ( $filter, $filtervals );
		//if ( $groupby )				$cl->SetGroupBy ( $groupby, SPH_GROUPBY_ATTR, $groupsort );
		if ( !empty($criteria->order) )
			$this->_sphinxClient->SetSortMode(SPH_SORT_EXTENDED, $criteria->order);

		if (!empty($criteria->distinct))
			$this->_sphinxClient->SetGroupDistinct($criteria->distinct);

		if (!empty($criteria->select))
			$this->_sphinxClient->SetSelect($criteria->select);

		if ( !empty($criteria->limit) )
			$this->_sphinxClient->SetLimits($criteria->offset, $criteria->limit, ( $criteria->limit>1000 ) ? $criteria->limit : 1000 );

		if (!empty($criteria->weight))
			$this->_sphinxClient->SetWeights($criteria->weight);

		if (!empty($criteria->match))
			$this->_sphinxClient->SetMatchMode($criteria->match == SphinxCriteria::SPHINX_CRITERIA_ALL ? SPH_MATCH_ALL : SPH_MATCH_ANY);


		if (!empty($criteria->filters)) {
			foreach ($criteria->filters as $filterField => $filterCondition) {
				$this->_sphinxClient->SetFilter($filterField, $filterCondition);
			}
		}
		//if ( count($filtervals) )	$cl->SetFilter ( $filter, $filtervals );
		//if ( $sortby )				$cl->SetSortMode ( SPH_SORT_EXTENDED, $sortby );
		//if ( $sortexpr )			$cl->SetSortMode ( SPH_SORT_EXPR, $sortexpr );
		//if ( $distinct )			$cl->SetGroupDistinct ( $distinct );

		$res = $this->_sphinxClient->Query($criteria->text, $criteria->index);
		if ( $res===false )
			throw new CException($this->_sphinxClient->GetLastError());

		$this->_resetParams();
		return $res;
	}


	protected function _resetParams()
	{
		$this->_sphinxClient->SetMatchMode (SPH_MATCH_ALL);
		$this->_sphinxClient->SetRankingMode(SPH_RANK_PROXIMITY_BM25);
		$this->_sphinxClient->ResetFilters();
		$this->_sphinxClient->ResetGroupBy();
		$this->_sphinxClient->ResetOverrides();
		$this->_sphinxClient->SetLimits(0,20);
		$this->_sphinxClient->_select = '*';
		$this->_sphinxClient->_weights		= array ();
		$this->_sphinxClient->_sort		= SPH_SORT_RELEVANCE;
		$this->_sphinxClient->_sortby		= "";
		$this->_sphinxClient->_min_id		= 0;
		$this->_sphinxClient->_max_id		= 0;
		$this->_sphinxClient->_ranker		= SPH_RANK_PROXIMITY_BM25;
		$this->_sphinxClient->_rankexpr	= "";
		$this->_sphinxClient->_overrides 	= array();
		$this->_sphinxClient->_error		= "";
		$this->_sphinxClient->_warning		= "";
		$this->_sphinxClient->_connerror	= false;
	}


	/*
	 * Подсветка найденных слов в название и описании
	 * @param array $highlights - Массив полей для подсветки
	 * @param $queryText - Запрос
	 * @param $index - индекс для поиска
	 * @param $highlightOptions - условия для подсветки
	 * @return array
	 */
	public function highLight(array $highlights, $queryText, $index, $highlightOptions = null)
	{
		$result = array();
		if (empty($highlightOptions))
			$highlightOptions = $this->highlightOptions;
		foreach ($highlights as $k => $v) {
			if (!empty($highlights[$k])) {

				$resultItems = $this->_sphinxClient->BuildExcerpts($highlights[$k], $index, $queryText, $highlightOptions);
				$i = 0;
				foreach ($highlights[$k] as $key => $text) {
					$result[$k][$key] = $resultItems[$i];
					$i++;
				}
			}
		}
		return $result;
	}

}