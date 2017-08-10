<?php

	namespace Kernel\App\RequestRoute;

	class Route
	{
		/*
			private variables
		*/
		private $getUri = [],$postUri = [],$uri = [],$request_uri,$argument = [],$getArgument = [],$postArgument = [],$notMatch = 0,$request_type = "BOTH",$count = 0,$input;

		/*
			constructor for setting uri and path
		*/
		public function __construct()
		{
			/*
				setting the request uri variables
			*/

			$this->request_uri =  parse_url($_SERVER['REQUEST_URI']);
			$this->request_uri['path'] = str_replace('php_framework/','', $this->request_uri['path']);

			/*
				This line is checking for request method whether its a post request or any other request using $_REQUEST['REQUEST_METHOD'] globals variables
			*/

			($_SERVER['REQUEST_METHOD'] == "POST" ? $this->input = $_POST : $this->input = $_GET);

			/*
				This is checking for files request whther the request contains files or not
				 if it contains files then it is set to $input['files'] array variables
			*/

			if(isset($_FILES) && !empty($_FILES))
			{
				$this->input['files'] = $_FILES;
			}

			return $this;
		}

		/*
			Get request function for getting the get request and setting values and methods in the getURI and getArguments methods
		*/

		public function get($uri,$argument)
		{
			if($_SERVER['REQUEST_METHOD'] == "GET")
			{
				$this->request_type = "GET";
			}

			$this->count += 1;
			$this->uri[] = $uri;
			$this->argument[] = $argument;
			return $this;
		}

		/*
			Post request function for getting the get request and setting values and methods in the getURI and getArguments methods
		*/

		public function post($uri,$argument)
		{
			if($_SERVER['REQUEST_METHOD'] == "POST")
			{
				$this->request_type = "POST";
			}

			$this->count += 1;
			$this->uri[] = $uri;
			$this->argument[] = $argument;
			return $this;
		}

		/*
			Get and POST request function for getting the get request and setting values and methods in the getURI and getArguments methods
		*/

		public function request($uri,$argument)
		{

			$this->count += 1;
			$this->request_type = "BOTH";
			$this->uri[] = $uri;
			$this->argument[] = $argument;
			return $this;
		}

		/*
			Middleware methods are methods to filter reqeust before doing certain task.
		*/


		public function middleware($middleware)
		{

			/*
				Checks if the middleware parameter is an array or a variale
			*/
			if(is_array($middleware))
			{

				/*
					If the argument is an array then finding the length and checking if the middleware

					exists . If it exists then passing the whole request to the middleware.

					Middleware generally filters out the whole request before doing the main task
				*/

				$middlewareLen = sizeof($middleware);

				for($i=0;$i<$middlewareLen;$i++)
				{

					/*
						***
						**  checking for file existence and class existence
						*
					*/

					if(file_exists('middlewares/'.$middleware[$i].'.php'))
					{
						include_once 'middlewares/'.$middleware[$i].'.php';
						
						if(class_exists($middleware[$i]))
						{
							$input = $_REQUEST;
							if(isset($_FILES) && !empty($_FILES))
							{
								$input['files'] = $_FILES;
							}

							/*
								If the return array value is false the middleware will not allow the 

								request to move further. It will simply terminate the whole reqeust
							*/

							$middlewareOBJ = new $middleware[$i]();

							$middleware_returnValue = $middlewareOBJ->__init__($input);

							/*
								If middleware return false then the request is stopped here,
								futher execution is stopped here
							*/

							if(!$middleware_returnValue[0])
							{
								unset($middlewareOBJ);
								die($middleware_returnValue[1]);
							}

							unset($middlewareOBJ);
						}
						else
						{
							die('No class found in the middleware');
						}
					}
					else
					{
						die('No middleware found');
					}
				}
			}
			else
			{
				/***
					If the argument is not an array, then it checks for single middleware file existence and class 

					existence 
				****/

				if(file_exists('middlewares/'.$middleware.'.php'))
				{
					include_once 'middlewares/'.$middleware.'.php';
					
					if(class_exists($middleware))
					{
						$input = $_REQUEST;

						if(isset($_FILES) && !empty($_FILES))
						{
							$input['files'] = $_FILES;
						}

						/*
								If the return array value is false the middleware will not allow the 

								request to move further. It will simply terminate the whole reqeust
							*/

						$middlewareOBJ = new $middleware();

						$middleware_returnValue = $middlewareOBJ->__init__($input);

						if(!$middleware_returnValue[0])
						{
							unset($middlewareOBJ);
							die($middleware_returnValue[1]);
						}

						unset($middlewareOBJ);
					}
					else
					{
						die('No class found in the middleware');
					}
				}
				else
				{
					die('No middleware found');
				}
			}
			return $this;
		}

		public function where($regex)
		{
			if(!is_array($regex))
			{
				die('where method must have an array as an argument');
			}

			$newURI = $this->uri;
			/*
				replacing the uri with the regex
			*/
			foreach($regex as $key => $value)
			{
				$this->uri[$this->count - 1] = str_replace($key, $value, $this->uri[$this->count - 1]);
			}

			if(preg_match("#^".$this->uri[$this->count - 1]."$#", $this->request_uri['path']))
			{
				/*
					creating array from REQUEST URI to match with the regex
				*/
				$currentURI = explode('/', $this->request_uri['path']);

				/*
					creating array from regex expression
				*/

				$regex_array = explode('/', $newURI[$this->count - 1]);

				/*
					getting size of the regex array
				*/

				$regexLen = sizeof($regex_array);
				$currentURILen = sizeof($currentURI);

				/*
					iterating the regex array and matching with the request uri array

					if match is found then new regex replaced data is pushed in input array
				*/

				if($regexLen == $currentURILen)
				{
					for($i=0;$i<$regexLen;$i++)
					{
						if(preg_match('/^[\$]/', $regex_array[$i]))
						{
							$this->input[$regex_array[$i]] = $currentURI[$i];
						}
					}
				}
				else
				{
					die('URI and regex parameters does not match');
				}
			}
		}
		

		public function execute()
		{
			/*
				checking for the request type whether its a get request or a post request

				if it is set to both get and post then it will be handled by the request global variables

			*/

			$uri = $this->uri;
			$argument = $this->argument;

			/*
				Iterating to all the routers to match the request URI with the specific request
			*/

			//getting the size of the uri varaibles

			$len = sizeof($uri);

			// matching uri

			for($i = 0; $i < $len; $i++)
			{
				$url = $uri[$i];


				/*
					if uri array and uri request matches
				*/

				if(preg_match("#^$url$#", $this->request_uri['path']))
				{
					// checking if the second argument is a method or a string

					/*
						if method then the method is called
					*/

					if(is_callable($argument[$i]))
					{
						echo $argument[$i]($this->input);
					}
					else
					{

						/*
							If the method is a string then parsing it and seeking if the files exists in controllers folders 

							If exists then seeking if the class exists

							If exists then passing the whole request to controllers else 

							404 Page not found is thrown
						*/

						$controller = explode('/', $argument[$i]);
						$controllerLen = sizeof($controller);

						if(file_exists('controllers/'.$argument[$i].'.php'))
						{
							include_once 'controllers/'.$argument[$i].'.php';

							if(class_exists($controller[$controllerLen - 1]))
							{
								$obj = new $controller[$controllerLen - 1]($this->input);
								unset($obj);
							}
							else
							{
								include 'error_files/404.html';
							}
						}
						else
						{
							include 'error_files/404.html';
						}
					}

					break;
				}
				else
				{

					/*
						If the request does not match then incrementing the norMatch variables
					*/
					$this->notMatch += 1;
				}
			}

			/*
				If the not match variables is equal to the length of the uri array

				404 error is thrown
			*/

			if($this->notMatch == $len)
			{
				include 'error_files/404.html';
			}
			return $this;
		}

		public function __destruct()
		{
			unset($this);
		}
	}
?>