<?php

	class Timer
	{
		public static function setTimeout($callback,$time)
		{
			if(isset($time) && !empty($time))
			{
				if(preg_match('/$[0-9]+/', $time))
				{
					usleep($time);

					$callback();
				}
				else
				{
					$callback([false,'Not a integer value']);
				}
			}
			else
			{
				usleep(0);
				$callback();
			}
		}

		public static function setTimeInterval($callback,$time)
		{
			while(true)
			{
				if(isset($time) && !empty($time))
				{
					if(preg_match('/$[0-9]+/', $time))
					{
						usleep($time);

						$callback();
					}
					else
					{
						$callback([false,'Not a integer value']);
					}
				}
				else
				{
					usleep(0);
					$callback();
				}
			}
		}
	}
?>