<?php

/*

	this class contains code for blocking ip address

*/
	namespace Kernel\App\Core;

	
	
	class BlockList
	{
		private $block_list;
		private $ip;
		public function __init__()
		{
			$this->user_ip = $this->FetchUserIpAddress();
			$this->block_list = $this->IpList();
			

			if(isset($this->block_list[$this->user_ip]))
			{
				return false;
			}
			else
			{
				return true;
			}
		}

		protected function FetchUserIpAddress()
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

		protected function IpList()
		{
			include_once 'route/BlockList.php';
			return $list;
		}
	}
?>