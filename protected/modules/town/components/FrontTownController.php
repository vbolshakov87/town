<?php
/**
 * Базовый контроллер для фронта сайта
 */
class FrontTownController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to 'column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='column2';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public $contentClass = 'width cf';


	public $disableBanners = false;
	public $bannerKeywords = array();



	public function init()
	{
        $this->contentClass = $this->getId() . ' ' . $this->contentClass;
		parent::init();

		/*
		if (!Yii::app()->request->isAjaxRequest)
		{
			$cs = Yii::app()->getClientScript();
			$cs->registerCoreScript('jquery');

			$basePath= dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets';
			$baseUrl = Yii::app()->getAssetManager()->publish($basePath,false, -1, true);

			// bootstrap
			$cs->registerScriptFile($baseUrl .  '/bootstrap/js/bootstrap.js');
			$cs->registerCssFile($baseUrl . '/bootstrap/css/bootstrap.css');
			$cs->registerCssFile('/css/main.css');
		}
		*/
	}





	/**
	 * @param array $types - Названия отклучаемых логгеров. Если пустой массив, то отключаются все логгеры.
	 * @return void
	 */
	public function disableLogs($types = array()){
		try {
			if(isset(Yii::app()->log) && isset(Yii::app()->log->routes)){

				foreach(Yii::app()->log->routes as $routeName => $routeSettings){

					if( (empty($types) || in_array($routeName, $types)) && isset(Yii::app()->log->routes[$routeName]->enabled)){
						Yii::app()->log->routes[$routeName]->enabled = false;
					}
				}

			}
		} catch (Exception $e) {}
	}


	/**
	 * Счетчик просмотра докумета
	 */
	public function actionStat()
	{
		$this->disableLogs();

		/** @var Story $model */
		$model = ucfirst($this->id);

		$id = intval(Yii::app()->getRequest()->getParam('id', 0));
		$tableName = $model::model()->tableName();

		if ($id > 0 && !empty($tableName)) {
			$app = new DocumentShowStat($tableName, $id);
			$app->run();
			$app->halt(true);
		}

		Yii::app()->end();
	}



	protected function _echoAjaxJsonError($errorText, $errorType = 'data') {
		echo json_encode(array(
			'status' => 'error',
			'errorType' => $errorType,
			'errorText' => $errorText
		));
		Yii::app()->end();
	}


	protected function _echoAjaxJsonOk($data) {
		echo json_encode(array(
			'status' => 'ok',
			'data' => $data
		));
		Yii::app()->end();
	}
}