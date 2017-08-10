<?php
	
	namespace Libraries\Lobes\Miscellaneous;
		
	require_once 'cns/Config.php';

	use Kernel\App\Core\Config;

	class FCM
	{
		public static function __init__($gcm_id,$input,$callback)
		{
			$ConfigOBJ = new Config();
  			$config = $ConfigOBJ->get();
  			
			$API_ACCESS_KEY =  $config->FCM_KEY;

			$url = 'https://fcm.googleapis.com/fcm/send';

			$fields = array();
			$fields['data'] = $input;

			if(is_array($gcm_id))
			{
				$fields['registration_ids'] = $gcm_id;
			}
			else
			{
				$fields['to'] = $gcm_id;
			}


			$headers = array(
			 'Content-Type:application/json',
			  'Authorization:key='.$API_ACCESS_KEY
			);


			$ch = curl_init();  // initiate curl
	        curl_setopt($ch, CURLOPT_URL,$url);
	        curl_setopt($ch, CURLOPT_POST, 1);  // tell curl you want to post something
	        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode( $fields )); // define what you want to post
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	        $output = curl_exec ($ch); // execute
	        $info = curl_getinfo($ch);
        	curl_close($ch);

			$callback($output);
		}
	}
?>