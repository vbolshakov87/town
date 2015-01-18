<?php
/**
 * Статичные методы обработки даты
 */

class Date {

	/**
	 * Дата с русскими названиями месяцев
	 * @param $time
	 * @return string
	 */
	public static function getRussianDate($time)
	{
		// если дата этого года - то выводим без года
		// 22 апреля
		// иначе вместе с годом
		// 10 мая 2013
        $date = '';
        if(date('Y', $time) == date('Y', time())){
            $date = Yii::app()->dateFormatter->format('d MMMM', $time);
        }else{
            $date = Yii::app()->dateFormatter->format('d MMMM yyyy', $time);
        }
        return $date;
	}


	/**
	 * Дата и время с русскими названиями месяцев
	 * @param $time
	 * @return string
	 */
	public static function getRussianDateTime($time)
	{
		// 21 ноября 2013 | 19:23
		return self::getRussianDate($time). '&nbsp;|&nbsp;'.date('H:i', $time);
	}

	/**
	 * Даты начала и окончания события
	 * @param $timeStart
	 * @param null $timeFinish
	 * @return string
	 */
	public static function getRussianDateRange($timeStart, $timeFinish = null)
	{
		if (date('ymd', $timeStart) == date('ymd', $timeFinish)) {
			$timeFinish = null;
		}

		// если вторая дата не задана, или эти даты в один день, то выводим
        if(empty($timeFinish) || $timeStart == $timeFinish){
            return self::getRussianDate($timeStart);
        }

        // если год не равен текущему
        if(date('Y', $timeFinish) != date('Y', time())){
            if(date('m', $timeStart) != date('m', $timeFinish)){
                // если месяца не совпадают
                // 10 мая - 14 июня
                return Yii::app()->dateFormatter->format('d MMMM', $timeStart).' — '.Yii::app()->dateFormatter->format('d MMMM', $timeFinish);
            }else{
                // если месяца совпадают
                // 10 - 14 мая 2014
                return Yii::app()->dateFormatter->format('d', $timeStart).' — '.Yii::app()->dateFormatter->format('d MMMM yyyy', $timeFinish);
            }
        }else
        {
            // год равен текущему
            if(date('m', $timeStart) != date('m', $timeFinish)){
                // если месяца не совпадают
                // 10 мая - 14 июня
                return $date = Yii::app()->dateFormatter->format('d MMMM', $timeStart) . ' — ' . $date = Yii::app()->dateFormatter->format('d MMMM', $timeFinish);
            }else{
                // если месяца совпадают
                // 10 - 14 мая
                return Yii::app()->dateFormatter->format('d', $timeStart).' — '.Yii::app()->dateFormatter->format('d MMMM', $timeFinish);
            }
        }
	}


	/**
	 * Время проведения события
	 * @param $timeStart
	 * @param null $timeFinish
	 * @return string
	 */
	public static function getTimeRange($timeStart, $timeFinish = null)
	{
        // если день совпадает
        if(date('dmY', $timeStart) == date('dmY', $timeFinish)) {

	        if ($timeStart == $timeFinish) {
		        if (Yii::app()->dateFormatter->format('H:mm', $timeStart) == 0) {
			        return '';
		        }
		        else {
			        // c 11:00
			        return 'Начало в ' . Yii::app()->dateFormatter->format('H:mm', $timeStart);
		        }
	        }
	        else {
		        // c 11:00 до 18::00
		        return 'c ' . Yii::app()->dateFormatter->format('H:mm', $timeStart). ' до '. Yii::app()->dateFormatter->format('H:mm', $timeFinish);
	        }

        } else {
            // иначе берем только дату старта
            // c 11:00
	        if (intval(Yii::app()->dateFormatter->format('Hmm', $timeStart)) > 0) {
		        return 'Начало в ' . Yii::app()->dateFormatter->format('H:mm', $timeStart);
	        }
	        else {
		        return '';
	        }

        }
	}


	/**
	 * Количество дней в месяце
	 * @param $month - номер месяца (1-12)
	 * @param $year год
	 * @return string
	 */
	public static function cal_days_in_month($month, $year)
	{
		return date('t', mktime(0, 0, 0, $month, 1, $year));
	}


	public static function dayBeginUnixTime($time = null)
	{
		if (is_null($time))
			$time = time();

		return mktime(0,0,0,date('m', $time), date('d', $time), date('Y', $time));
	}


	public static function getCentury($time, $format = 'show')
	{
		$century = intval(substr(date('Y', $time), 0, 2)) + 1 ;

        if ($format == 'param') {
            return $century;
        }
		switch ($century) {
			case 21: return 'XXI';
			case 20: return 'XX';
			case 19: return 'XIX';
			case 18: return 'XVIII';
			case 17: return 'XVII';
			case 16: return 'XVI';
			case 15: return 'XV';
			case 14: return 'XIV';
			case 13: return 'XIII';
			case 12: return 'XII';
			case 11: return 'XI';
			case 10: return 'X';
			case 9: return 'IX';
			case 8: return 'VIII';
			case 7: return 'VII';
			default : return '';
		}
	}
}