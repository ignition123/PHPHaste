<?php
	
/*
	this class contains code for configuration file	
*/
	namespace Kernel\App\Core;

	class Config
	{
		public function get()
		{
			$config = file_get_contents('config/config.json');

			return json_decode($config);
		}
	}
?>