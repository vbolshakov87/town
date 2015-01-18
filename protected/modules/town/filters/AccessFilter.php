<?php
class AccessFilter extends CFilter {




	protected function preFilter($filterChain)
	{
		/* @var $controller FrontController */
		$controller = $filterChain->controller;
		$action = $filterChain->action;
		$route = $controller->id.'/'.$action->id;

		if(
			(Yii::app()->getUser()->isGuest===true || !Yii::app()->getUser()->hasAdminAccess())
			&& !in_array($route, $controller->allowedActions())
		) {
			$controller->accessDenied();
			return false;
		}

		return true;
	}

}