<?php
class AdminAccessFilter extends CFilter {

	// разрешенные для любого пользователя роуты
	protected $_allowedRoutes = array(
		0 => 'auth/login',
	);


	protected function preFilter($filterChain)
	{
		/* @var $controller AdminController */
		$controller = $filterChain->controller;
		$action = $filterChain->action;
		$rout = $controller->id.'/'.$action->id;

		if(
			(Yii::app()->getUser()->isGuest===true || !Yii::app()->getUser()->hasAdminAccess())
			&& !in_array($rout, $this->_allowedRoutes)
		) {
			$controller->accessDenied();
			return false;
		}

		return true;
	}

}