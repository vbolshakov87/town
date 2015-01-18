<?php
Yii::import('api.vendors.ApiJsonRPC');

class ApiUrlRule extends CBaseUrlRule
{
	public function createUrl($manager, $route, $params, $ampersand)
	{
		if(isset($params['clientName'], $params['version'])){
			return 'api/'.$params['clientName'].'/'.$params['version'];
		}

		return false;
	}


	public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
	{
		if (preg_match('/^api\/([a-zA-Z0-9-]+)\/([0-9\.]+)$/', $pathInfo, $matches)) {

			$jsonRPC = new ApiJsonRPC();
			$jsonRPC->debug(Yii::app()->params['api']['debug']);
			if ($jsonRPC->isJsonRpcRequest()) {
				if ($jsonRPC->debug)
					$jsonRPC->setJsonRequest($_GET['data']);

				$_REQUEST['clientName']=$_GET['clientName']=$matches[1];
				$_REQUEST['version']=$_GET['version']=$matches[2]=strtr($matches[2], array('.' => ''));

				return 'api/'.$matches[1].$matches[2].'/Api'.$jsonRPC->getRequestMethodName();
			}
		}

		return false;
	}
}