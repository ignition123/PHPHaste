<?php

	
	namespace Libraries\Lobes\Miscellaneous;

	class Net
	{
		public function __init__($host,$port,$type,$message,$callback)
		{
			$this->host_up = gethostbyname($host);
			$this->port = port;

			$this->message = $message;

			if($type == 'TCP')
			{
				// tcp
				$this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or false;
			}
			else
			{
				//udp
				$this->socket = socket_create(AF_INET, SOCK_DGRAM, 0) or false;	
			}

			$this->socket = socket_create($this->socket, $this->host_up, $this->port) or false;

			socket_write($this->socket, $this->message,strlen($this->message));

			$this->result = socket_read($this->socket, 1024);

			$callback($this->result);

			socket_close($this->socket);

		}
	}
?>