<?php
/**
 * Ajax actions в админке
 */
class AjaxController extends AdminController {

	/**
	 * Поиск вариантов для метро по первым буквам
	 */
	public function actionMetroAutoComplete()
	{
		$result = array();
		
		$term = Yii::app()->getRequest()->getParam('q');
		if (!empty($term))
		{
			$criteria = new CDbCriteria;
			$criteria->addSearchCondition('t.name', $term.'%', false);
			$criteria->with = array(
				'metroLine' => array(
					'with' => 'city'
				)
			);
			$criteria->together = true;
			
			$stations = MetroStation::model()->findAll($criteria);
			
			if (!empty($stations))
			{
				foreach ($stations as $item)
				{
					$result[] = $item->dataForAutoComplete();
				}
			}
		}

		header('Content-type: application/json');
		echo CJSON::encode($result);
		Yii::app()->end();
	}
	
}