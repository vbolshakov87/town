<?php
/**
 * Главная страница сайта
 */
class IndexTownController extends FrontController
{
	public function actions()
	{
		return array(
			'index' => array(
				'class' => 'DocumentListAction',
				'limit' => 5,
			),
			'rss' => array(
				'class' => 'DocumentListAction',
				'limit' => 50,
				'view' => 'rss'
			),
		);
	}


	public function actionSearch()
	{
		$text = Yii::app()->getRequest()->getParam('q');
		$text = trim($text);

		$orderBy = Yii::app()->getRequest()->getParam('order_by', 'weight');
		if (!in_array($orderBy, array('weight', 'date'))) 
			$orderBy = 'weight';
		if ($orderBy == 'weight')
			$order = '@weight DESC, create_time DESC';
		else 
			$order = 'create_time DESC, @weight DESC';

		$lookAt = Yii::app()->getRequest()->getParam('look_at', 'all');
		if (!in_array($lookAt, array('all', 'story', 'photo_story', 'figure')))
			$lookAt = 'all';


		$searchIn = 'all';
		$pageNumber = (int) Yii::app()->getRequest()->getParam('pager', 1);
		$limit = Yii::app()->params['limitOnPage'];

		if (strlen($text) > 2) {
			$cacheKey = json_encode(array('documents', $this->id, $this->action->id, $pageNumber, $searchIn, md5($text) ));
			$cacheValue = Yii::app()->getCache()->get($cacheKey);
			$cacheValue = false;
			if ($cacheValue === false) {
				$criteria = new SphinxCriteria(array(
					'index' => 'oldyar',
					'text' => $text,
					'weight' => array ( 'title'=>10, 'brief'=>5, 'text' => 1 ),
					'order' => $order,
					'limit' => Yii::app()->params['limitOnPage'],
					'offset' => Yii::app()->params['limitOnPage']*($pageNumber-1),
				));

				if ($lookAt != 'all') {
					$criteria->filters['essence'] = $lookAt;	
				} 

				$data = Yii::app()->sphinx->findAll($criteria);

				$documentIds = array();
				$highlights = array();
				$searchResults = array();
			//	print_r($data);

				foreach ($data['matches'] as $match) {
					$documentIds[] = $match['id'];
					$searchResults[$match['id']] = $match;
				}

				/** @var Document[] $documents */
				$documents = Document::model()->findAllByPk($documentIds,
					array(
						'order' => 'FIELD(t.id, '.implode(',', $documentIds).')'
					)
				);

				foreach ($documents as $item) {
					$highlights['title'][$item->id] = $item->title;
					$highlights['brief'][$item->id] = $item->brief;
					$highlights['content'][$item->id] = $item->content;

				}
				
				$afterHighlight = Yii::app()->sphinx->highLight($highlights, $criteria->text, $criteria->index);

				foreach ($afterHighlight['title'] as $i=>$title)
					$searchResults[$i]['title'] = $title;

				foreach ($afterHighlight['brief'] as $i=>$brief)
					$searchResults[$i]['brief'] = $brief;

				foreach ($afterHighlight['content'] as $i=>$content)
					$searchResults[$i]['content'] = $content;


				$countAll = isset($data['total_found']) ? $data['total_found'] : 0;
				$pager = new CPagination($countAll);
				$pager->pageSize = $criteria->limit;
				$pager->pageVar = 'pager';

				Yii::app()->getCache()->set($cacheKey, array(
					'pager' => $pager,
					'documents' => $documents,
					'searchResults' => $searchResults,
					'data' => $data,
				), 10*60);

			} else {
				$documents = $cacheValue['documents'];
				$pager= $cacheValue['pager'];
				$data = $cacheValue['data'];
				$searchResults = $cacheValue['searchResults'];
			}

			$pager = new CPagination($data['total_found']);
			$pager->pageSize = $limit;
			$pager->pageVar = 'pager';
		}

		$this->render('search',
			array(
				'text' => $text,
				'searchResults' => !empty($searchResults) ? $searchResults : array(),
				'documents' => !empty($documents) ? $documents : array(),
				'pager' => !empty($pager) ? $pager : null,
				'total' => !empty($data) ? $data['total'] : 0,
				'totalFound' => !empty($data) ? $data['total_found'] : 0,
				'time' => !empty($data) ? $data['time'] : 0,
			)
		);
	}


	/**
	 * Автокоммлит
	 */
	public function actionAjaxData()
	{
		$this->disableLogs();

		$text = Yii::app()->getRequest()->getParam('term');
		if (empty($text)) {
			echo CJSON::encode(array());
			Yii::app()->end();
		}
		$criteria = new SphinxCriteria(array(
			'index' => 'oldYar',
			'text' => $text,
			'weight' => array ( 'title'=>1, 'brief' => 0, 'text'=>0 ),
			'order' => '@weight DESC',
			'limit' => 5,
		));

		$data = Yii::app()->sphinx->findAll($criteria);
		if (empty($data['matches'])) {
			echo CJSON::encode(array());
			Yii::app()->end();
		}

		$highlights = array();
		$searchResults = array();
		foreach ($data['matches'] as $match) {
			$documentIds[] = $match['id'];
			$searchResults[$match['id']] = $match;
		}

		/** @var Document[] $documents */
		$documents = Document::model()->findAllByPk($documentIds);
		foreach ($documents as $document) {
			$highlights['title'][$document->id] = $document->id;
		}


		$afterHighlight = Yii::app()->sphinx->highLight($highlights, $criteria->text, $criteria->index);

		$result = array();
		foreach ($documents as $document) {
			$result[] = array(
				'label' => CHtml::tag('span', array('class' => 'autocomplete-search-item', 'data-url'=>$document->createUrl()),  $afterHighlight['title'][$document->id], true),
				'value' => $document->title
			);
		}

		echo CJSON::encode($result);
		Yii::app()->end();
	}


	public function actionChangeRating()
	{
		$modelClass = Yii::app()->getRequest()->getParam('essenceType', null);
		if (!in_array($modelClass, array('Story', 'PhotoStory', 'Figure')))
			$this->_echoAjaxJsonError('Essence is not correct');

		$essenceId = intval(Yii::app()->getRequest()->getParam('essenceId', 0));
		if ($essenceId < 1)
			$this->_echoAjaxJsonError('Essence id is not correct');

		$score = doubleval(Yii::app()->getRequest()->getParam('score', 5));
		if ($score < 0 || $score > 5 )
			$this->_echoAjaxJsonError('Score is not correct');

		/** @var Story $item */
		$item = ActiveRecord::model($modelClass)->active()->findByPk($essenceId);
		if (empty($item))
			$this->_echoAjaxJsonError('Essence is not found');


		$item->weight = round( (($item->weight * $item->number_of_votes + $score) * 100) /($item->number_of_votes + 1) )/100;

		$item->number_of_votes +=1;
		$item->save();

		Yii::app()->getUser()->updateRatedDocuments($modelClass, $essenceId);

		$this->_echoAjaxJsonOk(array('weight' => $item->weight));
	}
}