<?php

class FilterAuthRequired extends CFilter {

	public $params = array();

	public function preFilter ($filterChain)
	{
		if (!empty($this->params)) {

			if (empty($this->params['userSID'])){
				throw new ApiException('Необходима авторизация', 401);
				return false;
			}

			if(!in_array($this->params['userSID'], Yii::app()->params['api']['userSIDS'])){
				throw new ApiException('Доступ запрещён', 403);
				return false;
			}

		}

		return true;
	}

}