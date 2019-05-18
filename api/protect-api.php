<?php
require 'config.php';

		use Firebase\JWT\JWT;
        require_once './php-jwt-master/src/JWT.php';
		
	$postdata = file_get_contents("php://input");	
	$request = json_decode($postdata);
		$jwt=isset($request->jwt) ? $request->jwt : "";
	//	$jwt=isset($_REQUEST['sl']) ? $_REQUEST['sl'] : "";
		
		if($jwt){
			// if decode succeed, show user details
			try {
				
				$key = "example_key";
				// decode jwt
				$decoded = JWT::decode($jwt, $key, array('HS256'));
		 
				http_response_code(200);
		 
				echo json_encode(array(
					"status" => true,
					"message" => "Access granted.",
					"data" => $decoded->data
				));
		 
			}
				// if decode fails, it means jwt is invalid
			catch (Exception $e){
					 
						// set response code
						http_response_code(401);
					 
						// tell the user access denied  & show error message
						echo json_encode(array(
							"status" => false,
							"message" => "Access denied.",
							"error" => $e->getMessage()
						));
					}
		}// show error message if jwt is empty
		else{
		 
			// set response code
			http_response_code(401);
		 
			// tell the user access denied
			echo json_encode(array(
					"status" => false,
					"message" => "Access denied. data="
					
					));
		}
		
	//var_dump($_REQUEST['sl']	);	
		
/*	if(!$user->is_logged_in()){
		echo '
		{
			"status": false
		}
		';
	}else{
		echo '
		{
			"status": true
		}
		';
	}
	*/
	
	//echo '<pre>';
	//var_dump($_SESSION);
	//echo '</pre>';

?> 
