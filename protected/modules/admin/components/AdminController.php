<?php
/**
 * Базовый контроллер админки
 */
class AdminController extends CController
{
	public $layout = 'application.modules.admin.views.layout.two_columns';
	public $menu=array();
	public $breadcrumbs=array();

	public function filters()
	{
		return array('auth', 'accessControl');
	}

	public function addPageTitle($title)
	{
		$this->setPageTitle($title);
	}

	/**
	 * Фильтр проверяющий авторизацию пользователя
	 * @param $filterChain
	 */
	public function filterAuth($filterChain)
	{
		$filter = new AdminAccessFilter();
		$filter->filter($filterChain);
	}


	/**
	 * Список допустимых без авторизации
	 * @return array
	 */
	public final function allowedActions()
	{
		return array();
	}


	public function actions()
	{
		return array(
			'imgUpload'=>array(
				'class'=>'application.modules.admin.actions.ImageUploadAction'
			),
		);
	}


	/**
	 * Обработка запрета на посещенение страницы
	 * @param null $message
	 * @throws CHttpException
	 */
	public function accessDenied($message=null)
	{
		if( $message===null )
			$message = 'Вы не авторизованы на данной странице';

		if( Yii::app()->getUser()->isGuest===true ) {
			Yii::app()->getRequest()->redirect(Yii::app()->createUrl('admin/auth/login'));
		}
		else {
			throw new CHttpException(403, $message);
		}
	}


	protected function formRedirectUrl($model) {
		$toApply = Yii::app()->request->getParam('apply', false);

		// сохранить
		if ($toApply === false){
			if (!empty($model->pid)) {
				return array('admin', 'pid' => $model->pid);
			}
			if (!empty($model->parent_id)) {
				return array('admin', 'pid' => $model->parent_id);
			}
			return array('admin');
		}

		// применить
		if (!empty($model->pid)) {
			return array('update', 'pid' => $model->pid, 'id' => $model->id);
		}
		if (!empty($model->parent_id)) {
			return array('update', 'pid' => $model->parent_id, 'id' => $model->id);
		}
		return array('update', 'id' => $model->id);
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
}
