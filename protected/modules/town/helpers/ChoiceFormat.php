<?php
class ChoiceFormat extends CChoiceFormat
{
	public static function format ( $messages, $number )
	{
		if ( is_array ( $messages ) )
		{
			if ( ( $count = count ( $messages ) ) !== 3 )
			{
				$messages = "'" . implode ( "', '", $messages ) . "'";
				throw new CException ( "Неверное количество сообщений (" . $count . "): " . $messages . "." );
			}

			$messages = vsprintf ( "n %% 10 == 1 && n != 11#%s|(n %% 10 == 2 || n %% 10 == 3 || n %% 10 == 4 ) && n %% 100 != 12 && n %% 100 != 13 && n %% 100 != 14#%s|#%s", $messages );
		}

		return parent::format ( $messages, $number );
	}
}