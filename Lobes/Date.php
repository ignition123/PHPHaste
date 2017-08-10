<?php

	namespace Libraries\Lobes\Miscellaneous;

	class Date
	{
		public static function date_diff($Object)
		{
			if($Object['format'] == 'D')
			{
				return floor(abs(strtotime($Object['Date1']) - strtotime($Object['Date2'])) / (60*60*24));
			}
			else if($Object['format'] == 'H')
			{
				return floor(abs(strtotime($Object['Date1']) - strtotime($Object['Date2'])) / (60*60));
			}
			else if($Object['format'] == 'M')
			{
				return floor(abs(strtotime($Object['Date1']) - strtotime($Object['Date2'])) / 60);
			}
			else if($Object['format'] == 'S')
			{
				return floor(abs(strtotime($Object['Date1']) - strtotime($Object['Date2'])));
			}
		}

		public static function add_time($Object)
		{
			if($Object['format'] == 'D')
			{
				return strtotime($Object['Date'] . ' +'.$Object['count'].'day');
			}
			else if($Object['format'] == 'H')
			{
				return strtotime($Object['Date'] . ' +'.$Object['count'].'Hour');
			}
			else if($Object['format'] == 'M')
			{
				return strtotime($Object['Date'] . ' +'.$Object['count'].'Minute');
			}
			else if($Object['format'] == 'S')
			{
				return strtotime($Object['Date'] . ' +'.$Object['count'].'Second');
			}
		}

		public static function sub_time($Object)
		{
			if($Object['format'] == 'D')
			{
				return strtotime($Object['Date'] . ' -'.$Object['count'].'day');
			}
			else if($Object['format'] == 'H')
			{
				return strtotime($Object['Date'] . ' -'.$Object['count'].'Hour');
			}
			else if($Object['format'] == 'M')
			{
				return strtotime($Object['Date'] . ' -'.$Object['count'].'Minute');
			}
			else if($Object['format'] == 'S')
			{
				return strtotime($Object['Date'] . ' -'.$Object['count'].'Second');
			}
		}
	}
?>