<?php
/*
	class for displaying html pages and using templates
*/
	namespace Kernel\App\Core;

	class Views
	{
		public static function render($view_name,$views_data)
		{
			if(file_exists('templates/'.$view_name.'.php'))
			{
				include_once 'templates/'.$view_name.'.php';
				require_once 'common_templates/common_templates.php';
			}
			else
			{
				include_once ROOT_DIR.'/error_files/404.html';
			}
		}

		public static function bind($find,$replace,$file)
		{
			// if filename is empty then 404 error is thrown
			
			if(empty($file))
			{
				include_once ROOT_DIR.'/error_files/404.html';

				header("HTTP/1.0 404 Not Found");
			}

			// if file exists then string are replaced

			if(file_exists(ROOT_DIR.'/cache_pages/'.$file))
			{
				include ROOT_DIR.'/cache_pages/'.$file;
				$ob = ob_start();
				$stuff = ob_get_contents();
				echo str_replace($find,$replace, getPage());
				$length = ob_get_length();
				header("Content-Length:$length");
				ob_flush(); 
				ob_end_flush(); 
			}
			else
			{
				if(file_exists(ROOT_DIR.'/views/'.$file))
				{
					$ob = ob_start();
					$stuff = ob_get_contents();

					$filename = ROOT_DIR.'/views/'.$file;
					$handle = fopen($filename, "r");
					$page = fread($handle, filesize($filename));
					fclose($handle);
					echo str_replace($find,$replace, $page);
					$length = ob_get_length();
					header("Content-Length:$length");
					ob_flush(); 
					ob_end_flush(); 
				}
				else
				{
					include_once ROOT_DIR.'/error_files/404.html';
				}
			}
		}
	}

?>