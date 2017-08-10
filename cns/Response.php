<?php

	namespace Kernel\App\Core;

	class Response
	{
		public static function end($ResponseType,$data,$headers = null)
		{
			/*
				checking for response type like json,plain string,base64 etc	
			*/

			if(strtolower($ResponseType) == 'json')
			{
				echo $data = json_encode($data);
			}
			else if(strtolower($ResponseType) == 'plain')
			{
				echo $data;
			}
			else if(strtolower($ResponseType) == 'base64')
			{
				echo base64_encode($data);
			}

			/*
				headers default value is set to null and if it is not null
				then iterating towards it and header php method
			*/

			if($headers != null)
			{	
				foreach($headers as $key => $values)
				{
					header($key.':'.$values);
				}
			}
		}
	}
?>