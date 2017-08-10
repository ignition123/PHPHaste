<?php
	
	namespace Libraries\Lobes\Miscellaneous;
	
	class Log
	{
		
		public static function Errorinit($bool)
		{
			if($bool == true)
			{
				return error_reporting(-1);
			}
			if($bool == false)
			{
				return error_reporting(0);
			}
		}

		public static function Request($pagename,$msg)
		{
			return file_put_contents(ROOT_DIR.'/logs.log','Page name: '.$pagename.' / Message: '.print_r($msg,true).' / Date: '.date('H:i:s D/M/Y')."\n\n",FILE_APPEND);
		}

		public static function Response($pagename,$msg)
		{
			return file_put_contents(ROOT_DIR.'/logs.log','Page name: '.$pagename.' / Message: '.print_r($msg,true).' / Date: '.date('H:i:s D/M/Y')."\n\n",FILE_APPEND);
		}

		public static function Errors($pagename,$msg)
		{
			return file_put_contents(ROOT_DIR.'/logs.log', 'Page name: '.$pagename.' / Message: '.$msg.' / Date: '.date('H:i:s D/M/Y')."\n\n",FILE_APPEND);
		}

		public static function Console($message)
		{
			print_r("<script>
				console.log('$message');
			</script>");
		}

	}
?>