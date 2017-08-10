<?php
	
	namespace Libraries\Lobes\Miscellaneous;

	class SendSMS
	{
		
		public static function __init__($mobile_no,$msg)
		{
		    $APIKey='RA-49C6D48A-3B62-11E5-9880-6A01C7E421F8';
		    $SenderId='AAPKDR';
		    $url ="http://api.dial2verify.com/SMS/SEND/$APIKey/$SenderId/$mobile_no";
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, array('Msg' => $msg));
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    $result = curl_exec($ch);
		    curl_close($ch);
		    if($result)
		    {
		    	return true;
		    }
		    else
		    {
		    	return false;
		    }
		}
	}

?>