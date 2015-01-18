<?php

class FilterCheckSig extends CFilter {
	
	public $sigSalt = '';
	public $params = array();
	public $methodName = '';


	public function preFilter ($filterChain)
	{

		if (!empty($this->params)) {

			if (empty($this->params['sig'])){
				throw new ApiException('Ошибка контрольной суммы', 400);
				return false;
			}

			$requestSig = $this->params['sig'];
			unset($this->params['sig']);
			$referenceSig = $this->makeSig($this->methodName, $this->params);

			if($requestSig !== $referenceSig){
				if (!Yii::app()->params['api']['debug'])
					throw new ApiException('Ошибка контрольной суммы', 400);
				else
					throw new ApiException('Ошибка контрольной суммы, должна быть '.$referenceSig, 400);

				return false;
			}

		}

		return true;
	}


	public function makeSig ($methodName, $params)
	{
		return md5($methodName . TextModifier::arr2str($params) . $this->sigSalt);
	}

}