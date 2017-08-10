<?php

/*
	controller logic class contains all logics
*/

	namespace Kernel\App\Core;

	class Thalamus
	{
		public static function fileexits($input)
		{//controlls the mortor cortex that is page request

			if(isset($input['mapping']) && !empty($input['mapping']))
			{
				if(file_exists(ROOT_DIR.'/'.$input['mapping'].'/'.$input['cortex'].'.php'))
				{
					require_once ROOT_DIR.'/'.$input['mapping'].'/'.$input['cortex'].'.php';
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				if(file_exists(ROOT_DIR.'/controllers/'.$input['cortex'].'.php'))
				{
					require_once ROOT_DIR.'/controllers/'.$input['cortex'].'.php';
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		public static function Neurons($input)
		{//calling classes and methods and passing inputs if exists
			if(class_exists($input['cortex']))
			{
				$myclass = new $input['cortex']($input);
				unset($myclass);
				return true;
			}
			else
			{
				return false;
			}
		}
	}
?>