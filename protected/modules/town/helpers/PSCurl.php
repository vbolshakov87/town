<?php

class PSCurl {

	public static function sendDataAndSetCookie($url, $cookie='')
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		$data = curl_exec($ch);
		$header = substr($data, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		$expire = time() + 60*60*24*14;

		if(preg_match_all("/PHPSESSID=(.*?);/i", $header, $result)) {
			$phpsess = $result[1][0];
			Yii::app()->request->cookies['PHPSESSID'] = new CHttpCookie('PHPSESSID', $phpsess, array('path' => '/', 'domain' => '.www.photosight.ru'));

		}

		// для автологина в старом коде
		if(preg_match_all("/member_hash=(.*?);/i", $header, $result)) {
			$phpsess = $result[1][0];
			setcookie('member_hash', $phpsess, $expire, '/');
		}
		if(preg_match_all("/member_id=(.*?);/i", $header, $result)) {
			$phpsess = $result[1][0];
			setcookie('member_id', $phpsess, $expire, '/');
		}

		// авторизация на форуме
		if(preg_match_all("/w3t_myname=(.*?);/i", $header, $result)) {
			$phpsess = $result[1][0];
			if ($phpsess != 'deleted') {
				setcookie('w3t_myname', $phpsess, $expire, '/', '.www.photosight.ru');

				if(preg_match_all("/w3t_mypass=(.*?);/i", $header, $result)) {
					$phpsess = $result[1][0];
					setcookie('w3t_mypass', $phpsess, $expire, '/', '.www.photosight.ru');
				}

				if(preg_match_all("/wordpress_logged_in_=(.*?);/i", $header, $result)) {
					$phpsess = $result[1][0];
					setcookie('wordpress_logged_in_', $phpsess, $expire, '/', '.photosight.ru');
				}
			}
		}


		return true;
	}



	public static function sendDataToCreateSession($url)
	{
		if (_ENVIRONMENT != 'production')
			return true;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIE, '');
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		$data = curl_exec($ch);
		$header = substr($data, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		$expire = time() + 60*60*24*14;


		if(preg_match_all("/PHPSESSID=(.*?);/i", $header, $result)) {
			$phpsess = $result[1][0];
			Yii::app()->request->cookies['PHPSESSID'] = new CHttpCookie('PHPSESSID', $phpsess, array('path' => '/', 'domain' => '.www.photosight.ru'));

		}

		return true;
	}
}