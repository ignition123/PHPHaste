<?php

/*
	this class just take the url pathname for routing
*/

namespace Kernel\App\Core;

class Bootstrap
{
	public function __construct()
	{

		//checking for url GET id, it is binded in htaccess

		if(!isset($_GET['url']))
		{
			//if not exitsts then by default index page will be thrown
		$url = 'index';

		}
		else
		{

		//else the page requested will be shown

		$url = $_GET['url'];

		}
		return $url = rtrim($url,'/');
	}
	public function __destruct()
	{
		/*
			destructor call releasing constructor
		*/
	}
}

?>