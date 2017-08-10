<?php  

	use Kernel\App\Core\Views;

	
	echo $views_data;

    $fileData = 'index.php';
    $find = ['{{valaue}}'];
    $replace = ['sudeep'];
    Views::bind($find,$replace,$fileData);

?>