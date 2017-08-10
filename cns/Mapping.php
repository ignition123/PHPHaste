<?php

/*
	this mapping class for request mapping
*/

	namespace Kernel\App\Core;

	class Mapping
	{
		public function __init__($url)
		{
			$this->mapping_list = [
				'CallbacksTest'=>[
					'status'=>true,
					'mapping'=>'api',
					'cortex'=>'user_auth'
				]
			];

			if(isset($this->mapping_list[$url]) && $this->mapping_list[$url]['status'] == true)
			{
				return $this->mapping_list[$url];
			}
			else
			{
				return false;
			}
		}
	}
?>