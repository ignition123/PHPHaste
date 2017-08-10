<?php

/*
	this database class for fetching data and initialize database model
*/
	namespace Kernel\App\Core;
	
	class HippoCampus
	{
		public static function HippoCampusDB($input)
		{//it controlls the database part includes the database script file

			if(isset($input['mapping']) && !empty($input['mapping']))
			{
				if(file_exists(ROOT_DIR.'/'.$input['mapping'].'DB/'))
				{
					if(file_exists(ROOT_DIR.'/'.$input['mapping'].'DB/'.$input['cortex'].'DB.php'))
					{
						require_once ROOT_DIR.'/'.$input['mapping'].'DB/'.$input['cortex'].'DB.php';
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return true;
				}
			}
			else
			{
				if(file_exists(ROOT_DIR.'/modelcallbacks_methods/'.$input['cortex'].'DB.php'))
				{
					require_once ROOT_DIR.'/modelcallbacks_methods/'.$input['cortex'].'DB.php';
				}
				return true;
			}
		}
	}

?>