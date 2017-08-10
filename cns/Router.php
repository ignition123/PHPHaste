<?php

	/*
		this class routes the requests
	*/

	namespace Kernel\App\Core;

	define( 'ROOT_DIR', dirname(__DIR__));

	include ROOT_DIR.'/cns/Mapping.php';

	use Kernel\App\Core\Bootstrap;
	use Kernel\App\Core\Mapping;

	class Router extends Bootstrap
	{//Routes Pages
		public function __construct($input)
		{
			$url = parent::__construct();

			$MappingObj = new Mapping();
			$mappingData = $MappingObj->__init__($url);

			if($mappingData)
			{
				$mappingData += $input;
				new Controller($mappingData,@$_FILES);
			}

			unset($MappingObj);	
		}
	}


?>