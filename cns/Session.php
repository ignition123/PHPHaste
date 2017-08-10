<?php
	
	namespace Kernel\App\Core;

	require_once ROOT_DIR."/cns/Config.php";

	class Session
	{
		private static $session = 'default';
		public static function FetchUserIpAddress()
		{
			$ipaddress = '';
		    if (getenv('HTTP_CLIENT_IP'))
		        $ipaddress = getenv('HTTP_CLIENT_IP');
		    else if(getenv('HTTP_X_FORWARDED_FOR'))
		        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		    else if(getenv('HTTP_X_FORWARDED'))
		        $ipaddress = getenv('HTTP_X_FORWARDED');
		    else if(getenv('HTTP_FORWARDED_FOR'))
		        $ipaddress = getenv('HTTP_FORWARDED_FOR');
		    else if(getenv('HTTP_FORWARDED'))
		       $ipaddress = getenv('HTTP_FORWARDED');
		    else if(getenv('REMOTE_ADDR'))
		        $ipaddress = getenv('REMOTE_ADDR');
		    else
		        $ipaddress = 'UNKNOWN';
		    return $ipaddress;
		}
		public static function __init__($session_type)
		{
			$ConfigOBJ = new Config();
  			$config = $ConfigOBJ->get();

			if($session_type == 'default' || $session_type == 'mongo' || $session_type == 'redis' || $session_type == 'memcache' || $session_type == 'mysql')
			{
				self::$session = $session_type;
			}
			else
			{
				return 'Sorry no driver found';
			}

			if($session_type == 'mysql')
			{
				$dbname = 'ign';
				$user = $config->mySql->username;
				$password = $config->mySql->password;
				$db = new \PDO("mysql:host=localhost;dbname=".$dbname,$user,$password);

				if(isset($_COOKIE['PHPSESSID']))
				{
					$bindkey = [
						$_COOKIE['PHPSESSID']
					];

					mySQL::prepare($bindkey,function()
					{
						return "SELECT session_id FROM session WHERE TIMESTAMPDIFF(MINUTE,NOW(),session_time) as time_diff > 30 AND session_id = ?";
					});

					if(mySQL::rowCount() == 1)
					{
						$new_session_id = md5(uniqid().self::FetchUserIpAddress().time());

						$bindkey = [
							$new_session_id,
							$_COOKIE['PHPSESSID']
						];
						mySQL::prepare($bindkey,function()
						{
							return "UPDATE session SET session_id = ? WHERE session_id = ?";
						});

						setcookie('PHPSESSID',$new_session_id ,0, "/");
					}
				}
				else
				{
					$new_session_id = md5(uniqid().self::FetchUserIpAddress().time());
					
					$bindkey = [
						$new_session_id
					];

					mySQL::prepare($bindkey,function()
					{
						return "INSERT INTO session (session_id,session_time) VALUES(?,NOW())";
					});

					setcookie('PHPSESSID',$new_session_id,0, "/");

					echo mySQL::rowCount();
				}
			}
		}

		public static function get($key)
		{
			if(self::$session == 'default')
			{
				if (session_status() == PHP_SESSION_NONE)
				{
				    session_start();
				}

				if(isset($_SESSION[$key]))
				{
					return $_SESSION[$key];
				}
				else
				{
					return 'No key found';
				}
			}
		}

		public static function set($key,$value)
		{
			if(self::$session == 'default')
			{
				if (session_status() == PHP_SESSION_NONE)
				{
				    session_start();
				}

				$_SESSION[$key] = $value;
			}
			else if(self::$session == 'mysql')
			{
				$bindkey = [
					$_COOKIE['PHPSESSID'],
					$key
				];
				mySQL::prepare($bindkey,function()
				{
					return "SELECT session_id FROM session_value WHERE session_id = ? AND session_key = ?";
				});

				if(mySQL::rowCount() == 1)
				{
					$bindkey = [
						$value,
						$_COOKIE['PHPSESSID'],
						$key
					];

					mySQL::prepare($bindkey,function()
					{
						return "UPDATE session_value SET session_value = ? WHERE session_id = ? AND session_key = ?";
					});
				}
				else
				{
					$bindkey = [
						$_COOKIE['PHPSESSID'],
						$key,
						$value
					];

					mySQL::prepare($bindkey,function()
					{
						return "INSERT INTO session_value (session_id,session_key,session_value) VALUES(?,?,?)";
					});
				}
			}
		}
	}
?>