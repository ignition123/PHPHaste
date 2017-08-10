<?php
	
	use Kernel\App\Core\Views;
	use Kernel\App\Core\Response;	

	class StudentController
	{
		public function __construct($input)
		{
			$data = [
				'status'=>true,
				'msg'=>'message is in json',
				'data'=>$input
			];

			$headers = [
				'Content-Type'=>'application/json',
				'Author'=>'Sudeep Dasgupta'
			];

			response::end('json',$data,$headers);

			views::render('index',"View is working even in controller");
		}
	}
?>