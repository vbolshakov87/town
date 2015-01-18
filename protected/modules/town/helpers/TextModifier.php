<?php
/**
 * Модификатор текста
 */

class TextModifier {

	public static  function editContentForRss($content)
	{
		$content = strip_tags($content, '<b>,<strong>,<i>,<em>,<u>,<br>,<p>,<ol>,<ul>,<li>,<sub>,<sup>,<center>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<strike>,<pre>,<span>,<a>,<font>,<table>,<tr>,<td>,<tbody>,<thead>');
		$content = str_replace('href="/"', 'href="'.Yii::app()->params['baseDomain'].'/', $content);
		return $content;
	}


	public static function htmlInOneSting($content) {
		return preg_replace("/(\r\n)+|(\n|\r|\t)+/", "", $content);
	}


	/**
	 * обрезает строку до указанной позиции с учётом слов (слова не рубит)
	 * @static
	 * @param $str Строка, которую будем резать
	 * @param $pos Позиция начала подстроки (как в substr())
	 * @param $maxStrLength Максимальная длина текста (Текст не будет длинее! Режет до последнего пробела, перед этой позицией)
	 * @param string $ellipsis Что ставить в конце строки. Можно передать троеточие "…" или "&hellip;" или какой-то html
	 * @return string
	 */
	public static function stripTextWords($str, $pos, $maxStrLength, $ellipsis = ''){
		if ($pos == 0 && mb_strlen($str, 'UTF-8') < $maxStrLength ) return $str;
		$shortText = mb_substr($str, $pos, $maxStrLength, 'UTF-8');
		$lastSpacePos = mb_strrpos($shortText, ' ', 'UTF-8');
		if( !empty($lastSpacePos) ){
			return mb_substr($shortText, 0, $lastSpacePos, 'UTF-8').$ellipsis;
		}
		return $shortText ? $shortText.$ellipsis : '';
	}


	public static function ukfirst($text)
	{
		return mb_strtoupper(mb_substr($text, 0, 1, 'UTF-8'), 'UTF-8').mb_substr($text, 1, mb_strlen($text,'UTF-8'), 'UTF-8');
	}


	/**
	 * Убираем текст в html->body
	 * @param $text
	 * @return string
	 */
	public static function wrapInHtml($text, $charset = 'utf-8')
	{
		$html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
			<head>
				<title></title>
				<meta http-equiv="Content-Type" content="text/html; charset='.$charset.'">
			</head>
			<body style="margin: 0; padding: 0;">';

		$html .= $text;
		$html .= '</body>
			</html>';

		return $html;
	}
	
	
	/**
	 * Подготавливаем текст для вставки в метатеги
	 * @param $text
	 * @return string
	 */
	public static function textForMetaTag($text) {
		return preg_replace("/(\r\n)+|(\n|\r|\t)+/", "", htmlspecialchars(strip_tags($text), ENT_QUOTES));
	}
	
	
	/**
	 * Склонение слова в зависимости от числа
	 * @param $digit число
	 * @param $form1 вариант слова для числа 1, например "фотография"
	 * @param $form2 вариант слова для чисел заканчивающих на цифру 2 до 4 , например "фотографии"
	 * @param $form3 вариант слова остальных чисел, например "фотографий"
	 * @return string
	 */
	public static function declension($digit, $form1, $form2, $form3)
	{
		$n = abs($digit) % 100;
		$n1 = $n % 10;
		if ($n >= 11 && $n <= 19) return $form3;
		if ($n1 >= 2 && $n1 <= 4) return $form2;
		if ($n1 == 1) return $form1;
		return $form3;
	}
	
	
	/**
	 * Форматирование текста комментария к фото
	 * @param type $text
	 * @return type
	 */
	public static function formatPhotoComment($text)
	{
		$text = nl2br(htmlspecialchars($text));
		
		//ставим ссылки на кроп
		preg_match_all("~\&lt\;\!--CROP\((-?\d+(\.\d)?,-?\d+(\.\d)?,-?\d+(\.\d)?,-?\d+(\.\d)?)\)--\&gt\;~", $text, $matches);
		$replace = array();
		foreach ($matches[1] as $i => $params)
		{
			$replace[$i] = '<a href="javascript:void(0)" onclick="SetCrop(' . $params . '); return false;" class="crop"><i><показать кадр></i></a>';
		}
		$text = str_replace($matches[0], $replace, $text);
		
		preg_match_all("~\&amp\;lt\;\!--CROP\((-?\d+(\.\d)?,-?\d+(\.\d)?,-?\d+(\.\d)?,-?\d+(\.\d)?)\)--\&amp\;gt\;~", $text, $matches);
		$replace = array();
		foreach ($matches[1] as $i => $params)
		{
			$replace[$i] = '<a href="javascript:void(0)" onclick="SetCrop(' . $params .'); return false;" class="crop"><i><показать кадр></i></a>';
		}
		$text = str_replace($matches[0], $replace, $text);

		$text = self::recognizeUrls($text);

		return $text;
	}
	
	
	/**
	 * Поиск и замена ссылок в тексте на тег <a>
	 * @param string $text
	 * @return string
	 */
	public static function recognizeUrls($text)
	{
		if (!preg_match_all("~((?:(?:ht|f)tps?://)|(?:www\.))([^<\s\n]+)(?<![]\.,:;!\})<-])~", $text, $matches))
			return $text;

		$matches[0] = array_unique($matches[0]);

		$replace = array();
		foreach ($matches[0] as $i => $params)
		{
			$pref = $matches[1][$i];
			$anchor = $matches[2][$i];

			if (strpos($pref, 'www.') !== false)
			{
				$anchor = 'www.' . $anchor;
				$pref = str_replace('www.', '', $pref);
			}

			if ($pref == '')
				$pref = 'http://';

			$replace[$i] = '<a target="_blank" href="' . $pref . $anchor . '">' . $anchor . '</a>';
		}

		$text = str_replace($matches[0], $replace, $text);
		return $text;
	}


	/**
	 * Конвертация в римские цифры
	 * @param $integer - число в integer
	 * @param bool $upcase - использовать UPPERCASE (по умолчанию true)
	 * @return string
	 */
	public static function romanic_number($integer, $upcase = true)
	{
		$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
		$return = '';
		while($integer > 0)
		{
			foreach($table as $rom=>$arb)
			{
				if($integer >= $arb)
				{
					$integer -= $arb;
					$return .= $rom;
					break;
				}
			}
		}

		return $return;
	}


	public static function sphinxEscapeString ( $string )
	{
		$from = array ( '\\', '(', ')', '|', '-', '!', '@', '~', '"', '&', '/', '^', '$', '=', '\'' );
		$to   = array ( '\\\\', '\\\\(', '\\\\)', '\\\\|', '\\\\-', '\\\\!', '\\\\@','\\\\~','\\\\"', '\\\\&', '\\\\/', '\\\\^', '\\\\$', '\\\\=', '\\\'' );



		return str_replace ( $from, $to, $string );
	}


	public static function stripText($text)
	{
		return trim( htmlspecialchars( strip_tags( stripslashes($text) ), ENT_QUOTES ) );
	}


	public static function decodeStripedText($text)
	{
		return htmlspecialchars_decode(htmlspecialchars_decode($text, ENT_QUOTES));
	}


	public static function arr2str($arr) {
		ksort($arr);
		$str = array(); //сортировка массива по ключам по алфавиту
		foreach ($arr as $k => $v) {
			if (is_array($v)) {
				$str[] = '[' . self::arr2str($v) . ']';
			}
			else {
				if ($v === true) // перевод булевого значения в строковое
				$v = 'true';
				if ($v === false) // перевод булевого значения в строковое
				$v = 'false';
				if (is_null($v)) // перевод значения null в строку ‘null’
				$v = 'null';
				if (is_numeric($v)) //перевод в десятичную систему без научной нотации, перевод в строку
				$v = strval($v);

				$str[] .= $k . '=' . $v;
			}
		}
		return implode('&', $str);
	}

}