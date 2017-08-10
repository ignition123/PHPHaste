<?php

namespace Request\Route\Controller;

require_once 'cns/Bootstrap.php';
require_once 'cns/Router.php';
require_once 'cns/Controller.php';
require_once 'cns/ServerConfig.php';
require_once 'cns/Route.php';
require_once 'route/Web.php';
require_once 'cns/Views.php';
require_once 'cns/Response.php';
require_once 'Lobes/Date.php';
require_once 'Lobes/FCM.php';
require_once 'Lobes/Log.php';
require_once 'Lobes/Net.php';
require_once 'Lobes/Remote.php';
require_once 'Lobes/Scaleimage.php';
require_once 'Lobes/Timer.php';
require_once 'cns/BlockList.php';



use Kernel\App\Core\Bootstrap;
use Kernel\App\Core\Router;
use Kernel\App\Core\Controller;
use Kernel\App\Route\Web;
use Libraries\Lobes\Miscellaneous\Date;
use Libraries\Lobes\Miscellaneous\FCM;
use Libraries\Lobes\Miscellaneous\Log;
use Libraries\Lobes\Miscellaneous\Net;
use Libraries\Lobes\Miscellaneous\Remote;
use Libraries\Lobes\Miscellaneous\Scaleimage;
use Libraries\Lobes\Miscellaneous\Timer;
use Kernel\App\RequestRoute\Route;
use Kernel\App\Core\BlockList;


$BlockList = new BlockList();
$FetchBlockStatus = $BlockList->__init__();
if(!$FetchBlockStatus)
{
	header("HTTP/1.0 404 Not Found");
	die();
}
unset($BlockList);


if($config->maintenance)
{
	if(isset($_REQUEST) && !empty($_REQUEST) && isset($_REQUEST['cortex']))
	{
		echo 'Oops, we are sorry server is under maintenance';
	}
	else
	{
		$_REQUEST = json_decode(file_get_contents('php://input'), true);

		if(isset($_REQUEST['cortex']) && !empty($_REQUEST['cortex']))
		{
			echo 'Oops, we are sorry server is under maintenance';
		}
		else
		{
			echo file_get_contents('error_files/maintenance.html');
		}
	}	
}
else
{
	if(isset($_REQUEST) && !empty($_REQUEST) && isset($_REQUEST['cortex']))
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$_REQUEST = null;
			$_GET = null;
			$_POST['url'] = $_SERVER['REQUEST_URI'];
			new Controller($_POST,@$_FILES);
		}
		else
		{
			$_REQUEST = null;
			$_POST = null;
			$_GET['url'] = $_SERVER['REQUEST_URI'];
			new Controller($_GET,@$_FILES);
		}
	}
	else
	{
		$_REQUEST = json_decode(file_get_contents('php://input'), true);

		if(isset($_REQUEST['cortex']) && !empty($_REQUEST['cortex']))
		{
			if($_SERVER['REQUEST_METHOD'] === 'POST')
			{
				$_REQUEST = null;
				$_GET = null;
				$_POST['url'] = $_SERVER['REQUEST_URI'];
				new Controller($_POST,@$_FILES);
			}
			else
			{
				$_REQUEST = null;
				$_POST = null;
				$_GET['url'] = $_SERVER['REQUEST_URI'];
				new Controller($_GET,@$_FILES);
			}
		}
		else
		{
			$route->execute();
			unset($route);

			$Bootstrap = new Bootstrap();
			if($_SERVER['REQUEST_METHOD'] === 'POST')
			{
				$_REQUEST = null;
				$_GET = null;
				$_POST['url'] = $_SERVER['REQUEST_URI'];
				$Router = new Router($_POST);
				unset($Router);
			}
			else
			{
				$_REQUEST = null;
				$_POST = null;
				$_GET['url'] = $_SERVER['REQUEST_URI'];
				$Router = new Router($_GET);
				unset($Router);
			}
			unset($Bootstrap);
		}
	}
}
	
?>