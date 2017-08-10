<?php
	
	namespace Libraries\Lobes\Miscellaneous;
	
	class Remote
	{
		
		public static function __init__($opt)
		{
			$handle = curl_init();

		    if($opt['callback'] == true)
		    {
		    	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		    }
		    else
		    {
		    	curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
		    }
		    if($opt['request'] == true)
		    {
		    	curl_setopt($handle, CURLOPT_POST, true);
		    	curl_setopt($handle, CURLOPT_POSTFIELDS, $opt['postData']);
		    }
		    else
		    {
		    	curl_setopt($handle, CURLOPT_POST, false);
		    }

		    curl_setopt($handle, CURLOPT_URL, $opt['url']);

		    if(isset($opt['headers']) && !empty($opt['headers']))
		    {
		    	curl_setopt($handle, CURLOPT_HTTPHEADER, $opt['headers']);
		    }
		
		    $output = curl_exec($handle);
		    
		    curl_close($handle);
		    
		  
		    return $output;
		}
	}

?>